<?php

require('../../Classes/sql.php');
$sql = new sql;


if (isset($_GET['edit']) & ($_GET['edit'] != NULL)) {
    $rows = $sql->SelectFromTable('UTILISATEUR', '*', "where id = '{$_GET['edit']}'");
    $row = $rows->fetch_array();

    if ($row == NULL) {
        unset($sql);
        header('location:utilisateurs.php ');
        exit;
    }
} else {
    header('location:utilisateurs.php ');
    exit;
}

unset($sql);


include('../../baseIndex.php');

?>

<div class="alert alert-success" role="alert">
    Editer un utilisateur
</div>
<div class="card">
    <div class="card-body">
        <form method="POST" action='../../Controller/utilisateursController.php'>
            <input type="hidden" name="id_user" id="id_user" value='<?php echo $row['Id'] ?>' />
            <input type="hidden" name="admin_role" value="edit" />


            <div class="row">
                <div class="col-4">
                    <label for="" class="form-label">Identifiant</label>
                    <input type="text" class="form-control" disabled name="Identifiant" value='<?php echo $row['Identifiant'] ?>'>
                </div>

            </div> <br>


            <div class="row">


                <div class="col-4">
                    <label for="" class="form-label">Nom</label>
                    <input type="text" class="form-control" name="Nom" value='<?php echo $row['Nom'] ?>'>
                </div>

                <div class="col-4">
                    <label for="" class="form-label">Prénom</label>
                    <input type="text" class="form-control" name="Prenom" value='<?php echo $row['Prenom'] ?>'>
                </div>

                <div class="col-4">
                    <label for="" class="form-label">Profil</label>

                    <select class="form-select" name="profil">

                        <?php
                        $val = $row['Profil'];
                        $r1 = '';
                        $r2 = '';
                        if ($val == 'USR')
                            $r1 = 'selected';
                        else
                            $r2 = 'selected';

                        ?>


                        <option value="USR" <?php echo $r1; ?>>Utilisateur</option>
                        <option value="ADM" <?php echo $r2; ?>>Administrateur</option>
                    </select>
                </div>


            </div> <br>



            <div class="row">
                <div class="col-4">
                    <label for="" class="form-label">Email</label>
                    <input type="mail" class="form-control" name="Mail" value='<?php echo $row['Mail'] ?>'>
                </div>


                <div class="col-4">
                    <label for="" class="form-label">Mot de passe</label>
                    <input type="text" class="form-control" name="password">
                </div>
                <div class="col-4">
                    <label for="" class="form-label">Confirmer le Mot de passe</label>
                    <input type="text" class="form-control" name="confirmpassword">
                </div>

            </div>
            <br>
            <div class="row">
                <div class="col">

                    <button type="submit" id="editerUtilisateur" name="editerUtilisateur" class="btn btn-primary">Mettre à jour</button>

                </div>




            </div>

        </form>
    </div>
</div>