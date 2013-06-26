<?php 
class User Extends AppModel {

		public static function registerUser($user){
			$db = DB::conn();
			$db->begin();
			$db->query('INSERT INTO user SET user_name = ?', $user);
			$this->id = $db->lastInsertId();
			$db->commit();

			
		}
	}
