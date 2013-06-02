<?php
/***************************************************************************************
 *                       			user.php
***************************************************************************************
*      Author:     	Topidesta as Shabiki <m.desta.fadilah@hotmail.com>
*      Website:    	http://www.twitter.com/emang_dasar
*
*      File:          	user.php
*      Created:   		2013 - 09.40.45 WIB
*      Copyright:  	(c) 2012 - desta
*                  	DON'T BE A DICK PUBLIC LICENSE
* 						Version 1, December 2009
*						Copyright (C) 2009 Philip Sturgeon
*
****************************************************************************************/
class User extends MX_Controller
{
	/*
	 * Class User yang digunakan untuk mengatur seluruh proses CRUD Pengguna Sistem
	* ----------------------------------------------------------------------------
	* Fungsi:
	* 			1. Daftar Seluruh Pengguna
	* 			2. Membuat Pengguna Baru
	* 			3. Membuat Group Baru
	* 			4. Melihat Pengguna Aktif
	* 			5. Melihat Pengguna Tidak Aktif
	* 			6. Menghapus Group
	* 			7. Menghapus User
	* 			8. Mengubah User
	* 			9. Mengubah Group
	*
	* Original source: - Library ionauth with some modification
	*/

	// group di tabel
	private $groups = array('perawat','konsumen','direktur','manajer');

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper(array('url', 'form'));
		$this->load->database();
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
	}
	
	/*
	 * Ionauth support
	 */
	
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

	/*
	 * Fungsi untuk menampilkan seluruh pengguna sistem
	*
	* @param @array
	*/
	function index()
	{
		if ($this->ion_auth->is_admin())
		{
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['users'] = $this->ion_auth->users()->result();
			foreach ($data['users'] as $k => $user)
			{
				$data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

			// paging
			$this->load->library('pagination');

			$uri_segment = 3;
			$data['offset'] = $this->uri->segment($uri_segment);

			$config['base_url'] = base_url().'user/index/';
			$config['total_rows'] = $this->ion_auth->users()->num_rows();
			$config['per_page'] = 10;
			$config['next_link'] = '<li>Selanjutnya</li>';
			$config['prev_link'] = '<li>Sebelumnya</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">..</a>';
			$config['cur_tag_close'] = '</li>';

			$data['users'] = $this->ion_auth->offset($this->uri->segment($uri_segment))->limit($config['per_page'])->users()->result();
			//$data['users'] = $this->ion_auth->users()->limit($config['per_page'])->offset($this->uri->segment($uri_segment))->result();
			foreach ($data['users'] as $k => $user)
			{
				// cek groups user
				$data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

			$this->pagination->initialize($config);
			$data["paging"] = $this->pagination->create_links();

			// Template
			$data['welcome'] = "Welcome back ". ucfirst($this->session->userdata('email'));
			$data['title']  = "Module Admin";
			$data['admin']  = "admin"; // Controller
			$data['view']   = "listall"; // View
			$data['module'] = "user"; // Controller

			echo Modules::run('template/admin',$data);

		}else{
			redirect('auth','refresh');
		}
	}
	
	function debuk(){
		$data['groups'] = $this->ion_auth->groups()->result_array();
		
		$group_option = array();
				foreach ($groups as $group){
					$group_option[$group->id] = $group->name;
				}
				echo "<td>" . form_dropdown('groups', $group_option) . "</td>"; 
			
		
		echo "<br /><hr />";
		$query = $this->db->get('groups');
		echo dump($query);
		
		echo "<br /><hr />";
		
		$gp = $this->ion_auth->groups()->row();
		
		echo dump($gp);
		echo "<br /><hr />";
		
		$grup= $this->ion_auth->group()->row();
		echo $grup->id;
		
		echo dump($grup);
		echo "<br /><hr />";
		$user =1;
		$data['user_groups'] = $this->ion_auth->get_users_groups($user)->result();
		echo dump($data);
		echo "<hr />";
		
		$groups = $this->ion_auth->groups('id')->result_array();

		foreach ($groups as $group):
		echo form_dropdown('id',$group,'group');
		endforeach;
		
		echo "<hr/>";
		
		$user = $this->ion_auth->user()->row();
		echo $user->username;
		
		echo "<hr />";
		
		$user = $this->ion_auth->user($id)->row();
		echo dump($user);
		echo "<hr />";
		/*
		 $this->load->model('user_model');
		$gr = $this->user_model->get_groups();
		echo dump($gr);
		*/

		echo "<br />";
		foreach ($user->groups as $group):
			echo ucfirst($group->name);
		endforeach;
		
		echo dump($groups);
		echo "<br/>";
		
		$this->load->database();
		$this->load->model('ion_auth_model');
		$query = $this->db->get('groups');
		echo dump($query);

	}
	/*
	 * Fungsi ini digunakan untuk membuat user baru
	* secara default, fungsi ini ada juga di module ionauth
	*
	*/
	function new_user()
	{
		$data['title'] = "Tambah Pengguna";
		
		if ($this->ion_auth->is_admin())
		{
			$this->form_validation->set_rules('username', 'Username','required|xss_clean');
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
			$this->form_validation->set_rules('group_id','Level');

			/*
			 * Cek validasi inputan user
			*/
			if ($this->form_validation->run() == true)
			{
				/*
				 * Field utama yang akan di simpan di tabel users
				*/
				$username = $this->input->post('username', true);
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$group_option = $this->input->post('groups', true);

			}

			/*
			 * Lakukan pengecekan regeister
			*/

			if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $group_option))
			{
				$this->session->set_flashdata('message', "Pengguna berhasil ditambahkan!");
				redirect('user/','refresh');
			}else{
				//set flashdata untuk kesalahan input atau untuk pesan error sebelumnya
				
				$data['message'] = (validation_errors()) ? '<div class="alert alert-error"><a class="close" data-dismiss="alert">X</a>'.validation_errors().'</div>' : $this->ion_auth->errors();
					
				//buat array untuk membuat field form
				$data['username'] = array(
						'name' => 'username',
						'id' => 'username',
						'type' => 'text',
						'class' => 'ttip_t',
						'title' => 'Masukan Username Yang Unik',
						'value' => $this->form_validation->set_value('username'),
				);
				$data['email'] = array(
						'name' => 'email',
						'id' => 'email',
						'type' => 'text',
						'class' => 'ttip_t',
						'title' => 'Masukan Alamat Email Yang Valid',
						'value' => $this->form_validation->set_value('email'),
				);

				$data['password'] = array(
						'name' => 'password',
						'id' => 'password',
						'type' => 'password',
						'class' => 'ttip_t',
						'title' => 'Masukkan Password Yang Valid',
						'value' => $this->form_validation->set_value('password'),
				);
				$data['password_confirm'] = array(
						'name' => 'password_confirm',
						'id' => 'password_confirm',
						'type' => 'password',
						'class' => 'ttip_t',
						'title' => 'Ulangi Password',
						'value' => $this->form_validation->set_value('password_confirm'),
				);
				
				$data['group_option'] = $this->ion_auth->add_to_group($group_id, $user_id);
									
				$data['welcome'] = "Welcome back ". ucfirst($this->session->userdata('email'));
				$data['title']  = "Module Admin";
				$data['admin']  = "admin"; // Controller
				$data['view']   = "newuser"; // View
				$data['module'] = "user"; // Controller

				echo Modules::run('template/admin',$data);
			}
		}else{
			echo 'not akses';
		}
	}

	/*
	 * Fungsi ini digunakan untuk membuat group baru
	*/
	function new_group()
	{
		
	}

	/*
	 * Fungsi ini digunakan untuk melihat user yang aktif
	*/
	function user_aktif()
	{
		$this->load->helper('debug_helper');
		$group = $this->ion_auth->group()->result();
		echo dump($group);
	}

	/*
	 * Fungsi ini digunakan untuk melihat user yang tidak aktif
	*/
	function nonaktif_user()
	{
			
	}

	/*
	 * Fungsi ini digunakan untuk menghapus user
	*
	* @param array id
	*/
	function hapus_user($id)
	{
		if (!$this->ion_auth->is_admin()){
			$errors = $this->ion_auth->errors();
		}else{
			$user_d = $this->ion_auth->delete_user($id);
			redirect('user');
		}
		
		/*
		if ($this->ion_auth->is_admin()) {
			$user_d = $this->ion_auth->delete_user($id);
			
			if (!$user_d) {
				$errors = $this->ion_auth->messages();
			}else{
				redirect ('user','refresh');
			}
		}else{
			echo 'not akses';
		}
		*/
	}

	/*
	 * Fungsi ini digunakan untuk menghapus group
	*/
	function hapus_group($group_id)
	{
		if ($this->ion_auth->is_admin())
		{
			$group_d = $this->ion_auth->delete_group($group_id);

			if (!$group_d)
			{
				$errors = $this->ion_auth->messages();
			}else{
				redirect ('group','refresh');
			}
		}
	}

	/*
	 * Fungsi ini digunakan untuk mengubah/ update users
	*
	*/
	function edit_user($id)
	{
		$data['title'] = "Edit Pengguna";
			
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$user->email;
		
		//validate form input
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		
		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error('This form post did not pass our security checks.');
			}
			
			// validasi inputan
			$data = array(
				'username' => $this->input->post('usernmae'),
				'email'  => $this->input->post('email'),
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
				$this->session->set_flashdata('message', "Data tersimpan");
				redirect("user", 'refresh');
			}
		}
		
		//display the edit user form
		$data['csrf'] = $this->_get_csrf_nonce();

		//set the flash data error message if there is one
		$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//pass the user to the view
		$data['user'] = $user;

		$data['username'] = array(
				'name' => 'username',
				'id'   => 'username',
				'type' => 'username'
		);
		
		$data['email'] = array(
				'name' => 'email',
				'id'   => 'email',
				'type' => 'email'
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
		
		$data['welcome'] = "Welcome back ". ucfirst($this->session->userdata('email'));
		$data['title']  = "Module Admin";
		$data['admin']  = "admin"; // Controller
		$data['view']   = "edituser"; // View
		$data['module'] = "user"; // Controller
		echo Modules::run('template/admin',$data);
	}
	
	function detail_user($id)
	{
		
	}

}


/* End of File: user.php */
/* Location: ../www/modules/user.php */