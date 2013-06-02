<?php
/***************************************************************************************
 *                       			konsumen.php
 ***************************************************************************************
 *      Author:     	Topidesta as Shabiki <m.desta.fadilah@hotmail.com>
 *      Website:    	http://www.twitter.com/emang_dasar
 *
 *      File:          	konsumen.php
 *      Created:   		2012 - 12.35.14 WIB
 *      Copyright:  	(c) 2012 - desta
 *                  	DON'T BE A DICK PUBLIC LICENSE
 * 						Version 1, December 2009
 *						Copyright (C) 2009 Philip Sturgeon
 *
 ****************************************************************************************/
class Manajer extends MX_Controller
{
	private $groups = 'manajer';
	
	function __construct()
	{
		parent::__construct();
		$data = array();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper(array('url', 'form'));
		$this->load->database();

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
	}

	function index()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group($this->groups))
		{
			
			// Buat Template
			$data['welcome'] = "Welcome " . ucfirst($this->session->userdata('email'));
			$data['title'] 	 = "Dashboard Panel";
			$data['manajer'] = "manajer"; // Controller
			$data['view'] 	 = "gen_manajer"; // View
			$data['module']  = "user"; // Controller
				
			// Load Template->view(login)
			echo Modules::run('template/manajer',$data);
		}else{
			redirect('auth/index/', 'refresh');
		}
	}
	/*
	 * Fungsi Khusus Manajer Untuk Mengatur Pelanggan
	 * 
	 * @param
	 * @array
	 * 
	 */
	function pelanggan() 
	{
		$data['welcome'] = "Welcome back ". ucfirst($this->session->userdata('email'));
		echo Modules::run('pelanggan/index', $data);
	}
}
 
 
 /* End of File: konsumen.php */
/* Location: ../www/modules/konsumen.php */ 