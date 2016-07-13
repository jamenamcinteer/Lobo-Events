<?php

include ('connect.php');


    $regId = array();
    /*$i = 0;
    $result = mysql_query("select * FROM gcm");

    while ($row = mysql_fetch_array($result)) {
        $regId[$i] = $row['reg_id'];
        $i++;
    }*/
    $regId[0] = 'APA91bHrrjbPHcN1-cFFtRoZM33ktJTVP_FJA3RniZwrpOQCqxCmZPpXxuC-89DBkIMlpKTeyTOQ6h26bY-aac81pEsuw8pNtd93iqBwmA0AME_UAYH4pgqdmG4fxXErvpp7dBqAr6S9wT5G4cWxjAPUK8AHRd5l6gQaXmHZKifPF4Cm3QoWJBc';

    include_once './gcm.php';
    $gcm = new GCM();
    $registatoin_ids = $regId;
    $message = array("price" => $_REQUEST['message'], "title" => 'Test Notification');
    $response = $gcm->send_notification($registatoin_ids, $message);
    echo $response;


?>