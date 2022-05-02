<?php

class ModeleVisiteur extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function retournerClient($Id, $MdP)
    {
        $requete = $this->db->get_where('client', array('mel' => $Id, 'motdepasse' => $MdP));
        //SELECT * FROM client WHERE mel = $Id AND motdepasse = $MdP
        return $requete->row();
    }

    public function insererClient($DonneesAInserer)
    {
        return $this->db->insert('client', $DonneesAInserer);
        //INSERT INTO client(nom, prenom, adresse, codepostal, ville, telephonefixe, telephonemobile, mel, motdepasse) VALUES($nom, $prenom, $adresse, $codepostal, $ville, $telephonefixe, $telephonemobile, $mel, $motdepasse)
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

    public function retournerPeriodes($datejour)
    {
        $this->db->select('*');
        $this->db->from('periode');
        $this->db->where('datefin >=', $datejour);
        $query = $this->db->get();
        return $query->result();
        //SELECT * FROM periode WHERE datefin >= datejour
    }

    public function retournerLiaisonActuelle()//$noLiaison
    {
        $this->db->select('pd.nom AS nomportdepart, pa.nom AS nomportarrivee, l.noliaison');
        $this->db->from('port pd, port pa, liaison l');
        $this->db->where('l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport');
        $this->db->where('noliaison', 1);
        $query = $this->db->get();
        return $query->row();
    }

    public function retournerTarifs()//$noLiaison
    {
        $this->db->select('c.lettrecategorie, c.libelle, ty.notype, ty.libelle, ta.tarif');
        $this->db->from('tarifer ta, type ty, categorie c');
        $this->db->where('c.lettrecategorie = ty.lettrecategorie AND ty.lettrecategorie = ta.lettrecategorie');
        $this->db->where('ta.noliaison', 1);
        $query = $this->db->get();
        return $query->result();
        //SELECT c.lettrecategorie, c.libelle, ty.notype, ty.libelle, ta.tarif FROM tarifer ta, type ty, categorie c, periode p WHERE c.lettrecategorie = ty.lettrecategorie AND ty.lettrecategorie = ta.lettrecategorie AND ta.noperiode = p.noperiode AND ta.noliaison = 1 AND p.datefin >= '2022-05-02';
        //SELECT pd.nom, pa.nom;, l.noliaison FROM port pd, port pa, liaison l WHERE l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport AND l.noliaison = 1;
    }
}
?>