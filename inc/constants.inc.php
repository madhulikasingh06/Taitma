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

DEFINE("MSG_ACCOUNT_VERIFIED_SUCCESS","Your account is verified. Please log in to continue.");
define("ERR_ACCOUNT_ALREADY_VERIFIED", "Your account is already verified.Please log in to continue");
define("ERR_ACCOUNT_VERIFIED_FAILED", "Your account could not be verified.");

define("MSG_ACCOUNT_REGISTRATION_SUCCESS", "Your registration was successful. <br/>We've sent you a verification link to your email.Please verify your account!");
define("ERR_ACCOUNT_REGISTRATION_FAILED", "There was some error processing your request.Your registration was not successful. Please try again.");

define("ERR_ACCOUNT_LOGIN_FAILED","Your id or password is incorrect. Please try again.");
define("ERR_ACCOUNT_LOGIN_UNVERIFIED","Your account is not verified. Please verify your account before logging in.");
define("MSG_ACCOUNT_LOGIN_SUCCESS","Logged in successfully.");









		
?>