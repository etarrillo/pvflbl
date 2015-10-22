<?php

include('../../config.php');
include('form.php');
include('lib.php');
include('model.php');

$i = required_param('i',PARAM_INT);
$s = required_param('s',PARAM_INT);

$context = get_context_instance(CONTEXT_SYSTEM);


$admin = has_capability('local/auto:control',$context) || is_siteadmin();

if(!$admin) redirect(new moodle_url('/'));

$model = new library_Model();

$model->edit_poll($i,array('state'=>$s));

redirect(new moodle_url('/local/library/index.php'));