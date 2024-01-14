<?php 

    require_once ('functions.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ronatsoft</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <div class="root">
        <?php  
        
        $header_data = get_section_custom_data('header_section');
        $logo_data = get_section_custom_data('logo_section');
        $about_us_data = get_section_custom_data('about_us_section');
        $projects_data = get_section_custom_data('our_projects_section');
        $feedbacks_data = get_section_custom_data('feedback_section');
                
        ?>
        <div class="header side-paddings" style="background-color: <?php echo $header_data['header_background_color'] ?>">
            <div class="header-logo">
                <?php if($header_data['logo_type'] == 1 or $header_data['logo_type'] == 2) { ?>
                <h1 class="logo-text">
                    <?php if($header_data['logo_type'] == 1) { ?>
                        <span style="color: <?php echo $header_data['logo_text'] ?>;"><?php echo $header_data['logo_color'] ?></span>
                    <?php } 
                        if($header_data['logo_type'] == 2) {
                    ?>
                        <span class="first-part" style="color: <?php echo $header_data['logo_first_part_color'] ?>;"><?php echo $header_data['logo_first_part_text']; ?></span>
                        <span class="second-part" style="color: <?php echo $header_data['logo_second_part_text'] ?>;"><?php echo $header_data['logo_second_part_text']; ?></span>
                    <?php
                        }
                        
                    ?>

                    
                </h1>
                <?php } 
                
                if($header_data['logo_type'] == 3) {
                    if($header_data['logo_image'] == 1) {
                    ?>
                        <img src="<?php echo "site-images/header-logo.png" ?>" alt="Logo" width="" height="150">
                    <?php
                    } 
                    if($header_data['logo_image'] == 2) {
                    ?>
                        <img src="<?php echo $header_data['logo_image_link'] ?>" alt="Logo" width="" height="150">
                    <?php
                    }
                }

                ?>
            </div>

            <div class="header-menu">
                <button id="menu-toggle" class="menu-toggle"><i class="fa-solid fa-bars"></i></button>

                <ul class="nav">
                    <li>
                        <a href="#our-projects" style="color: <?php echo $header_data['header_text_color'] ?>">Projects</a>
                    </li>
                    <li>
                        <a href="#customer-reviews" style="color: <?php echo $header_data['header_text_color'] ?>">Customers Reviews</a>
                    </li>
                    <li>
                        <a href="#about-us" style="color: <?php echo $header_data['header_text_color'] ?>">About Us</a>
                    </li>
                    <li>
                        <a href="#contsct-us" style="color: <?php echo $header_data['header_text_color'] ?>">Contact Us</a>
                    </li>
                </ul>
                <ul class="nav-socials">
                    <?php if($header_data['soc_link1'] != 0) {
                        $link_data = get_link_data($header_data['soc_link1']);
                        ?>
                            <li>
                                <a href="<?php echo $link_data['link_url'] ?>"  target="_blank">
                                    <i class="<?php echo $link_data['link_icon_class'] ?>" style="color: <?php echo $header_data['header_text_color'] ?>"></i>
                                </a>
                            </li>
                        <?php
                    }                   
                    if($header_data['soc_link2'] != 0) {
                        $link_data = get_link_data($header_data['soc_link2']);
                        ?>
                            <li>
                                <a href="<?php echo $link_data['link_url'] ?>"  target="_blank">
                                    <i class="<?php echo $link_data['link_icon_class'] ?>" style="color: <?php echo $header_data['header_text_color'] ?>"></i>
                                </a>
                            </li>
                        <?php
                    } 
                    if($header_data['soc_link3'] != 0) {
                        $link_data = get_link_data($header_data['soc_link3']);
                        ?>
                            <li>
                                <a href="<?php echo $link_data['link_url'] ?>"  target="_blank">
                                    <i class="<?php echo $link_data['link_icon_class'] ?>" style="color: <?php echo $header_data['header_text_color'] ?>"></i>
                                </a>
                            </li>
                        <?php
                    } ?>
                </ul>

            </div>

        </div>


        <div class="logo-block side-paddings" <?php echo ($logo_data['logo_section_background'] == 1) ? 'style="background-image: url(site-images/logo-background-image.png)"' : '' ?>
        <?php echo ($logo_data['logo_section_background'] == 2) ? 'style="background-image: url(); background-color: '.$logo_data['background_color'].'"' : '' ?>>
            <div>
                <span class="logo-welcome"><?php echo $logo_data['wellcome_text'] ?></span>
                <h1><?php echo $logo_data['company_name'] ?></h1>
                <span class="slogan">
                    <?php echo $logo_data['slogan_text'] ?>
                </span>
            </div>
        </div>


        <div id="about-us" class="about-us side-paddings" <?php echo 'style="background-color: '.$about_us_data['about_us_background_color'].'"' ?>>
            <div class="about-us-text" <?php  ?>>
                <h1 <?php echo 'style="color: '.$about_us_data['about_us_text_color'].'"' ?>><?php echo $about_us_data['displayed_about_section_name'] ?></h1>
                <p class="p1" <?php echo 'style="color: '.$about_us_data['about_us_text_color'].'"' ?>><?php echo $about_us_data['paragraph1'] ?></p>
                <p class="p2" <?php echo 'style="color: '.$about_us_data['about_us_text_color'].'"' ?>><?php echo $about_us_data['paragraph2'] ?></p>
            </div>
            <div class="about-us-image">
                <?php  
                
                if($about_us_data['image_set'] == 'true') {
                    switch ($about_us_data['about_us_image_type']) {
                        case '1':
                            ?>
                                <img src="<?php echo "site-images/about-us-image.png" ?>" alt="about-us-image">
                            <?php
                            break;
                        case '2':
                            ?>
                                <img src="<?php echo $about_us_data['about_us_image_link'] ?>" alt="about-us-image">
                            <?php
                            break;
                        default:
                            echo '';
                            break;
                    }
                }
                
                ?>

            </div>
        </div>


        <div id="our-projects" class="our-projects side-paddings" style="
            background: -webkit-linear-gradient(225deg, <?php echo $projects_data['from_color_gradient'] ?> 19%, <?php echo $projects_data['to_color_gradient'] ?> 100%);
            background: -moz-linear-gradient(225deg, <?php echo $projects_data['from_color_gradient'] ?> 19%, <?php echo $projects_data['to_color_gradient'] ?> 100%);
            background: linear-gradient(225deg, <?php echo $projects_data['from_color_gradient'] ?> 19%, <?php echo $projects_data['to_color_gradient'] ?> 100%);
        ">
            <h1><?php echo $projects_data['displayed_projects_section_name'] ?></h1>
            <div class="wrapper">
                <?php echo get_projects($projects_data['count_projects_blocks']) ?>
            </div>
        </div>


        <div id="customer-reviews" class="feedbacks side-paddings" style="color: <?php echo $feedbacks_data['background_color'] ?>">
            <h1><?php echo $feedbacks_data['displayed_feedback_section_name'] ?></h1>
            <div class="feedbacks-block">
                <?php
                
                echo get_feedback($feedbacks_data['count_feedback_blocks'], $feedbacks_data['background_color'], $feedbacks_data['feedback_background_color'])
                
                ?>
            </div>
        </div>


        <div id="contsct-us" class="contact-us side-paddings">
            <h1>Contact Us</h1>
            <form id="client-application">
                <input name="csrf_token" type="hidden" value="<?php echo generate_CSRF_form_token(); ?>">



                <div class="form-horisontal">
                    <div class="fields-part">

                        <div class="input-block">
                            <label for="first_name">First Name *</label>
                            <input id="first_name" type="text" name="first_name" placeholder="Your name" required>
                        </div>
                        <div class="input-block">
                            <label for="second_name">Second Name</label>
                            <input id="second_name" type="text" name="second_name" placeholder="Your surname">
                        </div>
                        <div class="input-block">
                            <label for="email">Email Addres *</label>
                            <input id="email" type="email" name="email" placeholder="Your email address" required>
                        </div>                        

                    </div>
                    <div class="fields-part">

                        <div class="input-block">
                            <label for="tel">Tel</label>
                            <input id="tel" type="tel" name="tel" placeholder="Your phone number">
                        </div>
                        <div class="input-block">
                            <label for="country">Country</label>
                            <input id="country" type="text" name="country" placeholder="Your country">
                        </div>
                        <div class="input-block">
                            <label for="company">Company</label>
                            <input id="company" type="text" name="company" placeholder="Your company">
                        </div> 

                    </div>
                </div>
                <div class="user-message">
                    <label for="message">Your message *</label>
                    <textarea name="message" id="message" cols="30" rows="10" placeholder="Enter your message" required></textarea>
                </div>
                <div>
                    <input type="submit" value="Send Application">
                </div>
                
            </from>
        </div>
        <div class="footer side-paddings">
            <h1>Ronatsoft</h1>
            <p>All rights Reserved</p>
        </div>






    </div>
    <?php echo get_scripts() ?>
</body>
</html>