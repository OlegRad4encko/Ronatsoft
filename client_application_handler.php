<?php 


    require_once ('functions.php');

    if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
    {
        echo build_form_info_block('Form submission error. Please update the page.', 'error');
        exit;
    }

    if(!isset($_POST['first_name']) || !isset($_POST['email']) || !isset($_POST['message'])) 
    {
        echo build_form_info_block('Please fill in all required fields.', 'error');
        exit;
    }

    if(empty(trim($_POST['first_name'])) || empty(trim($_POST['email'])) || empty(trim($_POST['message']))) {
        echo build_form_info_block('Please fill in all required fields.', 'error');
        exit;
    }

    if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo build_form_info_block('Please fill in correct email address.', 'error');
        exit;
    }

    $first_name = findXSS($_POST['first_name']);
    $second_name = (isset($_POST['second_name'])) ? findXSS($_POST['second_name']) : '';
    $email = findXSS($_POST['email']);
    $tel = (isset($_POST['tel'])) ? findXSS($_POST['tel']) : '';
    $country = (isset($_POST['country'])) ? findXSS($_POST['country']) : '';
    $company = (isset($_POST['company'])) ? findXSS($_POST['company']) : '';
    $message = findXSS($_POST['message']);

    $db->query("INSERT INTO `applications`
        (`app_user_first_name`, 
        `app_user_second_name`, 
        `app_user_mail`, 
        `app_user_tel`, 
        `app_user_country`, 
        `app_user_company`, 
        `app_user_message`) 
        VALUES (:first_name, :second_name, :email, 
        :tel, :country, :company, :u_message)", [
            'first_name' => $first_name,
            'second_name' => $second_name,
            'email' => $email,
            'tel' => $tel,
            'country' => $country,
            'company' => $company,
            'u_message' => $message
        ]);

    echo build_form_info_block('Your application has been sent', 'success');
    exit;

?>