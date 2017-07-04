<?php

namespace entity;

/**
* La classe user
*/
class user extends \lib\Entity
{
	
	private $id;

	private $login;

	private $password;


	function __construct($id = null)	{
		$this->id = $id;
	}


}