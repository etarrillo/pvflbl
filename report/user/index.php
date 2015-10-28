<?php

require('../../config.php');

defined('MOODLE_INTERNAL') || die;


$course = $DB->get_record('course', array('id'=>''.SITEID));

require_login($course);

$url = new moodle_url('/report/user/index.php', array());

$PAGE->set_url($url);
$PAGE->navbar->add('Editar Información');

require_capability('report/user:view',context_system::instance());


$PAGE->set_title(get_string('user','report_user'));

$usercontext = context_user::instance($USER->id);

$pictururl=new moodle_url('/pluginfile.php/'.$usercontext->id.'/user/icon/standard/f2', array('rev'=>$USER->picture));
$editurl=new moodle_url('/report/user/edit.php', array());

echo $OUTPUT->header();

$html='';
$html.='<div id="region-main" class="body-perfil">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span6" id="img-fb-user">
					<img class="pull-right img-circle" src="'.$pictururl.'" alt="">
				</div>
				<div class="span6">
					<ul class="fb-list-user">
						<li class="fb-txt-gray"><span class="fb-txt-green">Nombres: </span>'.$USER->firstname.'</li>
						<li class="fb-txt-gray"><span class="fb-txt-green">Apellidos: </span>'.$USER->lastname.'</li>
						<li class="fb-txt-gray"><span class="fb-txt-green">DNI: </span>487654321</li>
					</ul>
				</div>
			</div>
			<div class="row-fluid fb-block-perfil">
				<div class="span6">
					<h4 class="fb-txt-green">Datos personales</h4>
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="">Fecha de nacimiento: </label>
							<div class="controls">
							  <input type="date" id="" placeholder="Email">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="">Correo: </label>
							<div class="controls">
							  <input type="email" id="" placeholder="Correo">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="">Teléfono: </label>
							<div class="controls">
							  <input type="number" id="" placeholder="Teléfono">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="">Celular: </label>
							<div class="controls">
							  <input type="number" id="" placeholder="Celular">
							</div>
						</div>
					</form>
				</div>
				<div class="span6">
					<h4 class="fb-txt-green">Datos de la organización</h4>
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="">División: </label>
							<div class="controls">
							  <input type="text" id="" placeholder="División">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="">Departamento: </label>
							<div class="controls">
							  <input type="text" id="" placeholder="Departamento">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="">Área: </label>
							<div class="controls">
							  <input type="text" id="" placeholder="Área">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="">Puesto: </label>
							<div class="controls">
							  <input type="text" id="" placeholder="Puesto">
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
							  <input class="fb-btn-perfil" type="submit" id="" value="Guardar">
							  <span class="fb-icon fb-link-category"></span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>';

	echo $html;




/*







echo html_writer::tag('h2',get_string('mydata','report_user'), array('class'=>'title-data'));
echo html_writer::tag('h3',$USER->firstname.' '.$USER->lastname, array('class'=>'title-username'));


	echo html_writer::start_tag('div',array('id'=>'button-change-data'));
		echo $OUTPUT->single_button($editurl,get_string('edit'));
	echo html_writer::end_tag('div');







echo html_writer::start_tag('table',array('id'=>'table-user-data'));


	echo html_writer::start_tag('tr');
	echo html_writer::tag('td',get_string('username'));
	echo html_writer::tag('td',$USER->username);
	echo html_writer::end_tag('tr');

	echo html_writer::start_tag('tr');
	echo html_writer::tag('td',get_string('firstname'));
	echo html_writer::tag('td',$USER->firstname);
	echo html_writer::end_tag('tr');

	echo html_writer::start_tag('tr');
	echo html_writer::tag('td',get_string('lastname'));
	echo html_writer::tag('td',$USER->lastname);
	echo html_writer::end_tag('tr');

	echo html_writer::start_tag('tr');
	echo html_writer::tag('td',get_string('email'));
	echo html_writer::tag('td',$USER->email);
	echo html_writer::end_tag('tr');

	echo html_writer::start_tag('tr');
	echo html_writer::tag('td',get_string('msnid'));
	echo html_writer::tag('td',$USER->msn);
	echo html_writer::end_tag('tr');

	echo html_writer::start_tag('tr');
	echo html_writer::tag('td',get_string('icqnumber'));
	echo html_writer::tag('td',date(('d/m/Y'),$USER->icq));
	echo html_writer::end_tag('tr');

	echo html_writer::start_tag('tr');
	echo html_writer::tag('td',get_string('phone'));
	echo html_writer::tag('td',$USER->phone1);
	echo html_writer::end_tag('tr');

	echo html_writer::start_tag('tr');
	echo html_writer::tag('td',get_string('yahooid'));
	echo html_writer::tag('td',$USER->yahoo);
	echo html_writer::end_tag('tr');

	echo html_writer::start_tag('tr');
	echo html_writer::tag('td',get_string('phone2'));
	echo html_writer::tag('td',$USER->phone2);
	echo html_writer::end_tag('tr');

	echo html_writer::start_tag('tr');
	echo html_writer::tag('td',get_string('userpic'));
	echo html_writer::start_tag('td',array('class'=>'user_picture'));
	echo html_writer::empty_tag('img',array('src'=>$pictururl));
	echo html_writer::end_tag('td');
	echo html_writer::end_tag('tr');




echo html_writer::end_tag('table');

*/
echo $OUTPUT->footer();


