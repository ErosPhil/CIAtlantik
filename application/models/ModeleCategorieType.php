<?php

class ModeleCategorieType extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getCategoriesTypes()
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

    public function getLesCategories()
    {
        $query = $this->db->get('categorie');
        return $query->result();
    }

    public function getLesTypesAvecTarifs($noLiaison, $noPeriode)
    {
        $this->db->select('ty.lettrecategorie, ty.notype, ty.libelle, ta.tarif');
        $this->db->from('type ty, tarifer ta');
        $this->db->where('ty.lettrecategorie = ta.lettrecategorie AND ty.notype = ta.notype');
        $this->db->where('ta.noliaison',$noLiaison);
        $this->db->where('ta.noperiode',$noPeriode);
        $this->db->group_by("ty.libelle, ta.tarif");
        $this->db->order_by('ta.lettrecategorie ASC, ta.notype ASC');
        $query = $this->db->get();
        return $query->result();
        //SELECT ty.libelle, ta.tarif FROM type ty, tarifer ta WHERE ty.lettrecategorie = ta.lettrecategorie AND ty.notype = ta.notype AND ta.noliaison = 1 AND ta.noperiode = 1 GROUP BY ty.libelle, ta.tarif ORDER BY ta.lettrecategorie ASC, ta.notype ASC
    }
}