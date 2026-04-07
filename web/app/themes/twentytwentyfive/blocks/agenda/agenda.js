const { registerBlockType } = wp.blocks;
const { createElement, Fragment } = wp.element;
const ServerSideRender = wp.blockEditor?.ServerSideRender || wp.editor?.ServerSideRender;
const { InspectorControls } = wp.blockEditor || wp.editor;
const { PanelBody, RangeControl, TextControl } = wp.components;

registerBlockType('mytheme/agenda', {
    title: 'Agenda',
    icon: 'calendar',
    category: 'widgets',
    attributes: {
        number: { type: 'number', default: 5 },
        title: { type: 'string', default: '' }
    },
    edit: function(props) {
        const { attributes, setAttributes } = props;

        return createElement(
            Fragment,
            null,
            createElement(
                InspectorControls,
                null,
                createElement(
                    PanelBody,
                    { title: 'Paramètres du bloc', initialOpen: true },
                    // Champ titre
                    createElement(TextControl, {
                        label: 'Titre du bloc',
                        value: attributes.title,
                        onChange: (value) => setAttributes({ title: value })
                    }),
                    createElement(RangeControl, {
                        label: 'Nombre d’articles',
                        value: attributes.number,
                        onChange: value => setAttributes({ number: value }),
                        min: 1,
                        max: 20
                    })
                )
            ),
            createElement(ServerSideRender, {
                block: 'mytheme/agenda',
                attributes: attributes
            })
        );
    },
    save: function() { return null; }
});