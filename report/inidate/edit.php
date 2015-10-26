<?php

require('../../config.php'); // INCLUYE TODAS LAS FUNCIONALIDADES DE MOODLE
require('forms.php'); 

$id = optional_param('id', 0, PARAM_INT); 

$PAGE->set_url('/report/inidate/edit.php',array('id' => $id)); //Espeficica la url del reporte

require_login(); //Verifica si el usuario esta logueado

$PAGE->set_pagelayout('report');  //Configura la pagina segun el layour report

$PAGE->set_title('Fechas de Inicio*'); //Coloca el title a la pagina

$PAGE->set_heading('Fechas de Inicio*'); //Añade el header

$PAGE->navbar->add('reporte inidate'); //Añade el texto al breadcrumb

$datos = $DB->get_record('inidate',array('id'=>$id));



$mform = new create_inidate_form( null, array('course' => $datos->courseid, 'data'=> $datos ));




echo $OUTPUT->header();
echo $OUTPUT->heading('Fechas de Inicio**');  //Imprime el Titulo de pagina


if($data = $mform->get_data()){


	$datarecord = array('id' =>$data->id, 'courseid' => $data->idcourse, 'type_action' => 'ini', 'type' => $data->type, 'date' => $data->dateini);

	$coursedata = $DB->get_record('course', array('id' => $data->idcourse), 'fullname');


	$nameevent = 'Inicio de curso '.$coursedata->fullname;

	$dbevent = array('name'=>$nameevent,'description' => '', 'format'=>'1', 'courseid' =>$data->idcourse, 'groupid' => '0' , 'userid' => $USER->id,
	'repeatid' => '0', 'instance' => '0', 'eventtype' =>$data->type, 'timestart' => $data->dateini, 'timeduration' => '0', 'visible' => '1',
	'uuid' => '', 'sequence' => '1', 'timemodified'=> strtotime(date('d-m-Y h:i:s')));

	$datarecord['group'] = null;

	if(isset($data->group)){

		$datarecord['group'] = $data->group;
		$dbevent['groupid'] = $data->group;
	}
	


	$DB->update_record('inidate', $datarecord);

	$getidevent = $DB->get_record('inidate_event', array('idinidate' => $datarecord['id']), 'idevent');
	$dbevent['id'] = $getidevent->idevent;

	$DB->update_record('event', $dbevent, false);

	unset($datarecord['date']);
	unset($datarecord['type_action']);
	unset($datarecord['id']);

	$datarecord['id'] = $data->idend;

	$datarecord['type_action'] = 'end';

	$datarecord['date'] = $data->dateend;

	$dbevent['name'] = 'Fin de curso '.$coursedata->fullname;

	$dbevent['timestart'] = $data->dateend;


	$DB->update_record('inidate', $datarecord);

	$getidevent = $DB->get_record('inidate_event', array('idinidate' => $datarecord['id']), 'idevent');
	$dbevent['id'] = $getidevent->idevent;
	$DB->update_record('event', $dbevent, false);

	echo html_writer::tag('a', 'Regresar', array('href'=>new moodle_url('/report/inidate/course.php', array('id' => $datarecord['courseid']))));

}else{

	$mform->display();

}



echo $OUTPUT->footer(); //Imprime el Footer de pagina
?>