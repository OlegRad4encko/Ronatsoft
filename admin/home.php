<?php
    require_once('functions.php');

    if(!isset($_SESSION['name']) || empty($_SESSION['name'])){
        header("Location: index.php");
        exit (0);
    }

    if(isset($_SESSION['name'])){
        if(checkSession()) {
            header("Location: index.php");
            exit (0);
        }
    } 

    $active_page = 'none';
    if (isset($_GET['page'])) {
        $active_page = $_GET['page'];
    }

    $count_new_applications = get_new_applications_count();
    $CSFR_token = $_SESSION['csrf_token'];

?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Admin Panel</title>
        <?php echo get_styles(); ?>
    </head>
    <body>
        
        <div class="header outline">

            <div class="user-data">
                <h1><?php echo first_letter_to_appercase(get_user_role()); ?> | <?php echo get_user_name(); ?></h1>
            </div>
            <div class="inline">
                <button id="menu-toggle" class="menu-toggle"><i class="fa-solid fa-bars"></i></button>

                <ul class="nav">
                    <?php if (get_user_role() == "admin") { ?>
                    <li>
                        <a href="?page=users" id="users" <?php echo ($active_page == 'users')? 'class="active-page"' : '' ?>>Users</a>
                    </li>
                    <?php } ?>

                    <li>
                        <a href="?page=edit_landing" id="edit_landing" <?php echo ($active_page == 'edit_landing')? 'class="active-page"' : '' ?>>Edit Landing</a>
                    </li>
                    <li>
                        <a href="?page=applications" id="applications" <?php echo ($active_page == 'applications')? 'class="active-page"' : '' ?>>Applications <?php echo ($count_new_applications > 0)? '<i class="fa-solid fa-envelope"></i>'.$count_new_applications : ''?></a>
                    </li>

                    <?php if (get_user_role() == "admin") { ?>
                    <li><a href="?page=history" id="history" <?php echo ($active_page == 'history')? 'class="active-page"' : '' ?>>History</a></li>
                    <?php } ?>

                    <li><a href="?page=logout" id="logout">Logout</a></li>
                </ul>
            </div>
            

        </div>

        <div class="content outline" id="content">
                   
            <?php 
                
                switch($active_page) {
                    case 'users':

                        if(get_user_role() != "admin") {
                            header("location: home.php");
                        }
                        
                        echo get_users_table();
                        ?>
                        
                        <div class="controls controls-right">
                            <div>
                                <button type="button" name="add_user">Add User</button>
                            </div>
                        </div>
                        
                        <?php

                        break;

                    case 'edit_landing':
                        ?>

                        <h2>Social links <i class="fa-solid fa-circle-info"></i></h2>
                        <div class="socials-blocks">
                            <?php
                            
                            echo get_social_links();

                            ?>
                            <form class="social-block add-social">
                                <div>
                                    <input type="text" name="label" placeholder="Social name (alias)" required>
                                    <input type="text" name="icon" placeholder="icon class" required>
                                    <input type="text" name="link" placeholder="social link" required>
                                    <input name="csrf_token" type="hidden" value="<?php echo $CSFR_token; ?>" />
                                </div>
                                <div>
                                    <div class="icon-preview">
                                        Preview: <i name="preview" class=""></i>
                                    </div>
                                    <button id="delete-social" value="11">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </form>
                        </div>



                        <hr>



                        <h2>Edit page <i class="fa-solid fa-circle-info"></i></h2>


                        <h3>Header section</h3><?php $header_data = get_section_data('header_section'); ?>
                        <form class="edit-landing" id="header_section_form" enctype="multipart/form-data">
                            <input name="csrf_token" type="hidden" value="<?php echo $CSFR_token; ?>" />
                            <div class="inline gap1">
                                <div class="inline-block">
                                    <input id="logo_type_full" type="radio" name="logo_type" value="1" <?php echo ($header_data['logo_type'] == 1)? 'checked' : '' ?>>
                                    <label for="logo_type_full">Logo without parts</label>
                                </div>
                                <div>
                                    <input id="logo_type_divide" type="radio" name="logo_type" value="2" <?php echo ($header_data['logo_type'] == 2)? 'checked' : '' ?>>
                                    <label for="logo_type_divide">Two parts logo</label>
                                </div>
                                <div>
                                    <input id="logo_type_image" type="radio" name="logo_type" value="3" <?php echo ($header_data['logo_type'] == 3)? 'checked' : '' ?>>
                                    <label for="logo_type_image">Logo image</label>
                                </div>
                            </div>

                            <h4>Format of logotype</h4>

                            <!-- Logo, one color, type=text --> 
                            <div class="inline gap2 solid-logo">
                                <div class="inline-block">
                                    <label for="logo_text">Logo text</label>
                                    <input id="logo_text" type="text" name="logo_text" value="<?php echo $header_data['logo_text'] ?>" placeholder="Logo text">
                                </div>
                                <div class="inline-block">
                                    <label for="logo_color">Logo text color</label>
                                    <input id="logo_color" type="color" name="logo_color" value="<?php echo $header_data['logo_color'] ?>" placeholder="Logo text color">
                                </div>
                            </div>

                            <!-- Logo, two color, type=text --> 
                            <div class="inline gap2 parts-logo">
                                <div class="inline-block">
                                    <label for="logo_first_part_text">Logo first part text</label>
                                    <input id="logo_first_part_text" type="text" name="logo_first_part_text" value="<?php echo $header_data['logo_first_part_text'] ?>" placeholder="Logo text">
                                </div>
                                <div class="inline-block">
                                    <label for="logo_first_part_color">First part text color</label>
                                    <input id="logo_first_part_color" type="color" name="logo_first_part_color" value="<?php echo $header_data['logo_first_part_color'] ?>" placeholder="Logo text color">
                                </div>
                            </div>
                            <div class="inline gap2 parts-logo">
                                <div class="inline-block">
                                    <label for="logo_second_part_text">Logo second part text</label>
                                    <input id="logo_second_part_text" type="text" name="logo_second_part_text" value="<?php echo $header_data['logo_second_part_text'] ?>" placeholder="Logo text">
                                </div>
                                <div class="inline-block">
                                    <label for="logo_second_part_color">Second part text color</label>
                                    <input id="logo_second_part_color" type="color" name="logo_second_part_color" value="<?php echo $header_data['logo_second_part_color'] ?>" placeholder="Logo text color">
                                </div>
                            </div>


                            <!-- logo image -->
                            <div class="inline gap1 image-logo">
                                <div>
                                    <input id="logo_image_file" type="radio" name="logo_image" value="1" <?php echo (!$header_data['logo_image']) ? 'checked' : '' ?> <?php echo ($header_data['logo_image'] == 1) ? 'checked' : '' ?>>
                                    <label for="logo_image_file">Logo file</label>
                                </div>
                                <div>
                                    <input id="logo_image_link" type="radio" name="logo_image" value="2" <?php echo ($header_data['logo_image'] == 2) ? 'checked' : '' ?>>
                                    <label for="logo_image_link">Logo link</label>
                                </div>
                            </div>
                            <div class="inline gap2 image-logo">
                                <div class="inline-block logo-image-file">
                                    <label for="logo_image">Image file</label>
                                    <input id="logo_image" type="file" name="logo_image_file" accept=".gif, .jpg, .png, .jpeg" placeholder="Logo image file">
                                </div>
                                <div class="inline-block logo-image-link">
                                    <label for="logo_image_link_field">Logo image link</label>
                                    <input id="logo_image_link_field" type="text" name="logo_image_link" value="" placeholder="Logo image link">
                                </div>
                            </div>


                            <h4>Social links</h4>

                            <!-- Count of social links and selecting the links -->
                            <div class="inline gap1">
                                <div class="inline-block">
                                    <label for="count_of_soc_links">Count of social links in header</label>
                                    <select name="count_soc_links" id="count_of_soc_links">
                                        <option value="1" <?php echo ($header_data['count_soc_links'] == 1) ? 'selected' : '' ?>>1</option>
                                        <option value="2" <?php echo ($header_data['count_soc_links'] == 2) ? 'selected' : '' ?>>2</option>
                                        <option value="3" <?php echo ($header_data['count_soc_links'] == 3) ? 'selected' : '' ?>>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="inline gap1">
                                <div class="inline-block first-link">
                                    <label for="first_link">First link</label>
                                    <select name="soc1" id="first_link">
                                        <?php
                                            get_socials_for_select($header_data['soc_link1']);
                                        ?>
                                    </select>
                                </div>
                                <div class="inline-block second-link">
                                    <label for="second_link">Second link</label>
                                    <select name="soc2" id="second_link">
                                        <?php
                                            get_socials_for_select($header_data['soc_link2']);
                                        ?>
                                    </select>
                                </div>
                                <div class="inline-block third-link">
                                    <label for="third_link">Third link</label>
                                    <select name="soc3" id="third_link">
                                        <?php
                                            get_socials_for_select($header_data['soc_link3']);
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <h4>Color settings</h4>

                            <!-- text color \ header color -->
                            <div class="inline gap1">
                                <div class="inline-block">
                                    <label for="header_text_color">Header text color</label>
                                    <input id="header_text_color" type="color" name="header_text_color" value="<?php echo $header_data['header_text_color'] ?>" placeholder="Header text color">
                                </div>
                                <div class="inline-block">
                                    <label for="header_background_color">Header background color</label>
                                    <input id="header_background_color" type="color" name="header_background_color" value="<?php echo $header_data['header_background_color'] ?>" placeholder="Header background color">
                                </div>
                            </div>


                            <div class="inline gap1 inline-right">
                                <button type="submit"><i class="fa-regular fa-floppy-disk"></i></button>
                            </div>
                        </form>


                        <h3>Logo section</h3><?php $logo_data = get_section_data('logo_section') ?>
                        <form class="edit-landing" id="logo_section_form" enctype="multipart/form-data">
                            <input name="csrf_token" type="hidden" value="<?php echo $CSFR_token; ?>" />

                            <!-- text section -->
                            <div class="inline gap2 logo-section">
                                <div class="inline-block">
                                    <label for="wellcome_text">Wellcome text</label>
                                    <input id="wellcome_text" type="text" name="wellcome_text" value="<?php echo $logo_data['wellcome_text'] ?>" placeholder="Wellcome text" required>
                                </div>
                                <div class="inline-block">
                                    <label for="company_name">Company name</label>
                                    <input id="company_name" type="text" name="company_name" value="<?php echo $logo_data['company_name'] ?>" placeholder="Company name" required>
                                </div>
                                <div class="inline-block">
                                    <label for="slogan_text">Slogan text</label>
                                    <input id="slogan_text" type="text" name="slogan_text" value="<?php echo $logo_data['slogan_text'] ?>" placeholder="Slogan text" required>
                                </div>
                            </div>
                            <!-- background type selection -->
                            <h4>Background section settings</h4>
                            <div class="inline gap1">
                                <div>
                                    <input id="logo_section_file" type="radio" name="logo_section_background" value="1" <?php echo ($logo_data['logo_section_background'] == 1) ? 'checked' : '' ?>>
                                    <label for="logo_section_file">Logo background image</label>
                                </div>
                                <div>
                                    <input id="logo_section_color" type="radio" name="logo_section_background" value="2" <?php echo ($logo_data['logo_section_background'] == 2) ? 'checked' : '' ?>>
                                    <label for="logo_section_color">Logo background color</label>
                                </div>
                            </div>
                            <!-- background section -->
                            <div class="inline gap2 logo-section-background">
                                <div class="inline-block logo-background-image">
                                    <label for="logo_image">Background image</label>
                                    <input id="logo_image" type="file" name="background-image" accept=".gif, .jpg, .png, .jpeg" placeholder="Background image">
                                </div>
                                <div class="inline-block logo-background-color">
                                    <label for="logo_image_link_field">Background color</label>
                                    <input id="logo_image_link_field" type="color" name="background-color" value="<?php echo $logo_data['background_color'] ?>" placeholder="Background color">
                                </div>
                            </div>
                            <div class="inline gap1 inline-right">
                                <button type="submit"><i class="fa-regular fa-floppy-disk"></i></button>
                            </div>
                            

                        </form>


                        <h3>About Us section</h3><?php $about_us_data = get_section_data('about_us_section'); ?>
                        <form class="edit-landing" id="about_us_section_form" enctype="multipart/form-data">
                            <input name="csrf_token" type="hidden" value="<?php echo $CSFR_token; ?>" />
                            <div class="inline gap2">
                                <div class="inline-block">
                                    <label for="displayed_about_section_name">Displayed section name</label>
                                    <input id="displayed_about_section_name" type="text" name="displayed_about_section_name" value="<?php echo $about_us_data['displayed_about_section_name'] ?>" placeholder="Section name" required>
                                </div>
                                <div class="inline-block">
                                    <label for="paragraph1">Paragraph 1</label>
                                    <input id="paragraph1" type="text" name="paragraph1" value="<?php echo $about_us_data['paragraph1'] ?>" placeholder="Paragraph 1" required>
                                </div>
                                <div class="inline-block">
                                    <label for="paragraph2">Paragraph 2</label>
                                    <input id="paragraph2" type="text" name="paragraph2" value="<?php echo $about_us_data['paragraph2'] ?>" placeholder="Paragraph 2" required>
                                </div>
                            </div>

                            <h4>About us section image (will display near section content)</h4>
                            <div class="inline gap2 logo-section">
                                <div class="inline-block">
                                    <label for="image-set">Display about us image</label>
                                    <input type="checkbox" id="image-set" name="image_set" value="true" <?php echo ($about_us_data['image_set'] == 'true') ? 'checked' : '' ?>>
                                </div>
                            </div>

                            <div class="inline gap1 about-us-image">
                                <div>
                                    <input id="about_us_image" type="radio" name="about_us_image_type" value="1" <?php echo (!$about_us_data['about_us_image_type']) ? 'checked' : '' ?>
                                    <?php echo ($about_us_data['about_us_image_type'] == '1') ? 'checked' : '' ?>>
                                    <label for="about_us_image">Load image</label>
                                </div>
                                <div>
                                    <input id="about_us_image_link" type="radio" name="about_us_image_type" value="2" <?php echo ($about_us_data['about_us_image_type'] == '2') ? 'checked' : '' ?>>
                                    <label for="about_us_image_link">Fill the image link</label>
                                </div>
                            </div>

                            <div class="inline gap2 about-us-image">
                                <div class="inline-block about-us-image-file">
                                    <label for="about_us_image_file">Image file</label>
                                    <input id="about_us_image_file" type="file" name="about_us_image_file" accept=".gif, .jpg, .png, .jpeg" placeholder="Image file">
                                </div>
                                <div class="inline-block about-us-image-link">
                                    <label for="about_us_image_link">Image link</label>
                                    <input id="about_us_image_link" type="text" name="about_us_image_link" value="<?php echo $about_us_data['about_us_image_link'] ?>" placeholder="Image link">
                                </div>
                            </div>

                            <h4>Color settings</h4>
                            <div class="inline gap1">
                                <div class="inline-block">
                                    <label for="about_us_text_color">About Us text color</label>
                                    <input id="about_us_text_color" type="color" name="about_us_text_color" value="<?php echo $about_us_data['about_us_text_color'] ?>" placeholder="About Us text color">
                                </div>
                                <div class="inline-block">
                                    <label for="about_us_background_color">About Us background color</label>
                                    <input id="about_us_background_color" type="color" name="about_us_background_color" value="<?php echo $about_us_data['about_us_background_color'] ?>" placeholder="About Us background color">
                                </div>
                            </div>

                            <div class="inline gap1 inline-right">
                                <button type="submit"><i class="fa-regular fa-floppy-disk"></i></button>
                            </div>
                        </form>  

                        <h3>Our Projects section</h3><?php $our_projects = get_section_data('our_projects_section'); ?>
                        <form class="edit-landing" id="our_projects_section_form" enctype="multipart/form-data">
                            <input name="csrf_token" type="hidden" value="<?php echo $CSFR_token; ?>" />


                            <div class="inline gap2">
                                <div class="inline-block">
                                    <label for="displayed_projects_section_name">Displayed section name</label>
                                    <input id="displayed_projects_section_name" type="text" name="displayed_projects_section_name" value="<?php echo $our_projects['displayed_projects_section_name'] ?>" placeholder="Section name" required>
                                </div>
                                <div class="inline-block">
                                    <label for="count_projects_blocks">Count blocks displayed (n-random)</label>
                                    <input id="count_projects_blocks" type="number" name="count_projects_blocks" value="<?php echo $our_projects['count_projects_blocks'] ?>" min="2" max="10" placeholder="Count blocks" required>
                                </div>
                            </div>
                            <h4>Background gradient settings</h4>
                            <div class="inline gap2">
                                <div class="inline-block">
                                    <label for="from_color_gradient">Color 1</label>
                                    <input id="from_color_gradient" type="color" name="from_color_gradient" value="<?php echo $our_projects['from_color_gradient'] ?>" placeholder="from_color_gradient" required>
                                </div>
                                <div class="inline-block">
                                    <label for="to_color_gradient">Color 2</label>
                                    <input id="to_color_gradient" type="color" name="to_color_gradient" value="<?php echo $our_projects['to_color_gradient'] ?>" placeholder="to_color_gradient" required>
                                </div>
                            </div>
                            <div class="inline gap1 inline-right">
                                <button type="submit"><i class="fa-regular fa-floppy-disk"></i></button>
                            </div>

                        </form>
                        <h4>Add\edit projects</h4>
                        <div class="projects">
                            <?php get_projects(); ?>
                        </div>
                        <form class="project add-project" id="add_project">
                            <div class="project-data">
                                <input name="csrf_token" type="hidden" value="<?php echo $CSFR_token; ?>" />
                                <div>
                                    <label for="pr_link">Project link</label>
                                    <input id="pr_link" type="text" name="project_link">
                                </div>
                                <div>
                                    <label for="pr_image_link">Project image link</label>
                                    <input id="pr_image_link" type="text" name="project_image_link">
                                </div>
                                <div>
                                    <label for="pr_text">Project text</label>
                                    <input id="pr_text" type="text" name="project_text">
                                </div>
                                    
                            </div>
                            <button type="submit"><i class="fa-regular fa-floppy-disk"></i></button>
                        </form>



                        <h3>Client Feedbacks section</h3><?php $feedbacks = get_section_data('feedback_section'); ?>
                        <form class="edit-landing" id="feedbacks_section_form" enctype="multipart/form-data">
                            <input name="csrf_token" type="hidden" value="<?php echo $CSFR_token; ?>" />

                            <div class="inline gap2">
                                <div class="inline-block">
                                    <label for="feedback_section_name">Displayed section name</label>
                                    <input id="feedback_section_name" type="text" name="displayed_feedback_section_name" value="<?php echo $feedbacks['displayed_feedback_section_name'] ?>" placeholder="Displayed name" required>
                                </div>
                                <div class="inline-block">
                                    <label for="count_feedback_blocks">Count feedback blocks displayed (n-random)</label>
                                    <input id="count_feedback_blocks" type="number" name="count_feedback_blocks" value="<?php echo $feedbacks['count_feedback_blocks'] ?>" min="2" max="10" placeholder="Count" required>
                                </div>
                            </div>

                            <h4>Colors setings</h4>

                            <div class="inline gap2">
                                <div class="inline-block">
                                    <label for="background_color">Background color</label>
                                    <input id="background_color" type="color" name="background_color" value="<?php echo $feedbacks['background_color'] ?>" placeholder="background_color" required>
                                </div>
                                <div class="inline-block">
                                    <label for="feedback_background_color">Feedback background color</label>
                                    <input id="feedback_background_color" type="color" name="feedback_background_color" value="<?php echo $feedbacks['feedback_background_color'] ?>" placeholder="feedback_background_color" required>
                                </div>
                            </div>
                            <div class="inline gap1 inline-right">
                                <button type="submit"><i class="fa-regular fa-floppy-disk"></i></button>
                            </div>
                            <div class="inline gap1 inline-right">
                               <a href="feedbacks_setting.php" class="edit">Edit feedbacks <i class="fa-solid fa-pen-to-square"></i></a>
                            </div>
                        </form>

                        

                        <h3>Footer section</h3><?php $feedbacks = get_section_data('footer_section'); ?>
                        <form class="edit-landing" id="footer_section_form">
                            <input name="csrf_token" type="hidden" value="<?php echo $CSFR_token; ?>" />

                            <div class="inline gap2">
                                <div class="inline-block">
                                    <label for="footer_company_name">Company name</label>
                                    <input id="footer_company_name" type="text" name="displayed_footer_company_name" value="<?php echo $feedbacks['company_name'] ?>" placeholder="Company name" required>
                                </div>
                                <div class="inline-block">
                                    <label for="rights_text">Rights text</label>
                                    <input id="rights_text" type="text" name="rights_text" value="<?php echo $feedbacks['rights_text'] ?>" placeholder="Rights text" required>
                                </div>
                            </div>
                            <div class="inline gap2">
                                <div class="inline-block">
                                    <label for="background_footer_color">Background color</label>
                                    <input id="background_footer_color" type="color" name="background_footer_color" value="<?php echo $feedbacks['background_color'] ?>" placeholder="background_footer_color" required>
                                </div>
                                <div class="inline-block">
                                    <label for="footer_text_color">Text color</label>
                                    <input id="footer_text_color" type="color" name="footer_text_color" value="<?php echo $feedbacks['text_color'] ?>" placeholder="footer_text_color" required>
                                </div>
                            </div>

                            <div class="inline gap1 inline-right">
                                <button type="submit"><i class="fa-regular fa-floppy-disk"></i></button>
                            </div>
                        </form>

                        <?php

                        break;

                    case 'applications':
                        $entries_on_page = 10;
                        $new_applications = false;
                        $page_num = 1;

                        if(isset($_GET['entries_on_page'])) 
                        {
                            $entries_on_page = $_GET['entries_on_page'];
                        }
                        if(isset($_GET['new_applications']))
                        {
                            $new_applications = $_GET['new_applications'];
                        }
                        ?> 
                            <div class="applications">
                                <form class="filter">
                                    <input type="hidden" name="page" value="applications">
                                    <div>
                                        <div>
                                            <label for="entries_on_page">Entries on page: </label>
                                            <select name="entries_on_page" id="entries_on_page">
                                                <option value="10" <?php echo ($entries_on_page == 10) ? 'selected' : '' ?>>10</option>
                                                <option value="25" <?php echo ($entries_on_page == 25) ? 'selected' : '' ?>>25</option>
                                                <option value="50" <?php echo ($entries_on_page == 50) ? 'selected' : '' ?>>50</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="new">Only new application</label>
                                            <input type="checkbox" id="new" name="new_applications" value="true" <?php echo ($new_applications) ? 'checked' : '' ?>>
                                        </div>
                                    </div>
                                    <button type="submit">Apply</button>
                                </form>
                            <?php
                            if(isset($_GET['page_num'])) {
                                $page_num = $_GET['page_num'];
                            }

                            echo get_applications($entries_on_page, $new_applications, $page_num, $entries_on_page);
                            
                            ?>
                            </div>
                        <?php


                        
                        break;

                    case 'history':
                        
                        if(get_user_role() != "admin") {
                            header("location: home.php");
                        }

                        echo get_history_table();

                        break;

                    case 'logout':
                        log_out();
                        break;
                    
                    default:
                    ?>
                        <div class="temporary">Select a category to work with</div>
                    <?php
                        break;

                }

            ?>
        </div>

        <?php echo get_scripts() ?>
    </body>
</html>

<!-- сделать нормальный вид истории -->