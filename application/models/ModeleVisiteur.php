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
}
?>