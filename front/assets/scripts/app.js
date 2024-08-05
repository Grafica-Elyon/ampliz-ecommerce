import Components from './Components';
import 'owl.carousel';
import 'jquery-mask-plugin';
import 'iframe-resizer/js/iframeResizer';
import "./extend";

(function ($) {
	new Components();

	$('footer .copy-footer .copy-2').attr('title', "Versão " + window.MrPrint.plugin.version);

})(jQuery);
