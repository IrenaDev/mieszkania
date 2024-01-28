const toggleLinks = document.querySelectorAll('.btn-menu, .menu-item__dropdown');
Array.from(toggleLinks).forEach(link => {
	link.addEventListener('click', function () {
		const expanded = this.getAttribute('aria-expanded') === 'true' || false;
		this.setAttribute('aria-expanded', !expanded);
		const menu = this.nextElementSibling;
		menu.hidden = !menu.hidden;
	});
});

const hoverSubmenu = document.querySelectorAll('.main-header__desktop-nav .menu-item-has-children');
Array.from(hoverSubmenu).forEach(link => {
	link.addEventListener('mouseover', function () {
		const dropdown = this.querySelector('.menu-item__dropdown');
		if (dropdown.getAttribute('aria-expanded') !== 'true') {
			const expanded = dropdown.getAttribute('aria-expanded') === 'true' || false;
			dropdown.setAttribute('aria-expanded', !expanded);
			const menu = this.querySelector('.menu-item__submenu');
			menu.hidden = false;
		}
	});
	link.addEventListener('mouseout', function () {
		const dropdown = this.querySelector('.menu-item__dropdown');
		const expanded = dropdown.getAttribute('aria-expanded') === 'true' || false;
		dropdown.setAttribute('aria-expanded', !expanded);
		const menu = this.querySelector('.menu-item__submenu');
		menu.hidden = true;
	});
});

