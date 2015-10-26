<?php

require('../../config.php'); // INCLUYE TODAS LAS FUNCIONALIDADES DE MOODLE


$PAGE->set_url('/report/inidate/report.php'); //Espeficica la url del reporte

require_login(); //Verifica si el usuario esta logueado

$PAGE->set_pagelayout('report');  //Configura la pagina segun el layour report


$PAGE->set_title(get_string('pluginname','report_inidate')); //Coloca el title a la pagina

$PAGE->set_heading(get_string('pluginname','report_inidate')); //Añade el header

$PAGE->navbar->add('reporte inidate'); //Añade el texto al breadcrumb



echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('pluginname','report_inidate'));  //Imprime el Titulo de pagina


$sql = "SELECT c.id, c.fullname, ini.date, ini.type, g.name
		FROM {inidate} ini
		INNER JOIN {course} c 
		ON ini.courseid = c.id
		LEFT JOIN {groups} g 
		ON  ini.groupid = g.id
		ORDER BY ini.id ASC, ini.type ASC, ini.type_action DESC";

$all = $DB->get_records_sql($sql,array());


echo html_writer::start_tag('table');


	echo html_writer::start_tag('tr');

		echo html_writer::tag('th','Tipo');
		echo html_writer::tag('th','Nombre de Curso');
		echo html_writer::tag('th','Nombre del Grupo');
		echo html_writer::tag('th','Fecha de inicio');
		echo html_writer::tag('th','Fecha de fin');

	echo html_writer::end_tag('tr');

$i = 0;

$type = array('course'=>'Curso', 'group'=>'Grupo');

foreach($all as $date){

	if($i == 0){

		echo html_writer::start_tag('tr');
		echo html_writer::tag('td',$type[$date->type]);
		echo html_writer::tag('td',$date->fullname);
		echo html_writer::tag('td',$date->name);
		echo html_writer::tag('td',date("d-m-Y",$date->date));

		$i = 1;

	}else{

		echo html_writer::tag('td',date("d-m-Y",$date->date));
		echo html_writer::end_tag('tr');
		$i = 0;

	}



}


echo html_writer::end_tag('table');

echo $OUTPUT->footer(); //Imprime el Footer de pagina

