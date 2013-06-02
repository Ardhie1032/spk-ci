<?php
/***************************************************************************************
 *                       			soal_lib.php
 ***************************************************************************************
 *      Author:     	Topidesta as Shabiki <m.desta.fadilah@hotmail.com>
 *      Website:    	http://www.twitter.com/emang_dasar
 *
 *      File:          	soal_lib.php
 *      Created:   		2013 - 11.32.19 WIB
 *      Copyright:  	(c) 2012 - desta
 *                  	DON'T BE A DICK PUBLIC LICENSE
 * 						Version 1, December 2009
 *						Copyright (C) 2009 Philip Sturgeon
 *
 *		source:			Poll Application
 *
 ****************************************************************************************/
 class Soal_lib {
 	
 	private $CI;
 	private $max_soal_options;
 	private $min_soal_options;
 	
 	private $errors;
 	private $error_start_delim;
 	private $error_end_delim;
 	
 	function __construct() {
 		
 		$this->CI =& get_instance();
 		$this->CI->load->database();
 		$this->CI->load->model('soal_model');
 		
 		$this->CI->load->config('soal');
 		$this->max_soal_options = $this->CI->config->item('max_soal_options','soal');
 		$this->min_soal_options = $this->CI->config->item('min_soal_options','soal');
 		
 		$this->error_start_delim = '<p clas="error">';
 		$this->error_end_delim = '</p>';
 	}
 }
 
 
 /* End of File: soal_lib.php */
/* Location: ../www/libraries/soal_lib.php */ 