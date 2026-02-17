( function ( wp ) {

    const { registerPlugin } = wp.plugins;
    const { PluginDocumentSettingPanel } = wp.editPost;
    const { ToggleControl } = wp.components;
    const { createElement: el } = wp.element;
    const { useSelect, useDispatch } = wp.data;

    const GatekeeperPageSettings = function () {

        const meta = useSelect(
            ( select ) => select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
            []
        );

        const { editPost } = useDispatch( 'core/editor' );

        return el(
            PluginDocumentSettingPanel,
            {
                name: 'gkp-page-settings',
                title: 'Page Layout',
                className: 'gkp-page-settings',
            },
            el( ToggleControl, {
                label: 'Hide Default Header',
                checked: !! meta.gkp_hide_header,
                onChange: function ( value ) {
                    editPost( {
                        meta: Object.assign( {}, meta, {
                            gkp_hide_header: value,
                        } ),
                    } );
                },
            } ),
            el( ToggleControl, {
                label: 'Hide Default Footer',
                checked: !! meta.gkp_hide_footer,
                onChange: function ( value ) {
                    editPost( {
                        meta: Object.assign( {}, meta, {
                            gkp_hide_footer: value,
                        } ),
                    } );
                },
            } )
        );
    };

    registerPlugin( 'gkp-page-settings', {
        render: GatekeeperPageSettings,
    } );

} )( window.wp );
