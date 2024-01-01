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

        <div class="header side-paddings">
            <div class="header-logo">
                <h1 class="logo-text">
                    <span class="first-part">Ronat</span>
                    <span class="second-part">soft</span>
                </h1>
            </div>

            <div class="header-menu">
                <button id="menu-toggle" class="menu-toggle"><i class="fa-solid fa-bars"></i></button>

                <ul class="nav">
                    <li>
                        <a href="#our-projects">Projects</a>
                    </li>
                    <li>
                        <a href="#customer-reviews">Customers Reviews</a>
                    </li>
                    <li>
                        <a href="#about-us">About Us</a>
                    </li>
                    <li>
                        <a href="#contsct-us">Contact Us</a>
                    </li>
                </ul>
                <ul class="nav-socials">
                    <li>
                        <a href="">
                            <i class="fa-brands fa-telegram"></i>
                        </a>
                   </li>
                   <li>
                        <a href="">
                            <i class="fa-brands fa-telegram"></i>
                        </a>
                   </li>
                   <li>
                        <a href="">
                            <i class="fa-brands fa-telegram"></i>
                        </a>
                   </li>
                </ul>

            </div>

        </div>

        <div class="logo-block side-paddings">

            <div>
                <span class="logo-welcome">welcome to</span>
                <h1>Ronatsoft</h1>
                <span class="slogan">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor est risus, eu egestas orci condimentum eu.
                </span>
            </div>

        </div>

        <div id="about-us" class="about-us side-paddings">
            <div class="about-us-text">
                <h1>About Us</h1>
                <p class="p1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor est risus, eu egestas orci condimentum eu. Phasellus lobortis nec orci quis scelerisque. Aenean elementum tortor a augue luctus sodales.</p>
                <p class="p2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor est risus, eu egestas orci condimentum eu. Phasellus lobortis nec orci quis scelerisque. Aenean elementum tortor a augue luctus sodales. Duis at odio quis velit finibus tristique nec non felis. Vestibulum quis massa at ligula hendrerit bibendum. Cras ultrices libero faucibus turpis vehicula consectetur sit amet id enim. Integer ut fermentum elit. Morbi gravida elit eu vulputate eleifend.</p>
            </div>
            <div>
                <!-- maybe images here -->
            </div>
        </div>

        <div id="our-projects" class="our-projects side-paddings">
            <h1>Our projects</h1>
            <div class="wrapper">
                <a class="element" href="#">
                    <img src="assets/images/atomic.png">
                </a>
                <a class="element" href="#">
                    <img src="assets/images/social.png">
                </a>
                <a class="element" href="#">
                    <img src="assets/images/twitter.png">
                </a>
            </div>

        </div>

        <div id="customer-reviews" class="feedbacks side-paddings">
            <h1>Client Feedbacks</h1>
            <div class="feedbacks-block">


                <div class="feedback left">
                    <div class="client-info">
                        <div class="client-image">
                            <img src="assets/images/clients/client_example.jpg" alt="">

                        </div>
                        <div class="client-name-position">
                            <span>Name Surname</span>
                            <span>New customer</span>
                            <span>01\01\2023</span>
                        </div>
                    </div>
                    <div class="client-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque vulputate urna vitae odio rutrum porta. Donec sed dui justo. Mauris faucibus sodales suscipit. Vivamus accumsan pulvinar metus eu pellentesque. Phasellus dictum nisi lectus, vitae molestie erat tristique a. Nam gravida sed eros sit amet vulputate. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Integer placerat neque et quam ornare placerat. Praesent mauris turpis, condimentum pharetra erat at, faucibus tincidunt diam. Donec dignissim velit nec augue imperdiet, nec ultrices elit lacinia. Curabitur augue magna, malesuada at turpis et, porta ullamcorper odio. Vestibulum viverra nisi ut vulputate feugiat.
                    </div>
                </div>


                <div class="feedback right">
                    <div class="client-info">
                        <div class="client-image">
                            <!-- <img src="" alt=""> -->

                            <!-- default -->
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="client-name-position">
                            <span>Name Surname</span>
                            <span>New customer</span>
                            <span>01\01\2023</span>
                        </div>
                    </div>
                    <div class="client-text">
                        Lorem ipsum dolor sit amet
                    </div>
                </div>

                <div class="feedback left">
                    <div class="client-info">
                        <div class="client-image">
                            <img src="assets/images/clients/client_example.jpg" alt="">

                        </div>
                        <div class="client-name-position">
                            <span>Name Surname</span>
                            <span>New customer</span>
                            <span>01\01\2023</span>
                        </div>
                    </div>
                    <div class="client-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque vulputate urna vitae odio rutrum porta. Donec sed dui justo. 
                    </div>
                </div>

                <div class="feedback right">
                    <div class="client-info">
                        <div class="client-image">
                            <!-- <img src="" alt=""> -->

                            <!-- default -->
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="client-name-position">
                            <span>Name Surname</span>
                            <span>New customer</span>
                            <span>01\01\2023</span>
                        </div>
                    </div>
                    <div class="client-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque vulputate urna vitae odio rutrum porta. Donec sed dui justo. 
                    </div>
                </div>


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