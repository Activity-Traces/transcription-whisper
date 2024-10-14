<?php
require "Classes/sql.php";
$sql = new sql;

echo "créer le compte admin";


$isAdded =
    $sql->addUser('admin', 'ADM', 'administrateur', 'admin_transcripteur', 'admin@transcripteur.fr', md5('admin'));
if ($isAdded != 0) {
    mkdir("uploads/media/" . $_POST['identifiant'], 0700);
    mkdir("transcriptions/" . $_POST['identifiant'], 0700);
    echo "compte administrateur ajouté";
} else
    echo "echec dans la création du compte admin";
