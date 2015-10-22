<?php

require('../../config.php');

defined('MOODLE_INTERNAL') || die;

$course = $DB->get_record('course', array('id'=>''.SITEID));

require_login($course);

$url = new moodle_url('/report/gradesall/index.php', array());

$PAGE->set_url($url);

require_capability('report/gradesall:view', context_system::instance());
$PAGE->navbar->add('Mis Calificaciones');
echo $OUTPUT->header();




$query="SELECT c.id courseid, c.fullname course, cg.name category,g.finalgrade fgrade
		FROM  {course} c
		INNER JOIN {context} ct 
		ON c.id=ct.instanceid
		INNER JOIN {role_assignments} r
		ON r.contextid=ct.id
		RIGHT JOIN {course_categories} cg 
		ON c.category = cg.id
		LEFT JOIN {grade_items} gi 
		ON gi.courseid=c.id  
		LEFT JOIN {grade_grades} g 
		ON g.itemid=gi.id	AND g.userid=r.userid
		WHERE gi.itemtype=? AND r.userid=? 
		AND ct.contextlevel=?
		ORDER BY category ASC, course ASC";

$params=array('course',$USER->id,'50');


$allgrades=$DB->get_records_sql($query,$params);

$firstcat='';

$html = '';

$html.='<div id="region-main" class="body-calificaciones">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span10">
					<h2 class="fb-title-modules-cal fb-txt-gray">
						<span class="fb-icon fb-icon-title-modules-calificaciones">&nbsp;</span>
						Historial de calificaciones
					</h2>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span10">
					<div class="fb-table">
						<div class="fb-table-header fb-txt-green">
							<span class="fb-ancho40">Negocios</span>
							<span class="fb-ancho20">Inicio</span>
							<span class="fb-ancho20">Fin</span>
							<span class="fb-ancho10">Calificación</span>
						</div>
						<div class="fb-table-body">
							<span class="fb-ancho40">
								<span class="fb-icon fb-icon-course">&nbsp;</span>
								<a href="#" class="fb-txt-green">Data 1</a>
							</span>
							<span class="fb-txt-gray fb-ancho20">
								12-10-2015
							</span>
							<span class="fb-txt-gray fb-ancho20">
								12-12-2015
							</span>
							<span class="fb-ancho10 fb-nota-aprobada">
								20
							</span>
						</div>
						<div class="fb-table-body">
							<span class="fb-ancho40">
								<span class="fb-icon fb-icon-course">&nbsp;</span>
								<a href="#" class="fb-txt-green">Data 1</a>
							</span>
							<span class="fb-txt-gray fb-ancho20">
								12-10-2015
							</span>
							<span class="fb-txt-gray fb-ancho20">
								12-12-2015
							</span>
							<span class="fb-ancho10 fb-nota-desaprobada">
								10
							</span>
						</div>
						<div class="fb-table-body">
							<span class="fb-ancho40">
								<span class="fb-icon fb-icon-course">&nbsp;</span>
								<a href="#" class="fb-txt-green">Data 1</a>
							</span>
							<span class="fb-txt-gray fb-ancho20">
								12-10-2015
							</span>
							<span class="fb-txt-gray fb-ancho20">
								12-12-2015
							</span>
							<span class="fb-ancho10 fb-nota-aprobada">
								18
							</span>
						</div>
						<div class="fb-table-body">
							<span class="fb-ancho40">
								<span class="fb-icon fb-icon-course">&nbsp;</span>
								<a href="#" class="fb-txt-green">Data 1</a>
							</span>
							<span class="fb-txt-gray fb-ancho20">
								12-10-2015
							</span>
							<span class="fb-txt-gray fb-ancho20">
								12-12-2015
							</span>
							<span class="fb-ancho10 fb-nota-desaprobada">
								09
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>';

	echo $html;
/*
	foreach($allgrades as $grade){

		if(empty($grade->fgrade)){	
			$grade->fgrade=' - ';
		}else{
			$grade->fgrade=number_format ($grade->fgrade,2);
		}

		if($firstcat!=$grade->category){
			if($firstcat!=''){

				echo html_writer::end_tag('table');
			}

			$firstcat=$grade->category;


                echo html_writer::start_tag('table',array('class'=>'category-gradesall'));
				echo html_writer::start_tag('tr');
					echo html_writer::tag('th',$grade->category, array('class'=>'category-name'));
					echo html_writer::tag('th','Inicio');
					echo html_writer::tag('th','Fin');
					echo html_writer::tag('th','Nota');
				echo html_writer::end_tag('tr');

		}


		echo html_writer::start_tag('tr',array('class'=>'row-grade'));


            $condition_course = $DB->get_records('inidate',array('courseid'=> $grade->courseid,'type'=>'course'),'id,date,type_action');

             
			    $sql_group = "SELECT id.id,id.date, id.type_action,gm.groupid   
			                    FROM {inidate} id
			                    INNER JOIN {groups} g 
			                    ON g.id = id.groupid
			                    INNER JOIN {groups_members} gm
			                    ON gm.groupid = g.id
			                    WHERE id.courseid = ?
			                    AND gm.userid = ?
			                    AND id.type_action = ?
			                    ORDER BY id.date DESC LIMIT 1";

			    $groupend = $DB->get_record_sql($sql_group, array($grade->courseid,$USER->id,'end'));

			    $idgroup = '';
			    $idgroup = 0;
			    
			    if(isset($groupend->groupid)){
			    	$idtext = "AND gm.groupid = ? ";	
			    	$idgroup = $groupend->groupid;
			    } 

			    $sql_group = "SELECT id.id,id.date, id.type_action,gm.groupid   
			                    FROM {inidate} id
			                    INNER JOIN {groups} g 
			                    ON g.id = id.groupid
			                    INNER JOIN {groups_members} gm
			                    ON gm.groupid = g.id
			                    WHERE id.courseid = ?
			                    AND gm.userid = ?
			                    AND id.type_action = ?
			                    ". $idtext."
			                    ORDER BY id.date DESC LIMIT 1";

			    $groupini = $DB->get_record_sql($sql_group, array($grade->courseid,$USER->id,'ini',$idgroup));
			    

			echo html_writer::tag('td',$grade->course,array('class'=>'course-name'));

			if(!empty($groupini)){

				echo html_writer::tag('td',date('d-m-Y',$groupini->date),array('class'=>'date-ini'));
			}else{
				echo html_writer::tag('td','-',array('class'=>'date-ini'));
			}
            

			if(!empty($groupend)){

				echo html_writer::tag('td',date('d-m-Y',$groupend->date),array('class'=>'date-ini'));
			}else{
				echo html_writer::tag('td','-',array('class'=>'date-ini'));
			}
            	
			
			echo html_writer::tag('td',$grade->fgrade,array('class'=>'finalgrade'));


		echo html_writer::end_tag('tr');		
	}




echo html_writer::end_tag('table');*/


echo $OUTPUT->footer();


