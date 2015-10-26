<?php

require('../../config.php'); // INCLUYE TODAS LAS FUNCIONALIDADES DE MOODLE
require('forms.php'); 

$id = optional_param('id', 0, PARAM_INT); 

$PAGE->set_url('/report/inidate/delete.php',array('id' => $id)); //Espeficica la url del reporte

require_login(); //Verifica si el usuario esta logueado

$PAGE->set_pagelayout('report');  //Configura la pagina segun el layour report

$PAGE->set_title('Fechas de Inicio*'); //Coloca el title a la pagina

$PAGE->set_heading('Fechas de Inicio*'); //Añade el header

$PAGE->navbar->add('reporte inidate'); //Añade el texto al breadcrumb


$mform = new delete_inidate_form( null, array('id' => $id) );


echo $OUTPUT->header();
echo $OUTPUT->heading('Fechas de Inicio**');  //Imprime el Titulo de pagina


if($data = $mform->get_data()){

	$getdata = $DB->get_record('inidate', array('id' =>  $data->id));

	$DB->delete_records('inidate', array('id' => $data->id));

	$getidevent = $DB->get_record('inidate_event', array('idinidate' =>  $data->id), 'idevent');

	$DB->delete_records('inidate_event', array('idinidate' => $data->id));

	$DB->delete_records('event', array('id' => $getidevent->idevent));


	$dbdata = array('courseid' => $getdata->courseid, 'type' => $getdata->type, 'groupid' => $getdata->groupid, 'type_action' =>'ini');


	if($getdata->type_action == 'ini'){

		$dbdata['type_action'] = 'end';

	}



	$idexist=$DB->get_record('inidate',$dbdata,'id');

	if($idexist){

		$DB->delete_records('inidate', array('id' => $idexist->id));

		$getidevent = $DB->get_record('inidate_event', array('idinidate' =>  $idexist->id), 'idevent');

		$DB->delete_records('event', array('id' => $getidevent->idevent));

	}


	echo html_writer::tag('a', 'Regresar', array('href'=>new moodle_url('/report/inidate/course.php',array('id' => $getdata->courseid))));


}else{

	$mform->display() ;
}



echo $OUTPUT->footer(); //Imprime el Footer de pagina
?>