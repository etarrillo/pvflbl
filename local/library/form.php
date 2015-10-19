<?php

require_once($CFG->libdir.'/formslib.php');

class local_library_library extends moodleform {

    function definition() {
        global $DB;

        $mform =& $this->_form;
        $categorys  = $DB->get_records_menu('library_category',array());
        $mform->addElement('header', 'new', get_string('new','local_library'));
        $mform->addElement('select','category',get_string('category'),$categorys, array());
        $mform->addElement('text','name', get_string('name','local_library'));
        $mform->addElement('filepicker', 'file', 'Paquete*', null,array('maxbytes' => 6000700, 'accepted_types' => '*'));


        $mform->setType('name',PARAM_TEXT);
        $mform->setType('id',PARAM_INT);


        $mform->addRule('name',get_string('required'),'required','','cliente',false,false);
        $mform->addRule('category',get_string('required'),'required','','cliente',false,false);
        $mform->addRule('file',get_string('required'),'required','','cliente',false,false);


        if(isset($this->_customdata['id'])){

            $mform->setDefault('name',$this->_customdata['name']);
            $mform->setDefault('category',$this->_customdata['category']);
            //$mform->setDefault('file',$this->_customdata['inidate']);
           
        }

        $buttonarray=array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('savechanges'));
        $buttonarray[] = &$mform->createElement('cancel');
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
        $mform->closeHeaderBefore('buttonar');

       
         
    }
}

class local_library_newcat extends moodleform {

    function definition() {
        global $DB;

        $mform =& $this->_form;
        $customdata = $this->_customdata;
        

        if(isset($customdata['id'])){

             $mform->addElement('hidden', 'id',$customdata['id']);

             $query = "SELECT rolid AS funcion FROM {local_library_rol} 
                       WHERE libraryid=?
                       ";

            $funciones=$DB->get_records_sql($query,array($customdata['id']));

           foreach($funciones as $funcion){
             $result[$funcion->funcion]=$funcion->funcion;

           }


        }
        $mform->addElement('header', 'asignado', 'Asignados');
        $mform->addElement('select','name',NULL,$result,array('size'=>'20','ALIGN'=>'left'));



        
     $buttonarray=array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbuttonRemove', 'Quitar');
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
        $mform->closeHeaderBefore('buttonar');
    }
}


class local_library_newqst extends moodleform {

    function definition() {
        global $DB;

        $mform =& $this->_form;

      $query = "SELECT d1.data AS funcion FROM {user_info_data} d1
                INNER JOIN {user_info_data} d2 
                ON d2.userid = d1.userid 
                WHERE d2.fieldid=3
                AND d1.fieldid=2
                AND d2.data='DIVISION COMERCIAL'
                ORDER BY d1.data

               ";

        $funciones=$DB->get_records_sql($query,array());

        foreach($funciones as $funcion){
             $result[$funcion->funcion]=$funcion->funcion;

        }

        $mform->addElement('header', 'fun', 'Funciones');
        $mform->addElement('select','funcion',NULL,$result,array('size'=>'20','ALIGN'=>'left'));
        
        $buttonarray=array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbuttonAdd', 'Agregar');
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
        $mform->closeHeaderBefore('buttonar');
   
}
}


class local_library_lote extends moodleform {

    function definition() {
        global $DB;

        $mform =& $this->_form;
       $mform->addElement('header', 'lote', 'Cargar');
       $mform->addElement('file', 'file', get_string('file'));
       $mform->addElement('submit', 'submit', get_string('submit'));

   
}
}


class local_library_name extends moodleform {

    function definition() {
        global $DB;

        $mform =& $this->_form;
        $data = $this->_customdata;
      
        $mform->addElement('header', 'new', 'Cambiar Nombre Curso');
        $mform->addElement('hidden','id',$data['id']);
        $mform->addElement('text','name', get_string('name','local_library'), array('size'=>'100'));

       if(!empty($data['id'])){
            $data = $DB->get_record('local_library',array('id'=>$data['id']), 'name');
            $mform->setDefault('name',$data->name);
         
        }

        $mform->addElement('submit', 'submit', 'Cambiar');

   
}
}

class local_library_category extends moodleform {

    function definition() {
        global $DB;

        $mform =& $this->_form;
        $data = $this->_customdata;

        $mform->addElement('hidden','id',$data['id']);
        $mform->addElement('text','name',get_string('name','local_library'));

        $mform->setType('name',PARAM_TEXT);
        $mform->setType('id',PARAM_INT);


        $mform->addRule('name',get_string('required'),'required','','cliente',false,false);

        if(!empty($data['id'])){
            $data = $DB->get_record('library_category',array('id'=>$data['id']), 'id,name');
            $mform->setDefault('name',$data->name);
        }

        $this->add_action_buttons();

    }
}