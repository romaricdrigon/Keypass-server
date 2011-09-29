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
	    $q = "SELECT usr_id, usr_user, usr_password FROM key_user WHERE usr_user = ?";
	    $q = $this->db->query($q, array($username));
		$r = $q->row_array(); // on récupère le 1er résultat
	
	    if (isset($r['usr_password']) && $r['usr_password'] == $key)
	    {			
	    	return $r['usr_id'];
	    } else {
	    	return FALSE;
		}
	}

	/*
	 * CRUD
	 */
	public function add_section($user_id, $title)
	{
		$this->db->insert('key_data', array('key_title' => $title, 'key_usr_id' => $user_id)); 
		
		// on récupère l'id de l'enregistrement que l'on vient de faire
		return mysql_insert_id();
	}
	public function modify_section($user_id, $id, $data)
	{
		$this->db->where('key_id', $id)->where('key_usr_id', $user_id); // make sure it's owned by current user
		$this->db->update('key_data', array('key_title' => $data));
	}
	public function delete_section($user_id, $id)
	{
		$this->db->delete('key_data', array('key_id' => $id, 'key_usr_id' => $user_id)); 
	}
	public function get_blops($user_id)
	{
		$this->db->select('key_id AS id, key_title AS title, key_blop AS blop')->from('key_data')->where('key_usr_id', $user_id);
		$query = $this->db->get();
		
		return $query->result_array();
	}
	public function change_item($user_id, $id, $data)
	{
		$this->db->where('key_id', $id)->where('key_usr_id', $user_id); // make sure it's owned by current user
		$this->db->update('key_data', array('key_blop' => $data));
	}

	/*
	 * Change credentials
	 * We need old ones to find the record
	 */
	public function change_credentials($user_id, $user, $key, $new_user, $new_key) {
		$this->db->where('usr_id', $user_id)->where('usr_user', $user)->where('usr_password', $key);
		$this->db->update('key_user', array('usr_user' => $new_user, 'usr_password' => $new_key));
	}

	/*
	 * Change all sections
	 * receive an associative array
	 */
	public function change_all_items($user_id, $content)
	{
		foreach ($content as $blop)
		{
			$this->db->where('key_id', $blop['id'])->where('key_usr_id', $user_id); // make sure it's owned by current user
			$this->db->update('key_data', array('key_title' => $blop['title'], 'key_blop' => $blop['content']));
		}
	}

}

/* EOF */