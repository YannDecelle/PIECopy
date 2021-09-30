<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pie
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/dc883addae.js" crossorigin="anonymous"></script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

    <header id="site-header">
        <div id="header-left">
            <?php the_custom_logo(); ?>
            <div id="header-left-slogan">
                <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <p><?php echo get_bloginfo( 'description', 'display' ); ?></p>
            </div>
        </div>

        <?php
        $items = wp_get_nav_menu_items(
                get_nav_menu_locations("main-menu")['main-menu']
            );
        ?>

        <!-- BURGER MENU -->
        <button id="hamburger-button">&#9776;</button>
        <div id="hamburger-sidebar">
            <div id="hamburger-sidebar-header">
                <img src="<?= is_user_logged_in()? get_avatar_url(get_currentuserinfo()->user_email) :get_template_directory_uri().'/img/unknown.png' ?>" alt="">
                <?php if(is_user_logged_in()) : ?>
                    <a href="/profile"><?= get_currentuserinfo()->user_login ?></a>
                <?php else: ?>
                    <a href="/auth">Se connecter</a>
                <?php endif; ?>
            </div>
            <div id="hamburger-sidebar-body">
                <ul>
                    <?php foreach ($items as $menuItem) : ?>
                        <a href="<?= $menuItem->url ?>"><li><?= $menuItem->title ?></li></a>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div id="hamburger-overlay"></div>

        <ul id="header-right">

            <?php foreach ($items as $menuItem) : ?>
                    <li><a href="<?= $menuItem->url ?>"><?= $menuItem->title ?></a></li>
            <?php endforeach; ?>
            <li><a id="login-link" href="
            <?= !is_user_logged_in() ? '/auth' : '/profile' ?>
            "><i class="fas fa-user"></i></a></li>
        </ul>
    </header>

    <script src="<?php echo get_template_directory_uri(); ?>/js/pages/burger.js"></script>

</div>

</body>