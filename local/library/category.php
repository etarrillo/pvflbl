<?php

include('../../config.php');
include('model.php');

$url = new moodle_url('/local/library/category.php');
$PAGE->set_url($url);
require_login();

$context = context_system::instance();

$admin = is_siteadmin();

$name = get_string('pluginname','local_library');

$PAGE->set_context($context);

$PAGE->navbar->add($name);

$PAGE->set_title($name);

$PAGE->set_heading($name);

$model = new library_Model();

$categorys = $model->get_all_category();


echo $OUTPUT->header();


$newlink = new moodle_url('/local/library/editcat.php',array('id'=>0));
$newslink = new moodle_url('/local/library/index.php');

echo html_writer::start_tag('div');
	echo html_writer::tag('a','Agregar Categoria',array('href'=>$newlink, 'style'=>'margin-bottom:10px;display:inline-block;', 'class'=>'fb-btn'));

echo html_writer::end_tag('div');


echo html_writer::start_tag('div');
	echo html_writer::tag('a','Biblioteca',array('href'=>$newslink, 'style'=>'margin-bottom:10px;display:inline-block;', 'class'=>'fb-btn'));
echo html_writer::end_tag('div');

echo html_writer::start_tag('table',array('class'=>'table table-striped"', 'align'=>'center'));
	echo html_writer::start_tag('thead');
		echo html_writer::start_tag('tr');
			echo html_writer::tag('td','Nombre');
			echo html_writer::tag('td','Opciones');
		echo html_writer::end_tag('tr');
	echo html_writer::end_tag('thead');


	foreach($categorys as $c){	
		$edituri = new moodle_url('/local/library/editcat.php',array('id'=>$c->id));
		$deleteuri = new moodle_url('/local/library/deletecat.php',array('id'=>$c->id));
		echo html_writer::start_tag('tr');
			echo html_writer::tag('td',$c->name);	
			echo html_writer::start_tag('td');
				echo html_writer::tag('a',get_string('edit'),array('href'=>$edituri, 'style'=>'margin-bottom:10px;display:inline-block;', 'class'=>'fb-btn'));
				echo html_writer::tag('a',get_string('delete'),array('href'=>$deleteuri, 'style'=>'margin-bottom:10px;display:inline-block;', 'class'=>'fb-btn'));
			echo html_writer::end_tag('td');
		echo html_writer::end_tag('tr');
	}

	if(count($categorys) == 0){
		echo html_writer::start_tag('tr');
			echo html_writer::tag('td','No existen categorias registradas',array('colspan'=>2));
		echo html_writer::end_tag('tr');		

	}

echo html_writer::end_tag('table');
