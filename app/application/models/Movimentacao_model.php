<?php
defined("BASEPATH") or exit("No direct access script allowed");

class Movimentacao_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Insere uma nova movimentação
     */
    public function insert($dados)
    {
        return $this->db->insert("movimentacoes", $dados);
    }

    /**
     * Retorna todas as movimentações de uma conta
     */
    public function getExtrato($id)
    {
        $this->db->from("movimentacoes");
        $this->db->where("contas_id", $id);
        return $this->db->get()->result();
    }
}
