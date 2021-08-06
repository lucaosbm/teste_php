<?php
defined("BASEPATH") or exit("No direct access script allowed");

class Conta_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Reotorna todas as contas
     */
    public function getAll()
    {
        $this->db->select("conta.id as conta_id, conta.conta, pessoas.nome, pessoas.cpf, pessoas.id as pessoa_id");
        $this->db->from("contas as conta");
        $this->db->join("pessoas", "conta.pessoas_id = pessoas.id", "LEFT");

        return $this->db->get()->result();
    }

    /**
     * Insere uma conta no BD
     */
    public function insertConta($dados)
    {
        return $this->db->insert("contas", $dados);
    }

    /**
     * Atualiza uma conta no BD
     */
    public function updateConta($dados, $id)
    {
        $this->db->where("id", $id);
        return $this->db->update("contas", $dados);
    }

    /**
     * Exclui uma conta do BD
     */
    public function deleteConta($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete("contas");
    }

    /**
     * Retorna todas as contas de determinada pessoa
     */
    public function getContas($id)
    {
        $this->db->from("contas");
        $this->db->where("pessoas_id", $id);
        return $this->db->get()->result();
    }

    /**
     * Retorna o saldo de determinada conta
     * @return string
     */
    public function getSaldo($conta_id)
    {
        $this->db->select("saldo");
        $this->db->from("contas");
        $this->db->where("id", $conta_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result->saldo;
    }

    /**
     * Verifica se uma conta já está cadastrada
     */
    public function verificaConta($conta)
    {
        $query = $this->db->select("id")
            ->from("contas")
            ->where("conta", $conta)
            ->get();
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
}
