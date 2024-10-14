<div class="offcanvas offcanvas-end <?php echo $show[0] ?>" style="width:500px;" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offNewParole" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasBottomLabel">Ajouter une parole</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr>


    <div class="offcanvas-body small">
        <div class="alert alert-secondary" role="alert">

            <div class="row">
                <label class="form-label">Locuteur: </label>

                <select class="form-select" aria-label="Default select example" name="authorAdd">
                    <?php $sql->getAuthorsList($transcriptionId); ?>
                </select>


            </div>
            <br>

            <div class="row">
                <label class="form-label">Début: </label>

                <input msok="yes" type="text" class="form-control" id="TimeAdd1" name="Time1Add" value="00:00:00.00">
                <br>
                <label class="form-label">Fin: </label>

                <input msok="yes" type="text" class="form-control" id="Time2Add" name="Time2Add" value="00:00:00.00">



            </div>

            <br>
            <div class="row">
                <label class="form-label">Parole: </label>

                <textarea class="form-control" name="TexteAdd" rows='2'></textarea>
            </div>


        </div>
        <input msok="yes" class="btn btn-primary" type="submit" id='addPrl' name="addParole" value="Ajouter">
    </div>
</div>