<?php
class Usuarios_model extends CI_Model
{


    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */

    function __construct()
    {
        parent::__construct();
    }



    function get($perpage = 0, $start = 0, $one = false)
    {

        $this->db->from('usuarios');
        $this->db->select('usuarios.*, permissoes.nome as permissao, caixas.*');
        $this->db->limit($perpage, $start);
        $this->db->join('permissoes', 'usuarios.permissoes_Geral = permissoes.idPermissao', 'left');
        $this->db->join('caixas', 'usuarios.conta_Usuario = caixas.id_caixa', 'left');
        $this->db->order_by('situacao', 'desc');
        $this->db->order_by('permissoes_Geral', 'asc');
        $this->db->order_by('celular', 'desc');
        $this->db->order_by('conta_Usuario', 'asc');
        $this->db->order_by('nome', 'asc');


        $query = $this->db->get();

        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getAllTipos()
    {
        $this->db->where('situacao', 1);
        return $this->db->get('tiposUsuario')->result();
    }

    function get2($table)
    {

        return $this->db->get($table)->result();
    }

    function get3($table, $field1, $field2)
    {
        // Define a ordenação específica para o campo 'tipo'
        $this->db->order_by("FIELD($field1, 1, 3, 2)", null, false);

        // Ordena pelo segundo campo (id, no seu caso)
        $this->db->order_by($field2);

        // Retorna os resultados
        return $this->db->get($table)->result();
    }

    function getById($id)
    {
        $this->db->select('usuarios.*, caixas.*');
        $this->db->where('idUsuarios', $id);
        $this->db->join('caixas', 'usuarios.conta_Usuario = caixas.id_caixa', 'left');
        $this->db->limit(1);
        return $this->db->get('usuarios')->row();
    }

    function getByIdPermissao($id, $indice = 'idPermissao')
    {
        $this->db->select('permissoes.*');
        $this->db->where($indice, $id);
        $this->db->limit(1);
        return $this->db->get('permissoes')->row();
    }

    function add($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            return TRUE;
        }

        return FALSE;
    }

    function edit($table, $data, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0) {
            return TRUE;
        }

        return FALSE;
    }

    function delete($table, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1') {
            return TRUE;
        }

        return FALSE;
    }

    function count($table)
    {
        return $this->db->count_all($table);
    }
}
