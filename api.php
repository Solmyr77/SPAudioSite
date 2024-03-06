<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$data = json_decode(file_get_contents('php://input'), true);

class Mail {
    public $headers = "Content-Type: application/json; charset=utf-8";

    public $nev;
    public $email;
    public $telefon;
    public $datum;
    public $helyszin;
    public $letszam;
    public $finalMessage;
    public $dj;
    public $fenyek;
    public $foto;
    public $video;

    function __construct($rawMessage) {
        $splitMessage = explode("|||", $rawMessage);

        $this->nev = $splitMessage[0];
        $this->email = $splitMessage[1];
        $this->telefon = $splitMessage[2];
        $this->datum = $splitMessage[3];
        $this->helyszin = $splitMessage[4];
        $this->letszam = $splitMessage[5];
        $this->dj = $splitMessage[6];
        $this->fenyek = $splitMessage[7];
        $this->foto = $splitMessage[8];
        $this->video = $splitMessage[9];

        $this->finalMessage = "Név: $this->nev\nEmail: $this->email\nTelefon: $this->telefon\nDátum: $this->datum\nHelyszín: $this->helyszin\nLétszám: $this->letszam\nDJ: $this->dj\nFények: $this->fenyek\nFotós: $this->foto\nVideós: $this->video";
    }

    function sendEmail() {
        return mail("hang@spdisco.hu", "SP Audio !FONTOS!", $this->finalMessage, $this->headers);
    }
}

if (isset($data['message'])) {
    $currentMail = new Mail($data['message']);

    if($currentMail->sendEmail()) {
        echo json_encode(['status' => 'success', 'message' => 'Message received and email sent']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send email']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No message received']);
}

?>