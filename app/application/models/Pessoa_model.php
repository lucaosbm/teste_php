<?php
defined("BASEPATH") or exit("No direct access script allowed");

class Pessoa_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $this->db->from("pessoas");
        $this->db->order_by("nome", "ASC");
        return $this->db->get()->result();
    }

    public function insertPessoa($dados)
    {
        return $this->db->insert("pessoas", $dados);
    }

    public function updatePessoa($dados, $id)
    {
        $this->db->where("id", $id);
        return $this->db->update("pessoas", $dados);
    }

    public function deletePessoa($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete("pessoas");
    }
}
