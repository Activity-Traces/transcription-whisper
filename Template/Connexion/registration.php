<?php
require "header.php";

?>


<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
            </div>
        </div>
        <form method="POST" action='../../Controller/connexionController.php' onsubmit="return verifyPassword()">

            <div class="row justify-content-center">

                <div class="col-md-12 col-lg-8">
                    <div class="login-wrap p-4 p-md-5">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-user-o"></span>
                        </div>
                        <h5 class="text-center mb-4"> Formualaire d'inscription
                        </h5>


                        <div class="row">
                            <div class="col">

                                <div class="form-group">

                                    <input type="text" class="form-control rounded-left" placeholder="Identifiant" name="username" required <?php echo $pattern; ?>s>
                                </div>

                            </div>

                            <div class="col">

                                <div class="form-group">
                                    <input type="text" class="form-control rounded-left" placeholder="E-mail" name="mail" required>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col">

                                <div class="form-group">

                                    <input type="text" class="form-control rounded-left" placeholder="Nom" name="nom" required>
                                </div>

                            </div>

                            <div class="col">

                                <div class="form-group">

                                    <input type="text" class="form-control rounded-left" placeholder="Prénom" name="prenom" required>
                                </div>

                            </div>
                        </div>


                        <div class="row">
                            <div class="col">

                                <div class="form-group">

                                    <input type="password" class="form-control rounded-left" placeholder="Mot de passe" id="password" name="password" required <?php echo $pattern; ?>>
                                </div>

                            </div>

                            <div class="col">

                                <div class="form-group">

                                    <input type="password" class="form-control rounded-left" placeholder="Confirmer le mot de passe" type="password" id="confirmpassword" name="confirmpassword" required>
                                </div>

                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col text-center">


                                <button type="submit" id="registration" name="registration" class="btn btn-primary rounded submit p-3 px-5">Inscription</button>




                                <br>
                                <br>

                                <h5><a href="login.php" style="color: #922B21">Retour à la page de connexion</a></h5>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col">
                                <?php
                                if ((isset($_GET['cnxerr'])) && ($_GET['cnxerr'] == 'exist')) : ?>
                                    <br>
                                    <div class='alert alert-dismissible fade show' style="color: white; background-color: #A93226" role='alert'> <strong> Info: </strong>
                                        Inscription : Cet indentifiant est utilisé par un autre utilisateur! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'> </button> </div>
                                <?php endif; ?>


                                <div id="info" name="info">

                                </div>

                                <?php
                                if ((isset($_GET['cnxerr'])) && ($_GET['cnxerr'] == 'confirm')) : ?>
                                    <br>
                                    <div class='alert alert-success alert-dismissible fade show' role='alert'> <strong> Info: </strong>
                                        Inscription : Votre demande a été enregistrée. L'administrateur vas vous contacter pour activer votre compte <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'> </button> </div>
                                <?php endif; ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>

    </div>


    </div>
    <script>
        function verifyPassword() {
            var pw = document.getElementById("password").value;

            var pw2 = document.getElementById("confirmpassword").value; //check empty password field  

            console.log(pw, pw2);

            if ((pw != pw2)) {
                document.getElementById("info").innerHTML = " <br><div class='alert alert-dismissible fade show' style='color: white; background-color: #A93226' role='alert'> <strong> Inscription : </strong>Les deux mots de passes sont différents <button type = 'button' class = 'btn-close' data-bs-dismiss = 'alert' aria-label = 'Close'> </button> </div>";
                return false;
            } else
                return tr;
            ue
        }
    </script>