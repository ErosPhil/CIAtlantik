<?php

class ModelePeriode extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getPeriodes($datejour) //retourne les périodes futures
    {
        $this->db->select('*');
        $this->db->from('periode');
        $this->db->where('datefin >=', $datejour);
        $query = $this->db->get();
        return $query->result();
        //SELECT * FROM periode WHERE datefin >= datejour
    }
}