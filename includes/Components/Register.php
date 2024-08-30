<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Cliente;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\SessionSupport;
use MisterPrint\Support\View;
use MisterPrint\Helper\Url;

class Register extends Component
{
	protected $name = 'Cadastro';
	protected $description = 'Mister Print Register';
	protected $base = 'vc_mp_register';
	protected $data;

	public function render()
	{
		$data = $this->data;
		$data['params'] = $this->getParamsAjax();

		$data['params']['formulario_como_conheceu'] = \MisterPrint\Response\CustomerReferers::get();
		$data['params']['formulario_profissao_valores'] = \MisterPrint\Response\CustomerProfessions::get();
		$data['params']['formulario_areainteresse_valores'] = \MisterPrint\Response\CustomerInterest::get();
		$data['params']['formulario_atuacao_valores'] = \MisterPrint\Response\CustomerAtuations::get();

		$session = [];
		if(SessionSupport::exists('inclomplete-register')) {
			$session = SessionSupport::get('inclomplete-register');
			SessionSupport::delete('inclomplete-register');
		}

		if($_SESSION['cadastroSocial'] === 'F'){
			if(isset($_SESSION['userData_face']['id']) && isset($_SESSION['userData_face']['email'])) {
				$session['email'] = $_SESSION['userData_face']['email'];
				$session['nome-completo'] = $_SESSION['userData_face']['first_name'];
				$session['password'] = '-';
			}
		}
		else if($_SESSION['cadastroSocial'] === 'G'){
			session_start();
			if(isset($_SESSION['userData_google']['sub']) && isset($_SESSION['userData_google']['email'])) {
				$session['email'] = $_SESSION['userData_google']['email'];
				$session['nome-completo'] = $_SESSION['userData_google']['name'];
				$session['password'] = '-';
			}
		}

		$data = array_merge($data, $session);
		return (new View('user/register', $data))->get();
	}

