<?php

namespace MisterPrint\Support;

class MenuTree
{
	public static function porGrupo( $itens, $grupos )
	{
		$ordenados = self::naOrdemDaApi( $itens );
		$filhosPorMaster = array();

		foreach ( $ordenados as $item ) {
			if ( ! empty( $item['master_id'] ) ) {
				$filhosPorMaster[ (int) $item['master_id'] ][] = $item;
			}
		}

		$arvore = array();

		foreach ( (array) $grupos as $grupo ) {
			$grupo = (array) $grupo;
			$grupoId = (int) $grupo['id'];
			$exibeItens = self::exibeItens( $grupo );

			$raizesNoGrupo = array();

			foreach ( $ordenados as $item ) {
				if ( empty( $item['master_id'] ) && self::pertenceAoGrupo( $item, $grupoId ) ) {
					$raizesNoGrupo[ (int) $item['codigoMenu'] ] = true;
				}
			}

			$doGrupo = array();

			foreach ( $ordenados as $item ) {
				$menuId = (int) $item['codigoMenu'];

				if ( empty( $item['master_id'] ) ) {
					if ( ! isset( $raizesNoGrupo[ $menuId ] ) ) {
						continue;
					}

					$filhos = isset( $filhosPorMaster[ $menuId ] ) ? $filhosPorMaster[ $menuId ] : array();

					$item['children'] = $exibeItens ? $filhos : array();
					$doGrupo[] = $item;

					continue;
				}

				if ( ! self::vinculadoAoGrupo( $item, $grupoId ) ) {
					continue;
				}

				// Com o master na categoria, o item já aparece dentro dele: solto seria repetido.
				if ( $exibeItens && isset( $raizesNoGrupo[ (int) $item['master_id'] ] ) ) {
					continue;
				}

				$item['children'] = array();
				$doGrupo[] = $item;
			}

			$arvore[ $grupoId ] = $doGrupo;
		}

		return $arvore;
	}

	private static function naOrdemDaApi( $itens )
	{
		$lista = array();
		$temOrdem = true;

		foreach ( (array) $itens as $item ) {
			$item = (array) $item;
			$temOrdem = $temOrdem && isset( $item['ordemAlfabetica'] );
			$lista[] = $item;
		}

		if ( ! $temOrdem ) {
			return $lista;
		}

		usort( $lista, function ( $a, $b ) {
			return (int) $a['ordemAlfabetica'] <=> (int) $b['ordemAlfabetica'];
		} );

		return $lista;
	}

	private static function vinculadoAoGrupo( $item, $grupoId )
	{
		if ( empty( $item['gruposProprios'] ) || ! is_array( $item['gruposProprios'] ) ) {
			return false;
		}

		foreach ( $item['gruposProprios'] as $id ) {
			if ( (int) $id === (int) $grupoId ) {
				return true;
			}
		}

		return false;
	}

	private static function exibeItens( $grupo )
	{
		return ! isset( $grupo['exibir_itens'] ) || ! empty( $grupo['exibir_itens'] );
	}

	private static function pertenceAoGrupo( $item, $grupoId )
	{
		$csv = isset( $item['grupo'] ) ? (string) $item['grupo'] : '';
		$ids = array_filter( explode( ',', str_replace( ' ', '', $csv ) ), 'strlen' );

		return in_array( (string) $grupoId, $ids, true );
	}

	public static function url( $item )
	{
		$item = (array) $item;

		if ( ! empty( $item['special_product'] ) ) {
			return get_product_url( $item['codigoMenu'], $item['nomeMenu'] );
		}

		return get_category_url( $item['codigoMenu'], $item['slug'] );
	}

	public static function nome( $item )
	{
		$item = (array) $item;

		return str_replace( '*', '', (string) $item['nomeMenu'] );
	}

	public static function fundo( $cor )
	{
		$cor = trim( (string) $cor );

		if ( ! preg_match( '/^(#[0-9a-f]{3,8}|rgba?\(\s*[\d\s.,%]+\))$/i', $cor ) ) {
			return '';
		}

		return 'background:' . $cor;
	}
}
