<?php

require('../../config.php'); // INCLUYE TODAS LAS FUNCIONALIDADES DE MOODLE
require('forms.php'); 

$PAGE->set_url('/report/inidate/index.php'); //Espeficica la url del reporte

require_login(); //Verifica si el usuario esta logueado

$PAGE->set_pagelayout('report');  //Configura la pagina segun el layour report

$PAGE->set_title('Fechas de Inicio*'); //Coloca el title a la pagina

$PAGE->set_heading('Fechas de Inicio*'); //Añade el header

$PAGE->navbar->add('reporte inidate'); //Añade el texto al breadcrumb

if(!isset($SESSION->filter_inidate)){
	$SESSION->filter_inidate = array();
}

if(!isset($SESSION->idcourse_inidate)){
	$SESSION->idcourse_inidate = SITEID;
}


$courses = $DB->get_records('course',array(),'id,fullname'); //Recupera los valores ID y FULLNAME  de la base de datos 

echo $OUTPUT->header();
echo $OUTPUT->heading('Fechas de Inicio**');  //Imprime el Titulo de pagina




$form_new = new new_inidate_form();
$form_search = new search_inidate_form();
$form_create = new create_inidate_form(null,array('course'=> $SESSION->idcourse_inidate));


if($data = $form_create->get_data()){

	$dbdata = array('courseid'=>$data->idcourse, 'type'=>$data->type, 'type_action' =>$data->type_action );

	$nameevent = 'Inicio de curso '.$courses[$data->idcourse]->fullname;

	if($data->type_action == 'end'){

		$nameevent = 'Fin de curso '.$courses[$data->idcourse]->fullname;

	}

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

		echo html_writer::tag('span','Se ha guardado con exito*',array());

		echo html_writer::tag('a','Regresar',array('href'=> new moodle_url('/report/inidate/index.php', array())));




	}else{

		$id_inidate = $DB->insert_record('inidate', $dbdata, true);

		$id_event = $DB->insert_record('event',$dbevent, true);

		$DB->insert_record('inidate_event', array('idinidate' => $id_inidate, 'idevent' => $id_event) , false);

		echo html_writer::tag('span','Se ha guardado con exito*',array());

		echo html_writer::tag('a','Regresar',array('href'=> new moodle_url('/report/inidate/index.php', array())));

	}



}else{

	if($data = $form_new->get_data()){

		unset($form_create);
		$SESSION->idcourse_inidate = $data->course;
		
		$form_create = new create_inidate_form(null,array('course' => $SESSION->idcourse_inidate));
		$form_create->display();

	}else{


		if($data = $form_search->get_data()){

			$SESSION->filter_inidate[] = $data->coursename;
		}

		$form_filter = new filter_inidate_form(null,array('filter' => $SESSION->filter_inidate));

		if($data = $form_filter->get_data()){

			foreach($data as $check => $data){

				$num = explode('filter',$check);

				if(isset($num[1])){

					array_splice($SESSION->filter_inidate,$num[1], 1);

				}

			}

		}

		$form_filter = new filter_inidate_form(null,array('filter' => $SESSION->filter_inidate));

		$form_new->display();

		$form_search->display();

		$form_filter->display();


		$sql_list = "SELECT idt.id,  idt.type , idt.type_action action , idt.groupid, idt.date, c.fullname , g.name groupname
					 FROM {inidate} idt
					 INNER JOIN {course} c 
					 ON c.id = idt.courseid
					 LEFT JOIN {groups} g 
					 ON g.id = idt.groupid
					 WHERE 1 ";

		$params = array();

		foreach($SESSION->filter_inidate as $filter){
			$sql_list .= " AND c.fullname  LIKE ? ";
			$params[] = '%'.$filter.'%';

		}

		$courses = $DB->get_records_sql($sql_list,$params);		

		echo html_writer::start_tag('table',array());

		echo html_writer::start_tag('tr',array());

		echo html_writer::tag('th', 'Nombre del Curso',array());

		echo html_writer::tag('th', 'Accion',array());

		echo html_writer::tag('th', 'Tipo',array());

		echo html_writer::tag('th', 'Nombre del Grupo',array());

		echo html_writer::tag('th', 'Fecha de Inicio',array());

		echo html_writer::tag('th', 'Acciones',array());

		echo html_writer::end_tag('tr');


		if(count($courses) > 0){

			foreach($courses as $course){

				echo html_writer::start_tag('tr',array());

				echo html_writer::tag('td', $course->fullname, array());

				echo html_writer::tag('td', ucfirst(($course->action == 'ini') ? 'inicio' : $course->action ) ,array());

				echo html_writer::tag('td', ucfirst($course->type) ,array());

				echo html_writer::tag('td', ($course->groupname != NULL) ? $course->groupname : ' - ' ,array());

				echo html_writer::tag('td', date('d-m-Y',$course->date) ,array());

				echo html_writer::start_tag('td', array());

					echo html_writer::tag('a', 'Editar', array('href'=>new moodle_url('/report/inidate/edit.php', array('id'=>$course->id))));

					echo html_writer::tag('a', 'Eliminar', array('href'=>new moodle_url('/report/inidate/delete.php', array('id'=>$course->id))));

				echo html_writer::end_tag('td');

				echo html_writer::end_tag('tr');
			}

		}else{

				echo html_writer::start_tag('tr',array());

				echo html_writer::tag('td', 'No hay registros*', array('colspan'=>'4'));

				echo html_writer::end_tag('tr');

		}

		echo html_writer::end_tag('table');
	}
}





echo $OUTPUT->footer(); //Imprime el Footer de pagina
?>