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
                           <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50">
                               <path d="M25,2c12.703,0,23,10.297,23,23S37.703,48,25,48S2,37.703,2,25S12.297,2,25,2z M32.934,34.375	c0.423-1.298,2.405-14.234,2.65-16.783c0.074-0.772-0.17-1.285-0.648-1.514c-0.578-0.278-1.434-0.139-2.427,0.219	c-1.362,0.491-18.774,7.884-19.78,8.312c-0.954,0.405-1.856,0.847-1.856,1.487c0,0.45,0.267,0.703,1.003,0.966	c0.766,0.273,2.695,0.858,3.834,1.172c1.097,0.303,2.346,0.04,3.046-0.395c0.742-0.461,9.305-6.191,9.92-6.693	c0.614-0.502,1.104,0.141,0.602,0.644c-0.502,0.502-6.38,6.207-7.155,6.997c-0.941,0.959-0.273,1.953,0.358,2.351	c0.721,0.454,5.906,3.932,6.687,4.49c0.781,0.558,1.573,0.811,2.298,0.811C32.191,36.439,32.573,35.484,32.934,34.375z"></path>
                           </svg>
                       </a>
                   </li>
                   <li>
                       <a href="">
                           <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50">
                               <path d="M 16 3 C 8.8324839 3 3 8.8324839 3 16 L 3 34 C 3 41.167516 8.8324839 47 16 47 L 34 47 C 41.167516 47 47 41.167516 47 34 L 47 16 C 47 8.8324839 41.167516 3 34 3 L 16 3 z M 16 5 L 34 5 C 40.086484 5 45 9.9135161 45 16 L 45 34 C 45 40.086484 40.086484 45 34 45 L 16 45 C 9.9135161 45 5 40.086484 5 34 L 5 16 C 5 9.9135161 9.9135161 5 16 5 z M 37 11 A 2 2 0 0 0 35 13 A 2 2 0 0 0 37 15 A 2 2 0 0 0 39 13 A 2 2 0 0 0 37 11 z M 25 14 C 18.936712 14 14 18.936712 14 25 C 14 31.063288 18.936712 36 25 36 C 31.063288 36 36 31.063288 36 25 C 36 18.936712 31.063288 14 25 14 z M 25 16 C 29.982407 16 34 20.017593 34 25 C 34 29.982407 29.982407 34 25 34 C 20.017593 34 16 29.982407 16 25 C 16 20.017593 20.017593 16 25 16 z"></path>
                           </svg>
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