<?php

class ModeleCategorieType extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function retournerCategoriesTypes()
    {
        $this->db->select('c.libelle AS libellecategorie, c.lettrecategorie, t.notype, t.libelle AS libelletype');
        $this->db->from('categorie c, type t');
        $this->db->where('c.lettrecategorie = t.lettrecategorie');
        $query = $this->db->get();
        return $query->result();
    }

    public function nombreTypesCategorie()
    {
        $this->db->select('COUNT(*) AS nombre, lettrecategorie');
        $this->db->from('type');
        $this->db->group_by("lettrecategorie");
        $query = $this->db->get();
        return $query->result();
    }
}