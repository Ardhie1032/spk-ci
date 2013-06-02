<?php
/***************************************************************************************
 *                       			perawat.php
 ***************************************************************************************
 *      Author:     	Topidesta as Shabiki <m.desta.fadilah@hotmail.com>
 *      Website:    	http://www.twitter.com/emang_dasar
 *
 *      File:          	perawat.php
 *      Created:   		2013 - 13.12.55 WIB
 *      Copyright:  	(c) 2012 - desta
 *                  	DON'T BE A DICK PUBLIC LICENSE
 * 						Version 1, December 2009
 *						Copyright (C) 2009 Philip Sturgeon
 *
 ****************************************************************************************/
 class Perawat extends MX_Controller
 {
 	private $groups = 'manajer';
	
 	/*
 	 * Modul Data Perawat seluruh informasi para perawat PT. Narendra Krida.
 	 * 
 	 * - Tambah data perawat
 	 * - Edit data perawat
 	 * - Hapus data perawat
 	 * 
 	 */
 	function __construct(){
 		parent::__construct();
 		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->load->helper(array('form','url'));
 	}
 	
 	function index()
 	{
 		$this->load->model('perawat_model');
 		if ($this->ion_auth->is_admin() || $this->ion_auth->logged_in() && $this->ion_auth->in_group($this->groups))
 		{
 			$this->_manage();
 		}else{
 			redirect(base_url().'index.php/auth/index', 'refresh');
 		}
 	}
 	/*
 	 * Fungsi mengatur halaman perawat
 	 */
 	function  _manage()
 	{
 		
 		
 		$data['hasil'] = $this->perawat_model->get('perawat_id');
 		$data['view'] = 'perawat_view';
 		$data['module'] = 'perawat';
 		$data['welcome'] = "Welcome back ". ucfirst($this->session->userdata('email'));
		$data['title'] = "Module Perawat";
		
		
		
 		/*
 		 * Run template module
 		 * 
 		 * @param boolean
 		 * @array admin || manajer
 		 */
		if ($this->ion_auth->is_admin()){
			// Jika admin, arahkan ke template admin
			echo Modules::run('template/admin',$data);
		}else{
			// Jika manajer, arahkan ke template manajer
			echo Modules::run('template/manajer',$data);
		}
 	}
	
	function edit() {
		
	}
	
	function hapus() {
		
	}
 	
 	function tambah() {
 		// Pengecekan role user
 		if ($this->ion_auth->is_admin() || $this->ion_auth->logged_in() && $this->ion_auth->in_group($this->groups))
 		{
 			// lakukan proses CRUD di sini!
			// CRUD ATURAN CI
 			
 			// Buat Template
 			$data['welcome'] = "Welcome " . ucfirst($this->session->userdata('email'));
 			$data['title'] = "Module Perawat";
 			$data['perawat'] = "perawat"; // Controller
 			$data['view'] = "perawat_view"; // View
 			$data['module'] = "perawat"; // Controller
 		
 			// Load Template->view(login)
 			echo Modules::run('template/perawat',$data);
 		
 		}
 		else //apabila belum login
 		{
 			show_404();
 		}
 	}
 	
 	/*
 	 * From Davidconnelly.com
 	 */
 	
 	function get($order_by){
 		$this->load->model('m_perawat');
 		$query = $this->m_perawat->get($order_by);
 		return $query;
 	}
 	
 	function get_with_limit($limit, $offset, $order_by) {
 		$this->load->model('m_perawat');
 		$query = $this->m_perawat->get_with_limit($limit, $offset, $order_by);
 		return $query;
 	}
 	
 	function get_where($id){
 		$this->load->model('m_perawat');
 		$query = $this->m_perawat->get_where($id);
 		return $query;
 	}
 	
 	function get_where_custom($col, $value) {
 		$this->load->model('m_perawat');
 		$query = $this->m_perawat->get_where_custom($col, $value);
 		return $query;
 	}
 	
 	function _insert($data){
 		$this->load->model('m_perawat');
 		$this->m_perawat->_insert($data);
 	}
 	
 	function _update($id, $data){
 		$this->load->model('m_perawat');
 		$this->m_perawat->_update($id, $data);
 	}
 	
 	function _delete($id){
 		$this->load->model('m_perawat');
 		$this->m_perawat->_delete($id);
 	}
 	
 	function count_where($column, $value) {
 		$this->load->model('m_perawat');
 		$count = $this->m_perawat->count_where($column, $value);
 		return $count;
 	}
 	
 	function get_max() {
 		$this->load->model('m_perawat');
 		$max_id = $this->m_perawat->get_max();
 		return $max_id;
 	}
 	
 	function _custom_query($mysql_query) {
 		$this->load->model('m_perawat');
 		$query = $this->m_perawat->_custom_query($mysql_query);
 		return $query;
 	}
 
 }
 
 
 /* End of File: perawat.php */
/* Location: ../www/modules/perawat/perawat.php */ 