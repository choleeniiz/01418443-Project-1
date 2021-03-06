<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "webtech";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM event;"); 
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($events as $event) {
        $stmt = $conn->prepare("SELECT path FROM picture WHERE event_id=".$event->id); 
        $stmt->execute();
        $pictures = $stmt->fetchAll(PDO::FETCH_OBJ);
        $event->pictures = array();
        if ($pictures !== FALSE) {
            $event->pictures = $pictures;
        }
    }

    echo json_encode($events);
}
catch(PDOException $e) {
    echo "[]";
}
?>