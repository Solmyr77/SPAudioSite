<?php
if (isset ($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset ($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset ($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit (0);
}

$host = "mysql.nethely.hu:3306";
$username = "musicdb";
$password = "tAcg4a28yZsW";
$database = "musicdb";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die ("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $message = $data["message"];

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

        $sql = "INSERT INTO `music`(`ID`, `Title`, `Link`, `Uuid`, `Votes`, `AddedOn`, `PlayedAlready`, `CanPlay`) VALUES (uuid(), '$title', '$link', '$uuid', '$votes', '$addedOn', '$playedAlready', '$canPlay')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $conn->error;
        }
    }
    if (str_starts_with($message, "upvote:")) {
        $message = str_replace("upvote:", "", $message);

        $message = explode("|||", $message);

        $sql = "UPDATE `music` SET `Uuid`= CONCAT(`Uuid`, '|||$message[1]'), `Votes`= `Votes` + 1 WHERE `ID` = '$message[0]';";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM music";

    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $data = array();

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            echo "0 results";
        }
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();