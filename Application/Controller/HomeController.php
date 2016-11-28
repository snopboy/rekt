<?php

namespace Application\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Application\Model\UserModel;

class HomeController
{

	public $username = null;

	private function _getUsername()
	{
		$model = new UserModel();
		$this->username = $model->getUserName();
		return $this;
	}

	public function indexAction(Request $request)
	{
		$user = array('username' => $this->_getUsername()->username);
		return json_encode($user);
	}
}
