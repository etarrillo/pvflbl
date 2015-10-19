<?php


defined('MOODLE_INTERNAL') || die;


//Define permisos

$capabilities = array(

	'report/inidate:view' => array(
        'riskbitmask' => RISK_PERSONAL,
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
		),
	)

);


?>