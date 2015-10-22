<?php

include('../../config.php');
include('form.php');
include('lib.php');
include('model.php');
//error_reporting(-1);

//$i = required_param('i',PARAM_INT);
$i = optional_param('i',0,PARAM_INT);

$url = new moodle_url('/local/library/permisos.php',array('i'=>$i));

$PAGE->set_url($url);

require_login(); 

$PAGE->set_pagelayout('local');

$data = new moodle_url('/local/library/descarga.php');

$context = get_context_instance(CONTEXT_SYSTEM);

$PAGE->requires->js('/local/library/js/ext/jquery-1.7.2.min.js');
$PAGE->requires->js('/local/library/js/test.js');
$PAGE->requires->js('/local/library/js/jquery-ui-1.10.4.custom.min.js');
$PAGE->requires->js('/local/library/js/library.js');
$PAGE->requires->css('/local/library/css/colorbox.css');
$PAGE->requires->css('/local/library/css/jquery-ui-1.10.4.custom.css');

$admin = has_capability('local/auto:control',$context) || is_siteadmin();

//if(!$admin) redirect(new moodle_url('/'));

$name = get_string('createqst','local_library');

$PAGE->set_context($context);

$PAGE->navbar->add($name);

$PAGE->set_title($name);

$PAGE->set_heading($name);

$model = new library_Model();


$admisselector =new local_library_newcat($url,array('id'=>$i)); 

$potentialadmisselector = new local_library_newqst($url,array('id'=>$i));

$lote = new  local_library_lote($url,array('id'=>$i));

$name_update = new  local_library_name($url,array('id'=>$i));



if($data = $potentialadmisselector->get_data()){

          $users=$model->get_users($data->funcion);

           $record = array();
            $record['rolid'] = $data->funcion;
            $record['libraryid'] = $i;
            $record['userid'] = $USER->id;
            $record['timecreate'] = time();
          

        $entryid = $DB->insert_record('local_library_rol',$record,true);

        foreach ($users as $user) {

             $recor = array();

                $recor['userid'] = $user->userid;
                $recor['libraryid'] = $entryid;
                $recor['timecreate'] = time();

             $entry = $DB->insert_record('local_library_permission',$recor,true);
        }
      redirect(new moodle_url('/local/library/permisos.php'.'?i='.$i));
}


if($data = $admisselector->get_data()){

      $model->delete_permission($i,$data->name);

      redirect(new moodle_url('/local/library/permisos.php'.'?i='.$i));

}



if($data = $lote->get_data()){

       $content = $lote->get_file_content('file');
       $cont = explode("\n",$content);
    
      foreach ($cont as $key) {

           $record = array();
           $record['rolid'] = trim($key);
           $record['libraryid'] = $i;
           $record['userid'] = $USER->id;
           $record['timecreate'] = time();
      
           if($record['rolid']!=NULL){

            $entryid = $DB->insert_record('local_library_rol',$record,true);
            $users=$model->get_users($record['rolid']);

                foreach ($users as $user) {

                     $recor = array();

                     $recor['userid'] = $user->userid;
                     $recor['libraryid'] = $entryid;
                     $recor['timecreate'] = time();

                     $entry = $DB->insert_record('local_library_permission',$recor,true);
                 }

          }

       }
        redirect(new moodle_url('/local/library/permisos.php'.'?i='.$i));
  }


if( $data = $name_update->get_data()){
   
      $DB->update_record('local_library',array('id'=>$i,'name'=>$data->name));

      redirect(new moodle_url('/local/library/permisos.php'.'?i='.$i));

}



echo $OUTPUT->header();



echo html_writer::start_tag('div', array('id' => 'tabs'));
      echo html_writer::start_tag('ul');
            echo html_writer::tag('li', html_writer::tag('a', 'Permisos por Función', array('href' => '#tabs-1')));
            echo html_writer::tag('li', html_writer::tag('a', 'Permisos por Lote', array('href' => '#tabs-2')));
            echo html_writer::tag('li', html_writer::tag('a', 'Editar Nombre Curso', array('href' => '#tabs-3')));
      echo html_writer::end_tag('ul');

      echo html_writer::start_tag('div', array('id' => 'tabs-1'));

            ?>
            <div id="addadmisform">
             <table class="" WIDTH="100%">
            <tr>
              <td>
                  
                  <?php $admisselector->display(); ?>
                  </td>
              <td id='buttonscell'>
                <p class="arrow_button">
                    <input name="add" id="add" type="button" value="<?php echo $OUTPUT->larrow().'&nbsp;' ?>" title="<?php print_string('add'); ?>" /><br />
                    <input name="remove" id="remove" type="submit" value="<?php echo '&nbsp;'.$OUTPUT->rarrow(); ?>" title="<?php print_string('remove'); ?>" />  
                </p>
              </td>
              <td>
                  
                  <?php $potentialadmisselector->display(); ?>
              </td>
            </tr>
            </table>
            </div>
           <?php
      echo html_writer::end_tag('div');

      echo html_writer::start_tag('div', array('id' => 'tabs-2'));

            echo html_writer::start_tag('td');
                  echo html_writer::tag('a','Descarga Funciones',array('href'=>new moodle_url('/local/library/descarga.php')));
            echo html_writer::end_tag('td');

             $lote->display();


       echo html_writer::end_tag('div');

       echo html_writer::start_tag('div', array('id' => 'tabs-3'));

             $name_update->display();

       echo html_writer::end_tag('div');


echo html_writer::end_tag('div');


echo $OUTPUT->footer();




