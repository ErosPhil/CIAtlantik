<?php

class ModeleReservation extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function retournerReservationsLimite($nombreDeLignesARetourner, $noPremiereLigneARetourner, $noClient)
    {
        $this->db->limit($nombreDeLignesARetourner, $noPremiereLigneARetourner);
        $this->db->select('r.noreservation, r.dateheure, pd.nom AS nomportdepart, pa.nom AS nomportarrivee, t.dateheuredepart, r.montanttotal, r.paye');
        $this->db->from('reservation r, traversee t, liaison l, port pd, port pa');
        $this->db->where('r.notraversee = t.notraversee AND t.noliaison = l.noliaison AND l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport');
        $this->db->where('noclient', $noClient);
        $query = $this->db->get();
        return $query->result();
    }

    public function nombreDeReservations($noClient)
    {
        $this->db->where('noclient', $noClient);
        return $this->db->count_all("reservation");
    }

    public function reserver($DonneesDeReservation)
    {
        if(($this->db->insert('reservation', $DonneesDeReservation)) == true)
        {
            return $this->db->insert_id();
        }
        else
        {
            return false;
        }
    }

    public function enregistrer($DonneesDEnregistrement)
    {
        return $this->db->insert('enregistrer', $DonneesDEnregistrement);
    }
}