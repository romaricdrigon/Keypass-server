<?php
class Request_model extends CI_Model {			
    public function __construct()
    {
        parent::__construct();
    }
	
	/*
	 * Permet de checker un couple user/mdp
	 * Ce n'est pas un vrai mdp en fait, mais un mot crypté avec la clef de l'user
	 */
	public function valid_credentials($username, $key)
	{
		$this->load->helper('security');
	
	    // requête préparée, beaucoup plus sécurisé et rapide
	    $q = "SELECT * FROM key_user WHERE usr_user = ?";
	    $q = $this->db->query($q, array($username));
		$r = $q->row_array(); // on récupère le 1er résultat
	
	    if ($r['usr_password'] == $key)
	    {			
	    	return TRUE;
	    } else {
	    	return FALSE;
		}
	}

	/*
	 * CRUD
	 */
	public function add_section($title)
	{
		$this->db->insert('key_data', array('key_title' => $title)); 
		
		// on récupère l'id de l'enregistrement que l'on vient de faire
		return mysql_insert_id();
	}
	public function delete_section($id)
	{
		$this->db->delete('key_data', array('key_id' => $id)); 
	}
	public function get_blops()
	{
		$this->db->select('key_id AS id, key_title AS title, key_blop AS blop')->from('key_data');
		$query = $this->db->get();
		
		return $query->result_array(); // le 1er trouvé
	}
	public function change_item($id, $data)
	{
		$this->db->where('key_id', $id);
		$this->db->update('key_data', array('key_blop' => $data));
	}


}

/* EOF */