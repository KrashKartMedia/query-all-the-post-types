/**
 * Query All The Post Types — Admin tab switching and label toggling.
 *
 * @package
 */

(function () {
	'use strict';

	const tabs = document.querySelectorAll('.qatp-tab');
	const panels = document.querySelectorAll('.qatp-tab-panel');

	/**
	 * Activate a specific tab and show its panel.
	 *
	 * @param {HTMLElement} tab The tab button to activate.
	 */
	function activateTab(tab) {
		// Deactivate all tabs.
		tabs.forEach(function (t) {
			t.classList.remove('qatp-tab-active');
			t.setAttribute('aria-selected', 'false');
			t.setAttribute('tabindex', '-1');
		});

		// Hide all panels.
		panels.forEach(function (p) {
			p.style.display = 'none';
			p.setAttribute('aria-hidden', 'true');
		});

		// Activate the selected tab.
		tab.classList.add('qatp-tab-active');
		tab.setAttribute('aria-selected', 'true');
		tab.setAttribute('tabindex', '0');

		// Show the associated panel.
		const panel = document.getElementById(
			'qatp-panel-' + tab.getAttribute('data-tab')
		);
		if (panel) {
			panel.style.display = 'block';
			panel.setAttribute('aria-hidden', 'false');
		}
	}

	// Tab click handler.
	tabs.forEach(function (tab) {
		tab.addEventListener('click', function () {
			activateTab(tab);
		});
	});

	// Keyboard navigation for tabs.
	tabs.forEach(function (tab, index) {
		tab.addEventListener('keydown', function (e) {
			let targetIndex = null;

			// Arrow key navigation.
			if ('ArrowRight' === e.key || 'ArrowDown' === e.key) {
				e.preventDefault();
				targetIndex = (index + 1) % tabs.length;
			} else if ('ArrowLeft' === e.key || 'ArrowUp' === e.key) {
				e.preventDefault();
				targetIndex = (index - 1 + tabs.length) % tabs.length;
			} else if ('Home' === e.key) {
				e.preventDefault();
				targetIndex = 0;
			} else if ('End' === e.key) {
				e.preventDefault();
				targetIndex = tabs.length - 1;
			}

			if (null !== targetIndex) {
				tabs[targetIndex].focus();
				activateTab(tabs[targetIndex]);
			}
		});
	});

	// Toggle button handler with aria-expanded.
	const toggles = document.querySelectorAll('.qatp-toggle');

	toggles.forEach(function (button) {
		button.addEventListener('click', function () {
			const targetId = button.getAttribute('data-target');
			const el = document.getElementById(targetId);

			if (el) {
				const isHidden = 'none' === el.style.display;
				el.style.display = isHidden ? 'block' : 'none';
				el.setAttribute('aria-hidden', isHidden ? 'false' : 'true');
				button.setAttribute(
					'aria-expanded',
					isHidden ? 'true' : 'false'
				);
			}
		});
	});
})();
