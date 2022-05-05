<?php

class ModeleSecteur extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function retournerSecteurs()
    {
        $this->db->select('nosecteur, nom AS nomsecteur');
        $this->db->from('secteur');
        $query = $this->db->get();
        return $query->result();
    }
}