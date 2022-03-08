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
        echo "ID: " . $id . "<br>"; 
        var_dump($users);
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
        echo "ID: " . $id . "<br>"; 
        $user = $this->getTask($id);
        $taskJsonModel = new TaskJsonModel();       
        $taskJsonModel->changeStatusTask($user);
        // $this->view->showtask = $taskJsonModel->changeStatusTask();
        // $this->view->updatetask = $user;
    }

    public function showTaskAction() {      
       //Declaramos un objeto de tipo Model  
       $taskJsonModel = new TaskJsonModel();

       //Chequeamos si es cambio de estado
       if (isset($_GET['op'])){ 
           $option = $_GET['op'];
           if ($option == 'changestatus'){
                echo "<p style=color:red>CHANGESTATUS</p>";
                $id = $_GET['idTarea'];
                echo "ID: " . $id . "<br>"; 
                $user = $this->getTask($id);
                $taskJsonModel = new TaskJsonModel();       
                $taskJsonModel->changeStatusTask($user);
            }
       }
       // Pasamos los parametros del controller a la vista 
       $this->view->showtask = $taskJsonModel->listAllTask();
    }

    public function changeStateTaskAction() {
        echo  __FILE__ . " ".  __FUNCTION__;
    }

}
