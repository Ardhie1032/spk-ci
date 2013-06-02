<?php
/***************************************************************************************
 *                       			user_model.php
***************************************************************************************
*      Author:     	Topidesta as Shabiki <m.desta.fadilah@hotmail.com>
*      Website:    	http://www.twitter.com/emang_dasar
*
*      File:          	user_model.php
*      Created:   		2013 - 11.06.47 WIB
*      Copyright:  	(c) 2012 - desta
*                  	DON'T BE A DICK PUBLIC LICENSE
* 						Version 1, December 2009
*						Copyright (C) 2009 Philip Sturgeon
*
****************************************************************************************/
class User extends My_Model
{
	function __construct(){
		parent::__construct();
		$this->table = 'groups';
	}

	function get_groups($options = array())
	{
		$query = $this->db->get($this->table);
		foreach ($query->result() as $row) {
			$options[$row->id] = $row->name;
		}
		return $options;
	}
}


/* End of File: user.php */
/* Location: ../www/modules/user_model.php */