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

    public function retournerLiaisonActuelle($noLiaison)
    {
        $this->db->select('pd.nom AS nomportdepart, pa.nom AS nomportarrivee, l.noliaison');
        $this->db->from('port pd, port pa, liaison l');
        $this->db->where('l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport');
        $this->db->where('noliaison', $noLiaison);
        $query = $this->db->get();
        return $query->row();
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

    public function retournerTarifs($noLiaison)
    {
        $this->db->select('*');
        $this->db->from('tarifer');
        $this->db->where('noliaison', $noLiaison);
        $query = $this->db->get();
        return $query->result();
    }
}
?>