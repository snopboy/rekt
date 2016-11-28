<?php

namespace Application\Model;

class UserModel
{

	public function getUserName($username = null)
	{
		if (null === $username) {
			$username = 'Snopboy';
		}

		return $username;
	}
}
