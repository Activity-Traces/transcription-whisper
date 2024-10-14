<?php
require "header.php";

?>


<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
            </div>
        </div>
        <form method="POST" action='../../Controller/connexionController.php'>

            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="login-wrap p-4 p-md-5">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-user-o"></span>
                        </div>
                        <h5 class="text-center mb-4">
                            Connexion

                        </h5>
                        <div class="form-group">
                            <input type="text" class="form-control rounded-left" name="username" placeholder="Identifiant" required <?php echo $pattern; ?>s>
                        </div>
                        <div class="form-group d-flex">
                            <input type="password" class="form-control rounded-left" type="password" placeholder="Mot de passe" name="password" required>
                        </div>
                        <div class="form-group d-md-flex">
                            <div class="w-50">

                            </div>

                        </div>
                        <div class="form-group">
                            <button type="submit" name="checkUsername" class="btn btn-primary rounded submit p-3 px-5">Connexion</button>
                        </div>

                    </div>
                    <br><br>
                    <h5 class="text-center mb-4">
                        <A HREF='registration.php' style="color: #922B21">Besoin d'un compte? </A>

                    </h5>
                    <?php if ((isset($_GET['cnxerr'])) && ($_GET['cnxerr'] == 'err')) : ?>
                        <div class="alert alert-dismissible fade show" style="color: white; background-color: #303647" role="alert">
                            <strong>Connexion: </strong>Identifiant ou mot de passe incorrecte
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>

                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </form>
    </div>

    <div class="d-flex p-2   justify-content-center">

        <div class="mb3">


        </div>

</body>

</html>