<?php
class ThreadController extends AppController
{
	public function index()
	{
		// TODO: Get all threads
		$threads = Thread::getAll();

		$adapter = new \Pagerfanta\Adapter\ArrayAdapter($threads);
		$paginator = new \Pagerfanta\Pagerfanta($adapter);
		$paginator->setMaxPerPage(5);
		$paginator->setCurrentPage(Param::get('page', 1));
		$threads = Thread::objectToarray($paginator);

		$view = new \Pagerfanta\View\TwitterBootstrapView();
		$options = array('proximity' => 3, 'url' => 'card/all');
		$html = $view->render($paginator, 'routeGenerator', $options);

		$this->set(get_defined_vars());
	}

	public function view()
	{
		$thread = Thread::get(Param::get('thread_id'));
		$comments = $thread->getTestComments();
		$this->set(get_defined_vars());
	}


	public function write()
	{
		$thread = Thread::get(Param::get('thread_id'));
		$comment = new Comment;
		$page = Param::get('page_next', 'write');

		switch ($page) {
			case 'write':
			break;
			case 'write_end':
			$comment->username = Param::get('username');
			$comment->body = Param::get('body');

			try {
				$thread->write($comment);
			} catch (ValidationException $e) {
				$page = 'write';
			}

			break;
			default:
			throw new NotFoundException("{$page} is not found");
			break;
		}

		$this->set(get_defined_vars());
		$this->render($page);

	}

	public function create()
	{
		$thread = new Thread;
		$comment = new Comment;
		$page = Param::get('page_next', 'create');
		switch ($page) {
			case 'create':
			break;
			case 'create_end':
			$thread->title = Param::get('title');
			$comment->username = Param::get('username');
			$comment->body = Param::get('body');
			try {
				$thread->create($comment);
			} catch (ValidationException $e) {
				$page = 'create';
			}
			break;
			default:
			throw new NotFoundException("{$page} is not found");
			break;
		}
		$this->set(get_defined_vars());
		$this->render($page);
	}

	public function register()
	{	
		$thread         = new Thread;
		$page           = Param::get('page_next', 'register');
		// $user           = array();

		$username = Param::get('username');
		$password = Param::get('password');

		// echo $page;
		switch ($page) {
			case 'register':

			break;

			case 'register_end':
				try {
					$status = $thread->registerUser($username, $password);
				} catch (ValidationException $e) {
					
				}

			break;

			default:
			throw new NotFoundException("{$page} is not found");
			break;
		}
		$this->render($page);
		$this->set(get_defined_vars());
	}

}