	static public function action()
	{
		return function () {
			$register = [];
			$post = $_POST['data'];

			$session = [];
			if(SessionSupport::exists('inclomplete-register')) {
				$session = SessionSupport::get('inclomplete-register');
			}

			$post['cpf'] = $output = preg_replace('/[^0-9]/', '', $post['cpf']);
			$post['cnpj'] = $output = preg_replace('/[^0-9]/', '', $post['cnpj']);
			$post['telefone'] = $output = preg_replace('/[^0-9]/', '', $post['telefone']);
			$post['celular'] =  preg_replace('/[^0-9]/', '', $post['celular']);
			$post['cep'] = $output = preg_replace('/[^0-9]/', '', $post['cep']);
			$cpfCnpj = $post['cnpj'] ? $post['cnpj'] : $post['cpf'];

			$register = [
				"codigoEmpresa" => 4,
				"dadosCliente" => [
					"customers_recadastro" => 1,
					"customers_agree" => 1,
					"customers_agree_notfinal" => 1,
					"customers_firstname" => $post['nome-completo'],
					"customers_lastname" => $post['customers_lastname'],
					"customers_email_address" => isset($session['email']) ? $session['email'] : $post['email'],
					"customers_celular" => $post['celular'],
					"customers_password" => isset($session['password']) ? base64_decode($session['password']) : $post['password'],
					"customers_telephone" => $post['telefone'],
					"customers_cpf_cnpj" => $cpfCnpj,
					"customers_cpf" => $post['cpf'],
					"customers_cnpj" => $cpfCnpj,
					"customers_conheceu" => $post['info-referer'],
					"customers_obs" => @$post['origin_referer'] ?: '',
					"customers_loja" => "NET",
					"customers_bloqueado" => "0",
					"customers_novo" => "1",
					"customers_company" => $post['razao-social'],
					"customers_gender" => $post['genero'],
					"customers_dob" => $post['nascimento'],
					"customers_newsletter" => "1",
					"customers_ie" => $post['inscricao-estadual'],
					"customers_regiao" => '',
					"customers_preference" => '',
					"customers_lat" => '',
					"customers_long" => '',
					"is_incompleto" => 1,
					"customers_subdominio" => Url::getSubdomain(),
					"customers_descricao" => '',
					'customers_software' => $post['info-software'],
					'customers_consumo' => $post['info-faturamento'],
					'customers_has_physical_store' => $post['info-loja-fisica'] == "Sim",
					'customers_final' => $post['info-uso'] == "Uso Pessoal",
					'customers_interesse' => $post['areainteresse'],
				],
				"dadosEndereco" => [
					"entry_firstname" => $post['nome-completo'],
					"entry_postcode" => $post['cep'],
					"entry_country_id" => "55",
					"entry_gender" => $post['genero'],
					"entry_street_address" => $post['logradouro'],
					"entry_street_number" => $post['numero'],
					"complemento" => $post['complemento'],
					"entry_suburb" => $post['bairro'],
					"entry_city" => $post['cidade'],
					"entry_state" => $post['estado'],
					"entry_zone_id" => 0,
					"entry_cpf_cnpj" => $cpfCnpj,
					"entry_cpf" => $post['cpf'],
					"entry_cnpj" => $cpfCnpj,
					"entry_company" => $post['razao-social'],
					"entry_ie" => $post['inscricao-estadual'],
					"entry_rg" => '',
					"entry_city_id" => 0
				],
				"dadosComunicacao" => [
					"celular" => $post['celular'],
					"telefone" => $post['telefone'],
					"aparelho" => '',
					"facebook" => '',
					"twitter" => '',
					"skype" => '',
					"email_newsletter" => isset($session['email']) ? $session['email'] : $post['email'],
					"operadora" => '',
					"influencia" => ''
				],
				"dadosEmpresa" => [
					"profissao" => $post['profissao'],
					"cargo" => $post['profissao'],
					"atividade" => '',
					"qtd_funcionarios" => $post['info-funcionarios'],
					"e_commerce" => '',
					"isencao" => 0,
					'ativ_principal_text' => $post['ativ_principal_text'],
					'ativ_principal_code' => $post['ativ_principal_code'],
					'ativ_sec1_text' => $post['ativ_sec1_text'],
					'ativ_sec1_code' => $post['ativ_sec1_code'],
					'ativ_sec2_text' => $post['ativ_sec2_text'],
					'ativ_sec2_code' => $post['ativ_sec2_code'],
				],
			];
			unset($post['password']);
			if($post['pessoa'] == 'Pessoa Física'){
				$register['customers_cpf_cnpj'] = $register['customers_cpf'];
				$register['dadosCliente']['customers_company'] = "";
				$register['dadosCliente']['customers_cnpj'] = "";
				$register['dadosEmpresa']['ativ_principal_text'] = "";
				$register['dadosEmpresa']['ativ_principal_code'] = "";
				$register['dadosEmpresa']['ativ_sec1_text'] = "";
				$register['dadosEmpresa']['ativ_sec1_code'] = "";
				$register['dadosEmpresa']['ativ_sec2_text'] = "";
				$register['dadosEmpresa']['ativ_sec2_code'] = "";
				$register['dadosEndereco']['entry_company'] = "";
				$register['dadosEndereco']['entry_ie'] = "";
			}
			SessionSupport::delete('incomplete-register');
			SessionSupport::set('incomplete-register', $post);
			$clienteModel = new Cliente();
			$response = $clienteModel->salvar_cadastro_completo($register);
			if ($response) {
				SessionSupport::delete('incomplete-register');
				return ['redirect' => home_url('/cadastro_concluido/')];
			}

			$params = json_decode(base64_decode($_POST['params']), true);
			return (new View('user/register', [
				'fields' => [
					'Profissao' => $post['profissao'],
					'cpf' => $post['cpf'],
					'telefone' => $post['telefone'],
					'celular' => $post['celular'],
					'nascimento' => $post['nascimento'],
					'cnpj' => $post['cnpj'],
					'razao-social' => $post['razao-social'],
					'inscricao-estadual' => $post['inscricao-estadual'],
					'cep' => $post['cep'],
					'logradouro' => $post['logradouro'],
					'complemento' => $post['complemento'],
					'numero' => $post['numero'],
					'bairro' => $post['bairro'],
					'cidade' => $post['cidade'],
					'estado' => $post['estado'],
					'nascimento' => $post['nascimento'],
					'info-software' => $post['info-software'],
					'info-faturamento' => $post['info-faturamento'],
					'info-loja-fisica' => $post['info-loja-fisica'],
					'info-uso' => $post['info-uso'],
					'info-funcionarios' => $post['info-funcionarios'],
					'info-referer' => $post['info-referer'],
					'genero' => $post['sexo'],
					'area-atuacao' => $post['area-atuacao'],
					'ativ_principal_text' => $post['ativ_principal_text'],
					'ativ_principal_code' => $post['ativ_principal_code'],
					'ativ_sec1_text' => $post['ativ_sec1_text'],
					'ativ_sec1_code' => $post['ativ_sec1_code'],
					'ativ_sec2_text' => $post['ativ_sec2_text'],
					'ativ_sec2_code' => $post['ativ_sec2_code'],
				],
				'register' => json_encode($register),
				'retorno' => $response,
				'session' => '0',
				'params' => $params,
				'email' => $session['email'],
				'customers_lastname' => $post['customers_lastname'],
				'nome-completo' => $post['nome-completo'],
				'errors' => [ $clienteModel->get_message() ?: 'Verifique seus dados e tente novamente.' ]
			]))->get();
		};
	}

	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Titulo', 'Informações de cadastro'),
			Vc::paramText('Subtitulo', ''),
			Vc::paramText('Titulo painel', 'Informações de cadastro'),
			Vc::paramText('Subtitulo painel', 'Preencha os campos abaixo e seus dados ficarão salvos para as próximas compras.'),
			Vc::paramText('Formulario pessoa fisica', 'Pessoa Física'),
			Vc::paramText('Formulario pessoa juridica', 'Pessoa Jurídica'),
			Vc::paramText('Formulario dados pessoais', 'Dados pessoais'),
			Vc::paramText('Formulario dados juridicos', 'Dados Empresariais'),
			Vc::paramText('Formulario apelido', 'Apelido'),
			Vc::paramText('Formulario apelido placeholder', 'Digite seu nickname'),
			Vc::paramText('Formulario nome', 'Nome completo'),
			Vc::paramText('Formulario nome placeholder', 'Digite seu nome completo'),
			Vc::paramText('Formulario profissao', 'Profissão'),
			Vc::paramText('Formulario profissao placeholder', ''),
			Vc::paramText('Formulario areainteresse', 'Área de interesse'),
			Vc::paramText('Formulario areainteresse placeholder', ''),
			Vc::paramText('Formulario CPF', 'CPF'),
			Vc::paramText('Formulario CPF placeholder', 'Digite seu CPF'),
			Vc::paramText('Formulario telefone', 'Telefone (DDD)'),
			Vc::paramText('Formulario telefone placeholder', 'Digite seu telefone'),
			Vc::paramText('Formulario celular', 'Celular (DDD)'),
			Vc::paramText('Formulario celular placeholder', 'Digite seu Celular'),
			Vc::paramText('Formulario data nascimento', 'Data de nascimento'),
			Vc::paramText('Formulario genero', 'Gênero'),
			Vc::paramText('Formulario masculino', 'Masculino'),
			Vc::paramText('Formulario feminino', 'Feminino'),
			Vc::paramText('Formulario outros', 'Outros'),
			Vc::paramText('Formulario CNPJ', 'CNPJ'),
			Vc::paramText('Formulario CNPJ placeholder', 'CNPJ'),
			Vc::paramText('Formulario razão social', 'Razão social'),
			Vc::paramText('Formulario razão social placeholder', 'Razão social'),
			Vc::paramText('Formulario inscrição estadual', 'Inscrição Estadual'),
			Vc::paramText('Formulario inscrição estadual placeholder', 'Inscrição Estadual'),
			Vc::paramText('Formulario areas atuacao', 'Área de atuação'),
			Vc::paramText('Formulario ramo atividade', 'Ramo de atividades'),
			Vc::paramText('Formulario dados endereço', 'Dados do endereço'),
			Vc::paramText('Formulario logradouro', 'Logradouro'),
			Vc::paramText('Formulario logradouro placeholder', 'Digite o logradoudo. Ex: Av, Rua, Travessa, etc.'),
			Vc::paramText('Formulario numero', 'Número'),
			Vc::paramText('Formulario numero placeholder', 'Digite seu número'),
			Vc::paramText('Formulario complemento', 'Complemento'),
			Vc::paramText('Formulario complemento placeholder', 'Complemento'),
			Vc::paramText('Formulario CEP', 'CEP'),
			Vc::paramText('Formulario CEP placeholder', 'Digite seu CEP'),
			Vc::paramText('Formulario bairro', 'Bairro'),
			Vc::paramText('Formulario bairro placeholder', 'Digite seu Bairro'),
			Vc::paramText('Formulario cidade', 'Cidade'),
			Vc::paramText('Formulario cidade placeholder', 'Digite a cidade'),
			Vc::paramText('Formulario estado', 'Estado'),
			Vc::paramText('Formulario recebimento', 'Dados para emissão de Nota Fiscal'),
			Vc::paramText('Formulario recebimento fisica', 'Pessoa Física'),
			Vc::paramText('Formulario recebimento juridica', 'Pessoa Jurídica'),
			Vc::paramText('Formulario email', 'E-mail'),
			Vc::paramText('Formulario email placeholder', 'Digite aqui seu e-mail'),
			Vc::paramText('Formulario email confirmação', 'Confirmar E-mail'),
			Vc::paramText('Formulario email confirmação placeholder', 'Digite novamente seu e-mail'),
			Vc::paramText('Formulario senha', 'Senha'),
			Vc::paramText('Formulario senha placeholder', 'Digite uma senha'),
			Vc::paramText('Formulario senha confirmação', 'Confirmar Senha'),
			Vc::paramText('Formulario senha confirmação placeholder', 'Confirme sua senha'),
			Vc::paramText('Formulario receber email', 'Ao me cadastrar, eu confirmo que li e concordo com os Termos de Uso, Privacidade e Garantia da Ampliz e que receberei notificações, orientações e promoções através dos canais de contato. Podendo desabilitar essa função a qualquer momento.'),

