<?php
/***************************************************************************************
 *                       			soal.php
 ***************************************************************************************
 *      Author:     	Topidesta as Shabiki <m.desta.fadilah@hotmail.com>
 *      Website:    	http://www.twitter.com/emang_dasar
 *
 *      File:          	soal.php
 *      Created:   		2013 - 18.22.30 WIB
 *      Copyright:  	(c) 2012 - desta
 *                  	DON'T BE A DICK PUBLIC LICENSE
 * 						Version 1, December 2009
 *						Copyright (C) 2009 Philip Sturgeon
 *
 ****************************************************************************************/
 class Soal extends MX_Controller {
 	
 	/*
 	 * lihat contoh :
 	 * http://localhost/smiley/index.php/guestbook/index
 	 */
 	
 	private $groups = array('manajer','konsumen');
 	
 	function __construct() {
 		parent::__construct();
 		$this->load->library('ion_auth');
 		$this->load->library('session');
 		$this->load->library('soal_lib');
 		$this->load->library('form_validation');
 		$this->load->helper('url');
 		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
 	}
 	
 	function index() 
 	{
 		// | $this->ion_auth->in_group($this->groups)
 		if ($this->ion_auth->is_admin())
 		{
 			
 			$config['base_url'] = base_url().'soal/index/';
 			$config['total_rows'] = $this->soal_model->num_soals();
 			$config['per_page'] = 5;
 			$config['next_link'] = '<li>Selanjutnya</li>';
 			$config['prev_link'] = '<li>Sebelumnya</li>';
 			$config['cur_tag_open'] = '<li class="active"><a href="#">..</a>';
 			$config['cur_tag_close'] = '</li>';
 			
 			$this->load->library('pagination');
 			$this->pagination->initialize($config);
 			
 			// Fatal error: Call to undefined method Soal_lib::all_soal()
 			$data['results'] = $this->soal_model->all_soal($config['per_page'], $this->uri->segment(3));
 			$data['paging'] = $this->pagination->create_links();
 			
 			$data['welcome'] = "Welcome". ucfirst($this->session->userdata('email'));
 			$data['title'] = "Modul Soal";
 			$data['module'] = "soal"; // module
 			$data['soal'] = "soal"; // controller
 			$data['view'] = "display"; // view
 			
 			echo Modules::run('template/admin',$data);
 			
 		}else{
 			echo 'You not have access';
 		}
 	}
 	
 	function tambah()
 	{
 		if ($this->ion_auth->is_admin())
 		{
 			//Pengaturan maksimal dan minimal jumlah jawaban
 			$data['min_options'] = $this->config->item('min_puas_options','puas');
 			$data['max_options'] = $this->config->item('max_puas_options','puas');
 			
 			
 		}
 	}
 	
 	function ubah()
 	{
 		if ($this->ion_auth->is_admin())
 		{
 			
 		}
 	}
 	
 	function hapus()
 	{
 		if ($this->ion_auth->is_admin() || $this->ion_auth->in_group('manajer'))
 		{
 			echo 'admin dan manajer juga';
 		}else{
 			echo 'akses untuk manajer';
 		}
 	}
 	
 	function tampil_soal()
 	{
 		$data['welcome'] = "Welcome back ". ucfirst($this->session->userdata('email'));
 		$data['title']  = "Tampil Soal";
 		$data['module'] = 'soal';
 		$data['view'] = 'papan_soal';
 		echo Modules::run('template/konsumen',$data);
 	}
 }
 
 
 /* End of File: soal.php */
/* Location: ../www/modules/soal.php */ 