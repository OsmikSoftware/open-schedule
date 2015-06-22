<?php
//require functions file
require 'fxn/fxn.php';

$response = array();
if(isset($_GET['load_requests'])){
    switch($_GET['load_requests']){
        case "all":
            $response['data'] = getRowsQuery("SELECT * FROM requests");
            break;
        default:
            $response['data'] = getRowsQuery("SELECT * FROM requests");
            break;
    }
}
header('Content-type: application/json');
echo json_encode($response);