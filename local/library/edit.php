<?php

include('../../config.php');
include('form.php');
include('model.php');
error_reporting(-1);

$i = required_param('i',PARAM_INT);

$PAGE->set_url('/local/library/edit.php');

require_login(); 

$url = new moodle_url('/local/library/edit.php',array('i'=>$i));

$context = context_system::instance();

$admin = is_siteadmin();

if(!$admin) redirect(new moodle_url('/'));

$name = get_string('createpoll','local_library');

$PAGE->set_context($context);

$PAGE->navbar->add($name);

$PAGE->set_title($name);

$PAGE->set_heading($name);

$model = new library_Model();
$edata='';
if(!empty($i)) $edata = $model->get_librarys($i);

$mform = new local_library_library($url,$edata);

if($data = $mform->get_data()){


	$record = array();

	$record['name'] = $data->name;
	$record['fullname'] = 'curso';
    $record['userid'] = $USER->id;
    $record['timecreate'] = time();
    $record['timemodified'] = time();
	if(empty($i)) $record['state'] = 0;
    
	//$record['htmlfront'] = $html;

	$ruta = $CFG->dirroot .'/local/library';

	if(empty($i)){

			$entryid = $DB->insert_record('library',$record,true);

	            $name =$mform->get_new_filename('file');
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $nombre =pathinfo($name, PATHINFO_FILENAME);
                      

			    $success = $mform->save_file('file', $ruta.'/files/'.$name.'.'.$ext, false);
                    
                    $za  = new  ZipArchive (); 
					$res = $za->open($ruta.'/files/'.$name.'.'.$ext);
					
                     if( $res === TRUE ){ 
						  $za->extractTo($ruta.'/files/'); 
						  $za->close(); 

						    unlink($ruta.'/files/'.$name.'.'.$ext);

                            $dir = $ruta.'/files/'.$nombre; 
					        $dir2= $ruta.'/files/'.$entryid;

                            rename ($dir, $dir2);
                       
						} 
                              


		}else{
			$record['id'] = $i;
            $DB->update_record('library',$record);

           
                $name =$mform->get_new_filename('file');
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $nombre =pathinfo($name, PATHINFO_FILENAME);
                      
                
			    $success = $mform->save_file('file', $ruta.'/files/'.$name.'.'.$ext, false);
                    
                    $za  = new  ZipArchive (); 
					$res = $za->open($ruta.'/files/'.$name.'.'.$ext);
					
                     if( $res === TRUE ){ 

						  $za->extractTo($ruta.'/files/'); 
						  $za->close(); 

						    unlink($ruta.'/files/'.$name.'.'.$ext);
                            unlink($ruta.'/files/'.$i);

                            $dir = $ruta.'/files/'.$nombre; 
					        $dir2= $ruta.'/files/'.$i;

                            rename ($dir, $dir2);
                        
						}


		}


              

	redirect(new moodle_url('/local/library/index.php'));
	
}elseif($mform->is_cancelled())  redirect(new moodle_url('/local/library/index.php'));


echo $OUTPUT->header();

	$mform->display();

echo $OUTPUT->footer();
