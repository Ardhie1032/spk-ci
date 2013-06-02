<?php
/***************************************************************************************
 *                       			pelanggan.php
 ***************************************************************************************
 *      Author:     	Topidesta as Shabiki <m.desta.fadilah@hotmail.com>
 *      Website:    	http://www.twitter.com/emang_dasar
 *
 *      File:          	pelanggan.php
 *      Created:   		2013 - 21.06.52 WIB
 *      Copyright:  	(c) 2012 - desta
 *                  	DON'T BE A DICK PUBLIC LICENSE
 * 						Version 1, December 2009
 *						Copyright (C) 2009 Philip Sturgeon
 *
 ****************************************************************************************/
 
class Pelanggan extends MX_Controller
{
	private $groups = array('direktur','manajer');
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->load->helper(array('form','url'));
		$this->load->model('pelanggan_model','pelanggan');
	}
	
	// testing
	function debuk()
	{
		$data['hasil'] = $this->pelanggan->get();
		echo dump($data);
	}
	
	function index()
	{
		$this->load->model('pelanggan_model');
		if ($this->ion_auth->is_admin() || $this->ion_auth->logged_in() && $this->ion_auth->in_group($this->groups))
		{
			$this->_manage();
		}else{
			redirect(base_url().'index.php/auth/index', 'refresh');
		}
	}

	/*
	 * Fungsi Mengatur CRUD Pelanggan
	 */
	function _manage()
	{
		
		// paging
		$this->load->library('pagination');
		$config['base_url'] = base_url().'konsumen/index'; 
		$config['total_rows']   = $this->pelanggan->count('konsumen'); // false
		$config['per_page'] 	= 3;
		
		$data['view']    = 'pelanggan_view';
		$data['module']  = 'pelanggan';
		$data['welcome'] = "Welcome back ". ucfirst($this->session->userdata('email'));
		$data['title']   = "Module Pelanggan";
		
		$this->pagination->initialize($config);
		$data['hasil'] = $this->pelanggan->get_all($config['per_page'],$this->uri->segment(3));
		
		/*
		 * Run Template Module
		 * 
		 * @param boolean
		 * @array admin || manajer || direktur
		 */
		if ($this->ion_auth->is_admin()){ echo Modules::run('template/admin',$data);
		}elseif ($this->ion_auth->in_group('direktur')){ echo Modules::run('template/direktur',$data);
		}else{ echo Modules::run('template/manajer',$data); }
	}
	
	/*
	 * Fungsi untuk menghapus
	 * 
	 * @param id
	 * @array 
	 */
	function _delete()
	{
		
	}
	
	/*
	 * Fungsi untuk melihat details
	 * 
	 * @param id
	 * @array
	 */
	function _detail()
	{
		
	}
}
 
 
 /* End of File: pelanggan.php */
/* Location: ../www/modules/pelanggan.php */ 