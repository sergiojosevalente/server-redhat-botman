<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\ArrayCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\Drivers\Telegram\TelegramDriver;

require_once "vendor/autoload.php";
require_once "database/config.php";
require_once "models/user_model.php";
require_once "models/message_model.php";

$configs = [
    "telegram" => [
        //"token" => file_get_contents("private/TOKEN.txt"),
	'token' => '6011528705:AAEMOq9T5GAlRKZPp9hD1zV9ecOq5eMHfyQ',
        "chatid" => file_get_contents("private/chatid.txt")
    ]
];
DriverManager::loadDriver(TelegramDriver::class);

$cache = new ArrayCache();
$botman = BotManFactory::create($configs);

$botman->hears("/start", function (BotMan $bot) {
    $user = $bot->getUser();
    $bot->reply(
        "Hi" . " " . $user->getFirstName() . " " . "dari" . " " . "Telkomcel BOT " . " 😊\n\n" .
            "Bot Ini adalah prototipe untuk" . "\n" . "menampilkan BTS last Attached" . "\n\n" .
            "/help atau /help@telkomcel_bot" . " " . "Untuk Informasi lebih lanjut"
    );
});
$botman->hears("/help", function (BotMan $bot) {
    $message = "Berikut Contoh Penulisan Perintah :\n";
    $message .= "=============================\n";
    $message  .= "/say TTH Jam Site " . PHP_EOL . PHP_EOL;
    $message .= "/say 20230207 01 bts1,bts2 " . PHP_EOL . PHP_EOL;
    $bot->reply($message);
});

$botman->hears("/help@telkomcel_bot", function (BotMan $bot) {
    $message = "Berikut Contoh Penulisan Perintah :\n";
    $message .= "=============================\n";
    $message  .= "/say@telkomcel_bot TTH Jam Site " . PHP_EOL . PHP_EOL;
    $message .= "/say@telkomcel_bot 20230207 01 bts1,bts2 " . PHP_EOL . PHP_EOL;
    $bot->reply($message);
});

$botman->hears(
    "/say {messagesatu} {messagedua} {messagetiga}",
    function (
        BotMan $bot,
        $messagesatu,
        $messagedua,
        $messagetiga,
    ) {
        $getattached = (getattached(
            $bot->getUser(),
            $messagesatu,
            $messagedua,
            $messagetiga,
        ));
        if ($getattached == "Maaf /say tidak dikenali" or $getattached == "Maaf /say Array tidak dikenali") {
            $bot->reply(
                "Maaf Data Tidak Ada" . "\n\n" .
                    "Gunakan Parameter Input Lain" . "\n" .
                    "Cek /help"
            );
        } else {
            $datatth = " ";
            $datajam = " ";
            $datasite = " ";
            $type = " ";
            $nomorhp = " ";
            foreach ($getattached as $get) {
                $datatth .= $get[1]  . " ";
            }
            foreach ($getattached as $get) {
                $datajam .= $get[2] . " ";
            }
            foreach ($getattached as $get) {
                $datasite .= $get[3] . " ";
            }
            foreach ($getattached as $get) {
                $type .= $get[5] . " ";
            }
            foreach ($getattached as $get) {
                $nomorhp .= $get[6] . " ";
            }
            $messagetele = $datatth . " \n" . $datajam . " \n" . $datasite . " \n" . $type . " \n" . $nomorhp;
            $label = "TTH,JAM,SITE,TYPE,NOMORHP";
            $linetopcol = explode(",", $label);
            $formatted_data = "";
            foreach ($linetopcol as $top) {
                $formatted_data .= $top . "\t";
            }
            $lines = explode("\n", $messagetele);
            $cols = [];
            foreach ($lines as $line) {
                $cols[] = explode(" ", $line);
            }
            $max_cols = max(array_map(function ($col) {
                return count($col);
            }, $cols));
            $formatted_data .= "";
            for ($i = 0; $i < $max_cols; $i++) {
                for ($j = 0; $j < count($cols); $j++) {
                    $formatted_data .= isset($cols[$j][$i]) ? $cols[$j][$i] . " " : "";
                }
                $formatted_data .= "\n";
            }
            $file = fopen("./public/getlastattached.txt", "w");
            fwrite($file, $formatted_data);
            fclose($file);

            //Zip File
            //$zip = new ZipArchive();
            //$filenamezip = "./public/getlastattached.zip";
            //if ($zip->open($filenamezip, ZipArchive::CREATE) !== TRUE) {
            //    exit("<$filenamezip> tidak bisa dibuka");
            //}
            //$zip->addFile('./public/getlastattached.txt', 'getlastattached.txt');
            //$zip->close();

            $sendfile = include './private/filesend.php';
            $bot->reply(
                "File Get Last Attached Terkirim ke Grup"
            );
        }
    }
);