			// Campos de identificação de Lead
			Vc::paramText('Formulario info', 'Informações Adicionais'),
			Vc::paramText('Formulario info uso', 'Para qual finalidade você irá usar os impressos?'),
			Vc::paramText('Formulario info uso valores', 'Uso Pessoal;Revenda'),
			Vc::paramText('Formulario info faturamento', 'Qual seu faturamento mensal com gráficas online?'),
			Vc::paramText('Formulario info faturamento valores', 'até R$ 500,00;De R$ 501,00 a R$ 1.499,00;De R$ 1.500,00 a R$ 2.999,00;De R$ 3.000,00 a R$ 4.999,00;De R$ 5.000,00 a R$ 9.999,00;Acima de R$ 10.000,00'),
			Vc::paramText('Formulario info loja fisica', 'Possui loja física?'),
			Vc::paramText('Formulario info loja fisica valores', 'Sim;Não'),
			Vc::paramText('Formulario info funcionarios', 'Quantos funcionários possui?'),
			Vc::paramText('Formulario info funcionarios valores', 'Trabalho sozinho;Tenho 1 funcionário;Tenho 2 funcionários;Tenho 3 (ou mais) funcionários.'),
			Vc::paramText('Formulario info software', 'Qual programa você utiliza para preparar seus arquivos?'),
			Vc::paramText('Formulario info software valores', 'Creative Cloud (Adobe);CorelDraw;Afinnity;Outros'),
			//Vc::paramText('Formulario info software placeholder', 'Creative Cloud (Adobe);CorelDraw;Afinnity;Outros'),
			Vc::paramText('Formulario info referrer', 'Onde nos conheceu?'),
			Vc::paramText('Formulario info referrer placeholder', 'Selecione uma opção'),
			// Tamanhos dos campos de identificação
			Vc::paramText('Formulario info tamanho uso', '5'),
			Vc::paramText('Formulario info tamanho faturamento', '5'),
			Vc::paramText('Formulario info tamanho loja fisica', '2'),
			Vc::paramText('Formulario info tamanho funcionarios', '3'),
			Vc::paramText('Formulario info tamanho software', '5'),
			Vc::paramText('Formulario info tamanho referrer', '5'),



			Vc::paramText('Formulario botão', 'Cadastrar-me'),
		]);
	}
}
