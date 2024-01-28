const toggleAccordion = function (event) {
	event.preventDefault();
	const expanded = this.getAttribute('aria-expanded') === 'true' || false;
	this.setAttribute('aria-expanded', !expanded);
	const item = this.parentElement.nextElementSibling;
	item.hidden = !item.hidden;
};

const runAccordions = () => {
	document.querySelectorAll('.single-accordion__trigger').forEach(element => {
		element.addEventListener('click', toggleAccordion);
	});
};

runAccordions();

if (window.acf) {
	window.acf.addAction('render_block_preview/type=accordion', runAccordions);
}
