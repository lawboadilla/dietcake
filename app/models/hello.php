<?php 
	class Hello Extends AppModel {

		public static function getAll(){
			$chara   = array();
			$db      = DB::conn();
			$rows    = $db->rows("SELECT * FROM chara");

			foreach ($rows as $row) {
				$chara[] = new Thread($row);
			}

			return $chara;
		}
		
	}
