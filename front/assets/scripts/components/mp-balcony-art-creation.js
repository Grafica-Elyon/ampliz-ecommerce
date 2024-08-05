import Components from '../Components.js';

export default function ( el ) {
	let $el = $(el);

	let registerEvents = () => {
		$el.find( '#txtTelefone' ).mask('(00) 0000-0000');
		$el.find( '#txtCelular' ).mask('(00) 00000-0000');

		$el.on('click', '.creation-arts .duplicar-arte', duplicarArte);
		$el.on('click', '.more-art', adicionarArte);
		$el.on('click', '.remover-arte', removerArte);

		$el.on('submit', 'form', sendForm);
	}

	let adicionarArte = function () {
		let $this = $(this);
		let $row = $($this.parent().parent().find('.arts-list > .mp-form-row')[0]);
		let $clonedRow = $row.clone(true, true);
		$clonedRow.appendTo( $row.parent() );
		$clonedRow.find('[name*="txtProcessoReferencia"]').val('');
		$clonedRow.find('[name*="txtTipoProduto"]').val('');
		atualizarBotoesTirarLinha();
	}
	let duplicarArte = function () {
		let $this = $(this);
		let $row = $this.parents('.mp-form-row');
		let $clonedRow = $row.clone(true, true);
		$clonedRow.appendTo( $row.parent() );
		$clonedRow.find('.mp-select').val($row.find('.mp-select').val());
		atualizarBotoesTirarLinha();
	}
	let removerArte = function () {
		let $this = $(this);
		let $row = $this.parents('.mp-form-row');
		$row.remove();
		atualizarBotoesTirarLinha();
	}

	let atualizarBotoesTirarLinha = function () {
		let linhas = $el.find('.arts-list > *');
		let mostrar = linhas.length >= 2;

		$(linhas).find('.remover-arte')[ mostrar ? 'show' : 'hide' ]();
	}

	let sendForm = function ( e ) {
		e.preventDefault();

		var form = $(this);

		Components.loading( el, 'start' );

		$.ajax({
			type: "POST",
			url: wp.ajax_url,
			data: form.serialize(),
			success: function(data) {
				Components.loading( el, 'stop' );
				if ( data.status == 'success' ) {
					resetForm();
					window.alert('Sucesso.');
				} else if ( data.status == 'success' ) {
					window.alert('Erro: '+data.message);
				}
			}
		});
	}
	let resetForm = function () {
		let $form = $el.find('form');
		$form[0].reset();
		$form.find('.arts-list > :not(:first-child)').remove();
		atualizarBotoesTirarLinha();
	}

	registerEvents();
}
