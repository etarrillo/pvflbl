<?php

include('../../config.php');
include('form.php');
include('model.php');

$id = required_param('id',PARAM_INT);

$url = new moodle_url('/local/library/editcat.php',array('id'=>$id));
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

$mform = new local_library_category($url,array('id'=>$id));

$PAGE->set_context($context);

$PAGE->navbar->add($name);

$PAGE->set_title($name);

$PAGE->set_heading($name);


if($mform->is_cancelled()){
	redirect(new moodle_url('/local/news/index.php'));
}elseif($data = $mform->get_data()){

	$record = new stdClass();

	if(!empty($data->id)){
		$record->id = $data->id;
		$type = 'update_record';
	}else{
		$record->id = null;
		$type = 'insert_record';
	}

	$record->name = $data->name;

	$record->timecreated = time();

	$id = $DB->$type('library_category',$record,true);

	redirect(new moodle_url('/local/library/category.php'));
}
    
echo $OUTPUT->header();

	$mform->display();

echo $OUTPUT->footer();	