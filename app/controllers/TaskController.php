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
       $taskJsonModel = new TaskJsonModel();     
       $taskJsonModel->createTask();  

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
        // echo  __FILE__ . " ".  __FUNCTION__;
        
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
        // var_dump($user);
        $this->view->updatetask = $user ;
        // $action == 'update' ? 'Actualizamos el registro' : $this->view->updatetask = $user ;
        
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
            $id = $_GET['idTarea'];

            switch ($option){
                case "changestatus":
                    $user = $this->getTask($id);
                    $taskJsonModel = new TaskJsonModel();       
                    $allUsers = $taskJsonModel->listAllTask();
                    $taskJsonModel->changeStatusTask($allUsers, $user);
                    break;
                case "update":
                    $titulo = $_GET['titulo'];
                    $descripcion = $_GET['descripcion'];
                    //Enviamos a la página del Listado
                    // echo '<h1>Actualizamos el registro</h1>';
                    // echo 'Título: ' . $titulo . '<br>';
                    // echo 'Descripción: ' . $descripcion . '<br>';
                    //Actualizamos registro según los datos obtenidos
                    $user = $this->getTask($id);
                    $taskJsonModel = new TaskJsonModel(); 
                    $allUsers = $taskJsonModel->listAllTask();
                    $taskJsonModel->updateTask($allUsers, $user);                    
                    break;
                case "delete":
                    // echo "Delete task action";
                    $user = $this->getTask($id);
                    $taskJsonModel = new TaskJsonModel(); 
                    $allUsers = $taskJsonModel->listAllTask();
                    $taskJsonModel->deleteTask($allUsers, $user); 
                    break;
                default:
                    echo "Este valor no corresponde a ninguna acción";
            }
        //    if ($option == 'changestatus'){
        //         $id = $_GET['idTarea'];
        //         $user = $this->getTask($id);
        //         $taskJsonModel = new TaskJsonModel();       
        //         $allUsers = $taskJsonModel->listAllTask();
        //         $taskJsonModel->changeStatusTask($allUsers, $user);
        //     }
        }
        // Pasamos los parametros del controller a la vista 
        $this->view->showtask = $taskJsonModel->listAllTask();
    }

    public function changeStateTaskAction() {
        echo  __FILE__ . " ".  __FUNCTION__;
    }

}
