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

$polls = $model->get_librarys();

//$user = $model->get_users_permission($USER->id);

//$roles = array_shift($model->get_roles($USER->id));

$PAGE->requires->css('/local/library/css/ventanas-modales.css');
//$PAGE->requires->css('/local/library/css/library-styles.css');

$PAGE->requires->js('/local/library/js/ext/jquery-1.7.2.min.js');
$PAGE->requires->js('/local/library/js/ventanas-modales.js');

echo $OUTPUT->header();

if($admin){
		$addlink = new moodle_url('/local/library/index.php',array('i'=>0));


		echo html_writer::start_tag('div', array('class'=>'header-library'));
			echo html_writer::tag('a',get_string('panel','local_library'),array('href'=>$addlink));
		echo html_writer::end_tag('div');
}

 $html = '';
    $html.='
	<div id="region-main" class="body-biblioteca">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span10">
					<h2 class="fb-title-modules-cal fb-txt-gray">
						<span class="fb-icon fb-icon-title-modules-biblioteca">&nbsp;</span>
						Biblioteca de cursos virtuales
					</h2>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span10">
					<div class="fb-table">
						<div class="fb-table-header fb-txt-green">
							<span class="fb-ancho100">Negocios</span>
						</div>
						<div class="fb-table-body">
							<span class="fb-ancho100">
								<span class="fb-icon fb-icon-course">&nbsp;</span>
								<a href="#" class="fb-txt-gray">Programa de inducción Funcional Asesor de Negocios con Experiencia</a>
							</span>
						</div>
					</div>
					<div class="fb-table">
						<div class="fb-table-header fb-txt-green">
							<span class="fb-ancho100">Negocios</span>
						</div>
						<div class="fb-table-body">
							<span class="fb-ancho100">
								<span class="fb-icon fb-icon-course">&nbsp;</span>
								<a href="#" class="fb-txt-gray">Programa de inducción Funcional Asesor de Negocios con Experiencia</a>
							</span>
						</div>
						<div class="fb-table-body">
							<span class="fb-ancho100">
								<span class="fb-icon fb-icon-course">&nbsp;</span>
								<a href="#" class="fb-txt-gray">Programa de inducción Funcional Asesor de Negocios con Experiencia</a>
							</span>
						</div>
						<div class="fb-table-body">
							<span class="fb-ancho100">
								<span class="fb-icon fb-icon-course">&nbsp;</span>
								<a href="#" class="fb-txt-gray">Programa de inducción Funcional Asesor de Negocios con Experiencia</a>
							</span>
						</div>
					</div>
					<div class="fb-table">
						<div class="fb-table-header fb-txt-green">
							<span class="fb-ancho100">Negocios</span>
						</div>
						<div class="fb-table-body">
							<span class="fb-ancho100">
								<span class="fb-icon fb-icon-course">&nbsp;</span>
								<a href="#" class="fb-txt-gray">Programa de inducción Funcional Asesor de Negocios con Experiencia</a>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
';

 echo $html;
