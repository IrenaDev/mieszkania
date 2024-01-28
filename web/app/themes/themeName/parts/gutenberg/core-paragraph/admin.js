const { __ } = wp.i18n;
const { registerBlockStyle } = wp.blocks;

const styles = [
	{
		name: 'uppercase',
		label: __('Uppercase', 'themename'),
	},
	{
		name: 'subheading',
		label: __('Subheading', 'themename'),
	},
	{
		name: 'leadparagraph',
		label: __('Leadparagraph', 'themename'),
	},
];

wp.domReady(() => {
	styles.forEach(style => {
		registerBlockStyle('core/paragraph', style);
	});
});
