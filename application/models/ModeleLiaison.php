<?php

class ModeleLiaison extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function getLiaisonSec() //renvoie toutes les liaisons avec leur secteur
    {
        $this->db->select('s.nom AS nomsecteur, l.noliaison AS codeliaison, l.distance, pd.nom AS portdepart, pa.nom AS portarrivee');
        $this->db->from('liaison l, secteur s, port pd, port pa');
        $this->db->where('s.nosecteur = l.nosecteur AND l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport');
        $this->db->order_by('s.nom');
        $query = $this->db->get();
        return $query->result();
        //SELECT s.nom, l.noliaison, l.distance, pd.nom AS "portdepart", pa.nom AS "portarrivee" FROM liaison l, secteur s, port pd, port pa WHERE s.nosecteur = l.nosecteur AND l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport;
    }

    public function getLiaison($noLiaison) //renvoie toutes les informations sur une liaison
    {
        $this->db->select('pd.nom AS nomportdepart, pa.nom AS nomportarrivee, l.noliaison');
        $this->db->from('port pd, port pa, liaison l');
        $this->db->where('l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport');
        $this->db->where('noliaison', $noLiaison);
        $query = $this->db->get();
        return $query->row();
    }

    public function getTarifs($noLiaison) //renvoie tous les tarifs pour un noliaison
    {
        $this->db->select('*');
        $this->db->from('tarifer');
        $this->db->where('noliaison', $noLiaison);
        $query = $this->db->get();
        return $query->result();
    }

    public function getLiaisonS($nosecteur) //renvoie toutes les liaisons pour un secteur
    {
        $this->db->select('l.noliaison, pd.nom AS nomportdepart, pa.nom AS nomportarrivee');
        $this->db->from('liaison l, port pd, port pa');
        $this->db->where('l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport');
        $this->db->where('nosecteur', $nosecteur);
        $query = $this->db->get();
        return $query->result();
    }
}