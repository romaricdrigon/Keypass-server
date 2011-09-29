<?php
class Request extends CI_Controller {
	/* 
	 * Classe qui fait tout le boulot actuellement
	 */
	
	function index()
	{
		die('Direct access forbidden');
	}
	
	/*
	 * Recoit un mot (fixé) codé avec le mot de passe,
	 * compare avec la bdd
	 * si c'est conforme renvoie ok
	 * @param, en POST :
	 *  - id de l'user
	 *  - password ("key")
	 */
	public function gets()
	{
		$user = $this->input->post('user');
		$key = $this->input->post('key');
		
		if (strlen($user) == 0 || strlen($key) == 0)
		{
			die('Missing parameter');
		}
		
		// oui, en Php il faut vraiment faire ça, avec strict à TRUE, pour tester si c'est bien du base64 !
		if (base64_decode($key, TRUE) === FALSE)
		{
			die('Wrong encoding');
		}
		
		$this->load->model('request_model');
		
		$user_id = $this->request_model->valid_credentials($user, $key);
		if ($user_id !== FALSE)
		{
			// get all
			$data = $this->request_model->get_blops($user_id);
			
			echo json_encode($data);
		}
		else
		{
			die('Invalid credentials');
		}
	}
	
	/*
	 * Ajouter une section
	 */
	public function add_section()
	{
		$title = $this->input->post('title');
		$user = $this->input->post('user');
		$key = $this->input->post('key');
		
		if (strlen($title) == 0 || strlen($user) == 0 || strlen($key) == 0)
		{
			die('Missing parameter');
		}
		
		if (base64_decode($title, TRUE) === FALSE)
		{
			die('Wrong encoding');
		}
		
		$this->load->model('request_model');
		
		$user_id = $this->request_model->valid_credentials($user, $key);
		if ($user_id !== FALSE)
		{
			echo $this->request_model->add_section($user_id, $title);
		}
		else
		{
			die('Invalid credentials');
		}
	}

	public function modify_section()
	{
		$title = $this->input->post('title');
		$id = $this->input->post('id');
		$user = $this->input->post('user');
		$key = $this->input->post('key');
		
		if (strlen($title) == 0 || strlen($user) == 0 || strlen($key) == 0 || strlen($id) == 0)
		{
			die('Missing parameter');
		}

		if (is_numeric($id) == FALSE)
		{
			die('Wrong id');
		}
		
		if (base64_decode($title, TRUE) === FALSE)
		{
			die('Wrong encoding');
		}
		
		$this->load->model('request_model');
		
		$user_id = $this->request_model->valid_credentials($user, $key);
		if ($user_id !== FALSE)
		{
			echo $this->request_model->modify_section($user_id, $id, $title);
		}
		else
		{
			die('Invalid credentials');
		}
	}

	/*
	 * Supprimer une section
	 */
	public function remove_section()
	{
		$id = $this->input->post('id');
		$user = $this->input->post('user');
		$key = $this->input->post('key');
		
		if (strlen($id) == 0 || strlen($user) == 0 || strlen($key) == 0)
		{
			die('Missing parameter');
		}
		
		if (is_numeric($id) == FALSE)
		{
			die('Wrong id');
		}
		
		$this->load->model('request_model');
		
		$user_id = $this->request_model->valid_credentials($user, $key);
		if ($user_id !== FALSE)
		{
			$this->request_model->delete_section($user_id, $id);
		}
		else
		{
			die('Invalid credentials');
		}
	}
	
	/*
	 * Modifier un item, on ne sait pas quoi c'est crypté !
	 */
	public function change_data()
	{
		$content = $this->input->post('content');
		$id = $this->input->post('id');
		$user = $this->input->post('user');
		$key = $this->input->post('key');
		
		if (strlen($content) == 0 || strlen($id) == 0 || strlen($user) == 0 || strlen($key) == 0)
		{
			die('Missing parameter');
		}
		
		if (is_numeric($id) == FALSE)
		{
			die('Wrong id');
		}
		
		$this->load->model('request_model');
		
		$user_id = $this->request_model->valid_credentials($user, $key);
		if ($user_id !== FALSE)
		{
			$this->request_model->change_item($user_id, $id, $content);
		}
		else
		{
			die('Invalid credentials');
		}
	}
	
	/*
	 * Change credentials
	 * and so all encrypted content
	 */
	public function credentials_changed()
	{
		$user = $this->input->post('user');
		$key = $this->input->post('key');
		// new data
		$new_user = $this->input->post('newUser');
		$new_key = $this->input->post('newKey');
		$new_content = $this->input->post('newContent');

		
		if (strlen($user) == 0 || strlen($key) == 0 || strlen($new_user) == 0 || strlen($new_key) == 0 || strlen($new_content) == 0)
		{
			die('Missing parameter');
		}
		
		$this->load->model('request_model');
		
		$user_id = $this->request_model->valid_credentials($user, $key);
		if ($user_id !== FALSE)
		{
			// decode given JSON
			$content = json_decode($new_content, true);
			
			if ($content === NULL) // our decoding failed
			{
				die('Invalid JSON');
			}
			
			$this->request_model->change_credentials($user_id, $user, $key, $new_user, $new_key);
			$this->request_model->change_all_items($user_id, $content);
			
			exit('success');
		}
		else
		{
			die('Invalid credentials');
		}		
	}

}

/* EOF */