<?php

namespace App;

class Data{

	private static $db;

	public static function getDb(){

		if (self::$db === null)
		{
			self::$db = new Database;
		}
		return self::$db;
	}

}