(function(window, $, conscious){

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

	/* ==================================================
	 * UI setup and control.
	 ================================================== */
	conscious.maxscreen = 'desktop';
	conscious.setState({
		'mobile': 600,
		'tablet': 960
	});

	window.dashboard = {

		menu_category_open: false,

		mobile: {

			menu_open: false,

			openMobileMenu: function(){
				$('.js--dashboard__menu').animate({
					'left': 0
				}, 200, null);
				$('.js--dashboard__body').animate({
					'padding-left': $('.js--dashboard__menu').width(),
					'margin-right': '-' + $('.js--dashboard__menu').width()
				}, 200, null);
				dashboard.mobile.menu_open = true;
			},

			closeMobileMenu: function(){
				$('.js--dashboard__menu').animate({
					'left': '-' + $('.js--dashboard__menu').width()
				}, 200, null);
				$('.js--dashboard__body').animate({
					'padding-left': 0,
					'margin-right': 0
				}, 200, null, function(){
					$('.js--dashboard__body, .js--dashboard__menu').removeAttr('style');
				});
				dashboard.mobile.menu_open = false;
			},

			toggleMobileMenu: function(){
				if(!dashboard.mobile.menu_open){
					dashboard.mobile.openMobileMenu();
				}
				else{
					dashboard.mobile.closeMobileMenu();
				}
			}
		},

		openMenuCategory: function($group){
			if (!dashboard.menu_category_open && conscious.getState() === 'desktop'){
				$('.js--dashboard__menu').animate({
					'padding-right': $('.js--dashboard__menu').width()
				}, 200, null);
				$('.js--dashboard__body').animate({
					'padding-left': '+=' + $('.js--dashboard__menu').width(),
					'margin-right': '-' + $('.js--dashboard__menu').width()
				}, 200, null);
			}
			$('.js--dashboard__menu__group').removeClass('dashboard__menu__group--active').data('open', false);
			$group.addClass('dashboard__menu__group--active').data('open', true);
			dashboard.menu_category_open = true;
		},

		closeMenuCategory: function(){
			if(conscious.getState() === 'desktop'){
				$('.js--dashboard__menu').animate({
					'padding-right': 0
				}, 200);
				$('.js--dashboard__body').animate({
					'padding-left': '-=' + $('.js--dashboard__menu').width(),
					'margin-right': 0
				}, 200, null, function(){
					$('.js--dashboard__body, .js--dashboard__menu').removeAttr('style');
					$('.js--dashboard__menu__group').removeClass('dashboard__menu__group--active').data('open', false);
				});
			}
			else{
				$('.js--dashboard__menu__group').removeClass('dashboard__menu__group--active').data('open', false);
			}
			dashboard.menu_category_open = false;
		},

		toggleMenuCategory: function($group){
			if(!$group.data('open')){
				dashboard.openMenuCategory($group);
			}
			else{
				dashboard.closeMenuCategory();
			}
		},

		resetMenuCategory: function(){
			$('.js--dashboard__body, .js--dashboard__menu').removeAttr('style');
			$('.js--dashboard__menu__group').removeClass('dashboard__menu__group--active').data('open', false)
			dashboard.menu_category_open = false;
			dashboard.mobile.menu_open = false;
		},

		smoothLoad: function(collection, i){
			i = (i === undefined) ? 0 : i;
			if (i < $(collection).length){
				$(collection).eq(i).fadeIn(100, null, function(){
					dashboard.smoothLoad(collection, i + 1);
				});
			}
		}

	};

	conscious.stateChangeTo({
		'mobile': function(){
			dashboard.resetMenuCategory();
		},
		'tablet': function(){
			dashboard.resetMenuCategory();
		},
		'desktop': function(){
			dashboard.resetMenuCategory();
		}
	});

	$(document).ready(function(){
		$('.js--dashboard__menu__group').on('click', function(){
			dashboard.toggleMenuCategory($(this));
		});
		$('.js--toggle_menu').on('click', function(){
			dashboard.mobile.toggleMobileMenu();
		});
	});

})(window, jQuery, conscious)