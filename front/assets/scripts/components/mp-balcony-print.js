import Components from '../Components.js';

export default function ( el ) {
	let registerEvents = () => {
		$(el).find('.mp-btn-print').on('click',function () {
			var divToPrint = $(el).find('.print-container');
			var newWin = window.open('','Print-Window');

			// Começo do html
			newWin.document.open();
			newWin.document.write('<html>');

			// Escrevendo o Meta
			newWin.document.write('<meta>');
			if ( divToPrint.data('title') ) {
				newWin.document.write('<title>'+divToPrint.data('title')+'</title>');
			}
			if ( divToPrint.data('style') ) {
				newWin.document.write('<link rel="stylesheet" href="'+divToPrint.data('style')+'">');
			}
			newWin.document.write('</meta>');


			if ( divToPrint.find('pre') ) {
				divToPrint.find('pre').hide()
				newWin.document.write('<style>'+ divToPrint.find('pre').html() +'</style>');
			}

			// Pegando o body
			newWin.document.write('<body onload="window.print()">'+divToPrint.html()+'</body>');

			// Finalizando e fechando a tela
			newWin.document.write('</html>');
			newWin.document.close();
			setTimeout(function(){
				newWin.close();
			},10);
		})
	}
	registerEvents();
}
