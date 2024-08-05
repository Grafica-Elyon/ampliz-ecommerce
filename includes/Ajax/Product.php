<?php

namespace MisterPrint\Ajax;

use MisterPrint\BO\Produto;
use MisterPrint\Helper\Url;

class Product extends Ajax
{
	private $product;
	private $category;
	private $expects;
	private $format;
	private $print;
	private $paper;
	private $ennoblement;
	private $finishing;
	private $extra;


	public function init()
	{
		$this->product = new Produto();
		$this->category = $_POST['category'];
		$this->format = isset($_POST['format']) ? $_POST['format'] : false;
		$this->expects = isset($_POST['expects']) ? $_POST['expects'] : false;
		$this->print = isset($_POST['print']) ? $_POST['print'] : false;
		$this->paper = isset($_POST['paper']) ? $_POST['paper'] : false;
		$this->ennoblement = isset($_POST['ennoblement']) ? $_POST['ennoblement'] : false;
		$this->finishing = isset($_POST['finishing']) ? $_POST['finishing'] : false;
		$this->extra = isset($_POST['extra']) ? $_POST['extra'] : false;
	}

	public function handle()
	{
		$this->init();

		if ('print' === $this->expects) {
			$ajax = $this->getPrint();
		} else if ('paper' === $this->expects) {
			$ajax = $this->getPaper();
		} else if ('ennoblement' === $this->expects) {
			$ajax = $this->getEnnoblement();
		} else if ('acabamento' === $this->expects) {
			$ajax = $this->getAcabamento();
		} else if ('extra' === $this->expects) {
			$ajax = $this->getExtra();
		} else {
			$ajax = [
				'product' => $this->product->get_dados_da_categoria($this->category),
				'formats' => $this->product->get_formatos_do_produto($this->category),
			];
		}

		if(!empty($this->expects)){
			$prices = array_map(function($price) {
				return array_merge($price, ['add' => Url::getAddToCartUrl($price['id'])]);
			}, $this->product->get_resumo_e_previsao_de_produtos($this->category, $this->format, $this->print, $this->paper, $this->ennoblement, $this->finishing, $this->extra));

			$ajax['prices'] = $prices;
		}

		return $ajax;
	}

	public function getPrint()
	{
		return ['prints' => $this->product->get_cores_do_produto($this->category, $this->format)];
	}

	public function getPaper()
	{
		return ['papers' => $this->product->get_papeis_do_produto($this->category, $this->format, $this->print)];
	}

	public function getEnnoblement()
	{
		$ennoblementsArr = $this->product->get_enobrecimentos_do_produto($this->category, $this->format, $this->print, $this->paper);
		$ennoblements = [];
		foreach ($ennoblementsArr as $ennoblement) {
			$ennoblements[$ennoblement['slug']] = $ennoblement['descricao'];
		}
		return ['ennoblements' => $ennoblements];
	}

	public function getAcabamento()
	{
		$finishingsArr = $this->product->get_acabamentos_do_produto($this->category, $this->format, $this->print, $this->paper, $this->ennoblement);
		$finishings = [];
		foreach ($finishingsArr as $finishing) {
			$finishings[$finishing['id']] = $finishing['nome'] . ' + '.$finishing['prazo'].' dias';
		}
		return ['finishings' => $finishings];
	}

	public function getExtra()
	{
		return ['extras' => $this->product->get_extras_do_produto($this->category, $this->format, $this->print, $this->paper, $this->ennoblement, $this->finishing)];
	}
}