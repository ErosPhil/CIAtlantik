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

    public function getPeriodePourDate($date)
    {
        $this->db->select('p.noperiode');
        $this->db->from('periode p');
        $this->db->where("'".$date."'BETWEEN p.datedebut AND p.datefin");
        $query = $this->db->get();
        return $query->row()->noperiode;
    }
}