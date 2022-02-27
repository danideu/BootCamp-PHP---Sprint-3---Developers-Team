<?php
//<link rel="stylesheet" href="http://localhost:8899/cursos/barcelonaactiva/sprint3/to-do/web/stylesheets/styles.css"> 
//http://localhost:8899/cursos/barcelonaactiva/sprint3/to-do/web/login
$uri = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// echo $uri; 
echo '<link rel="stylesheet" href="' . $uri . '">';
// echo $_SERVER['REQUEST_SCHEME'] . '://' . '<br>';
// echo $_SERVER['HTTP_HOST'] . '<br>';
// echo $_SERVER['REQUEST_URI'] . '<br>'; 
// var_dump($_SERVER); 
?> 
