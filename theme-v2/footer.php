</div><!-- /#content -->

<!-- ===== SITE FOOTER ===== -->
<footer class="site-footer" role="contentinfo">

    <!-- Footer Grid -->
    <div class="footer__grid container">

        <!-- Col 1: Brand -->
        <div class="footer__col footer__col--brand">
            <div class="footer__logo">
                <?php
                if ( has_custom_logo() ) {
                    the_custom_logo();
                } else {
                    echo '<span class="footer__logo-text">בר-אל אופיר</span>';
                }
                ?>
            </div>
            <p class="footer__desc">
                בר-אל אופיר אספקה טכנית בע"מ — ספקית כלי עבודה מקצועיים מהמותגים המובילים בעולם. שירות אישי, מחירים תחרותיים, משלוח מהיר לכל הארץ.
            </p>
            <div class="footer__contact">
                <a href="tel:0524222910" class="footer__contact-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.78a16 16 0 0 0 6.29 6.29l.95-.95a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    052-422-2910
                </a>
                <a href="https://wa.me/972524222910" class="footer__contact-item footer__contact-item--wa" target="_blank" rel="noopener noreferrer">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.117.549 4.107 1.513 5.834L.057 23.5l5.826-1.527A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818c-1.848 0-3.563-.5-5.038-1.37l-.361-.213-3.455.906.921-3.368-.234-.375A9.818 9.818 0 0 1 2.182 12C2.182 6.57 6.57 2.182 12 2.182S21.818 6.57 21.818 12 17.43 21.818 12 21.818z"/></svg>
                    WhatsApp
                </a>
            </div>
        </div>

        <!-- Col 2: Categories -->
        <div class="footer__col">
            <h3 class="footer__col-title">קטגוריות</h3>
            <?php
            $cats = barel_get_top_cats( 8 );
            if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) :
            ?>
            <ul class="footer__links">
                <?php foreach ( $cats as $cat ) : ?>
                <li><a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a></li>
                <?php endforeach; ?>
                <li><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">כל המוצרים &rsaquo;</a></li>
            </ul>
            <?php endif; ?>
        </div>

        <!-- Col 3: Service -->
        <div class="footer__col">
            <h3 class="footer__col-title">שירות לקוחות</h3>
            <ul class="footer__links">
                <li><a href="<?php echo esc_url( home_url( '/my-account/' ) ); ?>">החשבון שלי</a></li>
                <li><a href="<?php echo esc_url( home_url( '/my-account/orders/' ) ); ?>">ההזמנות שלי</a></li>
                <li><a href="<?php echo esc_url( wc_get_cart_url() ); ?>">עגלת קניות</a></li>
                <li><a href="<?php echo esc_url( wc_get_checkout_url() ); ?>">תשלום</a></li>
                <li><a href="<?php echo esc_url( home_url( '/returns/' ) ); ?>">מדיניות החזרות</a></li>
                <li><a href="<?php echo esc_url( home_url( '/shipping/' ) ); ?>">משלוחים ואספקה</a></li>
                <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">צור קשר</a></li>
            </ul>
        </div>

        <!-- Col 4: About -->
        <div class="footer__col">
            <h3 class="footer__col-title">אודות</h3>
            <ul class="footer__links">
                <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">אודות החברה</a></li>
                <li><a href="<?php echo esc_url( home_url( '/brands/' ) ); ?>">מותגים</a></li>
                <li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">מדיניות פרטיות</a></li>
                <li><a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>">תקנון האתר</a></li>
                <li><a href="<?php echo esc_url( home_url( '/accessibility/' ) ); ?>">הצהרת נגישות</a></li>
                <li><a href="<?php echo esc_url( home_url( '/sitemap_index.xml' ) ); ?>">מפת האתר</a></li>
            </ul>
        </div>

    </div><!-- /.footer__grid -->

    <!-- Footer Bottom Bar -->
    <div class="footer__bottom">
        <div class="footer__bottom-inner container">
            <p class="footer__copy">
                &copy; <?php echo date( 'Y' ); ?> בר-אל אופיר אספקה טכנית בע"מ. כל הזכויות שמורות.
            </p>
            <div class="footer__payment">
                <span class="payment-badge">Visa</span>
                <span class="payment-badge">Mastercard</span>
                <span class="payment-badge">American Express</span>
                <span class="payment-badge">PayPal</span>
                <span class="payment-badge">Apple Pay</span>
            </div>
        </div>
    </div><!-- /.footer__bottom -->

</footer><!-- /.site-footer -->

<!-- ===== WHATSAPP FLOATING BUTTON ===== -->
<a href="https://wa.me/972524222910"
   class="whatsapp-fab"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="פתח שיחת WhatsApp"
   title="דברו איתנו ב-WhatsApp">
    <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.117.549 4.107 1.513 5.834L.057 23.5l5.826-1.527A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818c-1.848 0-3.563-.5-5.038-1.37l-.361-.213-3.455.906.921-3.368-.234-.375A9.818 9.818 0 0 1 2.182 12C2.182 6.57 6.57 2.182 12 2.182S21.818 6.57 21.818 12 17.43 21.818 12 21.818z"/>
    </svg>
    <span class="whatsapp-fab__label">שלחו הודעה</span>
</a>

</div><!-- /#page -->

<?php wp_footer(); ?>
</body>
</html>
