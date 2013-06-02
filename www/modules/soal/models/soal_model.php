<?php
/***************************************************************************************
 *                       			soal_model.php
 ***************************************************************************************
 *      Author:     	Topidesta as Shabiki <m.desta.fadilah@hotmail.com>
 *      Website:    	http://www.twitter.com/emang_dasar
 *
 *      File:          	soal_model.php
 *      Created:   		2013 - 09.57.52 WIB
 *      Copyright:  	(c) 2012 - desta
 *                  	DON'T BE A DICK PUBLIC LICENSE
 * 						Version 1, December 2009
 *						Copyright (C) 2009 Philip Sturgeon
 *
 ****************************************************************************************/
 class Soal_model extends CI_Model
 {
 	protected $banksoal_table;
 	protected $pilihan_table;
 	protected $jawaban_table;
 	
 	function __construct() {
 		$this->banksoal_table = 'banksoal';
 		$this->pilihan_table = 'jawaban';
 		$this->jawaban_table = 'votes';
 	}
 	/*
 	 * Menjumlah seluruh soal
 	 * 
 	 * @access public
 	 * @return integer
 	 */
 	function num_soals() {
 		return $this->db->count_all($this->banksoal_table);
 	}
 	
 	function all_soal()
 	{
 		
 	}
 }
 
 
 /* End of File: soal_model.php */
/* Location: ../www/modules/soal_model.php */ 