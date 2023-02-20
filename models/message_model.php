<?php

use BotMan\BotMan\Interfaces\UserInterface;

function getattached(UserInterface $user, $messagesatu, $messagedua, $messagetiga)
{
    $msg3 = explode(",", $messagetiga);
    $sitename = "";
    for ($i = 0; $i <  count($msg3); $i++) {
        if (count($msg3) - 1 == $i) {
            $sitename .= "'" . $msg3[$i] . "'";
        } else {
            $sitename .= "'" . $msg3[$i] . "',";
        }
    }
    $queryMessage = "SELECT * FROM get_attached WHERE
                            tth = '$messagesatu' AND
                            jam = '$messagedua'  AND 
                            sitetel IN ($sitename)
                            ";

    global $mysqli;
    $resultMessages = [];
    $result = mysqli_query($mysqli, $queryMessage);
    while ($resultMessage = mysqli_fetch_row($result)) {
        $resultMessages[] = $resultMessage;
    }
    if ($resultMessages == null) return "Maaf /say $resultMessages tidak dikenali";
    return $resultMessages;
}
