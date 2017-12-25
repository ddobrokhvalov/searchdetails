<?php
class params{
	public static $params=array();
	
	public static function init_default_params(){
		self::$params=array(
			"db_port" => array ("value" => "3306"), // СУБД mysql, oracle или mssql
      		"db_server" => array ("value" => "localhost"), // Сервер БД для MySQL
      		"db_name" => array ("value" => "searchdetails"), // Для MySQL и MSSQL - название БД, для Oracle - SID
      		"db_user" => array ("value" => "searchdetails"), // Пользователь БД
      		"db_password" => array ("value" => 'searchdetailspass'), // Пароль БД
			"table_name" => array ("value" => 'spares_parts'),
			"upload_dir"=> array("value"=> $_SERVER["DOCUMENT_ROOT"]."/uploads"),
		);
	}
}
params::init_default_params();

?>