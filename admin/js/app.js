(function(window, $, conscious){

	$(document).ready(function(){

		conscious.setState({
			'600': 600,
			'960': 960
		});
		
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

		conscious.stateChangeTo({
			'600': function() {
				dashboard.hideControlPanelMenu();
			},
			'960': function() {
				dashboard.hideControlPanelMenu();
			},
			'maxscreen': function() {
				dashboard.hideControlPanelMenu();
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
		snake_case = str;
		snake_case = $.trim(snake_case);
		// Strip all characters except alpha, hypen, underscore and spaces.
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

})(window, jQuery, conscious)