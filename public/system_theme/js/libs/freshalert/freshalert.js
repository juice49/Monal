/**
 *
 */
(function(window, $){

	freshalert = {

		generateReference: function(){
			var ref = '';
			var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			for(var i = 0; i < 10; i++){
				ref += possible.charAt(Math.floor(Math.random() * possible.length));
			}
			return ref;
		},

		alert: function(s){
			var settings = {};
			settings.type = (s.type !== undefined) ? s.type : 'danger';
			settings.title = (s.title !== undefined) ? s.title : 'Warning';
			settings.message = (s.message !== undefined) ? s.message : null;
			var alert = new Alert(settings);
			alert.show();
		},

		activeConfirm: function(s){
			var settings = {};
			settings.type = (s.type !== undefined) ? s.type : 'danger';
			settings.check = (s.check !== undefined) ? s.check : 'CONFIRM';
			settings.title = (s.title !== undefined) ? s.title : 'Warning';
			settings.message = (s.message !== undefined) ? s.message : null;
			settings.success = (s.success !== undefined) ? s.success : function(){};
			settings.cancel = (s.cancel !== undefined) ? s.cancel : function(){};
			var alert = new ActiveConfirm(settings);
			alert.show();
		}
	}

	function Alert(settings){

		var _this = this;
		this.reference = freshalert.generateReference();
		this.cover = '<div class="freshalert-alert_cover" id="freshalert-cover-' + _this.reference + '"></div>';
		this.alert = '<div class="freshalert-alert_wrap" id="freshalert-wrap-' + _this.reference + '">';
		this.alert += '<div class="freshalert-alert freshalert-' + settings.type + '">';
		this.alert += '<h1>' + settings.title + '</h1>';
		this.alert += (settings.message !== null) ? '<p>' + settings.message + '</p>' : '';
		this.alert += '<div class="freshalert-buttons"><span class="freshalert-btn freshalert-ok" id="freshalert-ok-' + _this.reference + '">Ok</span></div></div></div>';

		this.show = function(){
			$('body').append(_this.cover).append(_this.alert).data('freshalert', true);
			$('#freshalert-ok-' + _this.reference).on('click', function(){
				_this.remove();
			});
			$('#freshalert-wrap-' + _this.reference).css({
			 	'margin-top': '-' + ($('.freshalert-alert_wrap').outerHeight() / 2),
			 	'margin-left': '-' + ($('.freshalert-alert_wrap').outerWidth() / 2)
			 });
			 $(window).on('resize', function(){
			 	$('#freshalert-wrap-' + _this.reference).css({
				 	'margin-top': '-' + ($('.freshalert-alert_wrap').outerHeight() / 2),
				 	'margin-left': '-' + ($('.freshalert-alert_wrap').outerWidth() / 2)
				 });
			 });
		};

		this.remove = function(){
			$('#freshalert-cover-' + _this.reference + ', #freshalert-wrap-' + _this.reference).remove();
		};
	}

	function ActiveConfirm(settings){

		var _this = this;
		this.reference = freshalert.generateReference();
		this.cover = '<div class="freshalert-alert_cover" id="freshalert-cover-' + _this.reference + '"></div>';
		this.alert = '<div class="freshalert-alert_wrap" id="freshalert-wrap-' + _this.reference + '">';
		this.alert += '<div class="freshalert-alert freshalert-' + settings.type + '">';
		this.alert += '<h1>' + settings.title + '</h1>';
		this.alert += (settings.message !== null) ? '<p>' + settings.message + '</p>' : '';
		this.alert += '<p>Please type "' + settings.check + '" below and click confirm to proceed.</p>';
		this.alert += '<form><input type="text" class="freshalert-input" id="freshalert-input-' + _this.reference + '" /></form>';
		this.alert += '<div class="freshalert-buttons"><span class="freshalert-btn freshalert-cancel" id="freshalert-cancel-' + _this.reference + '">Cancel</span>';
		this.alert += '<span class="freshalert-btn freshalert-confirm" id="freshalert-confirm-' + _this.reference + '">Confirm</span></div></div></div>';

		this.show = function(){
			$('body').append(_this.cover).append(_this.alert).data('freshalert', true);
			$('#freshalert-confirm-' + _this.reference).on('click', function(){
				if (_this.validate()){
					settings.success();
					_this.remove();
				}
			});
			$('#freshalert-cancel-' + _this.reference).on('click', function(){
				settings.cancel();
				_this.remove();
			});
			$('#freshalert-wrap-' + _this.reference).css({
			 	'margin-top': '-' + ($('.freshalert-alert_wrap').outerHeight() / 2),
			 	'margin-left': '-' + ($('.freshalert-alert_wrap').outerWidth() / 2)
			 });
			 $(window).on('resize', function(){
			 	$('#freshalert-wrap-' + _this.reference).css({
				 	'margin-top': '-' + ($('.freshalert-alert_wrap').outerHeight() / 2),
				 	'margin-left': '-' + ($('.freshalert-alert_wrap').outerWidth() / 2)
				 });
			 });
		};

		this.remove = function(){
			$('#freshalert-cover-' + _this.reference + ', #freshalert-wrap-' + _this.reference).remove();
		};

		this.validate = function(){
			return ($('#freshalert-input-' + _this.reference).val() === settings.check) ? true : false;
		};
	}

	window.freshAlert = freshalert.alert;
	window.activeConfirm = freshalert.activeConfirm;

})(window, jQuery);