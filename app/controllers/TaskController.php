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
        //Declaramos un objeto de tipo Model  
        $taskJsonModel = new TaskJsonModel();   
        // Pasamos los parametros del controller a la vista 
        $users = $taskJsonModel->listAllTask();
        $user = $taskJsonModel->updateTask($users);
        var_dump($user);

        // $this->view->updatetask
    }

    public function showTaskAction() {      
       //Declaramos un objeto de tipo Model  
       $taskJsonModel = new TaskJsonModel();       
       
       // Pasamos los parametros del controller a la vista 
       $this->view->showtask = $taskJsonModel->listAllTask();
    }

    public function changeStateTaskAction() {
        echo  __FILE__ . " ".  __FUNCTION__;
    }

}
