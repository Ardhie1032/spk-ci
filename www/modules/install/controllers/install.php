<?php
/***************************************************************************************
 *                       			install.php
 ***************************************************************************************
 *      Author:     	Topidesta as Shabiki <m.desta.fadilah@hotmail.com>
 *      Website:    	http://www.twitter.com/emang_dasar
 *
 *      File:          	install.php
 *      Created:   		2013 - 19.37.09 WIB
 *      Copyright:  	(c) 2012 - desta
 *                  	DON'T BE A DICK PUBLIC LICENSE
 * 						Version 1, December 2009
 *						Copyright (C) 2009 Philip Sturgeon
 *		
 *		Based On:
 * 		@copyright  	2011 Emad Elsaid a.k.a Blaze Boy
 * 		@license    	http://www.gnu.org/licenses/gpl-2.0.txt   GPL License 2.0
 * 		@link       	https://github.com/blazeeboy/Codeigniter-Egypt
 *
 ****************************************************************************************/
 class Install extends MX_Controller
 {
 	function __construct(){
 		parent::__construct();
 		$this->load->database();
 		$this->load->helper('url');
 	}
 	
 	function index()
 	{
 		if( count($this->db->list_tables())==0 ){
 			$script = explode( ';', file_get_contents('mysql.sql') );
 			$script = array_map( 'trim', $script );
 			$script = array_filter( $script, 'count');
 			foreach( $script as $line )
 				if( $line!='' )
 				$this->db->query($line);
 		}
 		redirect('');
 	}
 }
 
 
 /* End of File: install.php */
/* Location: ../www/modules/install.php */ 