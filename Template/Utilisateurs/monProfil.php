<?php

require('../../Classes/sql.php');
include('../../baseIndex.php');

$sql = new sql;
$userId = $_SESSION['userid'];

$rows = $sql->SelectFromTable('UTILISATEUR', '*', "where id = '$userId'");
$row = $rows->fetch_array();




?>



<div class="alert alert-success" role="alert">
    Editer mon profil
</div>
<div class="row">
    <div class="col-2">
    </div>
    <div class="col-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action='../../Controller/utilisateursController.php'>
                    <input type="hidden" name="id_user" id="id_user" value='<?php echo $row['Id'] ?>' />


                    <div class="row">
                        <div class="col-6">
                            <label for="" class="form-label">Identifiant</label>
                            <input type="mail" class="form-control" name="Mail" value='<?php echo $row['Identifiant'] ?>' disabled>
                        </div>

                        <div class="col-6">
                            <label for="" class="form-label">Email</label>
                            <input type="mail" class="form-control" name="Mail" value='<?php echo $row['Mail'] ?>'>
                        </div>

                    </div>

                    <div class="row">


                        <div class="col-6">
                            <label for="" class="form-label">Nom</label>
                            <input type="text" class="form-control" name="Nom" value='<?php echo $row['Nom'] ?>'>
                        </div>

                        <div class="col-6">
                            <label for="" class="form-label">Prénom</label>
                            <input type="text" class="form-control" name="Prenom" value='<?php echo $row['Prenom'] ?>'>

                        </div>
                    </div>
                    <br>
                    <div class="row">


                        <div class="col-6">
                            <label for="" class="form-label">Mot de passe</label>

                            <input type="password" class="form-control" id="PassWd" name="PassWd" placeholder="Mot de passe">

                        </div>

                        <div class="col-6">
                            <label for="" class="form-label">Confirmer mon mot de passe</label>

                            <input type="password" class="form-control" id="PassWdConfirm" name="PassWdConfirm" placeholder="Mot de passe">

                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col">

                            <button type="submit" id="editerUtilisateur" name="editerUtilisateur" class="btn btn-primary" onclick="return verifyPassword();"> Mettre à jour</button>

                        </div>

                    </div><br>

                    <div id=info></div>

                </form>
            </div>
        </div>
    </div>

</div>


<br>

<?php if (isset($_GET['update']) && $_GET['update'] == 1) : ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Info: </strong>Mise à jour effectuée avec succès
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;

unset($sql);
?>

<script>
    function verifyPassword() {
        var pw = document.getElementById("PassWd").value;

        var pw2 = document.getElementById("PassWdConfirm").value;
        if ((pw != pw2)) {
            document.getElementById("info").innerHTML = " <div class='alert alert-warning alert-dismissible fade show' role='alert'> <strong> Info: </strong>Mots de passes différents <button type = 'button' class = 'btn-close' data-bs-dismiss = 'alert' aria-label = 'Close'> </button> </div>";
            return false;
        } else
            return true;
    }
</script>