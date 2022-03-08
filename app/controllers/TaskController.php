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

    public function getTask($id){
        echo  __FILE__ . " ".  __FUNCTION__;
        
        $taskJsonModel = new TaskJsonModel(); 
        $users = $taskJsonModel->listAllTask();
        foreach ($users as $user){
            if ($user['idTareas'] == $id){
                // var_dump($user);
                return $user;
            }
        }
        return null;
    }

    public function updateTaskAction() {
        echo  __FILE__ . " ".  __FUNCTION__;
        echo "<br>UpdateTaskAction<br>";
        $id = $_GET['idTarea'];
        $user = $this->getTask($id);
        $this->view->updatetask = $user;
    }

    public function changestatus(){
        echo  __FILE__ . " ".  __FUNCTION__;
        $id = $_GET['idTarea'];
        $user = $this->getTask($id);
        $taskJsonModel = new TaskJsonModel();     
        $allUsers = $taskJsonModel->listAllTask();  
        $taskJsonModel->changeStatusTask($allUsers, $user);
    }

    public function showTaskAction() {      
       //Declaramos un objeto de tipo Model  
       $taskJsonModel = new TaskJsonModel();

       //Chequeamos si es cambio de estado
       if (isset($_GET['op'])){ 
           $option = $_GET['op'];
           if ($option == 'changestatus'){
                $id = $_GET['idTarea'];
                $user = $this->getTask($id);
                $taskJsonModel = new TaskJsonModel();       
                $allUsers = $taskJsonModel->listAllTask();
                $taskJsonModel->changeStatusTask($allUsers, $user);
            }
       }
       // Pasamos los parametros del controller a la vista 
       $this->view->showtask = $taskJsonModel->listAllTask();
    }

    public function changeStateTaskAction() {
        echo  __FILE__ . " ".  __FUNCTION__;
    }

}
