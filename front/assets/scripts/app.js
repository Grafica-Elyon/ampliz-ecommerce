import Components from './Components';
import MegaMenu from './MegaMenu';
import 'owl.carousel';
import 'jquery-mask-plugin';
import 'iframe-resizer/js/iframeResizer';
import "./extend";

(function ($) {
	new Components();
	new MegaMenu();

	$('footer .copy-footer .copy-2').attr('title', "Versão " + window.MrPrint.plugin.version);

})(jQuery);
