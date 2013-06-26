<?php
class Thread extends AppModel
{
	public $validation = array(
		'title' => array(
			'length' => array(
				'validate_between', 1, 30,
				),
			),
		);

	public static function get($id)
	{
		$db = DB::conn();
		$row = $db->row('SELECT * FROM thread WHERE id = ?', array($id));
		return new self($row);
	}

	public static function getAll()
	{
		$threads = array();
		$db = DB::conn();
		$rows = $db->rows('SELECT * FROM thread');
		foreach ($rows as $row) {
			$threads[] = new Thread($row);
		}
		return $threads;
	}

	public static function getPaginatedThread($page)
	{	
			// $page       = 1;
		

		$threads    = array();
		$db         = DB::conn();
		$total_rows = $db->rows("SELECT count(*) FROM thread");
		
		$page_limit = 5;
		$offset     = $page * $page_limit;
		$paginated  = $db->rows("SELECT * FROM thread LIMIT $page, $page_limit");

		foreach ($paginated as $row) {
			$threads[] = new Thread($row);
		}

		return $threads;
	}


	public function getComments()
	{
		$comments = array();
		$db = DB::conn();
		$rows = $db->rows('SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC LIMIT 20', array($this->id));
		foreach ($rows as $row) {
			$comments[] = new Comment($row);
		}

		return $comments;
	}

	public function getTestComments()
	{
		$comments = array();
		$db = DB::conn();
		$rows = $db->rows('SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC LIMIT 20', array($this->id));
		foreach ($rows as $row) {
			$comments[] = new Comment($row);
		}

		return $comments;
	}

	public function write(Comment $comment)
	{
		if (!$comment->validate()) {
			throw new ValidationException('invalid comment');
		}

		$db = DB::conn();
		$db->query('INSERT INTO comment SET thread_id = ?, username = ?, body = ?, created = NOW()', array($this->id, $comment->username, $comment->body));
	}

	public function create(Comment $comment)
	{
		$this->validate();
		$comment->validate();
		if ($this->hasError() || $comment->hasError()) {
			throw new ValidationException('invalid thread or comment');
		}
		$db = DB::conn();
		$db->begin();
		$db->query('INSERT INTO thread SET title = ?, created = NOW()', array($this->title));
		$this->id = $db->lastInsertId();

			// write first comment at the same time
		$this->write($comment);
		$db->commit();
	}

	public static function registerUser($username, $password){
		$db     = DB::conn();
		$status = "";
		try {
			$db->begin();
			$db->query('INSERT INTO user SET user_name = ?, user_password = ?', array($username, $password));
			$db->commit();
			$status = "success";
			return $status;
		} catch (Exception $e) {
			$status = "failed";
			return $status;
		}
		
	}

	public static function objectToarray($data)
	{
		try{
			if (is_array($data) || is_object($data)){
				$result = array();
				foreach ($data as $key => $value){
					$result[$key] = $value;
				}
				return $result;
			}
			return $data;
		} catch(PDOException $e) {
			return "error ";
		}
	}

}
