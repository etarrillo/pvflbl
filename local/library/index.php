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

$category = $model->get_category();

//$roles = $model->get_roles($USER->id);

/*$PAGE->requires->css('/local/library/css/ventanas-modales.css');
$PAGE->requires->css('/local/library/css/library-styles.css');

$PAGE->requires->js('/local/library/js/ext/jquery-1.7.2.min.js');
$PAGE->requires->js('/local/library/js/test.js');
$PAGE->requires->js('/local/library/js/ventanas-modales.js');*/

    $PAGE->requires->css('/local/library/css/colorbox.css');
    $PAGE->requires->css('/local/library/css/library-styles.css');
    $PAGE->requires->css('/local/library/source/jquery.fancybox.css?v=2.1.5');

	$PAGE->requires->js('/local/library/lib/jquery-1.10.1.min.js');
	$PAGE->requires->js('/local/library/lib/jquery.mousewheel-3.0.6.pack.js');
	$PAGE->requires->js('/local/library/source/jquery.fancybox.js?v=2.1.5');
    $PAGE->requires->js('/local/library/js/test.js');

echo $OUTPUT->header();

$html ='';
if($admin){

	$addlink = new moodle_url('/local/library/edit.php',array('i'=>0));

	echo html_writer::start_tag('div', array());
		echo html_writer::tag('a',get_string('addpoll','local_library'),array('style'=>'margin-bottom:10px;display:inline-block;', 'class'=>'fb-btn', 'href'=>$addlink));
	echo html_writer::end_tag('div');

$html.='<div id="region-main" class="body-biblioteca">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span10">
					<h2 class="fb-title-modules-biblioteca fb-txt-gray">
						<span class="fb-icon fb-icon-title-modules-biblioteca">&nbsp;</span>
						Biblioteca de cursos virtuales
					</h2>
				</div>
			</div>
			<div class="row-fluid">
			<div class="span10">';

        

foreach ($category as $key => $value) {

	$polls = $model->get_librarys($value->id);


	$html.='<div class="fb-table">
						<div class="fb-table-header fb-txt-green">
							<span class="fb-ancho100">'.$value->name.'</span>
						</div>';

						foreach ($polls as $pollid => $pollvalue) {
							$viewlink = new moodle_url('/local/library/files/'.$pollvalue->id.'/index.html');
							$html.='<div class="fb-table-body">
							<span class="fb-ancho100">
								<span class="fb-icon fb-icon-course">&nbsp;</span>
								<a href="'.$viewlink.'" class="fb-txt-gray fancybox fancybox.iframe">'.$pollvalue->name.'</a>
							</span>
						    </div>';
						}
     
					$html.='</div>';





}
$html.='</div></div></div></div>';

echo $html;
/*




	$addlink = new moodle_url('/local/library/edit.php',array('i'=>0));

		echo html_writer::tag('h3',get_string('panel','local_library'), array());

		echo html_writer::start_tag('div', array());
			echo html_writer::tag('a',get_string('addpoll','local_library'),array('href'=>$addlink));
		echo html_writer::end_tag('div');

		echo html_writer::start_tag('table',array());
        echo html_writer::start_tag('thead');
			echo html_writer::start_tag('tr');
				echo html_writer::tag('th',get_string('pollname','local_library'));
				echo html_writer::tag('th',get_string('configpoll','local_library'));
			echo html_writer::end_tag('tr');
            echo html_writer::end_tag('thead');
			echo html_writer::start_tag('tbody');
			foreach($polls as $poll){
				$editlink = new moodle_url('/local/library/edit.php',array('i'=>$poll->id));
				$dellink = new moodle_url('/local/library/delete.php',array('i'=>$poll->id));
				$viewlink = new moodle_url('/local/library/files/'.$poll->id.'/index.html');
				$questionlink = new moodle_url('/local/library/permisos.php',array('i'=>$poll->id));
				$statelink = new moodle_url('/local/library/state.php',array('i'=>$poll->id,'s'=>(($poll->state=='0')? '1' : '0')));
				$stadislink = new moodle_url('/local/library/statistics.php',array('i'=>$poll->id,'s'=>(($poll->state=='0')? '1' : '0')));
				echo html_writer::start_tag('tr');
                      echo html_writer::start_tag('td');

                      echo html_writer::tag('a',$poll->name,array('class'=>'fancybox fancybox.iframe','rel'=>$poll->name,'href'=>$viewlink));
                      echo html_writer::end_tag('td');
					//echo html_writer::tag('td',$poll->name);
					echo html_writer::start_tag('td');
						//echo html_writer::tag('a',$poll->name,array('class'=>'clsVentanaIFrame clsBoton','href'=>$viewlink));
						echo '|';
						echo html_writer::tag('a',get_string('editconfig','local_library'),array('class'=>'poll-config','href'=>$editlink));
						echo '|';
						echo html_writer::tag('a',get_string('changequestion','local_library'),array('class'=>'poll-question','href'=>$questionlink));
						echo '|';
						echo html_writer::tag('a',(($poll->state=='0')?get_string('show'):get_string('hide')),array('class'=>'poll-state','href'=>$statelink));
						echo '|';
						echo html_writer::tag('a',get_string('deletepoll','local_library'),array('class'=>'poll-delete','href'=>$dellink,'onclick'=>'eliminar('.$poll->id.');return false;'));
					echo html_writer::end_tag('td');
				echo html_writer::end_tag('tr');
			}

			if(count($polls)==0){
				echo html_writer::start_tag('tr');
					echo html_writer::tag('td',get_string('nopolls','local_library'),array('colspan'=>2));
				echo html_writer::end_tag('tr');
			}


        echo html_writer::end_tag('tbody');
		echo html_writer::end_tag('table');*/
		
}





echo $OUTPUT->footer();
