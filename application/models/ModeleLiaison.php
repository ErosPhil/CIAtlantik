<?php

class ModeleLiaison extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function retournerLiaisons()
    {
        $this->db->select('s.nom AS nomsecteur, l.noliaison AS codeliaison, l.distance, pd.nom AS portdepart, pa.nom AS portarrivee');
        $this->db->from('liaison l, secteur s, port pd, port pa');
        $this->db->where('s.nosecteur = l.nosecteur AND l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport');
        $this->db->order_by('s.nom');
        $query = $this->db->get();
        return $query->result();
        //SELECT s.nom, l.noliaison, l.distance, pd.nom AS "portdepart", pa.nom AS "portarrivee" FROM liaison l, secteur s, port pd, port pa WHERE s.nosecteur = l.nosecteur AND l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport;
    }

    public function retournerLiaisonActuelle($noLiaison)
    {
        $this->db->select('pd.nom AS nomportdepart, pa.nom AS nomportarrivee, l.noliaison');
        $this->db->from('port pd, port pa, liaison l');
        $this->db->where('l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport');
        $this->db->where('noliaison', $noLiaison);
        $query = $this->db->get();
        return $query->row();
    }

    public function retournerTarifs($noLiaison)
    {
        $this->db->select('*');
        $this->db->from('tarifer');
        $this->db->where('noliaison', $noLiaison);
        $query = $this->db->get();
        return $query->result();
    }

    
}