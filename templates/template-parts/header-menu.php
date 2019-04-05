<?php
    global $post;
    $post_id = isset($post->ID) ? $post->ID : '';
    $header_options = turbo_get_header_settings( $post_id );
    extract($header_options['options']);
    $header_style = $header_options['style'];
    $header_css_class = $header_type.' '.$is_sticky;
    $is_sticky_id = $is_sticky === 'sticky-header' ? 'sticker' : 'non-sticker';
    $anime_sticky = '';
    if ($header_sticky_anime === 'yes') {
        $anime_sticky = 'sticky-header-anime';
    } else {
        $anime_sticky = 'non-sticky-header-anime';
    }
?>
<header class="header <?php echo esc_attr( $header_css_class); ?> <?php echo ''; ?> <?php echo esc_attr($anime_sticky); ?>">
    <nav class="navbar navbar-default" id="<?php echo esc_attr($is_sticky_id); ?>"  style="<?php echo esc_attr( $header_style); ?>">
        <div class="container">
            <?php if (empty($site_logo)) { ?>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="<?php echo esc_url(home_url('/')) ?>"  class="navbar-brand">
                        <span class="turbo-site-name"><?php echo bloginfo('name'); ?></span>
                    </a>
                </div>
            <?php } else { ?>
                <?php echo turbo_toggle_header_menu($site_logo); ?>
            <?php } ?>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <?php
                $defaults = array(
                    'theme_location' => 'primary_navigation',
                    'menu_class' => 'menu',
                    'menu_id' => '',
                    'echo' => true,
                    'items_wrap' => '<ul id="%1$s" class="nav navbar-nav navbar-center %2$s">%3$s</ul>',
                    'depth' => 4,
                    'fallback_cb' => 'turbo_nav_walker::fallback',
                    'walker' => new turbo_nav_walker()
                );
                wp_nav_menu($defaults);
                ?>

                <?php if (isset($header_right_menu) && $header_right_menu === 'yes') : ?>
                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($header_login) && $header_login === 'yes') : ?>
                        <?php
                        $account_text = is_user_logged_in() ? __('My Account', 'turbo') : __('Login / Register', 'turbo');
                        $account_icon = is_user_logged_in() ? 'fa fa-tachometer' : 'icon_lock-open_alt';
                        ?>
                        <li class="login-register-link right-side-link" style="display:none;">
                            <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" title="<?php echo esc_attr($account_text); ?>"><i class="<?php echo esc_attr($account_icon); ?>"></i><?php echo esc_attr($account_text); ?></a>
                        </li>
                    <?php endif; ?>

                    <?php
                    if (isset($header_lang) && $header_lang === 'yes') {
                        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                        if (is_plugin_active('sitepress-multilingual-cms/sitepress.php') && $header_lang == 'yes') :
                            turbo_wpml_languages('right-side-link');
                        endif;
                    }
                    ?>

                    <?php if (isset($header_currency) && $header_currency === 'disabled') : ?>
                        <li class="dropdown right-side-link last">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">USD<span class="ion-chevron-down"></span></a>
                            <ul class="dropdown-menu with-language">
                                <li><a href="#">USD</a></li>
                                <li><a href="#">Eur</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php echo do_shortcode( '[language-switcher]' ); ?>
                <!-- <a href="tel:+381606636616" class="header-phone"><i class="fa fa-phone"></i><span>+381 60 663 66 16</span></a> -->
                <?php endif; ?>

            </div>
        </div>
    </nav>
    <div class="sticky-nav-offset"></div>
</header>
