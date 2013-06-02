<?php
/***************************************************************************************
 *                       			template.php
 ***************************************************************************************
 *      Author:     	Topidesta as Shabiki <m.desta.fadilah@hotmail.com>
 *      Website:    	http://www.twitter.com/emang_dasar
 *
 *      File:          	template.php
 *      Created:   		2012 - 17.24.46 WIB
 *      Copyright:  	(c) 2012 - desta
 *                  	DON'T BE A DICK PUBLIC LICENSE
 * 						Version 1, December 2009
 *						Copyright (C) 2009 Philip Sturgeon
 *		
 *		source: 		www.davidconnelly.com/hmvcstuff
 *						www.dcradionnetwork.com
 *
 ****************************************************************************************/
class Template extends MX_Controller
{
	function login($data)
	{
		$this->load->view('login', $data);
	}
	
	function admin($data)
	{
		$this->load->view('admin',$data);
		//$this->load->view('side_admin');
	}

	function konsumen($data)
	{
		$this->load->view('konsumen',$data);
	}
	
	function perawat($data)
	{
		$this->load->view('perawat',$data);
	}
	
	function manajer($data)
	{
		$this->load->view('manajer', $data);
	}
	
	function direktur($data)
	{
		$this->load->view('direktur', $data);
	}
	
	// Default Templates
	function members($data)
	{
		$this->load->view('members',$data);
	}
}
 
 
 /* End of File: template.php */
/* Location: ../www/modules/template.php */ 