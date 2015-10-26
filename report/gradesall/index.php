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
			</div><div class="row-fluid">
				<div class="span10">';


			
	

	foreach($allgrades as $grade){

		if(empty($grade->fgrade)){	
			$grade->fgrade=' - ';
		}else{
			$grade->fgrade=number_format ($grade->fgrade,2);
		}


$html.='<div class="fb-table">';
		if($firstcat!=$grade->category){
	
			$firstcat=$grade->category;

            $html.='
						<div class="fb-table-header fb-txt-green">
							<span class="fb-ancho40">'.$grade->category.'</span>
							<span class="fb-ancho20">Inicio</span>
							<span class="fb-ancho20">Fin</span>
							<span class="fb-ancho10">Calificación</span>
						</div>';
               

		}


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
			    
             
                    $html.='<div class="fb-table-body">
							<span class="fb-ancho40">
								<span class="fb-icon fb-icon-course">&nbsp;</span>
								<a href="" class="fb-txt-green">'.$grade->course.'</a>
							</span>

							<span class="fb-txt-gray fb-ancho20">';

					       if(!empty($groupini)){

				             $html.= date('d-m-Y',$groupini->date);
			                 }else{
				             $html.= '-';
			                }
							$html.='</span><span class="fb-txt-gray fb-ancho20">';

							if(!empty($groupend)){

								$html.= date('d-m-Y',$groupend->date);
							}else{
								$html.= '-';
							}
						
							$html.='</span>';
							if($grade->fgrade>=14){
								$html.='<span class="fb-ancho10 fb-nota-aprobada">'.$grade->fgrade.'</span>';

							}else{
                                 $html.='<span class="fb-ancho10 fb-nota-desaprobada">'.$grade->fgrade.'</span>';
							}

							$html.='</div>';
		
	}

$html.='</div></div></div></div>';


echo $html;


echo $OUTPUT->footer();


