<?php 
include_once "config.php";
include_once "includes/ociConn.php";
include_once "includes/dbconn.php";
include_once "module/module_dpis/class-dpis.php";

    $dpis = new dpis;
    
    $arrPer_cardno = $dpis->queryPer_cardno(2343);
    echo "<pre>";
    print_r($arrPer_cardno);
 echo "</pre>";
    $dpis->ociClose();

    // echo json_encode($arrPer_cardno['result'][0]);


// var arrPer_cardno2 = ["1809700157271",
//                             "3860101000089",
//                             "3170100217471",
//                             "1102001359869",
//                             "3669900005227",
//                             "1100500395681",
//                             "3102101418588",
//                             "1929900310462",
//                             "3800100068518",
//                             "3809700119804",
//                             "3700700489078",
//                             "5930200003197",
//                             "3939900061876",
//                             "3801200567274",
//                             "3120600753861",
//                             "3600400044250",
//                             "3649900169530",
//                             "3930100920019",
//                             "1809900196393",
//                             "3930600196611",
//                             "3801400272081",
//                             "3900100014697",
//                             "3900900026436",
//                             "3801200567291",
//                             "3729900020543",
//                             "3120600144686",
//                             "4120600005668",
//                             "3939900255689",
//                             "5300690021923",
//                             "3659900041843",
//                             "3930500344724",
//                             "3809900677967",
//                             "3102100495236",
//                             "3960200411817",
//                             "3191100618329",
//                             "3919900128091",
//                             "3469900035501",
//                             "1809700157271",
// "3860101000089",
// "3170100217471",
// "1102001359869",
// "3669900005227",
// "1100500395681",
// "3102101418588",
// "1929900310462",
// "3800100068518",
// "3809700119804",
// "3700700489078",
// "5930200003197",
// "3939900061876",
// "3801200567274",
// "3120600753861",
// "3600400044250",
// "3649900169530",
// "3930100920019",
// "1809900196393",
// "3930600196611",
// "3801400272081",
// "3900100014697",
// "3900900026436",
// "3801200567291",
// "3729900020543",
// "3120600144686",
// "4120600005668",
// "3939900255689",
// "5300690021923",
// "3659900041843",
// "3930500344724",
// "3809900677967",
// "3102100495236",
// "3960200411817",
// "3191100618329",
// "3919900128091",
// "3469900035501",
// "1809700157271",
// "3860101000089",
// "3170100217471",
// "1102001359869",
// "3669900005227",
// "1100500395681",
// "3102101418588",
// "1929900310462",
// "3800100068518",
// "3809700119804",
// "3700700489078",
// "5930200003197",
// "3939900061876",
// "3801200567274",
// "3120600753861",
// "3600400044250",
// "3649900169530",
// "3930100920019",
// "1809900196393",
// "3930600196611",
// "3801400272081",
// "3900100014697",
// "3900900026436",
// "3801200567291",
// "3729900020543",
// "3120600144686",
// "4120600005668",
// "3939900255689",
// "5300690021923",
// "3659900041843",
// "3930500344724",
// "3809900677967",
// "3102100495236",
// "3960200411817",
// "3191100618329",
// "3919900128091",
// "3469900035501"]