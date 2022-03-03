<?php


class TaskController extends ApplicationController
{    
	public function indexAction()
	{
		$this->view->message = "hello from test::index";

	}
	
	public function checkAction()
	{
		echo "hello from test::check";
	}

    public function createTaskAction() {
       echo  __FILE__ . " ".  __FUNCTION__;
        /*
        * Recoger los valores de los campos
        * Validar la información contra bd o js
        * llamar al modelo para guardar los datos del form
        */
    }

    public function deleteTaskAction() {
        echo  __FILE__ . " ".  __FUNCTION__;
    }

    public function updateTaskAction() {
        echo  __FILE__ . " ".  __FUNCTION__;
    }

    public function showTaskAction() {        
       $taskJsonModel = new TaskJsonModel();
       $taskJsonModel->listAllTask();

       /*
       // Devuelve el valor de la vista
       $this->_getAllParams();
       */

    }

    public function changeStateTaskAction() {
        echo  __FILE__ . " ".  __FUNCTION__;
    }

}
