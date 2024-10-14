<div class="modal fade" id="ajouterUtilisateur" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter un Utilisateur</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action='../../Controller/utilisateursController.php'>

                    <div class="row">
                        <div class="col"><input type="text" class="form-control" name="identifiant" placeholder="Identifiant de connexion" required></div>
                    </div>
                    <br>
                    <div class="row">

                        <div class="col-6">
                            <input type="text" class="form-control" name="Nom" placeholder="Nom" required>

                        </div>


                        <div class="col-6">
                            <input type="text" class="form-control" name="Prenom" placeholder="Prénom" required>

                        </div>
                    </div> <br>

                    <div class="row">

                        <div class="col-6"> <select class="form-select" name="profil" required>
                                <option value="USR" selected>Profil</option>
                                <option value="USR">Utilisateur</option>
                                <option value="ADM">Administrateur</option>
                            </select>
                        </div>
                     
                    </div>
                    <br>
               
                    <div class="row">
                        <div class="col"><input type="mail" class="form-control" name="Mail" placeholder="E-mail" required></div>
                    </div>
                    <br>
                    <div class="row">

                        <div class="col">
                            <input type="text" class="form-control" name="PassWd" placeholder="Mot de passe" required>

                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">

                            <button type="submit" id="ajouterUtilisateur" name="ajouterUtilisateur" class="btn btn-primary">Ajouter</button>

                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>