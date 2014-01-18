(function(window, $, conscious){

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