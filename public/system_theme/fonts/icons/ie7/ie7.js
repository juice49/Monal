/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referring to this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'Monal-Icons\'">' + entity + '</span>' + html;
	}
	var icons = {
		'icon-table-small': '&#xe61a;',
		'icon-table-large': '&#xf009;',
		'icon-table': '&#xf00a;',
		'icon-gear': '&#xf013;',
		'icon-tag': '&#xf02b;',
		'icon-tags': '&#xf02c;',
		'icon-gears': '&#xf085;',
		'icon-ellipsis-h': '&#xf141;',
		'icon-ellipsis-v': '&#xf142;',
		'icon-search': '&#xe600;',
		'icon-zoomin': '&#xe601;',
		'icon-zoomout': '&#xe602;',
		'icon-cog': '&#xe639;',
		'icon-menu': '&#xe63a;',
		'icon-phone': '&#xe603;',
		'icon-mail': '&#xe604;',
		'icon-pencil': '&#xe605;',
		'icon-paperclip': '&#xe606;',
		'icon-user': '&#xe607;',
		'icon-users': '&#xe608;',
		'icon-user-add': '&#xe609;',
		'icon-pie': '&#xe60a;',
		'icon-bars': '&#xe60b;',
		'icon-graph': '&#xe60c;',
		'icon-lock': '&#xe60d;',
		'icon-lock-open': '&#xe60e;',
		'icon-minus-circle': '&#xe60f;',
		'icon-plus-circle': '&#xe610;',
		'icon-cross-circle': '&#xe611;',
		'icon-minus': '&#xe612;',
		'icon-plus': '&#xe613;',
		'icon-erase': '&#xe614;',
		'icon-info': '&#xe615;',
		'icon-info-circle': '&#xe616;',
		'icon-question': '&#xe617;',
		'icon-help-circle': '&#xe618;',
		'icon-warning': '&#xe619;',
		'icon-list': '&#xe61b;',
		'icon-upload': '&#xe61c;',
		'icon-download': '&#xe61d;',
		'icon-disk': '&#xe61e;',
		'icon-cloud': '&#xe61f;',
		'icon-upload-cloud': '&#xe620;',
		'icon-play': '&#xe621;',
		'icon-pause': '&#xe622;',
		'icon-record': '&#xe623;',
		'icon-stop': '&#xe624;',
		'icon-next': '&#xe625;',
		'icon-previous': '&#xe626;',
		'icon-first': '&#xe627;',
		'icon-last': '&#xe628;',
		'icon-arrow-left': '&#xe629;',
		'icon-arrow-down': '&#xe62a;',
		'icon-arrow-up': '&#xe62b;',
		'icon-arrow-right': '&#xe62c;',
		'icon-arrow-left-circle': '&#xe62d;',
		'icon-arrow-down-circle': '&#xe62e;',
		'icon-arrow-up-circle': '&#xe62f;',
		'icon-arrow-right-circle': '&#xe630;',
		'icon-triangle-left': '&#xe631;',
		'icon-triangle-down': '&#xe632;',
		'icon-triangle-up': '&#xe633;',
		'icon-triangle-right': '&#xe634;',
		'icon-chevron-left': '&#xe635;',
		'icon-chevron-down': '&#xe636;',
		'icon-chevron-up': '&#xe637;',
		'icon-chevron-right': '&#xe638;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
