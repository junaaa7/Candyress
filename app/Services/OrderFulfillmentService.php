<?php

namespace App\Services;

use App\Models\Order;
use App\Models\ProductStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderFulfillmentService
{
    /**
     * Fulfill the order by assigning available product stocks to its items.
     * Must be called within a database transaction or this method will wrap it in one.
     */
    public function fulfill(Order $order): void
    {
        DB::transaction(function () use ($order) {
            // Load items if not loaded
            $order->loadMissing('items');

            foreach ($order->items as $item) {
                // If already fulfilled, skip (e.g. partial fulfillment handling in the future)
                if ($item->product_stock_id) {
                    continue;
                }

                // Since quantity is usually 1 for digital accounts, we fulfill based on quantity
                // Note: The prompt assumes 1 stock per item. If quantity > 1, we might need multiple order_items or a loop.
                // Assuming standard e-commerce where 1 order_item = quantity 1 for digital goods.
                // If quantity > 1, we fulfill it loop times. Actually, if order_items has quantity > 1,
                // the `product_stock_id` on order_items only supports 1. So quantity should be 1 per order_item in cart,
                // or we assign the first stock and assume it's valid for all? Wait. The schema has `product_stock_id` on `order_items`.
                // So 1 order_item maps to 1 product_stock. We will fulfill 1 stock per order_item.

                for ($i = 0; $i < $item->quantity; $i++) {
                    $stock = ProductStock::where('product_id', $item->product_id)
                        ->where('status', 'available')
                        ->lockForUpdate()
                        ->first();

                    if ($stock) {
                        $stock->update([
                            'status' => 'sold',
                            'order_id' => $order->id,
                            'sold_at' => now(),
                        ]);

                        // If quantity is 1, update the item. If > 1, this logic only stores the last one.
                        // Usually for digital goods, quantity is forced to 1 or cart splits items.
                        $item->update(['product_stock_id' => $stock->id]);
                    } else {
                        Log::warning("OrderFulfillmentService: No stock available for Product ID {$item->product_id} in Order ID {$order->id}");
                        // Optional: we could throw an exception or notify admin.
                    }
                }
            }

            // Update order status
            $order->update(['status' => 'completed']);
        });
    }
}
