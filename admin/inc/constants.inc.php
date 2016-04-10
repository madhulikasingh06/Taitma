<?php

define("SUCCESS", 0);
define("ERROR", 1);

// DEFINE ERRORS
define( "ERR_EMAIL_REQUIRED", "Please enter an email.");
define( "ERR_EMAIL_INVALID", "Please enter a valid email address.");
define( "ERR_EMAIL_EXISTS", "A member with this email already exists.Please enter another email.");

define( "ERR_PASSWORD_REQUIRED", "Please enter a password.");
define( "ERR_PASSWORD_INVALID", "Please enter a valid password.");
define( "ERR_PASSWORD_LENGTH", "Please enter a password of minimum length 6.");

define( "ERR__CONFIRM_PASSWORD_REQUIRED", "Please confirm your password.");
define( "ERR_CONFIRM_PASSWORD_INVALID", "Please enter a valid confrim password.");

define("ERR_PASS_NO_MATCH", "Password and Confirm password do not match.");

define("ERR_COMPANY_REQUIRED", "Please enter a Company Name.");

define("ERR_ADDRESS1_REQUIRED", "Please enter Address 1.");
define("ERR_CITY_REQUIRED", "Please enter a City.");
define("ERR_PINCODE_REQUIRED", "Please enter a Pincode.");
define("ERR_PINCODE_INVALID", "Please enter a valid Pincode.");
define("ERR_STATE_REQUIRED", "Please enter a State.");
define("ERR_PHONE_REQUIRED", "Please enter a Phone Number.");
define("ERR_PHONE_INVALID", "Please enter a valid Phone Number.");
define("ERR_MOBILE_INVALID", "Please enter a valid Mobile Number.");
define("ERR_MOBILE_LENGTH", "Please enter a valid 10 digit Mobile Number.");
define("ERR_WEBSITE_INVALID", "Please enter a valid Website URL.");
define("ERR_REGION_REQUIRED", "Please choose a Region.");
define("ERR_CATEGORY_REQUIRED", "Please choose a Category.");
define("ERR_MEMBER_TYPE_REQUIRED", "Please choose a Member type.");
define("ERR_DOC_INVALID_SIZE", "Please upload a file of maximum size 1MB.");
define("ERR_DOC_2_INVALID", ".");

// define("ERR_", ".");
// define("ERR_", ".");
// define("ERR_", ".");
// define("ERR_", ".");
// define("ERR_", ".");
// define("ERR_", ".");
// define("ERR_", ".");

define("MSG_ACCOUNT_VERIFIED_SUCCESS","Your account is verified. Please log in to continue.");
define("ERR_ACCOUNT_ALREADY_VERIFIED", "Your account is already verified.Please log in to continue");
define("ERR_ACCOUNT_VERIFIED_FAILED", "Your account could not be verified.");

define("MSG_ACCOUNT_REGISTRATION_SUCCESS", "Your registration was successful. <br/>We've sent you a verification link to your email.Please verify your account!");
define("ERR_ACCOUNT_REGISTRATION_FAILED", "There was some error processing your request.Your registration was not successful. Please try again.");

define("ERR_ACCOUNT_LOGIN_FAILED","Your Username or password is incorrect. Please try again.");
define("ERR_ACCOUNT_LOGIN_UNVERIFIED","Your account is not verified. Please verify your account before logging in.");
define("MSG_ACCOUNT_LOGIN_SUCCESS","Logged in successfully.");
define("ERR_ACCOUNT_ADMIN_LOGIN_FAILED","Your are not authorized to view this page.");



define("EMAIL_VERIFICAITON_SUBJECT","[TAITMA]- Email verification.");

define("EMAILID_FROM", "donotreply@taitma.cleari.in");
define("EMAIL_FROM", "TAITMA");
define("SMTP_SERVER", "taitma.cleari.in");
define("SMTP_PORT", 587);
define("SMTP_USER","taitmacl");
define("SMTP_PASSWORD","tait@123");

define("MSG_ADMIN_APPROVAL_PENDING", "Your account approval is pending.");
define('MSG_ACCOUNT_EDIT_PROFILE_SUCCESS', 'Your account is successfully updated.');
define("ERR_ACCOUNT_EDIT_PROFILE", "Your account could not be updated. Please try again.");
define("ERR_ACCOUNT_EDIT_FORM_VAL_FAILED", "There is some error in the form! Please check and Submit again.");

define("INACTIVE_DURATION", 1200);

define("MEMBER_FILE_UPLOAD_FOLDER", "../MembersFiles/");


// Admin constants

define("ERR_MEMBERSHIP_NO_REQUIRED", "Please Enter a Membership number.");

