<?php

class ModeleReservation extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function retournerReservationsLimite($nombreDeLignesARetourner, $noPremiereLigneARetourner, $noClient)
    {
        $this->db->select('r.noreservation, r.dateheure, pd.nom AS nomportdepart, pa.nom AS nomportarrivee, t.dateheuredepart, r.montanttotal, r.paye');
        $this->db->limit($nombreDeLignesARetourner, $noPremiereLigneARetourner);
        $this->db->from('reservation r, traversee t, liaison l, port pd, port pa');
        $this->db->where('r.notraversee = t.notraversee AND t.noliaison = l.noliaison AND l.noport_depart = pd.noport AND l.noport_arrivee = pa.noport');
        $this->db->where('noclient', $noClient);
        $this->db->order_by('r.noreservation');
        $query = $this->db->get();
        /*var_dump($query->result());
        echo "/////////////////////";*/
        return $query->result();
    }

    public function nombreDeReservations($noClient)
    {
        $this->db->select("count(*) AS nombre");
        $this->db->from('reservation');
        $this->db->where('noclient', $noClient);
        $query = $this->db->get();
        return $query->row();
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

    public function getReservation($noReservation)
    {
        $requete = $this->db->get_where('reservation', array('noreservation' => $noReservation));
        return $requete->row();
    }

    public function getEnregistrements($noReservation)
    {
        $this->db->select('e.noreservation, e.quantite, t.lettrecategorie, t.notype, t.libelle');
        $this->db->from('enregistrer e, type t');
        $this->db->where('e.lettrecategorie = t.lettrecategorie AND e.notype = t.notype');
        $this->db->where('noreservation', $noReservation);
        $query = $this->db->get();
        return $query->result();
    }
}