$botman->hears(
    "/say@telkomcel_bot {messagesatu} {messagedua} {messagetiga}",
    function (
        BotMan $bot,
        $messagesatu,
        $messagedua,
        $messagetiga,
    ) {
        $getattached = (getattached(
            $bot->getUser(),
            $messagesatu,
            $messagedua,
            $messagetiga,
        ));
        if ($getattached == "Maaf /say tidak dikenali" or $getattached == "Maaf /say Array tidak dikenali") {
            $bot->reply(
                "Maaf Data Tidak Ada" . "\n\n" .
                    "Gunakan Parameter Input Lain" . "\n" .
                    "Cek /help@telkomcel_bot"
            );
        } else {
            $datatth = " ";
            $datajam = " ";
            $datasite = " ";
            $type = " ";
            $nomorhp = " ";
            foreach ($getattached as $get) {
                $datatth .= $get[1]  . " ";
            }
            foreach ($getattached as $get) {
                $datajam .= $get[2] . " ";
            }
            foreach ($getattached as $get) {
                $datasite .= $get[3] . " ";
            }
            foreach ($getattached as $get) {
                $type .= $get[5] . " ";
            }
            foreach ($getattached as $get) {
                $nomorhp .= $get[6] . " ";
            }
            $messagetele = $datatth . " \n" . $datajam . " \n" . $datasite . " \n" . $type . " \n" . $nomorhp;
            $label = "TTH,JAM,SITE,TYPE,NOMORHP";
            $linetopcol = explode(",", $label);
            $formatted_data = "";
            foreach ($linetopcol as $top) {
                $formatted_data .= $top . "\t";
            }
            $lines = explode("\n", $messagetele);
            $cols = [];
            foreach ($lines as $line) {
                $cols[] = explode(" ", $line);
            }
            $max_cols = max(array_map(function ($col) {
                return count($col);
            }, $cols));
            $formatted_data .= "";
            for ($i = 0; $i < $max_cols; $i++) {
                for ($j = 0; $j < count($cols); $j++) {
                    $formatted_data .= isset($cols[$j][$i]) ? $cols[$j][$i] . " " : "";
                }
                $formatted_data .= "\n";
            }
            $file = fopen("./public/getlastattached.txt", "w");
            fwrite($file, $formatted_data);
            fclose($file);

            //Zip File
            //$zip = new ZipArchive();
            //$filenamezip = "./public/getlastattached.zip";
            //if ($zip->open($filenamezip, ZipArchive::CREATE) !== TRUE) {
            //    exit("<$filenamezip> tidak bisa dibuka");
            //}
            //$zip->addFile('./public/getlastattached.txt', 'getlastattached.txt');
            //$zip->close();

            $sendfile = include './private/filesend.php';
            $bot->reply(
                "File Get Last Attached Terkirim ke Grup"
            );
        }
    }
);
// Fallback (balasan invalid command)
$botman->fallback(function (BotMan $bot) {
    $message  = "Penulisan perintah salah " . $bot->getMessage()->getText() . PHP_EOL . PHP_EOL;
    $message .= "Mungkin anda kurang input argumen perintah? Cek /help atau /help@telkomcel_bot";
    $bot->reply($message);
});

$botman->listen();
