<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller {
	
	/* Simple Auth with Ion Auth Library
	 * Author: Much. D. Fadilah
	 * modification from controller auth.php from original resource https://github.com/benedmunds/CodeIgniter-Ion-Auth
	 */
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->load->database();

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
	}
	
	/* BERIKUT FUNGSI-FUNGSI UNTUK MENAMPILKAN HALAMAN
	 * - function index() untuk menampilkan halaman beranda
	 * - function login() untuk menampilkan halaman login
	 * - function forgot_password() untuk menampilkan halaman form lupa password
	 * - function change_password() untuk mengubah password masuk ke sistem
	 * - function admin() untuk menampilkan halaman dengan role user
	 * - function konsumen() untuk menampilkan halaman dengan role administrator
	 * - function 
	 */

	//redirect if needed, otherwise display the user list
	function index(){

	if ($this->ion_auth->logged_in())
		{
			/*
			 * setting groups yang ada di tabel
			 * require settings: config/routes.php
			 * 
			 */
			if ($this->ion_auth->is_admin()){
				redirect('user/admin','refresh');
			}elseif ($this->ion_auth->in_group('direktur')){
				redirect('user/direktur','refresh');
			}elseif ($this->ion_auth->in_group('manajer')){
				redirect('user/manajer','refresh');
			}elseif ($this->ion_auth->in_group('konsumen')){
				redirect('user/konsumen','refresh');
			}elseif ($this->ion_auth->in_group('perawat')){
				redirect('user/perawat','refresh');
			}
		}
		else
		{
			redirect('auth/login','refresh');
			/*
			$data['login'] = "login";
			$data['view'] = "login";
			$data['module'] = "auth";
			$data['message'] = "";
			echo Modules::run('template/login',$data);
			*/
		}
	}

	//log the user in
	function login()
	{
		$data['title'] = "Login";

		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{ 
			//check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{ 
				//if the login is successful, redirect them back to the home page
				$this->session->set_flashdata('message', '<div class="alert alert-info alert-login">'.$this->ion_auth->messages().'</div>');
				redirect('auth/index', 'refresh');
			}
			else
			{ 
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', '<div class="alert alert-info alert-login">'.$this->ion_auth->errors().'</div>');
				
				//use redirects instead of loading views for compatibility with MY_Controller libraries
				redirect('auth/login', 'refresh'); 
			
			}
		}
		else
		{  
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);
			
			// Buat Template
			$data['login'] = "auth";
			$data['view'] = "login";
			$data['module'] = "auth";
			
			// Load Template->view(login)
			echo Modules::run('template/login',$data);
			//$this->load->view('auth/login', $data);
		}
	}

	//log the user out
	function logout()
	{
		$data['title'] = "Logout";

		//log the user out
		$logout = $this->ion_auth->logout();

		//redirect them to the login page
		$this->session->set_flashdata('message','<div class="alert alert-info alert-login">'.$this->ion_auth->messages().'</div>');
		redirect('auth/login', 'refresh');
	}
	
	//create a new user
	function create_user()
	{
		$data['title'] = "Tambah Pengguna";
	
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}
	
		//validate form input
		$this->form_validation->set_rules('first_name', 'Nama Pertama', 'required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Nama Terakhir', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Alama Email', 'required|valid_email');
		$this->form_validation->set_rules('phone1', 'Handphone', 'required|xss_clean|min_length[10]|max_length[13]');
		$this->form_validation->set_rules('company', 'Company Name', 'required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
	
		if ($this->form_validation->run() == true)
		{
			$username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$email    = $this->input->post('email');
			$password = $this->input->post('password');
	
			$additional_data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone1'),
			);
		}
		if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data))
		{
			//check to see if we are creating the user
			//redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			//display the create user form
			//set the flash data error message if there is one
			
			$data['message'] = (validation_errors() ? '<div class="alert alert-error"><a class="close" data-dismiss="alert">X</a>'.validation_errors().'</div>' : ($this->ion_auth->errors() ? $this->ion_auth->errors(): $this->session->flashdata('message')));
			
			$data['first_name'] = array(
					'name'  => 'first_name',
					'id'    => 'first_name',
					'type'  => 'text',
					'value' => $this->form_validation->set_value('first_name'),
			);
			$data['last_name'] = array(
					'name'  => 'last_name',
					'id'    => 'last_name',
					'type'  => 'text',
					'value' => $this->form_validation->set_value('last_name'),
			);
			$data['email'] = array(
					'name'  => 'email',
					'id'    => 'email',
					'type'  => 'text',
					'value' => $this->form_validation->set_value('email'),
			);
			$data['company'] = array(
					'name'  => 'company',
					'id'    => 'company',
					'type'  => 'text',
					'value' => $this->form_validation->set_value('company'),
			);
			$data['phone1'] = array(
					'name'  => 'phone1',
					'id'    => 'phone1',
					'type'  => 'text',
					'value' => $this->form_validation->set_value('phone1'),
			);
			$data['password'] = array(
					'name'  => 'password',
					'id'    => 'password',
					'type'  => 'password',
					'value' => $this->form_validation->set_value('password'),
			);
			$data['password_confirm'] = array(
					'name'  => 'password_confirm',
					'id'    => 'password_confirm',
					'type'  => 'password',
					'value' => $this->form_validation->set_value('password_confirm'),
			);
			
			$data['welcome'] = "Welcome back ". ucfirst($this->session->userdata('email'));
			$data['title'] = "Module Pengguna Sistem";
			$data['auth'] = "auth"; 		// Controller
			$data['view'] = "create_user"; 	// View
			$data['module'] = "auth"; 		// Controller
	
			
			echo Modules::run('template/admin',$data);
		}
	}
	
	//edit a user
	function edit_user($id)
	{
		$data['title'] = "Edit Pengguna";
	
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}
	
		$user = $this->ion_auth->user($id)->row();
	
		//process the phone number
		if (isset($user->phone) && !empty($user->phone))
		{
			$user->phone = explode('-', $user->phone);
		}
	
		//validate form input
		$this->form_validation->set_rules('first_name', 'Nama Pertama', 'required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Nama Kedua', 'required|xss_clean');
		$this->form_validation->set_rules('phone1', 'First Part of Phone', 'required|xss_clean|min_length[3]|max_length[3]');
		$this->form_validation->set_rules('phone2', 'Second Part of Phone', 'required|xss_clean|min_length[3]|max_length[3]');
		$this->form_validation->set_rules('phone3', 'Third Part of Phone', 'required|xss_clean|min_length[4]|max_length[4]');
		$this->form_validation->set_rules('company', 'Nama Perusahaan', 'required|xss_clean');
	
		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error('This form post did not pass our security checks.');
			}
	
			$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone1') . '-' . $this->input->post('phone2') . '-' . $this->input->post('phone3'),
			);
	
			//update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
	
				$data['password'] = $this->input->post('password');
			}
	
			if ($this->form_validation->run() === TRUE)
			{
				$this->ion_auth->update($user->id, $data);
	
				//check to see if we are creating the user
				//redirect them back to the admin page
				$this->session->set_flashdata('message', "User Saved");
				redirect("auth", 'refresh');
			}
		}
	
		//display the edit user form
		$data['csrf'] = $this->_get_csrf_nonce();
	
		//set the flash data error message if there is one
		$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
	
		//pass the user to the view
		$data['user'] = $user;
	
		$data['first_name'] = array(
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$data['last_name'] = array(
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$data['company'] = array(
				'name'  => 'company',
				'id'    => 'company',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('company', $user->company),
		);
		$data['phone1'] = array(
				'name'  => 'phone1',
				'id'    => 'phone1',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('phone1', $user->phone[0]),
		);
		$data['phone2'] = array(
				'name'  => 'phone2',
				'id'    => 'phone2',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('phone2', $user->phone[1]),
		);
		$data['phone3'] = array(
				'name'  => 'phone3',
				'id'    => 'phone3',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('phone3', $user->phone[2]),
		);
		$data['password'] = array(
				'name' => 'password',
				'id'   => 'password',
				'type' => 'password'
		);
		$data['password_confirm'] = array(
				'name' => 'password_confirm',
				'id'   => 'password_confirm',
				'type' => 'password'
		);
	
		$this->load->view('auth/edit_user', $data);
	}
	

	//change password
	function change_password()
	{
		$this->form_validation->set_rules('old', 'Old password', 'required');
		$this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{ 
			//display the form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$data['new_password'] = array(
				'name' => 'new',
				'id'   => 'new',
				'type' => 'password',
				'pattern' => '^.{'.$data['min_password_length'].'}.*$',
			);
			$data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{'.$data['min_password_length'].'}.*$',
			);
			$data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			//render
			$this->load->view('auth/change_password', $data);
		}
		else
		{
			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{ 
				//if the password was successfully changed
				$this->session->set_flashdata('message', '<div class="alert alert-info alert-login">'.$this->ion_auth->messages().'</div>');
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	//forgot password
	function forgot_password()
	{
		$this->form_validation->set_rules('email', 'Email Address', 'required');
		if ($this->form_validation->run() == false)
		{
			//setup the input
			$data['email'] = array('name' => 'email',
				'id' => 'email',
			);

			//set any errors and display the form
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			
			$data['login'] = "login";
			$data['view'] = "login";
			$data['module'] = "auth";
			
			echo Modules::run('template/login',$data);
			//$this->load->view('auth/forgot_password', $data);
		}
		else
		{
			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

			if ($forgotten)
			{ 
				//if there were no errors
				$this->session->set_flashdata('message', '<div class="alert alert-info alert-login">'.$this->ion_auth->messages().'</div>');
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	//reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{  
			//if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

			if ($this->form_validation->run() == false)
			{
				//display the form

				//set the flash data error message if there is one
				$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
				'type' => 'password',
					'pattern' => '^.{'.$data['min_password_length'].'}.*$',
				);
				$data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{'.$data['min_password_length'].'}.*$',
				);
				$data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$data['csrf'] = $this->_get_csrf_nonce();
				$data['code'] = $code;

				//render
				$this->load->view('auth/reset_password', $data);
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) 
				{

					//something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error('This form post did not pass our security checks.');

				} 
				else 
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{ 
						//if the password was successfully changed
						$this->session->set_flashdata('message', '<div class="alert alert-info alert-login">'.$this->ion_auth->messages().'</div>');
						$this->logout();
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{ 
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}


	//activate the user
	function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			//redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			//redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	//deactivate the user
	function deactivate($id = NULL)
	{
		$id = $this->config->item('use_mongodb', 'ion_auth') ? (string) $id : (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'user ID', 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$data['csrf'] = $this->_get_csrf_nonce();
			$data['user'] = $this->ion_auth->user($id)->row();

			$this->load->view('auth/deactivate_user', $data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{				
					show_error('This form post did not pass our security checks.');
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			//redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	

	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}
