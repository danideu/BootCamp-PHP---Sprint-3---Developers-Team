<?php 

/**
 * Used to define the routes in the system.
 * 
 * A route should be defined with a key matching the URL and an
 * controller#action-to-call method. E.g.:
 * 
 * '/' => 'index#index',
 * '/calendar' => 'calendar#index'
 */
$routes = array(	
	'/login' => 'login#index',
	'/task' => 'task#index',
	'/createtask' => 'task#createTask',
	'/deletetask' => 'task#deleteTask',
	'/updatetask' => 'task#updateTask',
	'/showtask' => 'task#showTask'
);