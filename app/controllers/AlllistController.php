<?php

class AlllistController extends ApplicationController
{
	public function indexAction()
	{
		$this->view->message = "hello from alllist::login";
	}
	
	public function checkAction()
	{
		echo "hello from alllist::check";
	}
}
