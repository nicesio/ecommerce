<?php

namespace Hcode\Model;

const SESSION="User";

use \Hcode\DB\Sql;
use \Hcode\Model;
/**
 * 
 */
class User extends Model
{
	public static function login($login, $password){
		$sql = new Sql;
		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(":LOGIN"=>$login));

		if (count ($results) === 0){
			throw new \Exception("Usuario Inexistente ou senha invalida.");
			
		}

		$data = $results[0];

		if (password_verify($password, $data["password"])===true){
			$user = new User();

			$user->setData($data["iduser"]);

			$_SESSION[User::SESSION] = $use->getValues();

			return $user;

		}else{
			throw new \Exception("Usuario inexistente ou senha invalida");
			
		}
	}

	public static function verifyLogin($inadmin = true){
		if(
			!isset ($_SESSION[User::SESSION])
			||
			!$_SESSION[User::SESSION]
			||
			!(int)$_SESSION[User::SESSION]["iduser"]>0
			||
			(bool)$_SESSION[User::SESSION]["inadmin"]!==$inadmin
		){
			header("Location: /admin/login");
			exit;
		}
	}


	public static function logout()
	{
		$_SESSION[User::SESSION]=NULL;
	}

}

?>