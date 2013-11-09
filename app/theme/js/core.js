/**
 * Core scripts for controlling dashboard layout and interactions
 *
 * @author Arran Jacques 
 */

(function($, conscious){

	'use strict';

	// Dashboard object
	window._DASHBOARD = {

		// Is the control panel submenu on display
		controlPanelOpen : false,

		/**
		 * Initialise the dashboard on load
		 */
		init : function() {

			$('.control_panel-submenu').hide();
			$('.control_panel-submenu_close').hide();

			// Bind mouse events for control panel
			$('.control_panel-heading').on('click', function(){
				$('.control_panel-heading').removeClass('active');
				if(!$(this).data('active')){
					$('.control_panel-heading').data('active', false);
					$(this).addClass('active').data('active', true);
					_DASHBOARD.expandControlPanel($(this).data('submenu'));
				}
				else{
					$('.control_panel-heading').data('active', false);
					_DASHBOARD.collapseControlPanel();
				}
			});
			$('.body-wrap, .control_panel-submenu_close').on('click', function(){
				$('.control_panel-heading').removeClass('active').data('active', false);
				_DASHBOARD.collapseControlPanel();
			});

			$('.dashboard-main').height($('.body-wrap').height() - $('.logout').outerHeight());
		},

		/**
		 * Expand the dashboard control panel to reveal submenu for menu item
		 *
		 * @param	String		The submenu to reveal
		 */
		expandControlPanel : function(submenu){

			$('.control_panel-submenu').hide();
			$('#' + submenu).show();
		
			if(!_DASHBOARD.controlPanelOpen){
				$('.control_panel').animate({
					'padding-right' : '+=250',
				}, 500);
				$('.body-wrap, .control_panel-submenu_bkg').animate({
					'padding-left' : '+=250',
				}, 500);
				$('.dashboard-content').animate({
					'margin-right' : '-=250',
				}, 500, null, function(){
					$('.control_panel-submenu_close').show();
				});
				_DASHBOARD.controlPanelOpen = true;
			}
		},

		/**
		 * Collapse the dashboard control panel to hide submenus
		 */
		collapseControlPanel : function(){

			if(_DASHBOARD.controlPanelOpen){
				$('.control_panel').animate({
					'padding-right' : '-=250',
				}, 500);
				$('.body-wrap, .control_panel-submenu_bkg').animate({
					'padding-left' : '-=250',
				}, 500);
				$('.dashboard-content').animate({
					'margin-right' : '+=250',
				}, 500);
				$('.control_panel-submenu_close').hide();
				_DASHBOARD.controlPanelOpen = false;
			}
			
		}

	}

})(jQuery, conscious);