<?php
set_time_limit(3600);
ini_set("memory_limit", "2024M");
ini_set('max_input_vars', 3000);


if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name('transcripteur');
    session_start();
    $type = $_SESSION['userType'];
}
if (!(isset($_SESSION['username']))) {
    header('location: /transcripteur/Template/Connexion/logout.php');
    exit;
}
