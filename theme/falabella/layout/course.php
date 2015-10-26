<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * A two column layout for the falabella theme.
 *
 * @package   theme_falabella
 * @copyright 2012 Bas Brands, www.basbrands.nl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
global $DB,$CFG;
// Set default (LTR) layout mark-up for a two column page (side-pre-only).
$regionmain = 'span9 pull-right';
$sidepre = 'span3 desktop-first-column';
// Reset layout mark-up for RTL languages.
if (right_to_left()) {
    $regionmain = 'span9';
    $sidepre = 'span3 pull-right';
}

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body <?php echo $OUTPUT->body_attributes('two-column'); ?>>

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<p class="esconder-txt">course</p>

<header>
    <div class="container-fluid">
        <div class="row-fluid">
            <div id="fb-breadcrumb">
                <?php echo $OUTPUT->navbar(); ?>
            </div>
            <div id="fb-user-menu">
                <div class="btn-group">
                <!-- Jalamos la imagen del usuario -->
                <!-- hay una función especial para esto, por el momento jalaré una del tema y le daré estilos -->
                    <span class="fb-img-user">
                        <img src="<?php echo $CFG->wwwroot;?>/theme/falabella/pix/f2.png">
                    </span>

                <!-- Imprimimos el nombre del usuario-->
                  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    <span> <?php echo $USER->firstname.' '.$USER->lastname ?> </span>
                    <span class="caret"></span>
                  </a>
                  <!-- Imprimimos la lista-->
                  <ul class="dropdown-menu">
                    <li><a href="/report/user/index.php">Editar Perfil</a></li>
                    <li><a href="#">Cambiar Contraseña</a></li>
                    <li><a href="<?php echo $CFG->wwwroot.'/login/logout.php?sesskey='.$USER->sesskey?>">Cerrar Sesión</a></li>
                  </ul>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12" id="fb-space-logo">
                <a class="brand" href="<?php echo $CFG->wwwroot;?>/report/courseall/index.php">
                    <img src="<?php echo $CFG->wwwroot;?>/theme/falabella/pix/logo-inside.png" alt="">
                </a>
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="span12" id="fb-menu">
            <nav id="nav" role="navigation">
                <a href="#nav" title="Show navigation">Mostrar Menú</a>
                <a href="#" title="Hide navigation">Ocultar Menú</a>
                <ul>
                    <li><a href="/report/courseall/index.php">Inicio</a></li>
                    <li>
                        <a href="/report/courseall/view.php" aria-haspopup="true">Programas</a>
                        <ul>
                        <?php $categorys  = $DB->get_records('course_categories',array('parent'=>1));
                         foreach ($categorys as $categorysid => $categorysvalue) {
                            $url = new moodle_url('/report/courseall/category.php',array('id'=>$categorysvalue->id));
                               echo '<li><a href="'.$url.'" >'.$categorysvalue->name.'</a></li>';
                            
                         }  ?>

                        </ul>
                    </li>
                    <li><a href="/report/gradesall/index.php" aria-haspopup="true">Calificaciones</a></li>
                    <li><a href="/local/library/view.php">Biblioteca</a></li>
                </ul>
            </nav>
            </div>
        </div>        
    </div>
</header>
<div id="page" class="container-fluid">
    <?php echo $OUTPUT->full_header(); ?>
    <div id="page-content" class="row-fluid">
        <section id="region-main" class="<?php echo $regionmain; ?>">
            <?php
            echo $OUTPUT->course_content_header();
            echo $OUTPUT->main_content();
            echo $OUTPUT->course_content_footer();
            ?>
        </section>
        <?php echo $OUTPUT->blocks('side-pre', $sidepre); ?>
    </div>

    <footer id="page-footer" class="row-fluid">
        <div class="span12">
            <p class="fb-txt-green fb-txt-bold">Soporte virtual</p>
            <p><span class="fb-icon fb-mail"></span>soporte.escuela@bancofalabella.com | <span class="fb-icon fb-phone"></span>021 529 3000</p>
        </div>
    </footer>

    <?php echo $OUTPUT->standard_end_of_body_html() ?>

</div>
</body>
</html>
