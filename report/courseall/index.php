<?php

require('../../config.php');

defined('MOODLE_INTERNAL') || die;


$course = $DB->get_record('course', array('id'=>''.SITEID));

require_login($course);

$url = new moodle_url('/report/courseall/index.php', array());

$PAGE->set_url($url);

require_capability('report/courseall:view', context_system::instance());


$PAGE->set_title(get_string('mycourse','report_courseall'));
$PAGE->set_heading(get_string('mycourse','report_courseall'));


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
              AND c.category <> '119'
		ORDER BY category, c.sortorder";

$params=array($USER->id,'5','50');


$allcourse=$DB->get_records_sql($query,$params);


$firstcat='';
$temp = '';
$contador=0;

 $temp.='<div class="body-frontpage">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span8">
					<a href="#">
						<img src="<?php echo $CFG->wwwroot;?>/theme/falabella/pix/img-main-frontpage.png" alt="">
					</a>
				</div>
				<div class="span4">
					<div class="fb-block">
						<div class="fb-block-header">
							<h3 class="fb-txt-gray">
								<span class="fb-icon fb-icon-bloque-1">&nbsp;</span>
								Cursos Vigentes
							</h3>
							<ul class="fb-cursos fb-txt-gray">';


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
    } else{
    	$idtext = '';
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
				

                $file=new moodle_url('/course/view.php', array('id'=>$onecourse->courseid));

				$temp.='<li>
									<a href="#" class="fb-txt-green">
										<span class="fb-icon fb-icon-item-curso">&nbsp;</span>
										'.$onecourse->course.'
									</a>
									<ul class="fb-fechas">
										<li>Fecha de Inicio: <span class="fecha">'.date('d-m-Y',$inidate).'</span></li>
										<li>Fecha de Fin: <span class="fecha">'.date('d-m-Y',$findate).'</span></li>
									</ul>
								</li>';


		}
	}


		$temp.='</ul>
						</div>
					</div>
					<div class="fb-block">
						<div class="fb-block-header">
							<h3 class="fb-txt-gray">
								<span class="fb-icon fb-icon-bloque-2">&nbsp;</span>
								Cursos Calificaciones
							</h3>
							<p class="fb-txt-gray">Lorem ipsum dolor sit amet, consectetur adipisicing elit <span class="fb-txt-green">Calificación aprobatoria es de 14</span> blanditiis maxime placeat sint vero sunt illum. Asperiores unde alias fuga, rerum.</p>
							<a class="pull-right fb-btn" href="#">Ver Calificaciones <span class="fb-icon fb-link-curso"></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>';

	echo $temp;



echo $OUTPUT->footer();


