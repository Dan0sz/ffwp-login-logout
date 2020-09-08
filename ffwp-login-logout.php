<?php
/**
 * @formatter:off
 * Plugin Name: Astra Pro Login/Logout
 * Description: Adds a custom login/logout menu item.
 * Version: 1.0.0
 * Author: Daan (from Fast FW Press)
 * Author URI: https://ffwp.dev
 * Text Domain: ffwp-ll
 * GitHub Plugin URI: https://github.com/Dan0sz/ffwp-login-logout
 * @formatter:on
 */

defined('ABSPATH') || exit;

/**
 * @param $custom_markup
 *
 * @return string
 */
function ffwp_add_login_logout_menu($custom_markup)
{
    ob_start();
    ?>
    <li id="ffwp-ll-menu-item" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children ffwp-ll-menu-item" aria-haspopup="true">
        <a href="/account/" class="menu-link">
            <?php
            $fill_top    = is_user_logged_in() ? '#0daadb' : 'none';
            $fill_bottom = is_user_logged_in() ? '#0d88db' : 'none';
            ?>
            <svg class="ffwp-ll-dude" mlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 512 512'>
                <path d='M344,144c-3.92,52.87-44,96-88,96s-84.15-43.12-88-96c-4-55,35-96,88-96S348,90,344,144Z' style='fill:<?= $fill_top; ?>;stroke:#0daadb;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px'/>
                <path d='M256,304c-87,0-175.3,48-191.64,138.6C62.39,453.52,68.57,464,80,464H432c11.44,0,17.62-10.48,15.65-21.4C431.3,352,343,304,256,304Z' style='fill:<?= $fill_bottom; ?>;stroke:#0d88db;stroke-miterlimit:10;stroke-width:32px'/>
            </svg>
        </a>
        <button class="ast-menu-toggle" aria-expanded="false">
            <span class="screen-reader-text">Menu Toggle</span>
        </button>
        <ul class="sub-menu">
            <li id="menu-item-account" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-account">
                <a href="/account/" class="menu-link"><?= is_user_logged_in() ? __('Edit Profile', 'ffwp-ll') : __('Login', 'ffwp-ll'); ?></a>
            </li>
            <?php if (is_user_logged_in()): ?>
                <li id="menu-item-purchase-history" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-purchase-history">
                    <a href="/account/history/" class="menu-link"><?= __('Your Orders', 'ffwp-ll'); ?></a>
                </li>
                <li id="menu-item-logout" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-logout">
                    <a href="/wp-login.php?action=logout" class="menu-link"><?= __('Logout', 'ffwp-ll'); ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
    <?php
    $menu_item = ob_get_clean();

    return $menu_item . $custom_markup;
}

add_filter('astra_masthead_get_menu_items', 'ffwp_add_login_logout_menu');

/**
 *
 */
function ffwp_redirect_to_account_page()
{
    if (check_admin_referer('log-out')) {
        $home_url = home_url('/account');
        wp_redirect($home_url);
        exit();
    }
}

add_filter('wp_logout', 'ffwp_redirect_to_account_page');
