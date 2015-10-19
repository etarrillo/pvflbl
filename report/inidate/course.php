<?php

require('../../config.php'); // INCLUYE TODAS LAS FUNCIONALIDADES DE MOODLE
require('forms.php'); 

$id = required_param('id', PARAM_INT); 

$PAGE->set_url('/report/inidate/course.php', array('id' => $id)); //Espeficica la url del reporte

require_login(); //Verifica si el usuario esta logueado

$PAGE->set_pagelayout('report');  //Configura la pagina segun el layour report

$PAGE->set_title(get_string('pluginname','report_inidate')); //Coloca el title a la pagina

$PAGE->set_heading(get_string('pluginname','report_inidate')); //Añade el header

$PAGE->navbar->add('reporte inidate'); //Añade el texto al breadcrumb


$sql_course = "SELECT c.id, c.fullname, ct.name category, ct.id categoryid, ct.parent categoryparent
					FROM {course} c 
					LEFT JOIN {course_categories} ct 
					ON c.category = ct.id
					WHERE c.id=? ";

$course = $DB->get_record_sql($sql_course,array('id' => $id));

echo $OUTPUT->header();
echo $OUTPUT->heading($course->fullname .' - '. $listcategory);  //Imprime el Titulo de pagina

if($course){

$listcategory = $course->category;

if($course->categoryid != 0 && $course->categoryparent != 0){

	$categoryparent = $DB->get_record('course_categories', array('id' => $course->categoryparent), 'name');

	$listcategory .= " - ". $categoryparent->name;

}




	echo html_writer::tag('a', 'Crear Nuevo', array('href'=>new moodle_url('/report/inidate/create.php', array('id'=>$course->id))));

	echo html_writer::tag('a','Nueva Busqueda',array('href'=> new moodle_url('/report/inidate/index.php' )));


		$sql_list = "SELECT idt.id,  idt.type , idt.groupid, idt.date, c.fullname , g.name groupname
					 FROM {inidate} idt
					 INNER JOIN {course} c 
					 ON c.id = idt.courseid
					 LEFT JOIN {groups} g 
					 ON g.id = idt.groupid
					 WHERE c.id = ? 
					 AND  idt.type_action = ?";

		$params = array($course->id, 'ini');

		$events = $DB->get_records_sql($sql_list,$params);		

		echo html_writer::start_tag('table',array());

		echo html_writer::start_tag('tr',array());

		echo html_writer::tag('th', 'Nombre del Curso',array());

		echo html_writer::tag('th', 'Tipo',array());

		echo html_writer::tag('th', 'Nombre del Grupo',array());

		echo html_writer::tag('th', 'Fecha de Inicio',array());

		echo html_writer::tag('th', 'Fecha de Fin',array());

		echo html_writer::tag('th', 'Acciones',array());

		echo html_writer::end_tag('tr');


		if(count($events) > 0){

			foreach($events as $event){


			$dbdata = array('courseid' => $course->id, 'type' => $event->type, 'groupid' => $event->groupid, 'type_action' =>'end');

            $getother = $DB->get_record('inidate',$dbdata,'date');	

				echo html_writer::start_tag('tr',array());

				echo html_writer::tag('td', $event->fullname, array());

				echo html_writer::tag('td', ucfirst($event->type) ,array());

				echo html_writer::tag('td', ($event->groupname != NULL) ? $event->groupname : ' - ' ,array());

				echo html_writer::tag('td', date('d-m-Y',$event->date) ,array());

				echo html_writer::tag('td', date('d-m-Y',$getother->date) ,array());

				echo html_writer::start_tag('td', array());

					echo html_writer::tag('a', 'Editar', array('href'=>new moodle_url('/report/inidate/edit.php', array('id'=>$event->id))));

					echo html_writer::tag('a', 'Eliminar', array('href'=>new moodle_url('/report/inidate/delete.php', array('id'=>$event->id))));

				echo html_writer::end_tag('td');

				echo html_writer::end_tag('tr');
			}

		}else{

				echo html_writer::start_tag('tr',array());

				echo html_writer::tag('td', 'No hay registros*', array('colspan'=>'4'));

				echo html_writer::end_tag('tr');

		}

		echo html_writer::end_tag('table');



}else{ 

		echo html_writer::start_tag('div',array());
			echo html_writer::tag('span','No existe ningun curso son ese id');
		echo html_writer::end_tag('div');

		echo html_writer::tag('a','Continuar', array('href' => new  moodle_url('/report/inidate/index.php')));

}


echo $OUTPUT->footer(); //Imprime el Footer de pagina