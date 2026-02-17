( function ( wp ) {

	const { addFilter } = wp.hooks;
	const { createElement: el, Fragment } = wp.element;
	const { InspectorControls } = wp.blockEditor || wp.editor;
	const { PanelBody, ToggleControl, SelectControl } = wp.components;

	const ANIMATIONS = [
		{ label: 'Fade Up', value: 'fade-up' },
		{ label: 'Fade Down', value: 'fade-down' },
		{ label: 'Fade Left', value: 'fade-left' },
		{ label: 'Fade Right', value: 'fade-right' },
		{ label: 'Zoom In', value: 'zoom-in' },
	];

	// 1️⃣ Add attributes to ALL blocks
	addFilter(
		'blocks.registerBlockType',
		'gkp/animation-attributes',
		function ( settings ) {

			settings.attributes = Object.assign( settings.attributes, {
				gkpAnimation: {
					type: 'object',
					default: {
						enabled: false,
						type: 'fade-up',
						delay: 0,
						once: true,
					},
				},
			});

			return settings;
		}
	);

	// 2️⃣ Add Animations panel
	addFilter(
		'editor.BlockEdit',
		'gkp/animation-panel',
		function ( BlockEdit ) {

			return function ( props ) {

				const animation = props.attributes.gkpAnimation || {};

				return el(
					Fragment,
					{},
					el( BlockEdit, props ),
					el(
						InspectorControls,
						{},
						el(
							PanelBody,
							{ title: 'Animations', initialOpen: false },

							el( ToggleControl, {
								label: 'Enable Animation',
								checked: !!animation.enabled,
								onChange: function ( value ) {
									props.setAttributes({
										gkpAnimation: Object.assign({}, animation, {
											enabled: value,
										}),
									});
								},
							}),

							animation.enabled &&
								el( SelectControl, {
									label: 'Animation Type',
									value: animation.type,
									options: ANIMATIONS,
									onChange: function ( value ) {
										props.setAttributes({
											gkpAnimation: Object.assign({}, animation, {
												type: value,
											}),
										});
									},
								}),

							animation.enabled &&
								el( SelectControl, {
									label: 'Delay',
									value: animation.delay,
									options: [
										{ label: 'None', value: 0 },
										{ label: '100ms', value: 100 },
										{ label: '200ms', value: 200 },
										{ label: '300ms', value: 300 },
									],
									onChange: function ( value ) {
										props.setAttributes({
											gkpAnimation: Object.assign({}, animation, {
												delay: parseInt(value, 10),
											}),
										});
									},
								}),

							animation.enabled &&
								el( ToggleControl, {
									label: 'Animate Once',
									checked: !!animation.once,
									onChange: function ( value ) {
										props.setAttributes({
											gkpAnimation: Object.assign({}, animation, {
												once: value,
											}),
										});
									},
								})
						)
					)
				);
			};
		}
	);

} )( window.wp );
