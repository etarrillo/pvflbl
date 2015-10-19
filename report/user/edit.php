<?php

require('../../config.php');

defined('MOODLE_INTERNAL') || die;

require_once("$CFG->libdir/gdlib.php");
include('user_form.php');


$course = $DB->get_record('course', array('id'=>''.SITEID));

require_login($course);

$url = new moodle_url('/report/user/edit.php', array());

$PAGE->set_url($url);
$PAGE->set_pagelayout('report');



require_capability('report/user:view', get_context_instance(CONTEXT_SYSTEM));


$PAGE->set_title(get_string('edit'));
$PAGE->set_heading(get_string('edit'));


echo $OUTPUT->header();

$mform = new user_edit_form();

if($user=$mform->get_data()){



    if($user->pass1!=''){
        $user->password=md5($user->pass1);
    }

    $DB->update_record('user', $user);

    foreach ((array)$user as $variable => $value) {
            $USER->$variable = $value;
    }


    $filename = $_FILES['picture']['name'];

    if($filename!=""){

        $usercontext = get_context_instance(CONTEXT_USER, $USER->id);

        do{
            $itemid=rand(0, 9999999999);

        }while($DB->record_exists('files',array('itemid'=>$itemid)));

        $fs = get_file_storage();

    

        $file_record = array('contextid'=>$usercontext->id, 'component'=>'user', 'filearea'=>'draft', 'itemid'=>$itemid,
                             'filepath'=>'/', 'filename'=>$filename, 'userid'=>$USER->id);

        $file=$fs->create_file_from_pathname($file_record, $_FILES['picture']['tmp_name']);


        $fs->delete_area_files($usercontext->id, 'user', 'icon');

        file_save_draft_area_files($itemid, $usercontext->id, 'user', 'newicon', 0, array());

        if (($iconfiles = $fs->get_area_files($usercontext->id, 'user', 'newicon')) && count($iconfiles) == 2) {
            // Get file which was uploaded in draft area
            foreach ($iconfiles as $file) {
                if (!$file->is_directory()) {
                    break;
                }
            }
            // Copy file to temporary location and the send it for processing icon
            if ($iconfile = $file->copy_content_to_temp()) {
                // There is a new image that has been uploaded
                // Process the new image and set the user to make use of it.
                // NOTE: Uploaded images always take over Gravatar
                $newpicture = (int)process_new_icon($usercontext, 'user', 'icon', 0, $iconfile);
                // Delete temporary file
                @unlink($iconfile);
                // Remove uploaded file.
                $fs->delete_area_files($usercontext->id, 'user', 'newicon');
            } 
        }

        $DB->set_field('user', 'picture', $newpicture, array('id' => $USER->id));

        $USER->picture = $newpicture;

    }

    if(get_user_preferences('bcp_data')){
        $DB->delete_records('user_preferences',array('userid'=>$USER->id,'name'=>'bcp_data'));
    }   

    if(get_user_preferences('auth_forcepasswordchange')){
        $DB->delete_records('user_preferences',array('userid'=>$USER->id,'name'=>'auth_forcepasswordchange'));
    }  

    echo html_writer::tag('p',get_string('savedata','report_user'));

	$returnurl = new moodle_url('/', array());

	echo $OUTPUT->single_button($returnurl,get_string('continue'));

}else{
	echo html_writer::tag('h3',$USER->firstname.' '.$USER->lastname, array('class'=>'title-username'));
	echo html_writer::tag('p','Bienvenido al Campus BCP, es necesario que completes tus datos para ayudarte en cualquier consulta que tengas',array('id'=>'message-user-edit'));
	$mform->display();
}



echo $OUTPUT->footer();


