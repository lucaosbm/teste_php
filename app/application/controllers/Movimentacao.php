<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Movimentacao extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("Conta_model", "conta");
		$this->load->model("Pessoa_model", "pessoa");
		$this->load->model("Movimentacao_model", "mov");
	}

	/**
	 * Carrega a view de cadastro/listagem das movimentações
	 */
	public function index()
	{
		$dados['pessoas'] = $this->pessoa->getAll();
		$this->load->view('movimentacao', $dados);
	}

	/**
	 * Faz o cadastro das movimentações
	 * Atualiza o Saldo
	 */
	public function atualizaSaldo()
	{
		//seta o fuso horário para o do Brasil
		date_default_timezone_set('America/Sao_Paulo');

		//inicia transaction
		$this->db->trans_start();

		//pega dados do post
		$valor = $this->input->post("valor");
		$op = $this->input->post("opcao");
		$conta_id = $this->input->post("conta");

		//pega o saldo atual
		$saldo = $this->conta->getSaldo($conta_id);

		//atualiza saldo e cadastra a movimentação caso seja depósito
		if ($op == 'dep') {
			//adiciona o valor ao saldo
			$this->conta->updateConta(array('saldo' => $saldo + $valor), $conta_id);
			//cadastra movimentação
			$dados = [
				'valor'	=>	$valor,
				'tipo'	=>	'+',
				'datetime'	=> date("Y-m-d H:i:s"),
				'contas_id'  =>	$conta_id
			];
			$this->mov->insert($dados);
			//atualiza saldo e cadastra a movimentação caso seja retirada
		} elseif ($op == 'ret') {
			//subtrai o valor do saldo
			$this->conta->updateConta(array('saldo' => $saldo - $valor), $conta_id);
			$dados = [
				'valor'	=>	$valor,
				'tipo' =>	'-',
				'datetime'	=> date("Y-m-d H:i:s"),
				'contas_id'	=>	$conta_id
			];
			//cadastra movimentação
			$this->mov->insert($dados);
		}

		//finaliza transaction
		$this->db->trans_complete();

		echo $this->db->trans_status();
	}

	/**
	 * Retorna um json com o extrato
	 */
	public function ajax_extrato()
	{
		$extrato = $this->mov->getExtrato($this->uri->segment(2));
		foreach ($extrato as $key => $ext) {
			$extrato[$key]->datetime = converte_datetime($ext->datetime);
		}
		echo json_encode($extrato);
	}
}
