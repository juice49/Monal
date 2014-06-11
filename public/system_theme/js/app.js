(function(window, $, conscious){

	$(document).ready(function(){

		// Set break points for dashboard.
		conscious.setState({
			'600': 600,
			'960': 960
		});
		
		// Toggle the dashboard control panel menu open/closed.
		$('.js--menu__option').on('click', function(){ 
			if ($(this).data('open') === 'open') {
				dashboard.hideControlPanelMenu($(this));
			} else {
				dashboard.showControlPanelMenu($(this));
			}
		});

		$('.js--mobile__nav').on('click', function() {
			if ($('.js--dashboard').data('open') === 'open') {
				dashboard.hideControlPanel();
			} else {
				dashboard.showControlPanel();
			}
		});

		$('.js--dashboard__user').on('click', function() {
			$('.js--user__menu').slideToggle(100);
		});
		$('.js--dashboard__header').on('mouseleave', function() {
			$('.js--user__menu').slideUp(100);
		});

		// Close the dashboard control panel menu each the window moves
		// through a breakpoint.
		conscious.stateChangeTo({
			'600': function() {
				dashboard.hideControlPanelMenu();
				$('.js--user__menu').slideUp(100);
			},
			'960': function() {
				dashboard.hideControlPanelMenu();
				$('.js--user__menu').slideUp(100);
			},
			'maxscreen': function() {
				dashboard.hideControlPanelMenu();
				$('.js--user__menu').slideUp(100);
			},
		});
	});

	/* ==================================================
	 * Dashboard functions
	 ================================================== */

	window.dashboard = {

		showControlPanel: function() {
			$('.js--dashboard').addClass('dashboard__control_panel--open').data('open', 'open');
		},

		hideControlPanel: function() {
			$('.js--dashboard').removeClass('dashboard__control_panel--open').data('open', 'closed');
		},

		showControlPanelMenu: function($option) {
			dashboard.showControlPanel();
			$('.js--menu__options').removeClass('menu__group__options--active');
			$('.js--menu__option').data('open', 'closed').removeClass('menu__group__title--active');
			$option.next('.menu__group__options').addClass('menu__group__options--active');
			$option.data('open', 'open').addClass('menu__group__title--active');
		},

		hideControlPanelMenu: function() {
			dashboard.hideControlPanel();
			$('.js--menu__options').removeClass('menu__group__options--active');
			$('.js--menu__option').next('.menu__group__options').removeClass('menu__group__options--active');
			$('.js--menu__option').data('open', 'closed').removeClass('menu__group__title--active');
		}
	};

	/* ==================================================
	 * Global helper functions.
	 ================================================== */

	/**
	 * Convert a string to snake_case allowing only alpha, underscore
	 * and space characters.
	 */
	window.snakeCaseString = function(str) {
		var snake_case = str;
		snake_case = $.trim(snake_case);
		// Strip all characters except alpha, hypens, underscores and spaces.
		snake_case = snake_case.replace(/[^A-Za-z-_ ]+/g, '');
		// Convert hyphens to spaces.
		snake_case = snake_case.replace(/[-]/g, ' ');
		// Replace mutiple spaces with one space.
		snake_case = snake_case.replace(/ +(?= )/g,'');
		// Convert spaces to underscores.
		snake_case = snake_case.replace(/[ ]/g, '_');
		// Covert characters to lowercase.
		snake_case = snake_case.toLowerCase();
		return snake_case;
	}

	window.slugify = function(str) {
		var slug = str;
		slug = $.trim(slug);
		// Strip all characters except alpha, numberic, hypens and underscores.
		slug = slug.replace(/[^A-Za-z0-9-_ ]+/g, '');
		// Convert hyphens and underscores to spaces.
		slug = slug.replace(/[-_]/g, ' ');
		// Replace mutiple spaces with one space.
		slug = slug.replace(/ +(?= )/g,'');
		// Convert spaces to hyphens.
		slug = slug.replace(/[ ]/g, '-');
		// Covert characters to lowercase.
		slug = slug.toLowerCase();
		return slug;
	}

})(window, jQuery, conscious)