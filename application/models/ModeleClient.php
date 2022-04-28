<?php

class ModeleClient extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function retournerClientN($NoClient)
    {
        $requete = $this->db->get_where('client', array('noclient' => $NoClient)); //<=> SELECT * FROM client WHERE noclient = $NoClient
        return $requete->row();
    }

    public function modifierInformations($DonneesAInserer, $noclient)
    {
        return $this->db->update('client', $DonneesAInserer, array('noclient' => $noclient)); //<=> UPDATE client SET valeur1 = $valeur1... WHERE noclient = $noclient
    }

    public function retournerReservations($noclient)
    {
        $this->db->select('r.noreservation, r.dateheure, pd.nom AS nomportdepart, pa.nom AS nomportarrivee, t.dateheuredepart, r.montanttotal, r.paye');
        $this->db->from('reservation r, traversee t, liaison l, port pd, port pa');
        $this->db->where('r.notraversee = t.notraversee AND t.noliaison = l.noliaison AND l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport');
        $this->db->where('noclient', $noclient);
        $query = $this->db->get();
        return $query->result();
        //SELECT r.noreservation, r.dateheure, pd.nom, pa.nom, t.dateheuredepart, r.montanttotal, r.paye FROM reservation r, traversee t, liaison l, port pd, port pa WHERE r.notraversee = t.notraversee AND t.noliaison = l.noliaison AND l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport AND r.noclient = x
    }
}
