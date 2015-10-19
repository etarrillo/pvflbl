<?php

require_once($CFG->libdir.'/formslib.php');

class new_inidate_form extends moodleform {

    function definition() {
    	global $DB;

      $cursos = $DB->get_records_sql_menu("SELECT id ,fullname
                                                FROM {course}",
                                                 array());

        $mform =& $this->_form;

        $mform->addElement('header', 'create', 'Crear Nuevo*');

        $mform->addElement('text', 'course','Curso');

        //$mform->addElement('select', 'name','Curso',$cursos);
        
        $mform->addElement('submit', 'find', 'Buscar*');

      }
}


class create_inidate_form extends moodleform {

    function definition() {
        global $DB;

        $customdata = $this->_customdata;

            $mform =& $this->_form;

            $course = $DB->get_record_sql("SELECT id , fullname 
                                           FROM {course} 
                                           WHERE id = ?",
                                           array($customdata['course']));


            $groups = $DB->get_records_sql_menu("SELECT id , name
                                                FROM {groups} 
                                                 WHERE courseid = ?",
                                                 array($course->id));

            $mform->addElement('header', 'filter', $course->fullname);
            $mform->addElement('hidden', 'idcourse', $customdata['course']);

            $mform->addElement('text', 'course',get_string('course'), array('readonly'=>'readonly'));
            $mform->setDefault('course', $course->fullname);

            $types = array();

            if(count($groups) > 0){

                $types['group'] = get_string('group');
		  $types['course'] = get_string('course');

                $mform->addElement('select', 'type','Tipo*',$types);

                $mform->addElement('select', 'group',get_string('group'),$groups);

                $mform->disabledIf('group', 'type', 'neq','group');

            }else{
		   $types['course'] = get_string('course');

                 $mform->addElement('select', 'type','Tipo*',$types);

            }

            $mform->addElement('date_selector', 'dateini','Inicio', array('startyear' => 2012, 
                                                                                    'stopyear'  => 2020,
                                                                                    'optional'  => false
                                                                                     ));


            $mform->addElement('date_selector', 'dateend','Fin', array('startyear' => 2012, 
                                                                                    'stopyear'  => 2020,
                                                                                    'optional'  => false
                                                                                     ));

            $textsubmit = 'Crear*';


            if(isset($customdata['data'])){

              $dbdata = array('courseid' => $customdata['data']->courseid, 'type' => $customdata['data']->type, 'groupid' => $customdata['data']->groupid, 'type_action' =>'ini');


              if($customdata['data']->type_action == 'ini'){

                $dbdata['type_action'] = 'end';

              }

              $getother=$DB->get_record('inidate',$dbdata,'id,date');


              $inivalue = $customdata['data']->date;

              $endvalue = $getother->date;

              if($customdata['data']->type_action == 'end'){


                $inivalue =  $getother->date;

                $endvalue = $customdata['data']->date;
                

              }

              
              

              $mform->addElement('hidden', 'id', $customdata['data']->id);  
              $mform->addElement('hidden', 'idend', $getother->id);  
              $mform->setDefault('type', $customdata['data']->type);
              $mform->setDefault('group', $customdata['data']->groupid);

              $mform->setDefault('dateini', $inivalue);
              $mform->setDefault('dateend', $endvalue);

               $textsubmit = 'Editar*';

            }


          $buttonarray=array();
          $buttonarray[] =& $mform->createElement('submit', 'send', $textsubmit);
          $buttonarray[] =& $mform->createElement('cancel');
          $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
          $mform->closeHeaderBefore('buttonar');
      }
}



class search_inidate_form extends moodleform {

    function definition() {
        global $DB;

        $mform =& $this->_form;

        $mform->addElement('header', 'filter', 'Filtro*');

        $mform->addElement('text', 'coursename', 'Nombre del Curso');
        
        $mform->addElement('submit', 'send', 'Enviar*');
      }
}


class delete_inidate_form extends moodleform {

    function definition() {
        global $CFG,$DB;

        $mform =& $this->_form;

        $customdata = $this->_customdata;

        $mform->addElement('hidden', 'id', $customdata['id']);
        
        $mform->addElement('submit', 'send', 'Confirmar*');

        $mform->addElement('html', '<input type="button"  onclick="location.href=\'index.php\'" value="Cancerlar">');

      }
}


class filter_inidate_form extends moodleform {

    function definition() {
        global $CFG,$DB;

        $mform =& $this->_form;
        
        $customdata = $this->_customdata;

        $i=0;

        foreach($customdata['filter'] as $filter){
          $mform->addElement('checkbox', 'filter'.$i, '',$filter);
          $i++;
        }

        if(count($customdata['filter'])){
          $mform->addElement('submit', 'delete', 'Eliminar Seleccionadas*');  
        }

        
        

      }
}


