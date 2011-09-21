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
			die("Missing parameter");
		}
		
		// oui, en Php il faut vraiment faire ça, avec strict à TRUE, pour tester si c'est bien du base64 !
		if (base64_decode($key, TRUE) === FALSE)
		{
			die("Wrong encoding");
		}
		
		$this->load->model('request_model');
		
		if ($this->request_model->valid_credentials($user, $key) === TRUE)
		{
			// get all
			$data = $this->request_model->get_blops();
			
			echo json_encode($data);
		}
		else
		{
			die("Invalid credentials");
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
			die("Missing parameter");
		}
		
		if (base64_decode($title, TRUE) === FALSE)
		{
			die("Wrong encoding");
		}
		
		$this->load->model('request_model');
		
		if ($this->request_model->valid_credentials($user, $key) === TRUE)
		{
			echo $this->request_model->add_section($title);
		}
		else
		{
			die("Invalid credentials");
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
			die("Missing parameter");
		}

		if (is_numeric($id) == FALSE)
		{
			die("Wrong id");
		}
		
		if (base64_decode($title, TRUE) === FALSE)
		{
			die("Wrong encoding");
		}
		
		$this->load->model('request_model');
		
		if ($this->request_model->valid_credentials($user, $key) === TRUE)
		{
			echo $this->request_model->modify_section($id, $title);
		}
		else
		{
			die("Invalid credentials");
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
			die("Missing parameter");
		}
		
		if (is_numeric($id) == FALSE)
		{
			die("Wrong id");
		}
		
		$this->load->model('request_model');
		
		if ($this->request_model->valid_credentials($user, $key) === TRUE)
		{
			$this->request_model->delete_section($id);
			
			echo 'Operation done';
		}
		else
		{
			die("Invalid credentials");
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
			die("Missing parameter");
		}
		
		if (is_numeric($id) == FALSE)
		{
			die("Wrong id");
		}
		
		$this->load->model('request_model');
		
		if ($this->request_model->valid_credentials($user, $key) === TRUE)
		{
			$this->request_model->change_item($id, $content);
		}
		else
		{
			die("Invalid credentials");
		}
	}

}

/* EOF */