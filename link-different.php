<?php
/**
 * Plugin Name: Link Different
 * Plugin URI: https://iconick.io/
 * Description: Style your links differently with unique hover effects for paragraph blocks (Peace Out, Rainbow, Hat Tip)
 * Version: 1.0.0
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
 * Add frontend styles
 */
function link_different_add_frontend_styles() {
    ?>
    <style>
    /* Link Different - Peace Out Style */
    p.is-style-peace-out {
        position: relative;
    }
    p.is-style-peace-out a {
        position: relative;
        color: inherit;
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
        content: '';
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
    </style>
    <?php
}
add_action('wp_head', 'link_different_add_frontend_styles');

/**
 * Add editor styles
 */
function link_different_add_editor_styles() {
    // Add inline styles to the block editor
    add_action('admin_footer', function() {
        ?>
        <style id="link-different-editor-styles">
        /* Link Different Editor Styles - More specific selectors */
        .wp-block.is-style-peace-out,
        .wp-block-paragraph.is-style-peace-out,
        [data-type="core/paragraph"].is-style-peace-out .block-editor-rich-text__editable {
            position: relative !important;
        }
        .wp-block.is-style-peace-out a,
        .wp-block-paragraph.is-style-peace-out a,
        [data-type="core/paragraph"].is-style-peace-out .block-editor-rich-text__editable a {
            position: relative !important;
            color: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6))) !important;
            text-decoration: none !important;
            transition: color .2s !important;
            z-index: 1 !important;
        }
        .wp-block.is-style-peace-out a::before,
        .wp-block-paragraph.is-style-peace-out a::before,
        [data-type="core/paragraph"].is-style-peace-out .block-editor-rich-text__editable a::before {
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
        .wp-block.is-style-peace-out a:hover::before,
        .wp-block-paragraph.is-style-peace-out a:hover::before,
        [data-type="core/paragraph"].is-style-peace-out .block-editor-rich-text__editable a:hover::before {
            transform: scaleX(1) !important;
            transform-origin: bottom left !important;
        }
        .wp-block.is-style-peace-out a:hover,
        .wp-block-paragraph.is-style-peace-out a:hover,
        [data-type="core/paragraph"].is-style-peace-out .block-editor-rich-text__editable a:hover {
            color: var(--wp--preset--color--base, var(--wp--preset--color--background, #fff)) !important;
        }

        .wp-block.is-style-rainbow a,
        .wp-block-paragraph.is-style-rainbow a,
        [data-type="core/paragraph"].is-style-rainbow .block-editor-rich-text__editable a {
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
        .wp-block.is-style-rainbow a:hover,
        .wp-block-paragraph.is-style-rainbow a:hover,
        [data-type="core/paragraph"].is-style-rainbow .block-editor-rich-text__editable a:hover {
            background-size: 0 3px, 100% 3px !important;
        }

        .wp-block.is-style-hat-tip a,
        .wp-block-paragraph.is-style-hat-tip a,
        [data-type="core/paragraph"].is-style-hat-tip .block-editor-rich-text__editable a {
            text-decoration: none !important;
            color: #18272F !important;
            font-weight: 700 !important;
            position: relative !important;
            transition: color 0.2s !important;
        }
        .wp-block.is-style-hat-tip a::before,
        .wp-block-paragraph.is-style-hat-tip a::before,
        [data-type="core/paragraph"].is-style-hat-tip .block-editor-rich-text__editable a::before {
            content: '' !important;
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
        .wp-block.is-style-hat-tip a:hover::before,
        .wp-block-paragraph.is-style-hat-tip a:hover::before,
        [data-type="core/paragraph"].is-style-hat-tip .block-editor-rich-text__editable a:hover::before {
            bottom: 0 !important;
            height: 100% !important;
        }

        /* Link Different - Boing Style */
        .wp-block.is-style-boing a,
        .wp-block-paragraph.is-style-boing a,
        [data-type="core/paragraph"].is-style-boing .block-editor-rich-text__editable a {
            position: relative !important;
            overflow: hidden !important;
            text-decoration: none !important;
            color: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6))) !important;
        }
        .wp-block.is-style-boing a::after,
        .wp-block-paragraph.is-style-boing a::after,
        [data-type="core/paragraph"].is-style-boing .block-editor-rich-text__editable a::after {
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
        .wp-block.is-style-boing a:hover::after,
        .wp-block-paragraph.is-style-boing a:hover::after,
        [data-type="core/paragraph"].is-style-boing .block-editor-rich-text__editable a:hover::after {
            left: 0 !important;
            bottom: -2px !important;
            width: 100% !important;
            height: 100% !important;
        }

        /* Link Different - Strikethrough Style */
        .wp-block.is-style-strikethrough a,
        .wp-block-paragraph.is-style-strikethrough a,
        [data-type="core/paragraph"].is-style-strikethrough .block-editor-rich-text__editable a {
            position: relative !important;
            text-decoration: none !important;
            color: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6))) !important;
            transition: color 0.3s ease !important;
        }
        .wp-block.is-style-strikethrough a::before,
        .wp-block-paragraph.is-style-strikethrough a::before,
        [data-type="core/paragraph"].is-style-strikethrough .block-editor-rich-text__editable a::before {
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
        .wp-block.is-style-strikethrough a:hover::before,
        .wp-block-paragraph.is-style-strikethrough a:hover::before,
        [data-type="core/paragraph"].is-style-strikethrough .block-editor-rich-text__editable a:hover::before {
            width: 100% !important;
        }
        .wp-block.is-style-strikethrough a::after,
        .wp-block-paragraph.is-style-strikethrough a::after,
        [data-type="core/paragraph"].is-style-strikethrough .block-editor-rich-text__editable a::after {
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
        .wp-block.is-style-strikethrough a:hover::after,
        .wp-block-paragraph.is-style-strikethrough a:hover::after,
        [data-type="core/paragraph"].is-style-strikethrough .block-editor-rich-text__editable a:hover::after {
            opacity: 0 !important;
        }

        /* Link Different - Squiggle Style */
        .wp-block.is-style-squiggle a,
        .wp-block-paragraph.is-style-squiggle a,
        [data-type="core/paragraph"].is-style-squiggle .block-editor-rich-text__editable a {
            position: relative !important;
            text-decoration: none !important;
            color: var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6))) !important;
            border-bottom: 1px solid var(--link-different-accent-color, var(--wp--preset--color--accent, var(--wp--preset--color--primary, #54b3d6))) !important;
            transition: all 0.15s ease-out !important;
        }
        .wp-block.is-style-squiggle a:hover,
        .wp-block-paragraph.is-style-squiggle a:hover,
        [data-type="core/paragraph"].is-style-squiggle .block-editor-rich-text__editable a:hover {
            border-bottom: none !important;
            padding-bottom: 2px !important;
            background-repeat: repeat-x !important;
            background-position: 0 100% !important;
            background-size: 10px 18px !important;
            background-image: var(--squiggle-svg, url("data:image/svg+xml;charset=utf8,%3Csvg id='squiggle-link' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:ev='http://www.w3.org/2001/xml-events' viewBox='0 0 10 18'%3E%3Cstyle type='text/css'%3E.squiggle%7Banimation:shift .5s linear infinite;%7D@keyframes shift %7Bfrom %7Btransform:translateX(-10px);%7Dto %7Btransform:translateX(0);%7D%7D%3C/style%3E%3Cpath fill='none' stroke='%2354b3d6' stroke-width='1' class='squiggle' d='M0,17.5 c 2.5,0,2.5,-1.5,5,-1.5 s 2.5,1.5,5,1.5 c 2.5,0,2.5,-1.5,5,-1.5 s 2.5,1.5,5,1.5' /%3E%3C/svg%3E")) !important;
        }
        </style>
        <?php
    });
}
add_action('admin_init', 'link_different_add_editor_styles');

/**
 * Enqueue block editor scripts for color picker
 */
function link_different_enqueue_editor_scripts() {
    wp_enqueue_script(
        'link-different-editor',
        plugin_dir_url(__FILE__) . 'editor.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-compose', 'wp-hooks', 'wp-block-editor'),
        '1.0.0',
        true
    );
}
add_action('enqueue_block_editor_assets', 'link_different_enqueue_editor_scripts');