/**
 *
 */

(function($, conscious){

	'use strict';

	window._CMS = {

		controlPanelOpen : false,
		submenuOnDisplay : false,

		init : function() {

			$('.cp-submenu').hide();
			$('.has_submenu').on('click', function(){
				_CMS.submenuOnDisplay = $(this).data('submenu');
				_CMS.expandControlPanel();
			});
			$('.body-wrap').on('click', _CMS.collapseControlPanel);

			$('.dashboard-main').height($('.body-wrap').height() - $('.logout').outerHeight())
		},

		expandControlPanel : function(){

			$('.cp-submenu').hide();
		
			if(!_CMS.controlPanelOpen){

				$('#' + _CMS.submenuOnDisplay).show();

				$('.control_panel').animate({
					'padding-right' : '+=280',
				}, 500);
				$('.body-wrap, .control_panel-submenu_bkg').animate({
					'padding-left' : '+=280',
				}, 500);
				$('.dashboard-content').animate({
					'margin-right' : '-=280',
				}, 500);

				_CMS.controlPanelOpen = true;
			}
			else{
				$('#' + _CMS.submenuOnDisplay).show();
			}
		},

		collapseControlPanel : function(){

			$('.cp-submenu').hide();

			if(_CMS.controlPanelOpen){

				$('.control_panel').animate({
					'padding-right' : '-=280',
				}, 500);
				$('.body-wrap, .control_panel-submenu_bkg').animate({
					'padding-left' : '-=280',
				}, 500);

				_CMS.controlPanelOpen = false;
				_CMS.submenuOnDisplay = false;
			}
		}

	}

})(jQuery, conscious);