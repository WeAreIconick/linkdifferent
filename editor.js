(function() {
    const { addFilter } = wp.hooks;
    const { createHigherOrderComponent } = wp.compose;
    const { Fragment } = wp.element;
    const { InspectorControls, ColorPalette } = wp.blockEditor;
    const { BaseControl, PanelBody, Button, ButtonGroup } = wp.components;

    // Add custom attributes to paragraph blocks
    addFilter(
        'blocks.registerBlockType',
        'link-different/add-attributes',
        function(settings, name) {
            if (name !== 'core/paragraph') {
                return settings;
            }

            return {
                ...settings,
                attributes: {
                    ...settings.attributes,
                    linkDifferentColor: {
                        type: 'string',
                        default: ''
                    },
                    linkDifferentStyle: {
                        type: 'string',
                        default: ''
                    }
                }
            };
        }
    );

    // Add Link Styles panel to inspector controls
    const withLinkStyleControls = createHigherOrderComponent(function(BlockEdit) {
        return function(props) {
            if (props.name !== 'core/paragraph') {
                return wp.element.createElement(BlockEdit, props);
            }

            const { attributes, setAttributes } = props;
            const { linkDifferentColor, linkDifferentStyle, className } = attributes;
            
            // Parse current style from className
            let currentStyle = linkDifferentStyle || '';
            if (!currentStyle && className) {
                if (className.includes('is-style-peace-out')) currentStyle = 'peace-out';
                else if (className.includes('is-style-rainbow')) currentStyle = 'rainbow';
                else if (className.includes('is-style-hat-tip')) currentStyle = 'hat-tip';
                else if (className.includes('is-style-boing')) currentStyle = 'boing';
                else if (className.includes('is-style-strikethrough')) currentStyle = 'strikethrough';
                else if (className.includes('is-style-squiggle')) currentStyle = 'squiggle';
            }

            // Function to update the paragraph style
            const setLinkStyle = function(style) {
                let newClassName = className || '';
                
                // Remove existing link styles
                newClassName = newClassName.replace(/\bis-style-peace-out\b/g, '');
                newClassName = newClassName.replace(/\bis-style-rainbow\b/g, '');
                newClassName = newClassName.replace(/\bis-style-hat-tip\b/g, '');
                newClassName = newClassName.replace(/\bis-style-boing\b/g, '');
                newClassName = newClassName.replace(/\bis-style-strikethrough\b/g, '');
                newClassName = newClassName.replace(/\bis-style-squiggle\b/g, '');
                newClassName = newClassName.trim();
                
                // Add new style if not 'none'
                if (style && style !== 'none') {
                    newClassName = newClassName ? newClassName + ' is-style-' + style : 'is-style-' + style;
                }
                
                setAttributes({ 
                    className: newClassName.trim(),
                    linkDifferentStyle: style
                });
            };

            const linkStyles = [
                { value: 'none', label: 'Default' },
                { value: 'peace-out', label: 'Peace Out' },
                { value: 'rainbow', label: 'Rainbow' },
                { value: 'hat-tip', label: 'Hat Tip' },
                { value: 'boing', label: 'Boing' },
                { value: 'strikethrough', label: 'Strikethrough' },
                { value: 'squiggle', label: 'Squiggle' }
            ];

            const showColorPicker = currentStyle && currentStyle !== 'none' && currentStyle !== 'rainbow';

            const colors = [
                { name: 'Blue', color: '#54b3d6' },
                { name: 'Teal', color: '#5cb3a6' },
                { name: 'Green', color: '#56a656' },
                { name: 'Purple', color: '#8656a6' },
                { name: 'Pink', color: '#d656a6' },
                { name: 'Orange', color: '#d68656' },
                { name: 'Red', color: '#d65656' },
                { name: 'Yellow', color: '#d6d656' },
                { name: 'Dark Blue', color: '#2c3e50' },
                { name: 'Dark Gray', color: '#34495e' }
            ];

            return wp.element.createElement(
                Fragment,
                {},
                wp.element.createElement(BlockEdit, props),
                wp.element.createElement(
                    InspectorControls,
                    {},
                    wp.element.createElement(
                        PanelBody,
                        { 
                            title: 'Link Styles',
                            initialOpen: true
                        },
                        wp.element.createElement(
                            'div',
                            {
                                className: 'block-editor-block-styles'
                            },
                            wp.element.createElement(
                                'div',
                                {
                                    className: 'block-editor-block-styles__variants'
                                },
                                linkStyles.map(function(style) {
                                    const isActive = (currentStyle === style.value || (!currentStyle && style.value === 'none'));
                                    return wp.element.createElement(
                                        'button',
                                        {
                                            key: style.value,
                                            type: 'button',
                                            className: 'components-button block-editor-block-styles__item is-next-40px-default-size is-secondary' + (isActive ? ' is-active' : ''),
                                            onClick: function() { setLinkStyle(style.value); },
                                            'aria-current': isActive ? 'true' : 'false',
                                            'aria-label': style.label
                                        },
                                        wp.element.createElement(
                                            'span',
                                            {
                                                className: 'components-truncate block-editor-block-styles__item-text css-5fhmgp e19lxcc00',
                                                'data-wp-c16t': 'true',
                                                'data-wp-component': 'Truncate'
                                            },
                                            style.label
                                        )
                                    );
                                })
                            )
                        ),
                        showColorPicker && wp.element.createElement(
                            Fragment,
                            {},
                            wp.element.createElement(
                                'hr',
                                { style: { margin: '16px 0' } }
                            ),
                            wp.element.createElement(
                                BaseControl,
                                {
                                    label: 'Link Accent Color',
                                    help: 'Choose a color for the link effect'
                                },
                                wp.element.createElement(ColorPalette, {
                                    colors: colors,
                                    value: linkDifferentColor,
                                    onChange: function(color) {
                                        setAttributes({ linkDifferentColor: color });
                                    },
                                    disableCustomColors: false,
                                    clearable: true
                                })
                            )
                        )
                    )
                )
            );
        };
    }, 'withLinkStyleControls');

    // Apply link style controls to block edit
    addFilter(
        'editor.BlockEdit',
        'link-different/with-link-style-controls',
        withLinkStyleControls
    );

    // Add inline style to blocks in editor
    const withInlineStyle = createHigherOrderComponent(function(BlockListBlock) {
        return function(props) {
            if (props.name !== 'core/paragraph' || !props.attributes.linkDifferentColor) {
                return wp.element.createElement(BlockListBlock, props);
            }

            const customProps = {
                ...props,
                wrapperProps: {
                    ...props.wrapperProps,
                    style: {
                        ...(props.wrapperProps ? props.wrapperProps.style : {}),
                        '--link-different-accent-color': props.attributes.linkDifferentColor
                    }
                }
            };

            return wp.element.createElement(BlockListBlock, customProps);
        };
    }, 'withInlineStyle');

    // Apply inline style to editor
    addFilter(
        'editor.BlockListBlock',
        'link-different/with-inline-style',
        withInlineStyle
    );

    // Add inline style to saved content
    addFilter(
        'blocks.getSaveContent.extraProps',
        'link-different/add-save-style',
        function(extraProps, blockType, attributes) {
            if (blockType.name !== 'core/paragraph') {
                return extraProps;
            }
            
            const { linkDifferentColor, className, squiggleSvg } = attributes;
            let customStyle = {};
            
            if (linkDifferentColor) {
                customStyle['--link-different-accent-color'] = linkDifferentColor;
            }
            
            // If it's a squiggle style, use the stored SVG or generate one
            if (className && className.includes('is-style-squiggle')) {
                if (squiggleSvg) {
                    customStyle['--squiggle-svg'] = squiggleSvg;
                } else {
                    const squiggleColor = linkDifferentColor || '#54b3d6';
                    const encodedColor = squiggleColor.replace('#', '%23');
                    const squiggleSVG = "url(\"data:image/svg+xml;charset=utf8,%3Csvg id='squiggle-link' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:ev='http://www.w3.org/2001/xml-events' viewBox='0 0 10 18'%3E%3Cstyle type='text/css'%3E.squiggle%7Banimation:shift .5s linear infinite;%7D@keyframes shift %7Bfrom %7Btransform:translateX(-10px);%7Dto %7Btransform:translateX(0);%7D%7D%3C/style%3E%3Cpath fill='none' stroke='" + encodedColor + "' stroke-width='1' class='squiggle' d='M0,17.5 c 2.5,0,2.5,-1.5,5,-1.5 s 2.5,1.5,5,1.5 c 2.5,0,2.5,-1.5,5,-1.5 s 2.5,1.5,5,1.5' /%3E%3C/svg%3E\")";
                    customStyle['--squiggle-svg'] = squiggleSVG;
                }
            }

            return {
                ...extraProps,
                style: {
                    ...extraProps.style,
                    ...customStyle
                }
            };
        }
    );
})();