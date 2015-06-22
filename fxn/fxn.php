<?php
define("DB_SERVER", "dbserver");
define("DB_USER", "dbuser");
define("DB_PASS", "dbpass");
define("DB_NAME", "dbname");

//FUNCTION TO INITIALIZE A DB CONNECTION. ACTUAL DB CREDENTIALS MUST BE DEFINED SEPARATELY
function getDBConnection() {
    return new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
}

//USEFUL FUNCTION TO GRAB A ROW FROM DB
function getRowQuery($query) {
    $conn = getDBConnection();
    $result = $conn->query($query);
    return $result->fetch_assoc();
}

//USEFUL FUNCTION TO GRAB MULTIPLE ROWS FROM DB
function getRowsQuery($query) {
    $data = array();
    $conn = getDBConnection();
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

//IDEAL FOR SINGLE-ACTION QUERIES TO BE EXECUTED, BECAUSE IT RETURNS THE AFFECTED ROWS(RETURN VALUE '1' IS IDEAL)
function actionQuery($query) {
    $conn = getDBConnection();
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $conn->affected_rows;
}