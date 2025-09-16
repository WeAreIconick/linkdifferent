<?php
/**
 * Plugin Name: Link Different
 * Description: Transform your ordinary WordPress links into irresistible eye candy with Link Different. Add delightful hover effects to paragraph links that make visitors actually want to click them.
 * Version: 1.0.1
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Nick Hamze
 * Author URI: https://iconick.io/
 * License: GPL v2 or later
 * Text Domain: link-different
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue block editor scripts
 */
function link_different_enqueue_editor_assets() {
    wp_enqueue_script(
        'link-different-editor',
        plugin_dir_url(__FILE__) . 'editor.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-compose', 'wp-hooks', 'wp-block-editor'),
        '1.0.0',
        true
    );
}
add_action('enqueue_block_editor_assets', 'link_different_enqueue_editor_assets');

/**
 * Add frontend styles
 */
function link_different_add_frontend_styles() {
    $css = '
    /* Link Different - Peace Out Style */
    p.is-style-peace-out {
        position: relative;
    }
    p.is-style-peace-out a {
        position: relative;
        color: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6)));
        text-decoration: none;
        transition: color .2s;
        z-index: 1;
    }
    p.is-style-peace-out a::before {
        content: " ";
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6)));
        z-index: -1;
        transform: scaleX(0);
        transform-origin: bottom right;
        transition: transform .3s cubic-bezier(0.76,0,0.24,1);
        border-radius: 3px;
    }
    p.is-style-peace-out a:hover::before {
        transform: scaleX(1);
        transform-origin: bottom left;
    }
    p.is-style-peace-out a:hover {
        color: var(--wp--preset--color--base, var(--wp--preset--color--background, #fff));
    }

    /* Link Different - Rainbow Style */
    p.is-style-rainbow a {
        position: relative;
        color: inherit;
        text-decoration: none;
        background:
            linear-gradient(to right, rgba(100,200,200,1), rgba(100,200,200,1)),
            linear-gradient(to right, rgba(255,0,0,1), rgba(255,0,180,1), rgba(0,100,200,1));
        background-size: 100% 3px, 0 3px;
        background-position: 100% 100%, 0 100%;
        background-repeat: no-repeat;
        transition: background-size 400ms;
    }
    p.is-style-rainbow a:hover {
        background-size: 0 3px, 100% 3px;
    }

    /* Link Different - Hat Tip Style */
    p.is-style-hat-tip a {
        text-decoration: none;
        color: #18272F;
        font-weight: 700;
        position: relative;
        transition: color 0.2s;
    }
    p.is-style-hat-tip a::before {
        content: \'\';
        background-color: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, hsla(196, 61%, 58%, .75))));
        opacity: 0.75;
        position: absolute;
        left: 0;
        bottom: 3px;
        width: 100%;
        height: 8px;
        z-index: -1;
        transition: all .3s ease-in-out;
    }
    p.is-style-hat-tip a:hover::before {
        bottom: 0;
        height: 100%;
    }

    /* Link Different - Boing Style */
    p.is-style-boing a {
        position: relative;
        overflow: hidden;
        text-decoration: none;
        color: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6)));
    }
    p.is-style-boing a::after {
        content: "";
        background: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6)));
        opacity: 0.25;
        position: absolute;
        left: 12px;
        bottom: -6px;
        width: calc(100% - 8px);
        height: calc(100% - 8px);
        z-index: -1;
        transition: 0.35s cubic-bezier(0.25, 0.1, 0, 2.05);
    }
    p.is-style-boing a:hover::after {
        left: 0;
        bottom: -2px;
        width: 100%;
        height: 100%;
    }

    /* Link Different - Strikethrough Style */
    p.is-style-strikethrough a {
        position: relative;
        text-decoration: none;
        color: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6)));
        transition: color 0.3s ease;
    }
    p.is-style-strikethrough a::before {
        content: "";
        position: absolute;
        width: 0;
        height: 2px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6)));
        transition: width 0.3s ease;
    }
    p.is-style-strikethrough a:hover::before {
        width: 100%;
    }
    p.is-style-strikethrough a::after {
        content: "";
        position: absolute;
        width: 100%;
        height: 2px;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        background: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6)));
        opacity: 0.3;
        transition: opacity 0.3s ease;
    }
    p.is-style-strikethrough a:hover::after {
        opacity: 0;
    }

    /* Link Different - Squiggle Style */
    p.is-style-squiggle a {
        position: relative;
        text-decoration: wavy underline;
        text-decoration-color: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6)));
        text-underline-offset: 3px;
        text-decoration-thickness: 2px;
        color: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6)));
        transition: all 0.15s ease-out;
    }
    p.is-style-squiggle a:hover {
        text-decoration-thickness: 3px;
        text-underline-offset: 4px;
    }
    ';
    
    echo '<style>' . wp_kses($css, array()) . '</style>';
}
add_action('wp_head', 'link_different_add_frontend_styles');

