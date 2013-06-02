<?php
/***************************************************************************************
 *                       			pelanggan_model.php
 ***************************************************************************************
 *      Author:     	Topidesta as Shabiki <m.desta.fadilah@hotmail.com>
 *      Website:    	http://www.twitter.com/emang_dasar
 *
 *      File:          	pelanggan_model.php
 *      Created:   		2013 - 21.07.11 WIB
 *      Copyright:  	(c) 2012 - desta
 *                  	DON'T BE A DICK PUBLIC LICENSE
 * 						Version 1, December 2009
 *						Copyright (C) 2009 Philip Sturgeon
 *
 ****************************************************************************************/
 
class Pelanggan_model extends CI_Model
{	
	
	private $table = 'konsumen';
	
	function __construct(){
		parent::__construct();
		
	}
	
	function get_all($limit, $offset=0)
	{
		$data['hasil'] = $this->db->get($this->table);
		return $data;
	}
	
	function get($konsumen_id,$fields,$where='',$one=false,$array='array'){
	
		$this->db->select($fields);
		$this->db->from($this->table);
		
		if($where){
			$this->db->where($where);
		}
	
		$query = $this->db->get();
	
		$result =  !$one  ? $query->result($array) : $query->row() ;
		return $result;
	}
		
	function add($id,$data){
		$this->db->insert($table, $data);
		if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
	
		return FALSE;
	}
	
	function edit($table,$data,$fieldID,$ID){
		$this->db->where($fieldID,$ID);
		$this->db->update($table, $data);
	
		if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
	
		return FALSE;
	}
	
	function delete($id,$fieldID,$ID){
		$this->db->where($fieldID,$ID);
		$this->db->delete($table);
		if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
	
		return FALSE;
	}
	
	function count($konsumen_id){
		return $this->db->count_all($this->table);
	}
}
 
 
 /* End of File: pelanggan_model.php */
/* Location: ../www/modules/pelanggan_model.php */ 