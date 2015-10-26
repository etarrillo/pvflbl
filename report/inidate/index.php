<?php

require('../../config.php'); // INCLUYE TODAS LAS FUNCIONALIDADES DE MOODLE
require('forms.php'); 


$PAGE->set_url('/report/inidate/index.php'); //Espeficica la url del reporte

require_login(); //Verifica si el usuario esta logueado

$PAGE->set_pagelayout('report');  //Configura la pagina segun el layour report


$PAGE->set_title(get_string('pluginname','report_inidate')); //Coloca el title a la pagina

$PAGE->set_heading(get_string('pluginname','report_inidate')); //Añade el header

$PAGE->navbar->add('reporte inidate'); //Añade el texto al breadcrumb


$form_new = new new_inidate_form();

if($data = $form_new->get_data()){

	$url = new moodle_url('/report/inidate/course.php', array('id'=>$data->course));

	header('location:'. $url);

}else{

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('pluginname','report_inidate'));  //Imprime el Titulo de pagina

		$form_new->display();	

echo $OUTPUT->footer(); //Imprime el Footer de pagina
}

