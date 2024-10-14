<div class="offcanvas offcanvas-end <?php echo $show[4] ?>" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" style="width: 900px;" id="offEclater" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasBottomLabel">Eclater une parole</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <div class="alert alert-secondary " role="alert">

            <div class="row" id="aeclater" style="display: none;">

            </div>
            <div class="row">

                <div class="alert alert-primary" role="alert">
                    <label class="form-label">Cliquer sur le texte et choiser un emplacement pour l'éclater</label>
                    <input msok="yes" type="text" class="form-control" id="aeclater2" name="aeclater2" value="" onclick="eclaterText()">
                </div>


            </div>
            <div class="row">
                <div class="col-2">

                    <select class="form-select" aria-label="Default select example" name="author1">
                        <?php $sql->getAuthorsList($transcriptionId); ?>
                    </select>
                </div>
                <div class="col-4"> <input msok="yes" type="text" class="form-control" id="Time1" name="Time1" value="00:00:00.000 / 00:00:00.000">
                </div>
                <div class="col-6">
                    <textarea class="form-control" placeholder="" id="eclaterTexte1" name="Texte1" rows=1></textarea>
                </div>
            </div><br>
            <div class="row">

                <div class="col-2">

                    <select class="form-select" aria-label="Default select example" name="author2">
                        <?php $sql->getAuthorsList($transcriptionId); ?>
                    </select>
                </div>
                <div class="col-4"> <input msok="yes" type="text" class="form-control" id="Time2" name="Time2" value="00:00:00.000 / 00:00:00.000">
                </div>
                <div class="col-6">
                    <textarea class="form-control" placeholder="" id="eclaterTexte2" name="Texte2" rows=1></textarea>
                </div>


            </div><br>
            <br>
            <input class="btn btn-primary" msok="yes" type="submit" name="Eclater" value="Eclater"></button>

        </div>
    </div>
</div>
<script>
    function eclaterText() {

        var cont = document.getElementById('aeclater2');

        let position = cont.selectionStart;

        let mytext = cont.value;
        let part1 = mytext.substring(0, position);
        let part2 = mytext.substring(position, cont.length);

        document.getElementById("eclaterTexte1").value = part1;
        document.getElementById("eclaterTexte2").value = part2;


    }
</script>