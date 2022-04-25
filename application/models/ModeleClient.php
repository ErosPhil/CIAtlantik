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

    public function retournerClientN($NoClient)
    {
        $requete = $this->db->get_where('client', array('noclient' => $NoClient));
        return $requete->row();
    }

    public function insererClient($DonneesAInserer)
    {
        return $this->db->insert('client', $DonneesAInserer);
    }
}
