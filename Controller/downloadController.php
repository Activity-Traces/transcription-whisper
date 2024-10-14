<?php
require "../Requires/session.php";
require('../Classes/sql.php');
$sql = new sql;

/************************************************************************************************************************* */

if (isset($_GET['download'])) {

    $srt_format = "";
    $txt_format = "";
    $out_format = "";
    $vtt_format = "WEBVTT \n\n";

    $res = $sql->SelectFrom('TRANSTEXTE', " * ", " where TransId = " . $_GET['download'] . " order by DebutTS");


    /************************************************************************************************************************* */

    $i = 1;

    while ($row = $res->fetch_row()) {
        $srt_index = $i;
        $other_indexes = "";

        if ($row[5] != "") {
            $srt_index = $i . ' - ' . $row[5];
            $other_indexes = $row[5] . " : ";
        }


        $srt_format = $srt_format . $srt_index . "\n" . $row[3] . ' --> ' . $row[4] . "\n" . $row[2] . "\n\n";
        $txt_format = $txt_format . $other_indexes . $row[2] . "\n";
        $out_format = $out_format  . '[' . $row[3] . ' --> ' . $row[4] . '] ' .  $other_indexes . $row[2] . "\n";
        $vtt_format = $vtt_format . $row[3] . ' --> ' . $row[4] . "\n" .  $other_indexes . $row[2] . "\n\n";

        $i++;
    }

    /************************************************************************************************************************* */
    /************************************************************************************************************************* */


    $zip_file = "init_files" . rand() . "zip";

    touch($zip_file);


    $zip = new ZipArchive;

    $this_zip = $zip->open($zip_file);


    if ($this_zip) {
        $zip->addFromString($_SESSION['transcriptionName'] . '.srt', $srt_format);
        $zip->addFromString($_SESSION['transcriptionName'] . '.txt', $txt_format);
        $zip->addFromString($_SESSION['transcriptionName'] . '.out', $out_format);
        $zip->addFromString($_SESSION['transcriptionName'] . '.vtt', $vtt_format);
    }

    $zip->close();


    //***************************************************************************************************** */

    if (file_exists($zip_file)) {

        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="' . $_SESSION['transcriptionName'] . '.zip"');
        readfile($zip_file);
        unlink($zip_file);
    }
}
