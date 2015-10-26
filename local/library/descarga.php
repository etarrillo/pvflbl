<?php

include('../../config.php');
include('lib.php');
include('model.php');




$model = new library_Model();

$funcion = $model->get_function();



header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=funcion.txt");
 
// do your Db stuff here to get the content into $content
$saltoLinea="\r\n";
 foreach ($funcion as $k ) {

   print $k->funcion.$saltoLinea;
 }


  
