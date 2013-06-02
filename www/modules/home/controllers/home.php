<?php
/***************************************************************************************
 *                       			home.php
 ***************************************************************************************
 *      Author:     	Topidesta as Shabiki <m.desta.fadilah@hotmail.com>
 *      Website:    	http://www.twitter.com/emang_dasar
 *
 *      File:          	home.php
 *      Created:   		2012 - 10.58.10 WIB
 *      Copyright:  	(c) 2012 - desta
 *                  	DON'T BE A DICK PUBLIC LICENSE
 * 						Version 1, December 2009
 *						Copyright (C) 2009 Philip Sturgeon
 *
 ****************************************************************************************/

/*
 * Default Template for Home
 * 
 * @access: Public
 * @role: admin,perawat,konsumen dan non-members
 */

class Home extends MX_Controller {

	public function index()
	{
		$this->load->view('home');
	}
}
 
 /* End of File: home.php */
/* Location: ../www/modules/home.php */ 