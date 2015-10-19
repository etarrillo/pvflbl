<?php

require('../../config.php'); // INCLUYE TODAS LAS FUNCIONALIDADES DE MOODLE
require('forms.php'); 

$id = required_param('id', PARAM_INT); 

$PAGE->set_url('/report/inidate/create.php',array('id' => $id)); //Espeficica la url del reporte

require_login(); //Verifica si el usuario esta logueado

$PAGE->set_pagelayout('report');  //Configura la pagina segun el layour report

$PAGE->set_title(get_string('pluginname','report_inidate')); //Coloca el title a la pagina

$PAGE->set_heading(get_string('pluginname','report_inidate')); //Añade el header

$PAGE->navbar->add(get_string('pluginname','report_inidate')); //Añade el texto al breadcrumb

$formurl = new moodle_url('/report/inidate/create.php', array('id'=>$id));

$mform = new create_inidate_form( $formurl , array('course' => $id) );

$course = $DB->get_record('course',array('id' => $id), 'id,fullname');

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname','report_inidate'));  //Imprime el Titulo de pagina


if($data = $mform->get_data()){

	$dbdata = array('courseid'=>$data->idcourse, 'type'=>$data->type, 'type_action' =>'ini' );

	$nameevent = 'Inicio de curso '.$course->fullname;

	$dbevent = array('name'=>$nameevent,'description' => '', 'format'=>'1', 'courseid' =>$data->idcourse, 'groupid' => '0' , 'userid' => $USER->id,
	'repeatid' => '0', 'instance' => '0', 'eventtype' =>$data->type, 'timestart' => $data->dateini, 'timeduration' => '0', 'visible' => '1',
	'uuid' => '', 'sequence' => '1', 'timemodified'=> strtotime(date('d-m-Y h:i:s')));

	if(isset($data->group)){
		$dbdata['groupid'] = $data->group;
		$dbevent['groupid'] = $data->group;
	}

	//var_dump($data);


	$idexist=$DB->get_record('inidate',$dbdata,'id');

	$dbdata['date'] = $data->dateini;

	if($idexist){

		$dbdata['id'] = $idexist->id;

		$DB->update_record('inidate', $dbdata, false);

		$getidevent = $DB->get_record('inidate_event', array('idinidate' => $idexist->id), 'idevent');

		$dbevent['id'] = $getidevent->idevent;

		$DB->update_record('event', $dbevent, false);

	}else{

		$id_inidate = $DB->insert_record('inidate', $dbdata, true);

		$id_event = $DB->insert_record('event',$dbevent, true);

		$DB->insert_record('inidate_event', array('idinidate' => $id_inidate, 'idevent' => $id_event) , false);

	}


	unset($dbdata['date']);
	unset($dbdata['type_action']);
	unset($dbdata['id']);

	$dbdata['type_action'] = 'end';


	$idexist=$DB->get_record('inidate',$dbdata,'id');

	$dbdata['date'] = $data->dateend;

	$dbevent['name'] = 'Fin de curso '.$course->fullname;

	$dbevent['timestart'] = $data->dateend;



	if($idexist){

		$dbdata['id'] = $idexist->id;

		$DB->update_record('inidate', $dbdata, false);

		$getidevent = $DB->get_record('inidate_event', array('idinidate' => $idexist->id), 'idevent');

		$dbevent['id'] = $getidevent->idevent;

		$DB->update_record('event', $dbevent, false);

	}else{

		$id_inidate = $DB->insert_record('inidate', $dbdata, true);

		$id_event = $DB->insert_record('event',$dbevent, true);

		$DB->insert_record('inidate_event', array('idinidate' => $id_inidate, 'idevent' => $id_event) , false);

	}

	echo html_writer::tag('span','Se ha guardado con exito*',array());

	echo html_writer::tag('a','Regresar',array('href'=> new moodle_url('/report/inidate/course.php', array('id' =>$id ))));



}else{

	$mform->display() ;
}



echo $OUTPUT->footer(); //Imprime el Footer de pagina
?>