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
    define('getNewsAndEventsForMemberType',"SELECT * FROM News_And_Notices where article_type='news' and enabled=1 and premium_val = ");
    define('getNewsAndEventsWithID','SELECT * FROM News_And_Notices where ID =');

    define('getUsefulLinksForMemberType', "SELECT *  FROM Useful_links where enabled=1  and premium_val = ");

    define("memberTypeRegular", "0");
    define("memberTypePremium", "0 or 1");

    define('getNoticeForMemberType',"SELECT * FROM News_And_Notices where article_type='notice' and enabled=1 and premium_val = ");

    


		
?>