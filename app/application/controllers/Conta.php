<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Conta extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("Conta_model", "conta");
		$this->load->model("Pessoa_model", "pessoa");
	}

	/**
	 * Carrega a view de cadastro/listagem das contas
	 */
	public function index()
	{
		$dados['pessoas'] = $this->pessoa->getAll();
		$dados['contas'] = $this->conta->getAll();
		$this->load->view('conta', $dados);
	}

	/**
	 * Faz o cadastro e a edição no banco de dados
	 */
	public function cadastro_conta()
	{
		$dado = $this->input->post();

		//verifica se existe uma conta o mesmo número e não deixa prosseguir o cadastro em caso positivo
		if ($this->conta->verificaConta($dado['conta'])) {
			$this->session->set_flashdata('warning', '<b>Número de conta já cadastrada, por favor tente outro número!</b>');
			redirect(base_url("conta"));
		}

		//edição
		if ($this->input->post("conta_id")) {
			$dados = [
				'conta'	=>	$dado['conta']
			];
			$this->conta->updateConta($dados, $dado['conta_id']);

			//cadastro
		} else {
			$dados = [
				'conta'	=>	$dado['conta'],
				'pessoas_id'	=>	$dado['pessoa_id']
			];

			$this->conta->insertConta($dados);
			$this->session->set_flashdata('success', '<b>Conta cadastrada com sucesso!</b>');
		}

		redirect(base_url("conta"));
	}

	/**
	 * Exclui uma conta do banco de dados
	 */
	public function excluir_conta()
	{
		$id = $this->input->post("id_pessoa");
		$this->conta->deleteConta($id);
		redirect(base_url("conta"));
	}

	/**
	 * Retorna um json com todas as contas de determinada pessoa
	 */
	public function ajax_contas()
	{
		$contas = $this->conta->getContas($this->uri->segment(2));
		echo json_encode($contas);
	}
	/**
	 * Verifica se o saldo é suficiente para realizar uma retirada
	 */
	public function verificaSaldo()
	{
		$saldo = $this->conta->getSaldo($this->input->post("id"));
		$valor = $this->input->post("valor");
		if ($saldo >= $valor)
			echo true;
		else
			echo false;
	}
}
