<?php

class ModeleClient extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function retournerClient($Id, $MdP)
    {
        $requete = $this->db->get_where('client', array('mel' => $Id, 'motdepasse' => $MdP));
        return $requete->row();
    }

//$Nom, $Prenom, $Adresse, $Ville, $CodePostal, $TelFixe = '', $TelPortable = '', $Mel, $MotDePasse

    public function insererClient($DonneesAInserer)
    {
        return $this->db->insert('client', $DonneesAInserer);
    }
}
