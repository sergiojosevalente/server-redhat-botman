<?php
$botToken = '6011528705:AAEMOq9T5GAlRKZPp9hD1zV9ecOq5eMHfyQ';
$chatId = '-844835074';

$filePath = './public/getlastattached.txt';

$file = fopen($filePath, 'r');
$content = fread($file, filesize($filePath));
fclose($file);

$botUrl = "https://api.telegram.org/bot$botToken/";
$fileUrl = $botUrl . "sendDocument?chat_id=$chatId";
$postFields = array(
    'document' => new CURLFile($filePath),
    'caption' => 'Here is your text file.'
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type:multipart/form-data"
));
curl_setopt($ch, CURLOPT_URL, $fileUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
$result = curl_exec($ch);
curl_close($ch);
echo $result;
