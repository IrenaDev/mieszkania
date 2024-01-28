document.body.addEventListener('mousedown', () => {
	document.body.classList.add('using-mouse');
});

document.body.addEventListener('keydown', event => {
	if (event.key === 'Tab') {
		document.body.classList.remove('using-mouse');
	}
});

window.addEventListener('load', () => {
	document.querySelector('body').classList.add('page-has-loaded');
});
