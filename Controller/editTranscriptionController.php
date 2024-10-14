<?php

require('../Classes/sql.php');
require "../Requires/session.php";

$_SESSION['debutRegion'] = $_POST['debutRegion'];
$_SESSION['finRegion'] =  $_POST['finRegion'];
$_SESSION['positionLecture'] = $_POST['positionLecture'];
$_SESSION['positionLectureScroll'] = $_POST['positionLectureScroll'];


$sql = new sql;

// mettre à jour le texte avant tout traitement
if (isset($_POST['TransId'])) {
    $TransId = $_POST['TransId'];

    $name = $sql->SelectFromTable('TRANSCRIPTION', 'Nom', "where Id = '{$TransId}'");
    $TransName = $name->fetch_array()[0];

    $Textes = $_POST['MyTextarea'];
    $Authors = $_POST['Authors'];

    $Times = $_POST['MyDates'];
    $updatedvalues = 'false';

    foreach ($Authors  as $key => $value) {

        $result = $sql->SelectFromTable('AUTEUR', 'Identifiant', "where Id = '{$value}'");
        $author = $result->fetch_array();

        $values =
            "IDAut = '{$value}',
            IdAuteur='{$author[0]}'";

        $sql->EditTable('TRANSTEXTE', $values, " (Id = '{$key}') and (TransId= '{$TransId}' )");
    }

    /************************************************************************************************************************/

    foreach ($Textes  as $key => $value) {
        $value = addslashes($value);
        $values = "Texte = '{$value}'";
        $sql->EditTable('TRANSTEXTE', $values, " (Id = '{$key}') and (TransId= '{$TransId}' )");
    }

    /************************************************************************************************************************/

    foreach ($Times  as $key => $value) {

        // ajouter les miliscondes

        $TVal = explode(' / ', $value);

        $DS = explode(':',  $TVal[0]);
        $MS1 = explode('.',  $DS[2])[1];

        $DF = explode(':', $TVal[1]);
        $MS2 = explode('.',  $DF[2])[1];

        $DebutTS = 1000 * ($DS[0] * 3600 + $DS[1] * 60 + $DS[2] * 1);
        $FinTS = 1000 * ($DF[0] * 3600 + $DF[1] * 60 + $DF[2] * 1);

        $values = "
            DDebut= '{$TVal[0]}',
            DFin ='{$TVal[1]}',
            DebutTS = '{$DebutTS}',
            FinTS ='{$FinTS}'
            ";

        $sql->EditTable('TRANSTEXTE', $values, " (Id = '{$key}') and (TransId= '{$TransId}' )");
    }

    $_SESSION['lastSaved'] = date('d-m-Y à H:i:s', time());


    /*********************************************************************************************************************** */

    if (isset($_POST['DeleteParole'])) {

        if (isset($_POST['choixFusion']) && count($_POST['choixFusion']) >= 1) {
            foreach ($_POST['choixFusion'] as $id) {
                $sql->DeleteFromTable("TRANSTEXTE", "Id", $id);
            }
        }
    }

    /*********************************************************************************************************************** */

    if (isset($_POST['addParole'])) {

        $_SESSION['action'] = 0;

        $DS = explode(':',  $_POST['Time1Add']);
        $DF = explode(':', $_POST['Time2Add']);

        $DebutTS = 1000 * ($DS[0] * 3600 + $DS[1] * 60 + $DS[2] * 1);
        $FinTS = 1000 * ($DF[0] * 3600 + $DF[1] * 60 + $DF[2] * 1);

        $result = $sql->SelectFromTable('AUTEUR', 'Identifiant', ' where Id = ' . $_POST['authorAdd']);
        $author = $result->fetch_array();

        $columns = "Id, TransId, Texte, DDebut, DFin, IdAuteur, IDAut, DebutTS, FinTS";

        $values = "NULL,'{$TransId}', '{$_POST['TexteAdd']}', '{$_POST['Time1Add']}', '{$_POST['Time2Add']}','{$author[0]}','{$_POST['authorAdd']}','{$DebutTS}', '{$FinTS}'";
        $sql->AddToTable('TRANSTEXTE', $columns, $values);
    }

    /*********************************************************************************************************************** */


    if (isset($_POST['updateAuthor']) && ($_POST['updateAuthor'] == true)) {

        $_SESSION['action'] = 1;

        $currentUsr = $_POST['author'];

        $newUsr = $_POST['newauthor'];
        $newUsrName = $sql->getAuthorName($TransId, $newUsr);

        if ($newUsr != null) {
            $values = "IDAut = '{$newUsr}',IdAuteur='{$newUsrName}'";

            if (isset($_POST['auteurSelection']) && ($_POST['auteurSelection'] == 'edit')) {

                if (isset($_POST['authorListCheched']) && count($_POST['authorListCheched']) >= 1) {


                    foreach ($_POST['authorListCheched'] as $id)


                        $sql->EditTable('TRANSTEXTE', $values, " (IDAut = '{$_POST['author']}') and (Id='{$id}') and (TransId= '{$TransId}' )");
                }
            } else

                $sql->EditTable('TRANSTEXTE', $values, " (IDAut = '{$_POST['author']}') and (TransId= '{$TransId}' )");
        }
    }

    /*********************************************************************************************************************** */


    if (isset($_POST['updateAuthors'])) {
        $_SESSION['action'] = 2;

        $Identifiant = $_POST['Identifiant'];
        $Sexe = $_POST['Sexe'];
        $Langue = $_POST['Langue'];
        $voir = $_POST['voirAuteur'];
        var_dump($Identifiant);

        foreach ($Identifiant  as $key => $value) {
            $sql->EditTable('AUTEUR', "Identifiant = '{$value}'", " (Id = '{$key}') and (TransId= '{$TransId}' )");
            $sql->EditTable('TRANSTEXTE', "IdAuteur = '{$value}'", " (IDAut = '{$key}') and (TransId= '{$TransId}' )");
        }

        foreach ($Sexe  as $key => $value)
            $sql->EditTable('AUTEUR',  "Sexe = '{$value}'", " (Id = '{$key}') and (TransId= '{$TransId}' )");

        foreach ($Langue  as $key => $value)
            $sql->EditTable('AUTEUR', "Langue = '{$value}'", " (Id = '{$key}') and (TransId= '{$TransId}' )");

        foreach ($voir  as $key => $value)
            $sql->EditTable('AUTEUR', "Voir = 0", " (TransId= '{$TransId}' )");

        foreach ($voir  as $key => $value)
            $sql->EditTable('AUTEUR',  "Voir = 1", " (Id = '{$key}') and (TransId= '{$TransId}' )");
    }


    /*********************************************************************************************************************** */


    if (isset($_POST['Fusionner'])) {

        $_SESSION['action'] = 3;

        $updatedvalues = 'false';
        if (isset($_POST['choixFusion']) && count($_POST['choixFusion']) > 1) {

            $texte = "";

            $result = $sql->SelectFromTable('TRANSTEXTE', " * ", " where Id = " . reset($_POST['choixFusion']));
            $FirstRow = $result->fetch_row();

            $result = $sql->SelectFromTable('TRANSTEXTE', " DFin, FinTS", " where Id = " . end($_POST['choixFusion']));
            $LastRow = $result->fetch_row();

            foreach ($_POST['choixFusion'] as $id) {
                $result = $sql->SelectFromTable('TRANSTEXTE', " Texte ", " where Id = " . $id);
                $row = $result->fetch_row();
                $texte = $texte . $row[0] . " ";

                // supprimer la ligne en question
                $sql->DeleteFromTable("TRANSTEXTE", "Id", $id);
            }
            $texte = addslashes($texte);
            $columns = "Id, TransId, Texte, DDebut, DFin, IdAuteur, IDAut, DebutTS, FinTS";

            $values = "NULL,'{$FirstRow[1]}','{$texte}','{$FirstRow[3]}','{$LastRow[0]}', '{$FirstRow[5]}',$FirstRow[6], '{$FirstRow[7]}', '{$LastRow[1]}'";
            $sql->AddToTable('TRANSTEXTE', $columns, $values);
            $updatedvalues = 'true';
        }
    }

    /*********************************************************************************************************************** */

    if (isset($_POST['Eclater'])) {
        $_SESSION['action'] = 4;

        $updatedvalues = 'false';

        if (isset($_POST['choixFusion']) && count($_POST['choixFusion']) == 1) {

            $texte = "";

            $result = $sql->SelectFromTable('TRANSTEXTE', " * ", " where Id = " . reset($_POST['choixFusion']));
            $FirstRow = $result->fetch_row();


            $texte1 = addslashes($_POST['Texte1']);
            $texte2 = addslashes($_POST['Texte2']);

            $author1 = $_POST['author1'];
            $author2 = $_POST['author2'];


            $result1 = $sql->SelectFromTable('AUTEUR', 'Identifiant', ' where Id = ' . $author1);
            $aut1 = $result1->fetch_array();

            $result2 = $sql->SelectFromTable('AUTEUR', 'Identifiant', ' where Id = ' . $author2);
            $aut2 = $result2->fetch_array();

            $TVal1 = explode(' / ', $_POST['Time1']);

            $DS = explode(':',  $TVal1[0]);
            $DF = explode(':', $TVal1[1]);

            $DebutTS1 = 1000 * ($DS[0] * 3600 + $DS[1] * 60 + $DS[2] * 1);
            $FinTS1 = 1000 * ($DF[0] * 3600 + $DF[1] * 60 + $DF[2] * 1);



            $TVal2 = explode(' / ', $_POST['Time2']);

            $DS = explode(':',  $TVal2[0]);
            $DF = explode(':', $TVal2[1]);

            $DebutTS2 = 1000 * ($DS[0] * 3600 + $DS[1] * 60 + $DS[2] * 1);
            $FinTS2 = 1000 * ($DF[0] * 3600 + $DF[1] * 60 + $DF[2] * 1);




            $columns = "Id, TransId, Texte, DDebut, DFin, IdAuteur, IDAut, DebutTS, FinTS";

            $values = "NULL,'{$FirstRow[1]}','{$texte1}','{$TVal1[0]}','{$TVal1[1]}', '$aut1[0]',$author1, '{$DebutTS1}', '{$FinTS1}'";
            $sql->AddToTable('TRANSTEXTE', $columns, $values);

            $values = "NULL,'{$FirstRow[1]}','{$texte2}','{$TVal2[0]}','{$TVal2[1]}', '{$aut2[0]}',$author2, '{$DebutTS2}', '{$FinTS2}'";
            $sql->AddToTable('TRANSTEXTE', $columns, $values);



            $sql->DeleteFromTable("TRANSTEXTE", "Id", reset($_POST['choixFusion']));
            $updatedvalues = 'true';
        }
    }


    /*********************************************************************************************************************** */

    if (isset($_POST['createSavebtn'])) {

        $_SESSION['action'] = 5;

        $text = '';

        $fileneme = $TransName . '_' . date('dmY_H\hi', time());;
        // créer l'entrée dans la table des sauvegardes$


        $file = "../uploads/saved/" . $_SESSION['username'] . '/' . $fileneme . '.srt';


        if (!(file_exists($file))) {

            $columns = "Id, TransId, FileName";

            $values = "NULL,'{$TransId}','{$fileneme}'";
            $sql->AddToTable('SAUVEGARDES', $columns, $values);

            // créer le fichier texte // srt!


            $result = $sql->SelectFrom('TRANSTEXTE', " * ", " where TransId = " . $TransId . " order by DebutTS");

            $i = 1;

            while ($row = $result->fetch_row()) {
                $t1 = $i;

                if ($row[5] != "")
                    $t1 = $i . ' - ' . $row[5];

                $text = $text . $t1 . "\n" . $row[3] . ' --> ' . $row[4] . "\n" . $row[2] . "\n\n";

                $i++;
            }

            file_put_contents($file, $text);


            $updatedvalues = 'true';
        }
    }

    /***********************************************************************************************************************/

    if (isset($_POST['addAuthor'])) {
        $_SESSION['action'] = 6;

        if (($_POST['authorName'] != '') && ($sql->AhthorExist($_POST['authorName']) == 0)) {
            $columns = "Id, Identifiant, TransId, Sexe, Langue";

            $values = "NULL,'{$_POST['authorName']}','{$TransId}', '{$_POST['Gender']}' , '{$_POST['Langue']}'";
            $sql->AddToTable('AUTEUR', $columns, $values);
        }
    }



    /*********************************************************************************************************************** */
    /*********************************************************************************************************************** */

    // trier avant la recherche
    $sql->sortTable('TRANSTEXTE', 'DebutTS');
    $sql->getSilence($TransId);

    // trier après l'insertion
    $sql->sortTable('TRANSTEXTE', 'DebutTS');

    unset($sql);
    header('location: ../Template/Transcription/ouvrirTranscription.php?add=' . $updatedvalues . '&open=' . $TransId);
    exit();
}
