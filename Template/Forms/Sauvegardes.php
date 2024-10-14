<div class="offcanvas offcanvas-end <?php echo $show[5] ?>" data-bs-scroll="true" data-bs-backdrop="false" style="width:500px;" tabindex="-1" id="offcanevashistorics" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasBottomLabel">Les sauvegardes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <div class="row">

            <div class="col-2">
                <label class="form-label"><br></label>

                <button class="btn btn-outline-secondary" msok='yes' title="Créer une sauvegarde" type="submit" id='createSavebtn' name="createSavebtn" value="createS">
                    <i class="fa-regular fa-floppy-disk" style="color: #E3784C;"></i>
                </button>



            </div>
        </div>
        <br>
        <div class="row">

            <?php
            $voir->SavedList($savedList);

            ?>
        </div>

    </div>


</div>