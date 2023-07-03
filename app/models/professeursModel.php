<?php

class Professeur {
    private $id_prof;
    private $nom_prof;
    private $prenom_prof;
    private $civilite;
    private $grade;
    private $actif_prof;

    public function __construct($id_prof, $nom_prof, $prenom_prof, $civilite, $grade, $actif_prof){
        $this->id_prof = $id_prof;
        $this->nom_prof = $nom_prof;
        $this->prenom_prof = $prenom_prof;
        $this->civilite = $civilite;
        $this->grade = $grade;
        $this->actif_prof = $actif_prof;
    }

    public function getIdProf(){
        return $this->id_prof;
    }
    public function getNomProf(){
        return $this->nom_prof;
    }
    public function getPrenomProf(){
        return $this->prenom_prof;
    }
    public function getCivilite(){
        return $this->civilite;
    }
    public function getGrade(){
        return $this->grade;
    }
    public function getActifProf(){
        return $this->actif_prof;
    }

    // SET FUNCTIONS

    public function setIdProf($id_prof){
        $this->id_prof = $id_prof;
    }
    public function setNomProf($nom_prof){
        $this->nom_prof = $nom_prof;
    }
    public function setPrenomProf($prenom_prof){
        $this->prenom_prof = $prenom_prof;
    }
    public function setCivilite($civilite){
        $this->civilite = $civilite;
    }
    public function setGrade($grade){
        $this->grade = $grade;
    }
    public function setActifProf($actif_prof){
        $this->actif_prof = $actif_prof;
    }

    // CRUD
    public function create(){
        $pdo = Database::connect();
        $qry = "INSERT INTO `professeurs` 
        (id_prof, nom_prof, prenom_prof, civilite, grade, actif_prof) 
        VALUES (:id_prof, :nom_prof, :prenom_prof, :civilite, :grade, True) ;";

        $preparedQry = $pdo->prepare($qry);

        $preparedQry->bindParam(':id_prof',$this->id_prof,PDO::PARAM_STR);
        $preparedQry->bindParam(':nom_prof',$this->nom_prof,PDO::PARAM_STR);
        $preparedQry->bindParam(':prenom_prof',$this->prenom_prof,PDO::PARAM_STR);
        $preparedQry->bindParam(':civilite',$this->civilite,PDO::PARAM_STR);
        $preparedQry->bindParam(':grade',$this->grade,PDO::PARAM_STR);


        $success = true;
        try{
            $preparedQry->execute();
        } catch (PDOException $e){
            // echo $e->getMessage();
            $success = false;
        }

        Database::disconnect();

        return $success;
    }

    public static function readAll(){
        $pdo = Database::connect();

        $qry = 
        "SELECT id_prof as `Identifiant`, nom_prof as `Nom`, prenom_prof as `Prenom`, civilite as `Civilite`, grade as `Grade` 
        FROM `professeurs`
        WHERE actif_prof = True;";

        $preparedQry = $pdo->prepare($qry);
        $preparedQry->execute();

        $response = $preparedQry->fetchAll();

        Database::disconnect();

        return $response;
    }

    public static function update($id,$data){
        $pdo = Database::connect();
        $qry = 
        "UPDATE `professeurs` 
        SET id_prof = :id_prof,
            nom_prof = :nom_prof,
            prenom_prof = :prenom_prof, 
            civilite = :civilite, 
            grade = :grade
        WHERE id_prof = :id;";

        $preparedQry = $pdo->prepare($qry);

        $preparedQry->bindParam(':id_prof',$data['id_prof'],PDO::PARAM_STR);
        $preparedQry->bindParam(':nom_prof',$data['nom_prof'],PDO::PARAM_STR);
        $preparedQry->bindParam(':prenom_prof',$data['prenom_prof'],PDO::PARAM_STR);
        $preparedQry->bindParam(':civilite',$data['civilite'],PDO::PARAM_STR);
        $preparedQry->bindParam(':grade',$data['grade'],PDO::PARAM_STR);
        $preparedQry->bindParam(':id',$id,PDO::PARAM_STR);

        $success = true;
        try{
            $preparedQry->execute();
        } catch (PDOException $e){
            echo $e->getMessage();
            $success = false;
        }

        Database::disconnect();

        return $success;
    }

    public static function delete($id){
        $pdo = Database::connect();

        $qry = 
        "UPDATE `professeurs`
        SET actif_prof = False
        WHERE id_prof = :id;";

        $preparedQry = $pdo->prepare($qry);
        $preparedQry->bindParam(':id',$id,PDO::PARAM_STR);

        $success = true;
        try{
            $preparedQry->execute();
        } catch (PDOException $e){
            echo $e->getMessage();
            $success = false;
        }

        Database::disconnect();

        return $success;
    }

    public static function getProfesseur($data){
        $pdo = Database::connect();

        // Preparer une interface pour recherche par matricule ou par nom
        $preparedQry = null;
        if(isset($data['id_prof'])){
            $qryByMatricule = 
            "SELECT * 
            FROM professeurs 
            WHERE id_prof = :id_prof AND actif_prof = True";

            $preparedQry = $pdo->prepare($qryByMatricule);
            $preparedQry->bindParam(':id_prof', $data['id_prof'],PDO::PARAM_STR);
        } else {
            $qryByName = 
            "SELECT * 
            FROM professeurs 
            WHERE LOWER(nom_prof) LIKE LOWER(:nom) AND LOWER(prenom_prof) LIKE LOWER(:prenom) AND actif_prof = True;";

            $preparedQry = $pdo->prepare($qryByName);
            $preparedQry->bindParam(':nom',$data['nom_prof'],PDO::PARAM_STR);
            $preparedQry->bindParam(':prenom',$data['prenom_prof'],PDO::PARAM_STR);
        }
        $preparedQry->execute();
        $response = $preparedQry->fetch();

        Database::disconnect();

        return $response;
    }
}

?>