define("RECORDS_PER_PAGE", 50);
define("MEMBER_SERIAL_NO", "1");
define("MEMBER_EMAIL", 2);
define("CONTACT_PERSON", 3);
define("COMPANY", 4);
define("UNAPPROVED", 5);

define("NO_SEARCH_RESULT", "No matching Members were found with the search criteria you have given.<br>Please check the search criteria and try again.");

define("ACTION_DELETE","d");
define("ACTION_UPDATE", "u");
define("ACTION_ADD", 'a');
define("MSG_LINK_UPDATE_SUCCESS","The link was successfully updated.");
define("ERR_LINK_UPDATE_FAILED","There was some error processing your request.The link could not be updated.");

define("MSG_LINK_DELETE_SUCCESS","The link was successfully deleted.");

define("MSG_LINK_ADD_SUCCESS","The link was successfully added.");
define("ERR_LINK_ADD_FAILED","There was some error processing your request.The link could not be added.");

// define("ERR_MEMBERSHIP_NO_REQUIRED", "Please enter a membership number.");

define("ERR_MEMBERSHIPNO_LENGTH", "Please enter a membership number of minimun 8 digits.");
define("ERR_MEMBERSHIPNO_EXISTS", "This membership number already exists.");

define("MEMBER_APPROVED_SUBJECT", "[TAITMA]- Membership approved!");

define("ERR_TITLE_REQUIRED", "Please enter a title.");
define("ERR_CONTENT_REQUIRED", "Please enter the contents.");
define("ERR_DROP_DOWN_REQUIRED", "Please choose a value.");


define("MSG_ACCOUNT_REGISTRATION_BYADMIN_SUCCESS", "The user was successfully created.");
define("ACTION_DELETE_NEWS", "news-del");
define("ACTION_DELETE_BANNER", "banner-del"); 
define("BANNER_FOLDER", "../images/FooterBanners/");

define("PREMIUM_YEARLY_MEMBERSHIP_YEARS", 1);
define("PREMIUM_LIFETIME_MEMBERSHIP_YEARS", 10);

define("PAYMENT_DATE_REQUIRED","Please enter a payment date");
define("MEMBERSHIP_START_DATE_REQUIRED","Please enter a membership start date");
define("MEMBERSHIP_EXPIRY_DATE_REQUIRED","Please enter a membership expiry date");
define("PAYMENT_MODE_REQUIRED","Please enter a payment mode.");
define("PAYMENT_AMOUNT", "Please enter payment amount.");
define("PAYMENT_NUMBER_REQUIRED","Please enter a check/payment number.");
define("PAYMENT_AGAINST", "Please enter payment against details.");
define("MEMBERSHIP_TYPE_REGULAR", 0);
define("MEMBERSHIP_TYPE_YEARLY", 1);
define("MEMBERSHIP_TYPE_LIFETIME", 2);


define("EMAIL_PAYMENT_RECEIVED_SUBJECT","[TAITMA]- Payment Received.");
define("EMAIL_REMINDER_MEMBERSHIP_EXPIRY_SUBJECT","[TAITMA]- Reminder for membership expiry.");
define("MEMBERSHIP_NUMBER_CHANGED_SUBJECT", "[TAITMA]- Membership number updated!");


//Constants for Invoice Creation
define("INVOICE_FOLDER", "admin/Bills/");
// define("INVOICE_FOLDER", "Bills/");
define("PDF_EXTENTION", ".pdf");

define("INVOICE_NAME", "The All India Toy Manufacturers' Association");
define("INVOICE_ADDRESS", "301, Business Park, 18 SV Road, Malad West, Mumbai");
define("INVOICE_CIN", "CIN: U36940MH1976NPL019122");
define("INVOICE_EMAIL", "E-Mail :taitma76@gmail.com");

//taxes  
define("INVOICE_TAX_1_NAME", "Service Tax");
define("INVOICE_TAX_1", 14.5);
define("INVOICE_TAX_2_NAME", "VAT");
define("INVOICE_TAX_2", 5);

define("INVOICE_COMPANY_PAN", "AAAFT0564E");
define("INVOICE_SERVICE_TAX_REG", "AAAFT0564SD001");

//Subject for New message to all the members

define("NEW_MESSAGE_SUBJECT", "[TAITMA]- A new message is posted.");

define("FIRST_REMINDER_DAY", 30);
define("SECOND_REMINDER_DAY", 10);
define("THIRD_REMINDER_DAY", 0);
define("FOURTH_REMINDER_DAY", -5);
define("LAST_REMINDER_DAY", -15);



















		
?>