<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

$data = json_decode(file_get_contents('php://input'), true);

$message = $data["message"];

$host = "localhost:3306";
$username = "musicdb";
$password = "tAcg4a28yZsW";

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

if (str_starts_with($message, "add:")) {
    $message = str_replace("add:", "", $message);

    $splitMessage = explode("|||", $message);
    
    $title = $splitMessage[0];
    $link = $splitMessage[1];
    $uuid = $splitMessage[2];
    $votes = $splitMessage[3];
    $addedOn = $splitMessage[4];
    $playedAlready = $splitMessage[5];
    $canPlay = $splitMessage[6];

    $sql = "INSERT INTO `music`(`ID`, `Title`, `Link`, `Uuid`, `Votes`, `AddedOn`, `PlayedAlready`, `CanPlay`) VALUES (uuid(),\'$title\',\'$link\',\'$uuid\',\'$votes\',\'$added\',\'$playedAlready\',\'$canPlay\');";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: $conn->error";
    }
}
