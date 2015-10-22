<?php

include('../../config.php');

defined('MOODLE_INTERNAL') || die;

require_login();

$url = new moodle_url('/report/courseall/view.php', array());

$PAGE->set_url($url);

require_capability('report/courseall:view', context_system::instance());
$PAGE->set_context(context_system::instance());
$PAGE->navbar->add('Programas');

echo $OUTPUT->header();

 $html = '';
$categorys  = $DB->get_records('course_categories',array('parent'=>2));



$html.='<div id="region-main">
		<div class="fluid-container">
			<div class="row-fluid">
				<div class="span12">
					<h2 class="fb-title fb-txt-green">Programas de aprendizaje</h2>
					<h3 class="fb-subtitle">¿Qué son?</h3>
					<p class="fb-parrafo fb-txt-gray">
						<span class="fb-icon fb-icon-parrafo">&nbsp;</span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique quisquam error iste pariatur nostrum ullam assumenda delectus incidunt neque, illo voluptatum eligendi vel, obcaecati saepe, ipsam totam enim tenetur voluptates?
					</p>
				</div>
			</div>
			<div class="fb-list-main-category">
			';

 foreach ($categorys as $key => $value) {
 	$ruta= new moodle_url('/course/index.php', array('categoryid'=>$value->id));
 	$html.='
				<div class="fb-category">
					<h4><span class="fb-icon fb-icon-title-category">&nbsp;</span>'.$value->name.'</h4>
					<p class="fb-parrafo"><span class="fb-icon fb-icon-parrafo">&nbsp;</span>'.$value->description.'</p>
					<a href="'.$ruta.'">Ver programa <span class="fb-icon fb-link-category"></span></a>
				</div>
			';
 }

    $html.='</div></div></div>';

 echo $html;



echo $OUTPUT->footer();
