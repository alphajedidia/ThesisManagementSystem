<?php

class Etudiant {
    private $matricule;
    private $nom;
    private $prenom;
    private $niveau;
    private $parcours;
    private $adr_email;

    private $actif;
    
    public function __construct($matricule, $nom, $prenom, $niveau, $parcours, $adr_email ,$actif) {
        $this->matricule = $matricule;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->niveau = $niveau;
        $this->parcours = $parcours;
        $this->adr_email = $adr_email;
        $this->actif = $actif;
    }
    public function getMatricule() {
        return $this->matricule;
    }
    
    public function getNom() {
        return $this->nom;
    }
    
    public function getPrenom() {
        return $this->prenom;
    }
    
    public function getNiveau() {
        return $this->niveau;
    }
    
    public function getParcours() {
        return $this->parcours;
    }
    
    public function getAdrEmail() {
        return $this->adr_email;
    }

    // SET FUNCTIONS

    public function setMatricule($matricule) {
        $this->matricule = $matricule;
    }
    
    public function setNom($nom) {
        $this->nom = $nom;
    }
    
    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }
    
    public function setNiveau($niveau) {
        $this->niveau = $niveau;
    }
    
    public function setParcours($parcours) {
        $this->parcours = $parcours;
    }
    
    public function setAdrEmail($adr_email) {
        $this->adr_email = $adr_email;
    }


    // CRUD functions
    public function create(){
        $pdo = Database::connect();
        $qry = "INSERT INTO `etudiants` 
        (matricule, nom_etudiant, prenom_etudiant, niveau, parcours, adr_email, actif) 
        VALUES (:matricule, :nom_etudiant, :prenom_etudiant, :niveau, :parcours, :adr_email, :actif) ;";

        $preparedQry = $pdo->prepare($qry);

        $preparedQry->bindParam(':matricule',$this->matricule,PDO::PARAM_STR);
        $preparedQry->bindParam(':nom_etudiant',$this->nom,PDO::PARAM_STR);
        $preparedQry->bindParam(':prenom_etudiant',$this->prenom,PDO::PARAM_STR);
        $preparedQry->bindParam(':niveau',$this->niveau,PDO::PARAM_STR);
        $preparedQry->bindParam(':parcours',$this->parcours,PDO::PARAM_STR);
        $preparedQry->bindParam(':adr_email',$this->adr_email,PDO::PARAM_STR);
        $preparedQry->bindParam(':actif',$this->actif,PDO::PARAM_BOOL);

        $success = true;

        try{
            $preparedQry->execute();
        } catch (PDOException $e){
            echo "";
            $success = false;
        }

        Database::disconnect();

        return $success;
    }

    public static function readAll(){
        $pdo = Database::connect();
        $qry = 
        "SELECT matricule, nom_etudiant as Nom, prenom_etudiant as Prenom, niveau, parcours, adr_email as Email
        FROM `etudiants` WHERE actif = True;";
        $preparedQry = $pdo->prepare($qry);
        $preparedQry->execute();
        
        $response = $preparedQry->fetchAll(PDO::FETCH_ASSOC);

        Database::disconnect();

        return $response;
    }

    public static function update($id,$data){
        $pdo = Database::connect();
        $qry = "UPDATE `etudiants` SET 
        matricule = :matricule,
        nom_etudiant = :nom_etudiant,
        prenom_etudiant = :prenom_etudiant, 
        niveau = :niveau, 
        parcours = :parcours, 
        adr_email = :adr_email
        WHERE matricule = :id;";

        $preparedQry = $pdo->prepare($qry);

        $preparedQry->bindParam(':matricule',$data['matricule'],PDO::PARAM_STR);
        $preparedQry->bindParam(':nom_etudiant',$data['nom_etudiant'],PDO::PARAM_STR);
        $preparedQry->bindParam(':prenom_etudiant',$data['prenom_etudiant'],PDO::PARAM_STR);
        $preparedQry->bindParam(':niveau',$data['niveau'],PDO::PARAM_STR);
        $preparedQry->bindParam(':parcours',$data['parcours'],PDO::PARAM_STR);
        $preparedQry->bindParam(':adr_email',$data['adr_email'],PDO::PARAM_STR);
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

    public static function delete($matricule){
        $pdo = Database::connect();
        $qry = "UPDATE `etudiants` SET actif = False WHERE matricule = :matricule;";

        $preparedQry = $pdo->prepare($qry);
        $preparedQry->bindParam(':matricule',$matricule,PDO::PARAM_STR);
        
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

    // Question 2 : Recherche d’étudiant par son numéro ou son nom en utilisant 
    public static function getEtudiant($data){
        $pdo = Database::connect();

        // Preparer une interface pour recherche par matricule ou par nom
        $preparedQry = null;
        if(isset($data['matricule'])){
            $qryByMatricule = 
            "SELECT * 
            FROM etudiants 
            WHERE matricule = :matricule AND actif = True";

            $preparedQry = $pdo->prepare($qryByMatricule);
            $preparedQry->bindParam(':matricule', $data['matricule'],PDO::PARAM_STR);
        } else {
            $qryByName = 
            "SELECT * 
            FROM etudiants 
            WHERE LOWER(nom_etudiant) LIKE LOWER(:nom) AND LOWER(prenom_etudiant) LIKE LOWER(:prenom) AND actif = True;";

            $preparedQry = $pdo->prepare($qryByName);
            $preparedQry->bindParam(':nom',$data['nom_etudiant'],PDO::PARAM_STR);
            $preparedQry->bindParam(':prenom',$data['prenom_etudiant'],PDO::PARAM_STR);
        }
        $preparedQry->execute();
        $response = $preparedQry->fetch();

        Database::disconnect();

        return $response;
    }

    public static function searchEngine($data){
        $pdo = Database::connect();
        $searchString = '%' . $data . '%';
        $request = 
        "SELECT matricule, nom_etudiant as Nom, prenom_etudiant as Prenom, niveau, parcours, adr_email as Email
         FROM etudiants WHERE (matricule LIKE ? OR nom_etudiant LIKE ?) AND actif = True";
        $prepared_stmnt = $pdo->prepare($request);
        $prepared_stmnt->bindParam(1,$data);
        $prepared_stmnt->bindParam(2,$searchString);
        $prepared_stmnt->execute();

        $allEtudiants = array();

        while ($result = $prepared_stmnt->fetch(PDO::FETCH_ASSOC)) {
            $allEtudiants[] = $result;
        }

        Database::disconnect();

        return $allEtudiants;
}

        public static function filtre($data){
            $pdo = Database::connect();
            ($data==1)?($request ="SELECT matricule, nom_etudiant as Nom, prenom_etudiant as Prenom, niveau, parcours, adr_email as Email
            FROM etudiants WHERE ? AND actif = True"):($request = "SELECT matricule, nom_etudiant as Nom, prenom_etudiant as Prenom, niveau, parcours, adr_email as Email
            FROM etudiants WHERE niveau = ? AND actif = True");
            $prepared_stmnt = $pdo->prepare($request);
            $prepared_stmnt->bindParam(1,$data);
            $prepared_stmnt->execute();
            $allEtudiants = array();

            while ($result = $prepared_stmnt->fetch(PDO::FETCH_ASSOC)) {
                $allEtudiants[] = $result;
            }

            Database::disconnect();

            return $allEtudiants;
        }
}

?>