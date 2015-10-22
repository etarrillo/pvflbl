<?php

require('../../config.php');

defined('MOODLE_INTERNAL') || die;

$id = required_param('id', PARAM_INT); // Category id

$course = $DB->get_record('course', array('id'=>''.SITEID));

require_login($course);

$url = new moodle_url('/report/courseall/category.php', array());

$PAGE->set_url($url);


require_capability('report/courseall:view',  context_system::instance());
$PAGE->navbar->add('Categorias');
$PAGE->set_title(get_string('mycourse','report_courseall'));


echo $OUTPUT->header();

$query="SELECT c.id courseid,c.fullname course, cg.name category
		FROM  {course} c
		INNER JOIN {context} ct 
		ON c.id=ct.instanceid
		INNER JOIN {role_assignments} r
		ON r.contextid=ct.id
		RIGHT JOIN {course_categories} cg 
		ON c.category = cg.id
		WHERE r.userid=? AND r.roleid=?
		AND ct.contextlevel=?
		AND cg.visible='1'
		AND c.visible='1'
        AND c.category=?
		ORDER BY category, c.sortorder";

$params=array($USER->id,'5','50',$id);

$allcourse=$DB->get_records_sql($query,$params);

$categorys  = $DB->get_record('course_categories',array('id'=>$id));



$firstcat='';
$temp = '';
$contador=0;

 $temp.='
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span7">
					<h2 class="fb-title fb-txt-green">'.$categorys->name.'</h2>
					<p class="fb-parrafo fb-txt-gray">
						<span class="fb-icon fb-icon-parrafo">&nbsp;</span>'.$categorys->description.'
					</p>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span7">
					<div class="fb-table">						
						<div class="fb-table-header fb-txt-green">
							<span class="fb-ancho30">Curso</span>
							<span class="fb-ancho20">Inicio</span>
							<span class="fb-ancho20">Fin</span>
							<span class="fb-ancho20">Estado</span>
						</div>';



	foreach($allcourse as $onecourse){


    $condition_course = $DB->get_records('inidate',array('courseid'=> $onecourse->courseid,'type'=>'course'),'id,date,type_action');

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

    $groupend = $DB->get_record_sql($sql_group, array($onecourse->courseid,$USER->id,'end'));

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

    $groupini = $DB->get_record_sql($sql_group, array($onecourse->courseid,$USER->id,'ini',$idgroup));
    

    $final_condition = true;
    $show_condition = true;
    $inidate = 0;
    $findate = 0;

  	if(count($condition_course) > 0){

  		foreach($condition_course as $condition){

  			if($condition->type_action == 'ini'){
				$final_condition = $final_condition && ($condition->date <= strtotime(date("Y-m-d")));
				$inidate = $condition->date;
			}else{
                $final_condition = $final_condition && ($condition->date >= strtotime(date("Y-m-d")));
                $findate = $condition->date;				
                $show_condition = $show_condition && ($condition->date >= strtotime(date("Y-m-d")));
			}
  		} 		 

  	}else{

  		if(!empty($groupini)){
			$final_condition = $final_condition && ($groupini->date <= strtotime(date("Y-m-d")));
			$inidate = $groupini->date;
  		}

  		if(!empty($groupend)){
  	        $final_condition = $final_condition && ($groupend->date >= strtotime(date("Y-m-d")));
            $findate = $groupend->date;		
            $show_condition = $show_condition && ($groupend->date >= strtotime(date("Y-m-d")));
  		}


  	}




		if($final_condition){
			$contador++;

			$sql_a="SELECT gg.finalgrade 
					FROM {grade_items} gi 
					INNER JOIN {grade_grades} gg ON gi.id = gg.itemid 
					WHERE gi.itemtype = 'course' AND gi.courseid = ? AND gg.userid = ? ";

			$params_a=array($onecourse->courseid,$USER->id);

			$grade = $DB->get_field_sql($sql_a, $params_a);

			 $temp.='<div class="fb-table-body">
							<span class="fb-ancho30">
								<span class="fb-icon fb-icon-course">&nbsp;</span>
								<a href="#" class="fb-txt-green">Data 1</a>
							</span>
							<span class="fb-txt-gray fb-ancho20">
								12-10-2015
							</span>
							<span class="fb-txt-gray fb-ancho20">
								12-12-2015
							</span>
							<span class="fb-txt-green-dark fb-ancho20">
								Finalizado
							</span>
						</div>';

			/*$temp.=  html_writer::start_tag('tr',array('class'=>'row-grade'));

				$temp.=  html_writer::start_tag('td',array('class'=>'course-name'));		

					if($final_condition){
						$temp.=  html_writer::tag('a',$onecourse->course,array('href'=>new moodle_url('/course/view.php', array('id'=>$onecourse->courseid))));	
					}else{
						$temp.=  html_writer::tag('span',$onecourse->course);	
					}
					
				
				$temp.=  html_writer::end_tag('td');

				$temp.=  html_writer::start_tag('td',array('class'=>'date-ini'));

					$temp.=  html_writer::tag('span', ($inidate == 0)? '-' : date('d-m-Y',$inidate) );

				$temp.=  html_writer::end_tag('td');

				$temp.=  html_writer::start_tag('td',array('class'=>'date-end'));

					$temp.=  html_writer::tag('span', ($findate == 0)? '-' : date('d-m-Y',$findate) );

				$temp.=  html_writer::end_tag('td');
					
					$temp.=  html_writer::start_tag('td',array('class'=>'date-end'));

	
					if($DB->record_exists('grade_items',array('courseid'=>$onecourse->courseid,'itemmodule'=>'quiz'))){
						if($grade){
							$temp.=  html_writer::tag('span','En proceso');
						}else{
							$temp.=  html_writer::tag('span','En proceso');
						}					
					}else{
						$temp.=  html_writer::tag('span','---------------');	
					}

					

					$temp.=  html_writer::end_tag('td');

			$temp.=  html_writer::end_tag('tr')*/	
		}
	}





 $temp.='</div>
				</div>
				<div class="span5">
					<img src="pix/personaje.png" alt="">
				</div>
			</div>
		</div>
	';

	
	echo $temp;


echo $OUTPUT->footer();


