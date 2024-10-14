<?php

require 'config.php';

class sql
{
    //************************************************************************************************************************************* */

    private $Connexion;

    //************************************************************************************************************************************* */

    function __construct()
    {
        $this->Connexion =
            $connexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME)
            or die("Erreur de connexion : " . mysqli_error($this->Connexion));
    }

    //************************************************************************************************************************************* */

    function __destruct()
    {
        $this->Connexion->close();
    }

    //************************************************************************************************************************************* */

    public function Login($user, $pwrd)
    {


        $query = "SELECT * FROM `UTILISATEUR` WHERE Identifiant='$user' and passWd='$pwrd' and Access=1";
        $result = $this->Connexion->query($query);

        return ($result->num_rows);
    }

    //*************************************************************************************************************************************
    public function userExist($user)
    {


        $query = "SELECT * FROM `UTILISATEUR` WHERE Identifiant='$user'";
        $result = $this->Connexion->query($query);
        return ($result->num_rows);
    }

    //************************************************************************************************************************************* */


    //
    public function canAcess($user_id, $canaccess)
    {


        if ($canaccess == '1')
            $canaccess = '0';
        else $canaccess = '1';
        $sql = "update UTILISATEUR set Access ='$canaccess' where id = $user_id";
        $result = $this->Connexion->query($sql);
    }
    //************************************************************************************************************************************* */


    public function addUser($identifiant, $profil, $Nom, $Prenom, $Mail, $password)
    {
        $sql = "SELECT COUNT(*) AS num_rows FROM UTILISATEUR WHERE Identifiant ='{$Mail}' LIMIT 1;";
        $result = $this->Connexion->query($sql);

        $row = $result->fetch_array();
        if ($row["num_rows"] > 0) {
            return (0);
        } else {

            $sql = "INSERT INTO UTILISATEUR (Id, Identifiant, Profil, Nom, Prenom, Mail, PassWd, Access) 
            values 
            (NULL, '" . $identifiant . "','" . $profil . "','" . $Nom . "','" . $Prenom . "','" . $Mail . "','" . $password . "',0)";
            $result = $this->Connexion->query($sql);
            return (1);
        }
    }





    //************************************************************************************************************************************* */

    public function getUserType($user)
    {
        $sql = " select  Profil from UTILISATEUR where Identifiant = '{$user}'";
        $result = $this->Connexion->query($sql);
        $row = $result->fetch_array();

        return $row['Profil'];
    }

    //************************************************************************************************************************************* */


    public function getUserId($user)
    {
        $sql = " select  id from UTILISATEUR where Identifiant = '{$user}'";
        $result = $this->Connexion->query($sql);
        $row = $result->fetch_array();

        return $row['id'];
    }

    //************************************************************************************************************************************* */


    public function getAuthorId($user)
    {
        $sql = " select  Id from AUTEUR where Identifiant = '{$user}'";
        $result = $this->Connexion->query($sql);
        $row = $result->fetch_array();

        return $row['Id'];
    }

    //************************************************************************************************************************************* */
    //************************************************************************************************************************************* */


    public function getTranscriptionText($trans_id)
    {
        $query = "   SELECT Id, IdAuteur, CONCAT(DDebut, ' / ', Dfin), Texte, DebutTS, FinTS 
        FROM `TRANSTEXTE` 
        WHERE  TransId  = '{$trans_id}' and IDAut in (Select  Id From AUTEUR where Voir = 1 and TransId  = '{$trans_id}')
        order by DebutTS ASC ";
        $result = $this->Connexion->query($query);
        return ($result);
    }




    //************************************************************************************************************************************* */
    //************************************************************************************************************************************* */

    public function getLastid()
    {
        return ($this->Connexion->insert_id);
    }

    //************************************************************************************************************************************* */

    public function InTable($table, $field, $value)
    {


        $query = "SELECT * FROM $table WHERE $field='$value'";
        $result = $this->Connexion->query($query);
        return ($result->num_rows);
    }

    //************************************************************************************************************************************* */

    public function DeleteFromTable($table, $id, $value)
    {
        $sql = "delete from $table where $id = '$value'";

        $result = $this->Connexion->query($sql);
    }
    //************************************************************************************************************************************* */

    public function AddToTable($table, $columns, $values)
    {

        try {

            $sql = "INSERT INTO $table ($columns) VALUES ($values)";
            $result = $this->Connexion->query($sql);
            return (1);
        } catch (Exception $e) {
            return (0);
        }
    }

    //************************************************************************************************************************************* */

    public function EditTable($table, $values, $condition)
    {

        $sql = "Update $table SET $values 
                where $condition ";

        try {
            $result = $this->Connexion->query($sql);
        } catch (Exception $e) {
            die("Une erreur s'est produite l'or de la mise à jour. Merci de vérifier le données à mettre à jour");
        }
    }

    //********************************************************************************************************************

    public function SelectFromTable($table, $list, $condition)
    {
        $result = NULL;
        $SQL  = "SELECT $list FROM $table $condition order by Id ASC";
        $result = $this->Connexion->query($SQL);
        return $result;
    }

    //********************************************************************************************************************

    public function SelectFrom($table, $list, $condition)
    {
        $result = NULL;
        $SQL  = "SELECT $list FROM $table $condition";
        $result = $this->Connexion->query($SQL);
        return $result;
    }



    //*************************************************************************************************************************************
    public function AhthorExist($author)
    {


        $query = "SELECT * FROM `AUTEUR` WHERE Identifiant='$author'";
        $result = $this->Connexion->query($query);
        return ($result->num_rows);
    }

    //************************************************************************************************************************************* */

    public function getAuthorsList($id)
    {

        $SQL = "SELECT Id, Identifiant FROM `AUTEUR` where TransId = $id";


        $result = $this->Connexion->query($SQL);

        while ($row = $result->fetch_row())
            echo "<option value='$row[0]'>$row[1]</option>";
    }

    //************************************************************************************************************************************* */

    public function getAuthorsLists($id)
    {

        $SQL = "SELECT Id, Identifiant FROM `AUTEUR` where TransId = $id";


        $result = $this->Connexion->query($SQL);
        return $result;
    }



    //*************************************************************************************************************************************

    public function getAuthorName($TransId, $authorId)
    {
        $sql = "SELECT Identifiant FROM `AUTEUR` where TransId = $TransId and Id = $authorId";
        $result = $this->Connexion->query($sql);
        $row = $result->fetch_array();

        return $row['Identifiant'];
    }


    //************************************************************************************************************************************* */

    public function UpdateAuthors($transid)
    {

        try {

            $sql = "
            INSERT INTO AUTEUR (Identifiant, TransId) 
            SELECT IdAuteur, TransId from TRANSTEXTE where TransId = '{$transid}' group by IdAuteur
            ";

            $result = $this->Connexion->query($sql);
            return (1);
        } catch (Exception $e) {
            return (0);
        }
    }


    //*************************************************************************************************************************************

    public function getSilence($Transid)
    {

        $sql = "SELECT Id FROM `AUTEUR` where TransId = $Transid and Identifiant = 'Silence'";
        $result = $this->Connexion->query($sql);
        $author = $result->fetch_array();

        $SilenceId = $author['Id'];

        $SQL = "SELECT Id, DFin, FinTS, IdAuteur, IdAut  FROM TRANSTEXTE WHERE TransId = " . $Transid . " and FinTS not in (select DebutTS from TRANSTEXTE) order by DebutTS ASC;";
        $result = $this->Connexion->query($SQL);

        while ($row = $result->fetch_row()) {
            $ql = "SELECT Id, DDebut, DebutTS FROM TRANSTEXTE WHERE TransId = " . $Transid . " and DebutTS>" . $row[2] . " order by DDebut asc LIMIT 1;";

            $res = $this->Connexion->query($ql);
            $row2 = $res->fetch_row();

            $texte = "0";

            if ($row2 != null) {

                // get Silence Id

                $q = "insert into TRANSTEXTE (TransId, Texte,DDebut, DFin,IdAuteur, IdAut, DebutTS, FinTS)
                                        values ('{$Transid}','{$texte}', '{$row[1]}','{$row2[1]}','Silence','{$SilenceId}','{$row[2]}','{$row2[2]}')";

                $t = $this->Connexion->query($q);
            }
        }

        $SQL = "delete from TRANSTEXTE where TransId = " . $Transid . " and DFin =''";
        $this->Connexion->query($SQL);

        $SQL = "update TRANSTEXTE set Texte = ROUND((FinTS-DebutTS)/1000,2) where IdAuteur='Silence' and TransId = " . $Transid;
        $this->Connexion->query($SQL);
    }
    //*************************************************************************************************************************************

    public function sortTable($table, $id)


    {
        $sql = "ALTER TABLE $table ORDER BY $id ASC;";
        $res = $this->Connexion->query($sql);
    }
}
