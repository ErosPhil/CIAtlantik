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
        //SELECT * FROM client WHERE mel = $Id AND motdepasse = $MdP
        return $requete->row();
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
    
    public function insererClient($DonneesAInserer)
    {
        return $this->db->insert('client', $DonneesAInserer);
        //INSERT INTO client(nom, prenom, adresse, codepostal, ville, telephonefixe, telephonemobile, mel, motdepasse) VALUES($nom, $prenom, $adresse, $codepostal, $ville, $telephonefixe, $telephonemobile, $mel, $motdepasse)
    }
}
