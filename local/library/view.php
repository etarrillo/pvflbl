<?php

include('../../config.php');
include('model.php');

$PAGE->set_url('/local/library/index.php');

require_login();

$context = context_system::instance();

$admin = is_siteadmin();

$name = get_string('pluginname','local_library');

$PAGE->set_context($context);

$PAGE->navbar->add($name);

$PAGE->set_title($name);

$PAGE->set_heading($name);

$model = new library_Model();


    $PAGE->requires->css('/local/library/css/colorbox.css');
    $PAGE->requires->css('/local/library/css/library-styles.css');
    $PAGE->requires->css('/local/library/source/jquery.fancybox.css?v=2.1.5');

	$PAGE->requires->js('/local/library/lib/jquery-1.10.1.min.js');
	$PAGE->requires->js('/local/library/lib/jquery.mousewheel-3.0.6.pack.js');
	$PAGE->requires->js('/local/library/source/jquery.fancybox.js?v=2.1.5');
    $PAGE->requires->js('/local/library/js/test.js');

$category = $model->get_category();

echo $OUTPUT->header();

if($admin){
		$addlink = new moodle_url('/local/library/index.php',array('i'=>0));


		echo html_writer::start_tag('div', array('class'=>'header-library'));
			echo html_writer::tag('a',get_string('panel','local_library'),array('href'=>$addlink));
		echo html_writer::end_tag('div');
}

     $html = '';
     $html.='<div id="region-main" class="body-biblioteca">
		<div class="container-fluid">
		<div class="row-fluid">
		<div class="span10">
		<h2 class="fb-title-modules-biblioteca fb-txt-gray">
		<span class="fb-icon fb-icon-title-modules-biblioteca">&nbsp;</span>
						Biblioteca de cursos virtuales</h2>
		</div></div>
		<div class="row-fluid">
		<div class="span10">';

	foreach ($category as $key => $value) {

		$polls = $model->get_librarys($value->id);
		$html.='<div class="fb-table">
				<div style="border:1px solid #858585;" class="fb-table-header fb-txt-green">
				<span class="fb-ancho100">'.$value->name.'</span></div>';

				foreach ($polls as $pollid => $pollvalue) {
				$viewlink = new moodle_url('/local/library/files/'.$pollvalue->id.'/index.html');
		$html.='<div class="fb-table-body">
						<span class="fb-ancho100">
						<span class="fb-icon fb-icon-course">&nbsp;</span>
						<a href="'.$viewlink.'" class="fb-txt-gray fancybox fancybox.iframe">'.$pollvalue->name.'</a>
						</span></div>';
				}
	     
		$html.='</div>';





	}
        $html.='</div></div></div></div>';

echo $html;



echo $OUTPUT->footer();
