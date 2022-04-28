<?php

class ModeleVisiteur extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function retournerClient($Id, $MdP)
    {
        $requete = $this->db->get_where('client', array('mel' => $Id, 'motdepasse' => $MdP)); //<=> SELECT * FROM client WHERE mel = $Id AND motdepasse = $MdP
        return $requete->row();
    }

    public function insererClient($DonneesAInserer)
    {
        return $this->db->insert('client', $DonneesAInserer); //<=> INSERT INTO client(nom, prenom, adresse, codepostal, ville, telephonefixe, telephonemobile, mel, motdepasse) VALUES($nom, $prenom, $adresse, $codepostal, $ville, $telephonefixe, $telephonemobile, $mel, $motdepasse)
    }

    public function retournerLiaisons()
    {
        $this->db->select('s.nom AS nomsecteur, l.noliaison AS codeliaison, l.distance, pd.nom AS portdepart, pa.nom AS portarrivee');
        $this->db->from('liaison l, secteur s, port pd, port pa');
        $this->db->where('s.nosecteur = l.nosecteur AND l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport');
        $query = $this->db->get();
        return $query->result();
        //SELECT s.nom, l.noliaison, l.distance, pd.nom AS "portdepart", pa.nom AS "portarrivee" FROM liaison l, secteur s, port pd, port pa WHERE s.nosecteur = l.nosecteur AND l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport;
    }
}
?>