/*
		echo html_writer::tag('h2', 'Biblioteca Virtual', array('class' => 'report-title'));

		echo html_writer::start_tag('div', array('class'=>'library-txt'));
			echo html_writer::tag('p','Estos cursos son una implementación esencial para el continuo crecimiento profesional y la gestión de equipo.');
			echo html_writer::tag('p','Esperamos que puedas contar con las herramientas de gestión que necesitas.');
		echo html_writer::end_tag('div');
if($admin){

	$addlink = new moodle_url('/local/library/index.php',array('i'=>0));


		echo html_writer::start_tag('div', array('class'=>'header-library'));
			echo html_writer::tag('a',get_string('panel','local_library'),array('href'=>$addlink));
		echo html_writer::end_tag('div');

		echo html_writer::start_tag('table',array('id'=>'new-report-table'));
		echo html_writer::start_tag('thead');
			echo html_writer::start_tag('tr');
				echo html_writer::tag('th',get_string('pollname','local_library'));
				echo html_writer::tag('th',get_string('configpoll','local_library'));
			echo html_writer::end_tag('tr');
			echo html_writer::end_tag('thead');
			echo html_writer::start_tag('tbody');

			echo html_writer::start_tag('tr');
				echo html_writer::tag('th','Aquí podrás consultar los cursos que consideramos adecuados para tu puesto. <strong><em>Recuerda que estos cursos no registran nota ni participación.</em></strong>',array('class'=>'msg-library'));
			echo html_writer::end_tag('tr');

			

            

			foreach($polls as $poll){
			
				$viewlink = new moodle_url('/local/library/files/'.$poll->id.'/index.html');
                
				echo html_writer::start_tag('tr');
                      echo html_writer::start_tag('td');
                      echo html_writer::tag('a',$poll->name,array('class'=>'clsVentanaIFrame clsBoton','rel'=>$poll->name,'href'=>$viewlink));
                      echo html_writer::end_tag('td');
					//echo html_writer::tag('td',$poll->name);
	
				echo html_writer::end_tag('tr');
			}

			if(count($polls)==0){
				echo html_writer::start_tag('tr');
					echo html_writer::tag('td',get_string('nopolls','local_library'),array('colspan'=>2));
				echo html_writer::end_tag('tr');
			}

		echo html_writer::end_tag('tbody');
		echo html_writer::end_tag('table');

}elseif($roles->userid==$USER->id){

$addlink = new moodle_url('/local/library/index.php',array('i'=>0));



		echo html_writer::start_tag('div', array('class'=>'header-library'));
			echo html_writer::tag('a',get_string('panel','local_library'),array('href'=>$addlink));
		echo html_writer::end_tag('div');

		echo html_writer::start_tag('table',array('id'=>'new-report-table'));
		echo html_writer::start_tag('thead');
			echo html_writer::start_tag('tr');
				echo html_writer::tag('th',get_string('pollname','local_library'));
				echo html_writer::tag('th',get_string('configpoll','local_library'));
			echo html_writer::end_tag('tr');
                echo html_writer::end_tag('thead');
			echo html_writer::start_tag('tbody');

			echo html_writer::start_tag('tr');
				echo html_writer::tag('th','Aquí podrás consultar los cursos que consideramos adecuados para tu puesto. <strong><em>Recuerda que estos cursos no registran nota ni participación.</em></strong>',array('class'=>'msg-library'));
			echo html_writer::end_tag('tr');
			

			

			foreach($polls as $poll){
			
				$viewlink = new moodle_url('/local/library/files/'.$poll->id.'/index.html');
               
				echo html_writer::start_tag('tr');
                      echo html_writer::start_tag('td');
                      echo html_writer::tag('a',$poll->name,array('class'=>'clsVentanaIFrame clsBoton','rel'=>$poll->name,'href'=>$viewlink));
                      echo html_writer::end_tag('td');
					//echo html_writer::tag('td',$poll->name);
	
				echo html_writer::end_tag('tr');
			}

			if(count($polls)==0){
				echo html_writer::start_tag('tr');
					echo html_writer::tag('td',get_string('nopolls','local_library'),array('colspan'=>2));
				echo html_writer::end_tag('tr');
			}

		echo html_writer::end_tag('tbody');
		echo html_writer::end_tag('table');



}elseif(isset($user)){

echo html_writer::start_tag('table',array('id'=>'new-report-table'));
echo html_writer::start_tag('thead');
			echo html_writer::start_tag('tr');
				echo html_writer::tag('th',get_string('pollname','local_library'));
			echo html_writer::end_tag('tr');
	echo html_writer::end_tag('thead');

echo html_writer::start_tag('tbody');
echo html_writer::start_tag('tr');
				echo html_writer::tag('th','Aquí podrás consultar los cursos que consideramos adecuados para tu puesto. <strong><em>Recuerda que estos cursos no registran nota ni participación.</em></strong>',array('class'=>'msg-library'));
			echo html_writer::end_tag('tr');

     foreach($user as $curso){

	      
				$viewlink = new moodle_url('/local/library/files/'.$curso->libraryid.'/index.html');

				echo html_writer::start_tag('tr');
                      echo html_writer::start_tag('td');
                      echo html_writer::tag('a',$curso->name,array('class'=>'clsVentanaIFrame clsBoton','rel'=>$curso->name,'href'=>$viewlink));
                      echo html_writer::end_tag('td');
					//echo html_writer::tag('td',$poll->name);
	
				echo html_writer::end_tag('tr');
			}

       if(count($user)==0){
				echo html_writer::start_tag('tr');
					echo html_writer::tag('td',get_string('nopolls','local_library'),array('colspan'=>2));
				echo html_writer::end_tag('tr');
			}

         echo html_writer::end_tag('tbody');
		echo html_writer::end_tag('table');


}else{

                 echo html_writer::start_tag('tr');
					echo html_writer::tag('td',get_string('nopolls','local_library'),array('colspan'=>2));
				echo html_writer::end_tag('tr');


}

*/



echo $OUTPUT->footer();
