<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pessoa extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("Pessoa_model", "pessoa");
	}

	/**
	 * Carrega a view do cadastro/listagem das Pessoas
	 */
	public function index()
	{
		$dados['pessoas'] = $this->pessoa->getAll();
		$this->load->view('pessoa', $dados);
	}

	/**
	 * Faz o cadastro e a edição no banco de dados
	 */
	public function cadastro_pessoa()
	{
		//edição
		if (!empty($this->input->post("id"))) {

			$dado = $this->input->post();
			$dados = [
				'nome'	=>	$dado['nome'],
				'cpf'	=>	$this->limpaCPF($dado['cpf']),
				'endereco'	=>	$dado['endereco']
			];
			if ($this->pessoa->updatePessoa($dados, $dado['id']))
				$this->session->set_flashdata('success', '<b>Pessoa editada com sucesso!</b>');
			else
				$this->session->set_flashdata('success', '<b>Erro ao editar pessoa!</b>');
			//cadastro
		} else {

			$dado = $this->input->post();
			$dados = [
				'nome'	=>	$dado['nome'],
				'cpf'	=>	$this->limpaCPF($dado['cpf']),
				'endereco'	=>	$dado['endereco']
			];
			if ($this->pessoa->insertPessoa($dados))
				$this->session->set_flashdata('success', '<b>Pessoa cadastrada com sucesso!</b>');
			else
				$this->session->set_flashdata('error', '<b>Ocorreu um erro ao cadastrar!</b>');
		}
		redirect(base_url());
	}

	/**
	 * Remove os pontos e o traço do CPF
	 */
	public function limpaCPF($valor)
	{
		$valor = trim($valor);
		$valor = str_replace(".", "", $valor);
		$valor = str_replace("-", "", $valor);
		return $valor;
	}

	/**
	 * Exclui uma pessoa do banco
	 */
	public function excluir_pessoa()
	{
		$id = $this->input->post("id_pessoa");
		if ($this->pessoa->deletePessoa($id))
			$this->session->set_flashdata('success', '<b>Pessoa excluída com sucesso!</b>');
		else
			$this->session->set_flashdata('error', '<b>Erro ao excluir pessoa!</b>');

		redirect(base_url());
	}
}
