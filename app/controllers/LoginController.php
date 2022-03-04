<?php

class LoginController extends ApplicationController
{
	public function __construct(){
			
	}

	public function indexAction()
	{
		$this->view->message = "hello from test::login";
	}
	
	public function checkAction()
	{
		echo "hello from login::check";
	}
}
