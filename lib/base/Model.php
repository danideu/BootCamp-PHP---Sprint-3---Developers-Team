<?php
/**
 * A base model for handling the database connections
 */
class Model
{
	private $json = "todo.json";
	private $tareas_json = null;

	public function __construct()
	{
		// $uri = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$this->tareas_json = json_decode(file_get_contents("http://localhost:8899/cursos/barcelonaactiva/sprint3/to-do/web/javascripts/todo.json", true), true);
		$this->listAllTask($this->tareas_json);
	}
	
	public function listAllTask($json){
		echo 'Listar todas las tarea';
		var_dump($json);
		return($json);
	}

	public function deleteTask($task){
		$this->task = $task;
		echo 'Eliminar tarea' . $this->task;
	}

	public function updateTask($task){
		$this->task = $task;
		echo 'Actualziar tarea' . $this->task;
	}

	public function completeTask($task){
		$this->task = $task;
		echo 'Completar tarea' . $this->task;
	}

	public function fetchOne($id)
	{
		$sql = 'select * from ' . $this->_table;
		$sql .= ' where id = ?';
		
		$statement = $this->_dbh->prepare($sql);
		$statement->execute(array($id));
		
		return $statement->fetch(PDO::FETCH_OBJ);
	}
	
	/**
	 * Saves the current data to the database. If an key named "id" is given,
	 * an update will be issued.
	 * @param array $data the data to save
	 * @return int the id the data was saved under
	 */
	public function save($data = array())
	{
		$sql = '';
		
		$values = array();
		
		if (array_key_exists('id', $data)) {
			$sql = 'update ' . $this->_table . ' set ';
			
			$first = true;
			foreach($data as $key => $value) {
				if ($key != 'id') {
					$sql .= ($first == false ? ',' : '') . ' ' . $key . ' = ?';
					
					$values[] = $value;
					
					$first = false;
				}
			}
			
			// adds the id as well
			$values[] = $data['id'];
			
			$sql .= ' where id = ?';// . $data['id'];
			
			$statement = $this->_dbh->prepare($sql);
			return $statement->execute($values);
		}
		else {
			$keys = array_keys($data);
			
			$sql = 'insert into ' . $this->_table . '(';
			$sql .= implode(',', $keys);
			$sql .= ')';
			$sql .= ' values (';
			
			$dataValues = array_values($data);
			$first = true;
			foreach($dataValues as $value) {
				$sql .= ($first == false ? ',?' : '?');
				
				$values[] = $value;
				
				$first = false;
			}
			
			$sql .= ')';
			
			$statement = $this->_dbh->prepare($sql);
			if ($statement->execute($values)) {
				return $this->_dbh->lastInsertId();
			}
		}
		
		return false;
	}
	
	/**
	 * Deletes a single entry
	 * @param int $id the id of the entry to delete
	 * @return boolean true if all went well, else false.
	 */
	public function delete($id)
	{
		$statement = $this->_dbh->prepare("delete from " . $this->_table . " where id = ?");
		return $statement->execute(array($id));
	}
}
