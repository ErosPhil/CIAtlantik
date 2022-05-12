<?php

class ModeleTraversee extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getLesTraverseesBateaux($noLiaison, $dateTraversee)
    {
        $this->db->select('t.notraversee, t.dateheuredepart, b.nom AS nombateau');
        $this->db->from('traversee t, bateau b');
        $this->db->where('t.nobateau = b.nobateau');
        $this->db->where('t.noliaison', $noLiaison);
        $this->db->where('t.dateheuredepart LIKE', $dateTraversee."%");
        $query = $this->db->get();
        return $query->result();
    }

    public function getQuantiteEnregistree($noTraversee, $lettreCategorie)
    {
        $this->db->select('sum(quantite) AS quantiteenregistree');
        $this->db->from('traversee t, reservation r, enregistrer e');
        $this->db->where('t.notraversee = r.notraversee AND r.noreservation = e.noreservation');
        $this->db->where('t.notraversee', $noTraversee);
        $this->db->where('e.lettrecategorie', $lettreCategorie);
        $query = $this->db->get();
        return $query->row();
    }

    public function getCapaciteMaximale($noTraversee, $lettreCategorie)
    {
        $this->db->select('c.capacitemax');
        $this->db->from('contenir c, bateau b, traversee t');
        $this->db->where('c.nobateau = b.nobateau AND b.nobateau = t.nobateau');
        $this->db->where('t.notraversee', $noTraversee);
        $this->db->where('c.lettrecategorie', $lettreCategorie);
        $query = $this->db->get();
        return $query->row();
    }

    public function getTraversee($noTraversee)
    {
        $requete = $this->db->get_where('traversee', array('notraversee' => $noTraversee));
        return $requete->row();
    }
}