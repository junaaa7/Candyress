<style>

    .cute-footer {
        --c-blush: #FFF5F8;
        --c-petal: #FFE1EA;
        --c-rose: #FF9EBB;
        --c-berry: #D6477F;
        --c-cocoa: #5B3A4A;
        font-family: 'Nunito', system-ui, sans-serif;
        color: var(--c-cocoa);
        background: linear-gradient(180deg, var(--c-blush) 0%, #FFEAF1 100%);
        position: relative;
    }
    .cute-footer .cute-display { font-family: 'Fredoka', 'Nunito', sans-serif; }
    .cute-footer-muted { color: #9C7A8A; }

    .cute-footer-wave { display: block; width: 100%; height: 40px; margin-bottom: -1px; }

    .cute-footer-heading {
        font-family: 'Fredoka', sans-serif; font-weight: 600; font-size: 1rem; color: var(--c-berry);
        display: inline-block; padding: .2rem .8rem; border-radius: 999px;
        background: var(--c-petal); border: 2px dashed var(--c-rose);
    }

    .cute-footer-link { color: #9C7A8A; font-weight: 600; transition: color .2s ease, padding-left .2s ease; }
    .cute-footer-link:hover { color: var(--c-berry); padding-left: .25rem; }

    /* Round sticker-style social buttons */
    .cute-social {
        display: inline-flex; align-items: center; justify-content: center;
        width: 2.75rem; height: 2.75rem; border-radius: 999px;
        background: #fff; color: var(--c-berry);
        border: 2px solid var(--c-petal); box-shadow: 0 4px 0 var(--c-petal);
        transition: transform .15s ease, box-shadow .15s ease, background-color .2s ease, color .2s ease, border-color .2s ease;
    }
    .cute-social:hover { transform: translateY(2px); box-shadow: 0 2px 0 var(--c-rose); background: var(--c-rose); color: #fff; border-color: var(--c-rose); }

    .cute-footer :focus-visible { outline: 2px solid var(--c-rose); outline-offset: 3px; border-radius: 999px; }
</style>

<footer class="cute-footer mt-12">
    <svg class="cute-footer-wave" viewBox="0 0 1440 40" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0 20 Q 60 0 120 20 T 240 20 T 360 20 T 480 20 T 600 20 T 720 20 T 840 20 T 960 20 T 1080 20 T 1200 20 T 1320 20 T 1440 20 V0 H0 Z" fill="#fff"/>
    </svg>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <span class="cute-display inline-flex items-center gap-1.5 text-2xl font-bold tracking-tight" style="color: var(--c-berry);">
                    <span aria-hidden="true">🍬</span>Candyress.
                </span>
                <p class="mt-4 text-sm cute-footer-muted max-w-sm leading-relaxed">
                    Platform terpercaya untuk kebutuhan layanan digital premium Anda. Proses cepat, harga bersahabat, dan bergaransi. 💕
                </p>

                <!-- Ikon Kontak & Sosial Media -->
                <div class="mt-6 flex items-center gap-4">
                    <!-- WhatsApp -->
                    <a href="https://wa.me/628XXXXXXXXXX" target="_blank" rel="noopener" class="cute-social" aria-label="WhatsApp">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.012c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                        </svg>
                    </a>

                    <!-- Instagram -->
                    <a href="https://instagram.com/kitakaktus" target="_blank" rel="noopener" class="cute-social" aria-label="Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                        </svg>
                    </a>

                    <!-- TikTok -->
                    <a href="https://tiktok.com/@kitakaktus" target="_blank" rel="noopener" class="cute-social" aria-label="TikTok">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 2.23-1.15 4.39-2.98 5.74-1.84 1.35-4.22 1.86-6.49 1.34-2.27-.52-4.13-2.07-5.18-4.16-1.06-2.09-1.06-4.59-.01-6.68 1.05-2.09 2.91-3.64 5.18-4.16 1.48-.34 3.03-.21 4.41.38v4.06c-.84-.28-1.78-.31-2.65-.08-.87.23-1.64.8-2.15 1.55-.51.75-.68 1.69-.47 2.57.21.88.78 1.64 1.53 2.15.75.51 1.69.68 2.57.47.88-.21 1.64-.78 2.15-1.53.4-.6.6-1.32.57-2.05-.05-3.32-.01-6.64-.02-9.96-.01-2.31 0-4.62-.01-6.93z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="cute-footer-heading">Menu</h3>
                <ul class="mt-5 space-y-2.5">
                    <li><a href="#" class="cute-footer-link text-sm">Home</a></li>
                    <li><a href="#" class="cute-footer-link text-sm">Semua Produk</a></li>
                    <li><a href="#" class="cute-footer-link text-sm">Cara Pembelian</a></li>
                </ul>
            </div>

            <div>
                <h3 class="cute-footer-heading">Bantuan</h3>
                <ul class="mt-5 space-y-2.5">
                    <li><a href="#" class="cute-footer-link text-sm">FAQ</a></li>
                    <li><a href="#" class="cute-footer-link text-sm">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="cute-footer-link text-sm">Hubungi Kami</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-10 pt-8 flex items-center justify-between" style="border-top: 2px dashed var(--c-rose);">
            <p class="text-sm cute-footer-muted">&copy; {{ date('Y') }} Candyress. All rights reserved. 🎀</p>
        </div>
    </div>
</footer>