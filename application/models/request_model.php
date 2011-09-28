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
	
	    if (isset($r['usr_password']) && $r['usr_password'] == $key)
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
	public function modify_section($id, $data)
	{
		$this->db->where('key_id', $id);
		$this->db->update('key_data', array('key_title' => $data));
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

	/*
	 * Change credentials
	 * We need old ones to find the record
	 */
	public function change_credentials($user, $key, $new_user, $new_key) {
		$this->db->where('usr_user', $user)->where('usr_password', $key);
		$this->db->update('key_user', array('usr_user' => $new_user, 'usr_password' => $new_key));
	}

	/*
	 * Change all sections
	 * receive an associative array
	 */
	public function change_all_items($content)
	{
		foreach ($content as $blop)
		{
			$this->db->where('key_id', $blop['id']);
			$this->db->update('key_data', array('key_title' => $blop['title'], 'key_blop' => $blop['content']));
		}
	}

}

/* EOF */