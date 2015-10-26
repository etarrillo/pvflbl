<?php

include('../../config.php');
include('model.php');

$idCurso = $_POST['idCurso'];

$model = new library_Model();
$ruta = '/var/www/html/bcp/local/library';
$model->del_poll($idCurso); 
unlink($ruta.'/files/'.$idCurso); 

echo new moodle_url('/local/library/index.php');

