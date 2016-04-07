<?php
    // Database credentials
    define('DB_HOST', 'localhost');
    define('DB_USER', 'taitmacl_admin');
    define('DB_PASS', 'tait@123');
    define('DB_NAME', 'taitmacl_taitma');

    //Sps
    define('getUsefulLinks', 'GetUsefulLinks()');
    define('registerNewMember' , 'RegisterNewMemeber');


    //SQLs
    define('getMembersCategories' , 'select * from Members_Categories');
    define('getMemebersType','select * from Members_Type');
    define('getNewsAndEventsForMemberType',"SELECT * FROM News_And_Notices where article_type='news' and enabled=1 and (premium_val = ");
    define('getNewsAndEventsWithID','SELECT * FROM News_And_Notices where ID =');

    define('getUsefulLinksForMemberType', "SELECT *  FROM Useful_links where enabled=1  and (premium_val = ");

    define("memberTypeRegular", "0)");
    define("memberTypePremium", "0 or 1)");

    define('getNoticeForMemberType',"SELECT * FROM News_And_Notices where article_type='notice' and enabled=1 and (premium_val = ");

    // define("getFooterImages", "SELECT * From Banners WHERE enabled=1 ORDER By Image_order ASC LIMIT 8;")

    define("getFooterImages", "SELECT * From Banners WHERE enabled=1 ORDER By RAND() ASC LIMIT 7;");

    define("getLimitedMembers", "SELECT * FROM Members_Profile");
    define("getMembersCount", "SELECT serial_no FROM Members_Profile");

    define("getMemberStatus", "SELECT verification_status_desc from Verification_Status where Verification_status = (SELECT verification_status from Member_Verification_Status where serial_no =?)");

    


		
?>