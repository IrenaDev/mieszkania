/* global Splide */
const elms = document.getElementsByClassName('splide');
const runSlider = () => {
	Array.prototype.forEach.call(elms, el => {
		new Splide(el, {
			perPage: 1,
			autoHeight: true,
		}).mount();
	});
};

runSlider();

if (window.acf) {
	window.acf.addAction('render_block_preview/type=slider', runSlider);
}