/**
 * Add editor styles
 */
function link_different_add_editor_styles() {
    $css = '
    /* Link Different Editor Styles - More specific selectors for both direct and container styles */
    .editor-styles-wrapper p.is-style-peace-out,
    .wp-block.is-style-peace-out,
    .wp-block-paragraph.is-style-peace-out,
    [data-type="core/paragraph"].is-style-peace-out p,
    .editor-styles-wrapper .is-style-peace-out p,
    .wp-block.is-style-peace-out p,
    [data-type="core/group"].is-style-peace-out p,
    [data-type="core/template-part"].is-style-peace-out p {
        position: relative !important;
    }
    .editor-styles-wrapper p.is-style-peace-out a,
    .wp-block.is-style-peace-out a,
    .wp-block-paragraph.is-style-peace-out a,
    [data-type="core/paragraph"].is-style-peace-out p a,
    .editor-styles-wrapper .is-style-peace-out p a,
    .wp-block.is-style-peace-out p a,
    [data-type="core/group"].is-style-peace-out p a,
    [data-type="core/template-part"].is-style-peace-out p a {
        position: relative !important;
        color: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6))) !important;
        text-decoration: none !important;
        transition: color .2s !important;
        z-index: 1 !important;
    }
    .editor-styles-wrapper p.is-style-peace-out a::before,
    .wp-block.is-style-peace-out a::before,
    .wp-block-paragraph.is-style-peace-out a::before,
    [data-type="core/paragraph"].is-style-peace-out p a::before,
    .editor-styles-wrapper .is-style-peace-out p a::before,
    .wp-block.is-style-peace-out p a::before,
    [data-type="core/group"].is-style-peace-out p a::before,
    [data-type="core/template-part"].is-style-peace-out p a::before {
        content: " " !important;
        display: block !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        background: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6))) !important;
        z-index: -1 !important;
        transform: scaleX(0) !important;
        transform-origin: bottom right !important;
        transition: transform .3s cubic-bezier(0.76,0,0.24,1) !important;
        border-radius: 3px !important;
    }
    .editor-styles-wrapper p.is-style-peace-out a:hover::before,
    .wp-block.is-style-peace-out a:hover::before,
    .wp-block-paragraph.is-style-peace-out a:hover::before,
    [data-type="core/paragraph"].is-style-peace-out p a:hover::before,
    .editor-styles-wrapper .is-style-peace-out p a:hover::before,
    .wp-block.is-style-peace-out p a:hover::before,
    [data-type="core/group"].is-style-peace-out p a:hover::before,
    [data-type="core/template-part"].is-style-peace-out p a:hover::before {
        transform: scaleX(1) !important;
        transform-origin: bottom left !important;
    }
    .editor-styles-wrapper p.is-style-peace-out a:hover,
    .wp-block.is-style-peace-out a:hover,
    .wp-block-paragraph.is-style-peace-out a:hover,
    [data-type="core/paragraph"].is-style-peace-out p a:hover,
    .editor-styles-wrapper .is-style-peace-out p a:hover,
    .wp-block.is-style-peace-out p a:hover,
    [data-type="core/group"].is-style-peace-out p a:hover,
    [data-type="core/template-part"].is-style-peace-out p a:hover {
        color: var(--wp--preset--color--base, var(--wp--preset--color--background, #fff)) !important;
    }

    .editor-styles-wrapper p.is-style-rainbow a,
    .wp-block.is-style-rainbow a,
    .wp-block-paragraph.is-style-rainbow a,
    [data-type="core/paragraph"].is-style-rainbow p a,
    .editor-styles-wrapper .is-style-rainbow p a,
    .wp-block.is-style-rainbow p a,
    [data-type="core/group"].is-style-rainbow p a,
    [data-type="core/template-part"].is-style-rainbow p a {
        position: relative !important;
        color: inherit !important;
        text-decoration: none !important;
        background:
            linear-gradient(to right, rgba(100,200,200,1), rgba(100,200,200,1)),
            linear-gradient(to right, rgba(255,0,0,1), rgba(255,0,180,1), rgba(0,100,200,1)) !important;
        background-size: 100% 3px, 0 3px !important;
        background-position: 100% 100%, 0 100% !important;
        background-repeat: no-repeat !important;
        transition: background-size 400ms !important;
    }
    .editor-styles-wrapper p.is-style-rainbow a:hover,
    .wp-block.is-style-rainbow a:hover,
    .wp-block-paragraph.is-style-rainbow a:hover,
    [data-type="core/paragraph"].is-style-rainbow p a:hover,
    .editor-styles-wrapper .is-style-rainbow p a:hover,
    .wp-block.is-style-rainbow p a:hover,
    [data-type="core/group"].is-style-rainbow p a:hover,
    [data-type="core/template-part"].is-style-rainbow p a:hover {
        background-size: 0 3px, 100% 3px !important;
    }

    .editor-styles-wrapper p.is-style-hat-tip a,
    .wp-block.is-style-hat-tip a,
    .wp-block-paragraph.is-style-hat-tip a,
    [data-type="core/paragraph"].is-style-hat-tip p a,
    .editor-styles-wrapper .is-style-hat-tip p a,
    .wp-block.is-style-hat-tip p a,
    [data-type="core/group"].is-style-hat-tip p a,
    [data-type="core/template-part"].is-style-hat-tip p a {
        text-decoration: none !important;
        color: #18272F !important;
        font-weight: 700 !important;
        position: relative !important;
        transition: color 0.2s !important;
    }
    .editor-styles-wrapper p.is-style-hat-tip a::before,
    .wp-block.is-style-hat-tip a::before,
    .wp-block-paragraph.is-style-hat-tip a::before,
    [data-type="core/paragraph"].is-style-hat-tip p a::before,
    .editor-styles-wrapper .is-style-hat-tip p a::before,
    .wp-block.is-style-hat-tip p a::before,
    [data-type="core/group"].is-style-hat-tip p a::before,
    [data-type="core/template-part"].is-style-hat-tip p a::before {
        content: \'\' !important;
        background-color: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, hsla(196, 61%, 58%, .75)))) !important;
        opacity: 0.75 !important;
        position: absolute !important;
        left: 0 !important;
        bottom: 3px !important;
        width: 100% !important;
        height: 8px !important;
        z-index: -1 !important;
        transition: all .3s ease-in-out !important;
    }
    .editor-styles-wrapper p.is-style-hat-tip a:hover::before,
    .wp-block.is-style-hat-tip a:hover::before,
    .wp-block-paragraph.is-style-hat-tip a:hover::before,
    [data-type="core/paragraph"].is-style-hat-tip p a:hover::before,
    .editor-styles-wrapper .is-style-hat-tip p a:hover::before,
    .wp-block.is-style-hat-tip p a:hover::before,
    [data-type="core/group"].is-style-hat-tip p a:hover::before,
    [data-type="core/template-part"].is-style-hat-tip p a:hover::before {
        bottom: 0 !important;
        height: 100% !important;
    }

    .editor-styles-wrapper p.is-style-boing a,
    .wp-block.is-style-boing a,
    .wp-block-paragraph.is-style-boing a,
    [data-type="core/paragraph"].is-style-boing p a,
    .editor-styles-wrapper .is-style-boing p a,
    .wp-block.is-style-boing p a,
    [data-type="core/group"].is-style-boing p a,
    [data-type="core/template-part"].is-style-boing p a {
        position: relative !important;
        overflow: hidden !important;
        text-decoration: none !important;
        color: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6))) !important;
    }
    .editor-styles-wrapper p.is-style-boing a::after,
    .wp-block.is-style-boing a::after,
    .wp-block-paragraph.is-style-boing a::after,
    [data-type="core/paragraph"].is-style-boing p a::after,
    .editor-styles-wrapper .is-style-boing p a::after,
    .wp-block.is-style-boing p a::after,
    [data-type="core/group"].is-style-boing p a::after,
    [data-type="core/template-part"].is-style-boing p a::after {
        content: "" !important;
        background: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6))) !important;
        opacity: 0.25 !important;
        position: absolute !important;
        left: 12px !important;
        bottom: -6px !important;
        width: calc(100% - 8px) !important;
        height: calc(100% - 8px) !important;
        z-index: -1 !important;
        transition: 0.35s cubic-bezier(0.25, 0.1, 0, 2.05) !important;
    }
    .editor-styles-wrapper p.is-style-boing a:hover::after,
    .wp-block.is-style-boing a:hover::after,
    .wp-block-paragraph.is-style-boing a:hover::after,
    [data-type="core/paragraph"].is-style-boing p a:hover::after,
    .editor-styles-wrapper .is-style-boing p a:hover::after,
    .wp-block.is-style-boing p a:hover::after,
    [data-type="core/group"].is-style-boing p a:hover::after,
    [data-type="core/template-part"].is-style-boing p a:hover::after {
        left: 0 !important;
        bottom: -2px !important;
        width: 100% !important;
        height: 100% !important;
    }

    .editor-styles-wrapper p.is-style-strikethrough a,
    .wp-block.is-style-strikethrough a,
    .wp-block-paragraph.is-style-strikethrough a,
    [data-type="core/paragraph"].is-style-strikethrough p a,
    .editor-styles-wrapper .is-style-strikethrough p a,
    .wp-block.is-style-strikethrough p a,
    [data-type="core/group"].is-style-strikethrough p a,
    [data-type="core/template-part"].is-style-strikethrough p a {
        position: relative !important;
        text-decoration: none !important;
        color: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6))) !important;
        transition: color 0.3s ease !important;
    }
    .editor-styles-wrapper p.is-style-strikethrough a::before,
    .wp-block.is-style-strikethrough a::before,
    .wp-block-paragraph.is-style-strikethrough a::before,
    [data-type="core/paragraph"].is-style-strikethrough p a::before,
    .editor-styles-wrapper .is-style-strikethrough p a::before,
    .wp-block.is-style-strikethrough p a::before,
    [data-type="core/group"].is-style-strikethrough p a::before,
    [data-type="core/template-part"].is-style-strikethrough p a::before {
        content: "" !important;
        position: absolute !important;
        width: 0 !important;
        height: 2px !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        background: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6))) !important;
        transition: width 0.3s ease !important;
    }
    .editor-styles-wrapper p.is-style-strikethrough a:hover::before,
    .wp-block.is-style-strikethrough a:hover::before,
    .wp-block-paragraph.is-style-strikethrough a:hover::before,
    [data-type="core/paragraph"].is-style-strikethrough p a:hover::before,
    .editor-styles-wrapper .is-style-strikethrough p a:hover::before,
    .wp-block.is-style-strikethrough p a:hover::before,
    [data-type="core/group"].is-style-strikethrough p a:hover::before,
    [data-type="core/template-part"].is-style-strikethrough p a:hover::before {
        width: 100% !important;
    }
    .editor-styles-wrapper p.is-style-strikethrough a::after,
    .wp-block.is-style-strikethrough a::after,
    .wp-block-paragraph.is-style-strikethrough a::after,
    [data-type="core/paragraph"].is-style-strikethrough p a::after,
    .editor-styles-wrapper .is-style-strikethrough p a::after,
    .wp-block.is-style-strikethrough p a::after,
    [data-type="core/group"].is-style-strikethrough p a::after,
    [data-type="core/template-part"].is-style-strikethrough p a::after {
        content: "" !important;
        position: absolute !important;
        width: 100% !important;
        height: 2px !important;
        top: 50% !important;
        left: 0 !important;
        transform: translateY(-50%) !important;
        background: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6))) !important;
        opacity: 0.3 !important;
        transition: opacity 0.3s ease !important;
    }
    .editor-styles-wrapper p.is-style-strikethrough a:hover::after,
    .wp-block.is-style-strikethrough a:hover::after,
    .wp-block-paragraph.is-style-strikethrough a:hover::after,
    [data-type="core/paragraph"].is-style-strikethrough p a:hover::after,
    .editor-styles-wrapper .is-style-strikethrough p a:hover::after,
    .wp-block.is-style-strikethrough p a:hover::after,
    [data-type="core/group"].is-style-strikethrough p a:hover::after,
    [data-type="core/template-part"].is-style-strikethrough p a:hover::after {
        opacity: 0 !important;
    }
    ';
    
    echo '<style id="link-different-editor-styles">' . wp_kses($css, array()) . '</style>';
}
add_action('admin_head', 'link_different_add_editor_styles');
add_action('admin_footer', 'link_different_add_editor_styles');

