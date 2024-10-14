<?php

require('../Classes/sql.php');
$sql = new sql;

/****************************************************************************************************************************************/

// Controle d'accès pour un utilisateur
if (isset($_POST['checkUsername'])) {

  if ($sql->Login($_POST['username'], md5($_POST['password'])) == 1) {

    session_name('transcripteur');
    session_start();

    $_SESSION['userType'] = $sql->getUserType($_POST['username']);
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['userid'] = $sql->getUserId($_POST['username']);
    header('location: ../index.php');
  } else {
    header('location: ../Template/Connexion/login.php?cnxerr=err');
  }
}

/****************************************************************************************************************************************/
// inscription : nouveau utilisateur

if (isset($_POST['registration'])) {


  if ($sql->userExist($_REQUEST['username']) == 0) {

    // créer une nouvelle inscription

    $sql->addUser($_REQUEST['username'], 'USR', $_REQUEST['nom'], $_REQUEST['prenom'], $_REQUEST['mail'], md5($_POST['password']), 0);


    mkdir("../uploads/media/" . $_POST['username'], 0777);
    mkdir("../uploads/transcriptions/" . $_POST['username'], 0777);
    mkdir("../uploads/saved/" . $_POST['username'], 0777);

    header('location: ../Template/Connexion/registration.php?cnxerr=confirm');
  } else {

    // utilisateur exsite dans la BD des utilisateurs

    header('location: ../Template/Connexion/registration.php?cnxerr=exist');
  }
}

/****************************************************************************************************************************************/

unset($sql);
exit();
