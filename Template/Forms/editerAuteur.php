<div class="offcanvas offcanvas-end <?php echo $show[1] ?>" style="width:500px;" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offtoolsEditerAuteur" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasBottomLabel">Mettre à jour un locuteur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr>
    <div class="offcanvas-body small">




        <div class="alert alert-secondary" role="alert">
            <div class="row">
                <div class="col-6">
                    <label class="form-label">Remplacer: </label>

                    <select class="form-select" aria-label="Default select example" name="author">
                        <?php $sql->getAuthorsList($transcriptionId); ?>
                    </select>
                </div>
                <div class="col-6">
                    <input type="hidden" id="idtrans" name="idtrans" value="<?php echo $transcriptionId ?>">
                    <label class="form-label">Par : </label>


                    <select class="form-select" aria-label="Default select example" name="newauthor">
                        <?php $sql->getAuthorsList($transcriptionId); ?>
                    </select>


                </div>


            </div><br>
            <div class="row">
                <div class="col-12">

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="auteurSelection" value="edit">
                        <label class="form-check-label">Appliquer seulement sur les transcriptions sélectionnées</label>
                    </div>

                </div>
            </div>



        </div>

        <div class="row" id="authorList" style="display: none;">
        </div>

        <div class="modal-footer">
            <input msok="yes" class="btn btn-primary" msok="yes" t type="submit" name="updateAuthor" value="Mettre à jour" onclick="initSelectedList();"></button>
        </div>
    </div>


</div>