/**
 * Enqueue styles for Site Editor
 */
function link_different_site_editor_styles() {
    // Check if we're in the Site Editor
    if (!is_admin()) {
        return;
    }
    
    $current_screen = get_current_screen();
    if ($current_screen && $current_screen->id === 'site-editor') {
        // Add the same styles for Site Editor
        link_different_add_frontend_styles();
        link_different_add_editor_styles();
    }
}
add_action('admin_head', 'link_different_site_editor_styles');

/**
 * Add styles to Site Editor iframe
 */
function link_different_site_editor_iframe_styles() {
    // Get the CSS content safely
    $frontend_css = '
    /* Link Different - Peace Out Style */
    p.is-style-peace-out {
        position: relative;
    }
    p.is-style-peace-out a {
        position: relative;
        color: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6)));
        text-decoration: none;
        transition: color .2s;
        z-index: 1;
    }
    p.is-style-peace-out a::before {
        content: " ";
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6)));
        z-index: -1;
        transform: scaleX(0);
        transform-origin: bottom right;
        transition: transform .3s cubic-bezier(0.76,0,0.24,1);
        border-radius: 3px;
    }
    p.is-style-peace-out a:hover::before {
        transform: scaleX(1);
        transform-origin: bottom left;
    }
    p.is-style-peace-out a:hover {
        color: var(--wp--preset--color--base, var(--wp--preset--color--background, #fff));
    }
    /* Additional styles would continue here... */
    ';
    
    echo '<style>' . wp_kses($frontend_css, array()) . '</style>';
}
add_action('admin_print_styles-site-editor', 'link_different_site_editor_iframe_styles');