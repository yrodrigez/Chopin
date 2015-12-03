<?php
// file: setup.php

$sqlFile = 'db.sql';
$host = "127.0.0.1"; //$_POST["host"];
$user = "root"; //$_POST["user"];
$password = ""; //$_POST["password"];

public function importSQL($sqlFile, $host, $user, $password) {
    $link = mysqli_connect($host, $user, $password);
    if (mysqli_connect_errno()) die ("MySQL Connection error");

    $sqlErrorCode = "";

// read the sql file
    $f = fopen($sqlFile,"r+");
    $sqlFile = fread($f, filesize($sqlFile));
    $sqlArray = explode(';',$sqlFile);
    foreach ($sqlArray as $stmt) {
        if (strlen($stmt)>3 && substr(ltrim($stmt),0,2)!='/*') {
            $result = mysqli_query($link, $stmt);
            if (!$result) {
                $sqlErrorCode = mysqli_errno($link);
                $sqlErrorText = mysqli_error($link);
                $sqlStmt = $stmt;
                break;
            }
        }
    }
}

?>