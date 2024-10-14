<div class="container-fluid">

    <div class="offcanvas offcanvas-end <?php echo $show[2] ?>" style="width:500px;" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offtoolsEditerAuteurs" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasBottomLabel">Mettre à jour les locuteurs</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <hr>
        <div class="offcanvas-body small">


            <div class="modal-body">
                <div class="row">
                    <?php
                    // liste des auteurs
                    $cond = " where TransId =" . $transcriptionId;
                    $res = $sql->SelectFromTable('AUTEUR', " Id, Identifiant, Sexe, Langue, Voir", $cond);
                    $voir->auteurs($res);
                    ?>

                </div>
            </div>
            <div class="modal-footer">
                <input msok="yes" class="btn btn-primary" type="submit" name="updateAuthors" value="Mettre à jour"></button>

            </div>
        </div>
    </div>
</div>