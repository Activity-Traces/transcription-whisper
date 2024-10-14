<?php

require('../Classes/sql.php');
require "../Requires/session.php";

/********************************************************************************************************************************* */

$sql = new sql;

/********************************************************************************************************************************* */
// supprimer une sauvgarde

if (isset($_GET['mode']) && (($_GET['mode'] == '1'))) {

    $TransId = $_GET['TransId'];
    $FileId = $_GET['FileId'];

    $condition =  " where TransId = " .   $TransId . " and Id= " . $FileId;
    $result = $sql->SelectFromTable('SAUVEGARDES', " FileName ", $condition);

    if ($result->num_rows > 0) {
        $obj = $result->fetch_object();
        if (file_exists("../uploads/saved/" .  $_SESSION['username'] . '/' . $obj->FileName . '.srt')) {
            echo "uploads/saved/" .  $_SESSION['username'] . '/' .  $obj->FileName . '.srt';

            unlink("../uploads/saved/" .  $_SESSION['username'] . '/' .  $obj->FileName . '.srt');
        }
    }
    $sql->DeleteFromTable('SAUVEGARDES', 'Id', $FileId);
}

/********************************************************************************************************************************* */

if (isset($_GET['mode']) && (($_GET['mode'] == '2'))) {


    $TransId = $_GET['TransId'];
    $FileId = $_GET['FileId'];

    $result = $sql->SelectFromTable('SAUVEGARDES', " FileName ", " where Id=" . $FileId);
    $row = $result->fetch_row();

    $folder = "../uploads/saved/" . $_SESSION['username'] . '/';

    $transcription_file = $folder . $row[0] . ".srt";


    $updatedvalues = 'true';

    $sql->DeleteFromTable("TRANSTEXTE", "TransId", $TransId);


    $myfile = file_get_contents($transcription_file, "r");

    $text = explode("\n", $myfile);
    $i = 0;


    for ($i = 0; $i < count($text) - 4; $i = $i + 4) {

        $user = '';

        $value =  explode(" - ", $text[$i]);
        if (count($value) > 1) {

            $user = explode(" - ", $text[$i])[1];
            $user = str_replace(' ', '', $user);
            $user = str_replace('\n', '', $user);
            $user = preg_replace("#(\r\n|\n\r|\n|\r)#", "", $user);

            $userid = $sql->getAuthorId($user);
        }

        $time = explode(" --> ", $text[$i + 1]);

        $timedebut = str_replace(',', '.', $time[0]);
        $timefin = str_replace(',', '.', $time[1]);

        $timedebut = str_replace(' ', '', $timedebut);
        $timedebut = str_replace('\n', '', $timedebut);
        $timedebut = preg_replace("#(\r\n|\n\r|\n|\r)#", "", $timedebut);


        $timefin = str_replace(' ', '', $timefin);
        $timefin = str_replace('\n', '', $timefin);
        $timefin = preg_replace("#(\r\n|\n\r|\n|\r)#", "", $timefin);



        $DS = explode(':', $timedebut);
        $DF = explode(':', $timefin);

        $DebutTS = 1000 * ($DS[0] * 3600 + $DS[1] * 60 + $DS[2] * 1);
        $FinTS = 1000 * ($DF[0] * 3600 + $DF[1] * 60 + $DF[2] * 1);

        $textes = addslashes($text[$i + 2]);


        //$text = addslashes($text);
        $columns = "Id, TransId, Texte, DDebut, DFin, IdAuteur, IDAut, DebutTS, FinTS";

        // idaut getUserId($user)

        $values = "NULL,'{$TransId}','{$textes}','{$timedebut}','{$timefin}', '{$user}','{$userid}', '{$DebutTS}', '{$FinTS}'";
        $sql->AddToTable('TRANSTEXTE', $columns, $values);
    }
}


$condition = " where TransId = " . $TransId;
$result = $sql->SelectFromTable('AUTEUR', " Id, Identifiant ", $condition);


while ($rows = $result->fetch_row()) {

    $values = "IDAut = '{$rows[0]}'";
    $sql->EditTable('TRANSTEXTE', $values, " (IdAuteur = '{$rows[1]}') and (TransId= '{$TransId}' )");
}

/*********************************************************************************************************************** */

// trier avant la recherche
$sql->sortTable('TRANSTEXTE', 'DebutTS');

unset($sql);

header('location: ../Template/Transcription/ouvrirTranscription.php?add=' . $updatedvalues . '&open=' . $TransId);
exit();
