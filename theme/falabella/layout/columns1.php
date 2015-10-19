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
 * The one column layout.
 *
 * @package   theme_falabella
 * @copyright 2013 Moodle, moodle.org
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Get the HTML for the settings bits.
$html = theme_falabella_get_html_for_settings($OUTPUT, $PAGE);

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<p class="esconder-txt">columns1</p>

<header>
    <div class="container-fluid">
        <div class="row-fluid">
            <div id="fb-breadcrumb">
                <?php echo $OUTPUT->navbar(); ?>
            </div>
            <div id="fb-user-menu">
                <?php echo $OUTPUT->user_menu(); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12" id="fb-space-logo">
                <a class="brand" href="<?php echo $CFG->wwwroot;?>">
                    <img src="<?php echo $CFG->wwwroot;?>/theme/falabella/pix/logo-banco-falabella.png" alt="">
                </a>
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="span12" id="fb-menu">
                <div class="navbar">
                    <nav role="navigation" id="fb-main-menu">
                        <div class="container-fluid">
                            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </a>
                            <div class="nav-collapse collapse">
                                <?php echo $OUTPUT->custom_menu(); ?>
                                <!-- <ul class="nav pull-right">
                                    <li><?php echo $OUTPUT->page_heading_menu(); ?></li>
                                </ul> -->
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>        
    </div>
</header>

<div id="page" class="container-fluid">

    <?php echo $OUTPUT->full_header(); ?>

    <div id="page-content" class="row-fluid">
        <section id="region-main" class="span12">
            <?php
            echo $OUTPUT->course_content_header();
            echo $OUTPUT->main_content();
            echo $OUTPUT->course_content_footer();
            ?>
        </section>
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
