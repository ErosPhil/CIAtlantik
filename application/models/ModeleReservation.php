<?php

class ModeleReservation extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
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