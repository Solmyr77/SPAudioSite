<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require_once('PHPMailer.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$data = json_decode(file_get_contents('php://input'), true);

class Mail {
    public $nev;
    public $email;
    public $telefon;
    public $datum;
    public $helyszin;
    public $letszam;
    public $extraReqs;
    public $finalMessage;
    public $sound;
    public $show;
    public $concert;
    public $live;
    public $dj;
    public $fenyek;
    public $foto;
    public $video;
    public $datumASZF;

    function __construct($rawMessage) {
        $splitMessage = explode("|||", $rawMessage);

        $this->nev = $splitMessage[0];
        $this->email = $splitMessage[1];
        $this->telefon = $splitMessage[2];
        $this->datum = $splitMessage[3];
        $this->helyszin = $splitMessage[4];
        $this->letszam = $splitMessage[5];
        $this->extraReqs = $splitMessage[6];
        $this->sound = $splitMessage[7];
        $this->show = $splitMessage[8];
        $this->concert = $splitMessage[9];
        $this->live = $splitMessage[10];
        $this->dj = $splitMessage[11];
        $this->fenyek = $splitMessage[12];
        $this->foto = $splitMessage[13];
        $this->video = $splitMessage[14];
        $this->datumASZF = $splitMessage[15];

        $this->finalMessage = "Név: $this->nev\nEmail: $this->email\nTelefon: $this->telefon\nDátum: $this->datum\nHelyszín: $this->helyszin\nLétszám: $this->letszam\nEgyéb kérések: $this->extraReqs\nHangosítás: $this->sound\nMűsorvezetés: $this->show\nÉlő koncert: $this->concert\nÉlő közvetítés: $this->live\nDJ: $this->dj\nFények: $this->fenyek\nFotós: $this->foto\nVideós: $this->video\nÁSZF Elfogadás dátuma: $this->datumASZF";
    }

    function sendEmail() {
        $autoResponse = "Tisztelt $this->nev,\n\nKöszönjük érdeklődését és a rendezvény részletes adatait! Örömmel értesítjük, hogy a következő információk alapján sikeresen rögzítettük árajánlat kérelmét.\n\nRendelési részletek:\nNév: $this->nev\nEmail: $this->email\nTelefon: $this->telefon\nDátum: $this->datum\nHelyszín: $this->helyszin\nLétszám: $this->letszam\nEgyéb kérések: $this->extraReqs\n\nKiválasztott szolgáltatások:\nHangosítás: $this->sound\nMűsorvezetés: $this->show\nÉlő koncert: $this->concert\nÉlő közvetítés: $this->live\nDJ: $this->dj\nFények: $this->fenyek\nFotós: $this->foto\nVideós: $this->video\n\nKérjük, ellenőrizze a rendelési részleteket. Ha bármilyen változtatást vagy további kérdést szeretne feltenni, kérjük, lépjen kapcsolatba velünk elérhetőségeink valamelyikén.\n\nKöszönjük, hogy minket választott!\n\nÜdvözlettel,\nSándor Péter E.V.";

        $adminEmail = new PHPMailer();
        $adminEmail->CharSet = "UTF-8"; 
        $adminEmail->SetFrom('hang@spdisco.hu', 'Sándor Péter');
        $adminEmail->Subject   = 'Árajánlat kérelem !FONTOS!';
        $adminEmail->Body      = $this->finalMessage;
        $adminEmail->AddAddress( 'hang@spdisco.hu' );
        $adminEmail->Send();

        $customerEmail = new PHPMailer();
        $customerEmail->CharSet = "UTF-8"; 
        $customerEmail->SetFrom('hang@spdisco.hu', 'Sándor Péter');
        $customerEmail->Subject   = 'Visszaigazolás - SP Audio';
        $customerEmail->Body      = $autoResponse;
        $customerEmail->AddAddress( 'hang@spdisco.hu' );
        $customerEmail->addCC( $this->email );

        return $customerEmail->Send();
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
