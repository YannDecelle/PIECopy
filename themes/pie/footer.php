<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pie
 */

?>

<footer id="colophon" class="site-footer">

    <div id="footer-block">

        <div>

            <div class="footer-title">
                <h2>A propos</h2>
                <hr>
            </div>

          
            <a class="jesaispas" href="/contact/"><p>Nous contacter</p></a>

        </div>

        <span class="footer-vertical-line"></span>

        <?php the_custom_logo(); ?>

        <span class="footer-vertical-line"></span>

        <div>

            <div id="cache" class="footer-title">
                <h2>Mentions légales</h2>
                <hr>
            </div>

            <div class="footer-title">
            <a class="jesaispas" href="/Terms-conditions/"><p>Mentions légales</p></a>
            </div>

        </div>

    </div>

    <div class="footer-info">
        @2021 Paper Industry Event.
        <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'pie' ) ); ?>">
            <?php
            /* translators: %s: CMS name, i.e. WordPress. */
            printf( esc_html__( 'Propulsé par %s', 'pie' ), 'WordPress' );
            ?>
        </a>.
        <?php
        /* translators: 1: Theme name, 2: Theme author. */
        printf( esc_html__( 'Tous droits réservés, Thème: %1$s par %2$s.', 'pie' ), 'pie', '<a href="http://underscores.me/">PIE12</a>' );
        ?>
        <a href="#">
            CGU
        </a>
    </div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

