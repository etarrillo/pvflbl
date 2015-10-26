<?php

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/lib/formslib.php');

class user_edit_form extends moodleform {

    // Define the form
    function definition() {
        global $USER, $CFG, $COURSE;

        $mform =& $this->_form;

        $mform->addElement('hidden', 'id',$USER->id);

        $mform->addElement('header', 'Editar', 'Editar Perfil');
        $mform->addElement('text', 'username', get_string('username'),array('readonly'=>'readonly'));
        $mform->setDefault('username', $USER->username);
        $mform->addRule('username', get_string('required'), 'required', '', 'client', false, false);


        $mform->addElement('text', 'firstname', get_string('firstname'),array('readonly'=>'readonly'));
        $mform->setDefault('firstname', $USER->firstname);
        $mform->addRule('firstname', get_string('required'), 'required', '', 'client', false, false);


        $mform->addElement('text', 'lastname', get_string('lastname'),array('readonly'=>'readonly'));
        $mform->setDefault('lastname', $USER->lastname);
        $mform->addRule('lastname', get_string('required'), 'required', '', 'client', false, false);



        $mform->addElement('password', 'pass1', get_string('newpassword'));
        $mform->addElement('password', 'pass2', get_string('newpassword').' ('.get_String('again').')');


        if(get_user_preferences('auth_forcepasswordchange')){
            $mform->addRule('pass1', get_string('required'), 'required', '', 'client', false, false);
            $mform->addRule('pass2', get_string('required'), 'required', '', 'client', false, false);
        }

        $mform->addElement('text', 'email', 'Correo Banco');
        $mform->setDefault('email', $USER->email);
        $mform->addRule('email', get_string('required'), 'required', '', 'client', false, false);
        $mform->addRule('email', get_string('invalidemail'), 'email', '', 'client', false, false);

        $mform->addElement('text', 'msn', get_string('msnid'));
        $mform->setDefault('msn', $USER->msn);
        $mform->addRule('msn', get_string('required'), 'required', '', 'client', false, false);
        $mform->addRule('msn', get_string('invalidemail'), 'email', '', 'client', false, false);


        $mform->addElement('date_selector', 'icq', get_string('icqnumber'),array('startyear' => 1920,'stopyear'  => 2020,'timezone'  => 99, 'step'      => 5));
        $mform->setDefault('icq', $USER->icq);
        $mform->addRule('icq', get_string('required'), 'required', '', 'client', false, false);


        $mform->addElement('text', 'phone1', get_string('phone'));
        $mform->setDefault('phone1', $USER->phone1);
        $mform->addRule('phone1', get_string('required'), 'required', '', 'client', false, false);
        $mform->addRule('phone1', get_string('isnumber','report_user'), 'numeric', '', 'client', false, false);

        $mform->addElement('text', 'yahoo', get_string('yahooid'));
        $mform->setDefault('yahoo', $USER->yahoo);
       // $mform->addRule('yahoo', get_string('required'), 'required', '', 'client', false, false);
        $mform->addRule('yahoo', get_string('isnumber','report_user'), 'numeric', '', 'client', false, false);


        $mform->addElement('text', 'phone2', get_string('phone2'));
        $mform->setDefault('phone2', $USER->phone2);
        //$mform->addRule('phone2', get_string('required'), 'required', '', 'client', false, false);
        $mform->addRule('phone2', get_string('isnumber','report_user'), 'numeric', '', 'client', false, false);


	 $mform->addElement('html', '<div><span class="msg-picture">Recuerda que esta imagen ser&aacute; vista por tus compa&ntilde;eros.</span></div>');

        $mform->addElement('file', 'picture', get_string('userpic'));


        $mform->addElement('submit', 'save', get_string('savechanges'));
        $mform->addElement('html', '<div style="color:#A00" align="right">En caso no cuente con correo BCP ingrese un correo personal**</div>');
    }

    function validation($data, $files) {
        global $USER;
        $errors = parent::validation($data, $files);

        if ($data['pass1'] <> $data['pass2']) {
            $errors['pass1'] = get_string('passwordsdiffer');
            $errors['pass2'] = get_string('passwordsdiffer');
            return $errors;
        }
        return $errors;
    }

}


