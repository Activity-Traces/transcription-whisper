<?php
require('../Classes/sql.php');

$sql = new sql;


/****************************************************************************************************************************************/
if (isset($_POST['editerUtilisateur'])) {

    $values = "
    Nom = '{$_POST['Nom']}', 
    Prenom= '{$_POST['Prenom']}', 
    Mail= '{$_POST['Mail']}'";


    if (isset($_POST['admin_role']) && ($_POST['admin_role'] == 'edit')) {
        if ($_POST['password'] != null) {
            $pwrd = md5($_POST['password']);
            $values = $values . ", PassWd = '{$pwrd}'";
        }
    } else {
        if ($_POST['PassWd'] != null) {
            $pwrd = md5($_POST['PassWd']);
            $values = $values . ", PassWd = '{$pwrd}'";
        }
    }

    $sql->EditTable('UTILISATEUR', $values, " Id = '{$_POST['id_user']}'");

    if (isset($_POST['admin_role']) && ($_POST['admin_role'] == 'edit')) {
        //   header('location: ../Template/Utilisateurs/utilisateurs.php');
        //   exit();
    } else {

        //  header('location: ../Template/Utilisateurs/monProfil.php?update=1');
        //  exit();
    }
}

/****************************************************************************************************************************************/

if (isset($_POST['ajouterUtilisateur'])) {


    $pwrd = md5($_POST['PassWd']);


    $isAdded = $sql->addUser($_POST['identifiant'], $_POST['profil'], $_POST['Nom'], $_POST['Prenom'], $_POST['Mail'], $pwrd);
    if ($isAdded == 0)
        $_SESSION['UExiste'] = 1;
    else {
        mkdir("../uploads/media/" . $_POST['identifiant'], 0700);
        mkdir("../transcriptions/" . $_POST['identifiant'], 0700);
    }

    header('location: ../Template/Utilisateurs/utilisateurs.php');
    exit();
}


/****************************************************************************************************************************************/
if (isset($_GET['userid'])) {


    $sql->canAcess($_GET['userid'], $_GET['actif']);
    header('location: ../Template/Utilisateurs/utilisateurs.php');
    exit();
}
unset($sql);
