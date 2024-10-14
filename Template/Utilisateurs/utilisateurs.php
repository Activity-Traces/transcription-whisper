<?php

include('../../baseIndex.php');
require('../../Classes/sql.php');
require('../../Classes/html.php');
include('ajouterUtilisateur.php');

$json = array();
$sql = new sql;
$voir = new html;

$userid = $_SESSION['userid'];



if (isset($_GET['delete'])) { {
        $sql->DeleteFromTable('UTILISATEUR', 'id', $_GET['delete']);


        rmdir("../uploads/media/" .  $_SESSION['username']);
        rmdir("../uploads/transcriptions/" .  $_SESSION['username']);
    }
}

$condition = "";
if (isset($_POST['rechercher']) && ($_POST['rechercher'] != ""))
    $condition =  "where nom like '%" . $_POST['rechercher'] . "%'";

$result = $sql->SelectFromTable('UTILISATEUR', " Id, Identifiant,  Nom, Prenom, Mail, Profil, Access ", $condition);
?>


<?php if (isset($_SESSION['UExiste']) && $_SESSION['UExiste'] == 1) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Info: </strong>Cet utilisateur existe. Merci de choisir un autre identifiant.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;

$_SESSION['UExiste'] = 0;
?>

<div class="card">
    <div class="card-body">

        <form method="POST">

            <div class="row">
                <div class="col-11">
                    <input type="text" name="rechercher" class="form-control" placeholder="Rechercher par nom">
                </div>

                <div class="col-1">

                    <a class="btn" href="#ajouterUtilisateur" data-bs-toggle="modal" data-bs-target="#ajouterUtilisateur" role="button"> <i class='fas fa-plus  fa-2x' title='Ajouter un membre'></i></a>

                </div>


            </div>

        </form>

        <hr>


        <?php
        $voir->Table(
            ['#', 'Identifiant', 'Nom', 'Prénom', 'E-mail', 'Profil', 'Statut', '', '', ''],
            $result,
            'utilisateurs',
            'delete',
            'editerUtilisateur',
            true,
            true
        ); ?>

    </div>
</div>
<!--------------------------------------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------------------------------------->

<?php
unset($sql);
unset($html);
?>
<!--------------------------------------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------------------------------------->