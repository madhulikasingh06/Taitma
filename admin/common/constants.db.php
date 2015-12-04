<?php
    // Database credentials
//     define('DB_HOST', 'localhost');
//     define('DB_USER', 'root');
//     define('DB_PASS', 'root');
//     define('DB_NAME', 'taitma_db');
    
        // Database credentials
    define('DB_HOST', 'localhost');
    define('DB_USER', 'taitmacl_admin');
    define('DB_PASS', 'tait@123');
    define('DB_NAME', 'taitmacl_taitma');

    //Sps
    define('registerNewMember' , 'RegisterNewMemeber');


    //SQLs
    define('getUsefulLinks', 'SELECT * from Useful_links');

    define('getMembersCategories' , 'SELECT * from Members_Categories');
    define('getMemebersType','SELECT * from Members_Type');
    define("getAllMembers", "SELECT serial_no,email,contact_person,company_name FROM Members_Profile");
    define("getUnapprovedMembers", "SELECT * FROM Members_Profile where serial_no IN (SELECT serial_no from Member_Verification_Status WHERE Verification_Status =1)");
    define("getUnapprovedMemberDetails", "SELECT * FROM Members_Profile where serial_no=");
    define("getUnapprovedMembersCount", "SELECT serial_no FROM Members_Profile where serial_no IN (SELECT serial_no from Member_Verification_Status WHERE Verification_Status =1)");

    define("getLimitedMembers", "SELECT * FROM Members_Profile");
    define("getMembersCount", "SELECT serial_no FROM Members_Profile");

    define("searchMemberWithSerialNo", "SELECT * FROM `Members_Profile` where membership_no like ");
    define("getMemberWithSerialNoCount", "SELECT serial_no FROM `Members_Profile` where membership_no like ");


    define("searchMemberWithEmail", "SELECT * FROM `Members_Profile` where email like ");
    define("getMemberWithEmailCount", "SELECT serial_no FROM `Members_Profile` where email like ");


    define("searchMemberWithContactPerson", "SELECT * FROM `Members_Profile` where contact_person like ");
    define("getMemberWithContactPersonCount", "SELECT serial_no FROM `Members_Profile` where contact_person like ");


    define("searchMemberWithCompany", "SELECT * FROM `Members_Profile` where company_name like ");
    define("getMemberWithCompanyCount", "SELECT serial_no FROM `Members_Profile` where company_name like ");

    define("getMemberStatus", "SELECT verification_status_desc from Verification_Status where Verification_status = (SELECT verification_status from Member_Verification_Status where serial_no =?)");
    
    
    define('getNewsAndEvents',"SELECT * FROM News_And_Notices where article_type='news'");
    define('getNewsAndEventsWithID','SELECT * FROM News_And_Notices where ID =');
    define('getNotices',"SELECT * FROM News_And_Notices where article_type='notice'");

    define('getBanners', "SELECT * FROM Banners ORDER By Image_order ASC");
    define('getBannerWithID','SELECT * FROM Banners where ID =');

    define("getFooterImages", "SELECT * From Banners WHERE enabled=1 ORDER By Image_order ASC LIMIT 8;")






		
?>