<?php


/*********************************************************************************************************************** */

require "../Requires/session.php";
require('../Classes/sql.php');

/*********************************************************************************************************************** */

function uploadFile($file_dir, $file, $nom)
{
    $isLoaded = false;

    $filename = basename($_FILES[$file]["name"]);
    $mediaExtension = explode('.', $filename)[1];
    $target_file = $file_dir . $nom . '.' . $mediaExtension;
    if ($_FILES[$file]['error'] == 0) {
        move_uploaded_file($_FILES[$file]["tmp_name"], $target_file);
        $isLoaded = true;
    }
    return ($isLoaded);
}

/*********************************************************************************************************************** */
/*********************************************************************************************************************** */

if (isset($_POST['AjouterTranscription'])) {

    /*********************************************************************************************************************** */

    $media_dir = "../uploads/media/" . $_SESSION['username'] . '/';
    $transcription_dir = "../uploads/transcriptions/" . $_SESSION['username'] . '/';

    $mediaFilename = explode('.', basename($_FILES["fichierMedia"]["name"]))[0];
    $audioExtention  = explode('.', basename($_FILES["fichierMedia"]["name"]))[1];

    $transcription_file = $transcription_dir . $mediaFilename . '.' . explode('.', basename($_FILES["fichiersrt"]["name"]))[1];

    $diarization = 0;

    $sql = new sql;

    if ($sql->InTable('TRANSCRIPTION', 'Nom', $mediaFilename) > 0) {
        header('location: ../index.php?tn=true');
        exit();
    }

    /*********************************************************************************************************************** */

    // charger le fichier multimedia

    $MediaLoaded = uploadFile($media_dir, 'fichierMedia',  $mediaFilename);

    // charger le fichier de transcription

    $transLoaded = uploadFile($transcription_dir, 'fichiersrt', $mediaFilename);

    /***********************************************************************************************************************/


    if (($transLoaded == true) && ($MediaLoaded == true)) {

        // créer la transcription  dans la bd


        $now = date('d-m-Y à H:i:s', time());
        $columns = "Id, Nom, Description, TransExtension, AudioExtension, UserId, CreatedAt";
        $values = "NULL,'$mediaFilename', '', 'srt', '{$audioExtention}', '{$_SESSION['userid']}', '{$now}' ";
        $sql->AddToTable('TRANSCRIPTION', $columns, $values);
        $TransId = $sql->getLastid();


        // Ajouter un Auteur Silence

        $silence = "Silence";
        $columns = "Identifiant,TransId";
        $values = "'{$silence}','{$TransId}'";
        $sql->AddToTable('AUTEUR', $columns, $values);


        if (isset($_POST['diarisation']) && ($_POST['diarisation'] == 'on'))
            $diarization = 1;

        $myfile = file_get_contents($transcription_file, "r");
        $val = explode("\n", $myfile);
        $i = 0;


        for ($i = 0; $i < count($val) - 4; $i = $i + 4) {

            $user = '';
            if ($diarization == 1) {
                $value =  explode(" - ", $val[$i]);
                if (count($value) > 1) {
                    $user = explode(" - ", $val[$i])[1];
                    $user = str_replace(' ', '', $user);
                    $user = str_replace('\n', '', $user);
                    $user = preg_replace("#(\r\n|\n\r|\n|\r)#", "", $user);
                }
            }
            $time = explode(" --> ", $val[$i + 1]);

            $timedebut = str_replace(',', '.', $time[0]);
            $timefin = str_replace(',', '.', $time[1]);

            $timedebut = str_replace('.000', '.00', $timedebut);
            $timefin = str_replace('.000', '.00', $timefin);


            $timedebut = str_replace(' ', '', $timedebut);
            $timedebut = str_replace('\n', '', $timedebut);
            $timedebut = preg_replace("#(\r\n|\n\r|\n|\r)#", "", $timedebut);


            $timefin = str_replace(' ', '', $timefin);
            $timefin = str_replace('\n', '', $timefin);
            $timefin = preg_replace("#(\r\n|\n\r|\n|\r)#", "", $timefin);

            // millisec a ajouter

            $DS = explode(':', $timedebut);
            $DF = explode(':', $timefin);

            $MS1 = explode('.',  $DS[2])[1];
            $MS2 = explode('.',  $DF[2])[1];

            // millisec a ajouter dans la règle


            $DebutTS = 1000 * ($DS[0] * 3600 + $DS[1] * 60 + $DS[2] * 1);
            $FinTS = 1000 * ($DF[0] * 3600 + $DF[1] * 60 + $DF[2] * 1);

            $text = addslashes($val[$i + 2]);
            $text = strtolower($text);
            $text = str_replace(['.', ',', ';', '?', '!', '"'], '', $text);

            $text = preg_replace("#(\r\n|\n\r|\n|\r)#", "", $text);

            //$text = addslashes($text);
            $columns = "Id, TransId, Texte, DDebut, DFin, IdAuteur, IDAut, DebutTS, FinTS";

            $values = "NULL,'{$TransId}','{$text}','{$timedebut}','{$timefin}', '{$user}','0', '{$DebutTS}', '{$FinTS}'";
            $sql->AddToTable('TRANSTEXTE', $columns, $values);
        }

        // mettre à jour la table des auteurs

        $sql->UpdateAuthors($TransId);

        $sql->getSilence($TransId);

        // mettre à jour à nouveau l'identifiant auteur dans la table des textes 

        $result = $sql->SelectFromTable('AUTEUR', " Id, Identifiant ", " where TransId = " . $TransId);


        while ($row = $result->fetch_row()) {

            $values = "IDAut = '{$row[0]}'";
            $sql->EditTable('TRANSTEXTE', $values, " (IdAuteur = '{$row[1]}') and (TransId= '{$TransId}' )");
        }

        $sql->sortTable('TRANSTEXTE', 'DebutTS');
    }


    /*********************************************************************************************************************** */

    unset($sql);


    header('location: ../');
    exit();
}
