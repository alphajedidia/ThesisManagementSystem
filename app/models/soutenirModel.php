<?php 

class Soutenir 
{
    private $matricule;
    private $annee_univ;
    private $id_org;
    private $note;
    private $president;
    private $examinateur;
    private $rapporteur_int;
    private $rapporteur_ext;

    public function __construct($matricule,$annee_univ,$id_org,$note,$president,$examinateur,$rapporteur_int,$rapporteur_ext){
        $this->matricule = $matricule;
        $this->annee_univ = $annee_univ;
        $this->id_org = $id_org;
        $this->note = floatval($note);
        $this->president = $president;
        $this->examinateur = $examinateur;
        $this->rapporteur_int = $rapporteur_int;
        $this->rapporteur_ext = $rapporteur_ext;
    }

    public function getMatricule(){
        return $this->matricule;
    }
    public function getAnnee_univ(){
        return $this->annee_univ;
    }
    public function getId_org(){
        return $this->id_org;
    }
    public function getNote(){
        return $this->note;
    }
    public function getPresident(){
        return $this->president;
    }
    public function getExaminateur(){
        return $this->examinateur;
    }
    public function getRapporteur_int(){
        return $this->rapporteur_int;
    }
    public function getRapporteur_ext(){
        return $this->rapporteur_ext;
    }

    // SET FUNCTIONS 
    public function SetMatricule($matricule){
        $this->matricule = $matricule;
    }
    public function setAnnee_univ($annee_univ){
        $this->annee_univ = $annee_univ;
    }
    public function setId_org($id_org){
        $this->id_org = $id_org;
    }
    public function setNote($note){
        $this->note = $note;
    }
    public function setPresident($president){
        $this->president = $president;
    }
    public function setExaminateur($examinateur){
        $this->examinateur = $examinateur;
    }
    public function setRapporteur_int($rapporteur_int){
        $this->rapporteur_int = $rapporteur_int;
    }
    public function setRapporteur_ext($rapporteur_ext){
        $this->rapporteur_ext = $rapporteur_ext;
    }

    // CRUD
    public function create(){
        $pdo = Database::connect();

        $qry = "INSERT INTO `soutenir` (matricule, annee_univ, id_org, note, president, examinateur, rapporteur_int, rapporteur_ext)
        VALUES (:matricule, :annee_univ, :id_org, :note, :president, :examinateur, :rapporteur_int, :rapporteur_ext)";

        $preparedQry = $pdo->prepare($qry);
        $preparedQry->bindParam(':matricule',$this->matricule,PDO::PARAM_STR);
        $preparedQry->bindParam(':annee_univ',$this->annee_univ,PDO::PARAM_STR);
        $preparedQry->bindParam(':id_org',$this->id_org,PDO::PARAM_INT);
        // A noter que note est de type `float` mais la bdd le transformera automatiquement
        $preparedQry->bindParam(':note',$this->note,PDO::PARAM_STR);
        $preparedQry->bindParam(':president',$this->president,PDO::PARAM_STR);
        $preparedQry->bindParam(':examinateur',$this->examinateur,PDO::PARAM_STR);
        $preparedQry->bindParam(':rapporteur_int',$this->rapporteur_int,PDO::PARAM_STR);
        $preparedQry->bindParam(':rapporteur_ext',$this->rapporteur_ext,PDO::PARAM_STR);

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

    public static function readAll(){
        $pdo = Database::connect();

        $qry = 
        "SELECT s.matricule as `Matricule`, 
                e.nom_etudiant as `Nom`, 
                e.prenom_etudiant as `Prenom(s)`, 
                o.design as `Organisme`, 
                s.note as `Note`, 
                s.annee_univ as `Annee universitaire`, 
                CONCAT(p1.nom_prof, ' ', p1.prenom_prof) AS `President`, 
                CONCAT(p2.nom_prof, ' ', p2.prenom_prof) AS `Examinateur`, 
                CONCAT(p3.nom_prof, ' ', p3.prenom_prof) AS `Rapporteur Int`, 
                CONCAT(p4.nom_prof, ' ', p4.prenom_prof) AS `Rapporteur Ext`
        FROM soutenir s
        JOIN organismes o ON s.id_org = o.id_org
        JOIN etudiants e ON s.matricule = e.matricule
        JOIN professeurs p1 ON s.president = p1.id_prof
        JOIN professeurs p2 ON s.examinateur = p2.id_prof
        JOIN professeurs p3 ON s.rapporteur_int = p3.id_prof
        JOIN professeurs p4 ON s.rapporteur_ext = p4.id_prof;";

        $preparedQry = $pdo->prepare($qry);
        $preparedQry->execute();

        $response = $preparedQry->fetchAll();

        Database::disconnect();

        return $response;
    }

    public static function update($id,$data){
        $pdo = Database::connect();

        $qry = 
        "UPDATE soutenir 
        SET matricule = :matricule, 
        annee_univ = :annee_univ, 
        id_org = :id_org, 
        note = :note, 
        president = :president, 
        examinateur = :examinateur, 
        rapporteur_int = :rapporteur_int, 
        rapporteur_ext = :rapporteur_ext
        WHERE matricule = :id";

        $preparedQry = $pdo->prepare($qry);

        $preparedQry->bindParam(':matricule',$data['matricule'],PDO::PARAM_STR);
        $preparedQry->bindParam(':annee_univ',$data['annee_univ'],PDO::PARAM_STR);
        $preparedQry->bindParam(':id_org',$data['id_org'],PDO::PARAM_INT);
        $preparedQry->bindParam(':note',$data['note']);
        $preparedQry->bindParam(':president',$data['president'],PDO::PARAM_STR);
        $preparedQry->bindParam(':examinateur',$data['examinateur'],PDO::PARAM_STR);
        $preparedQry->bindParam(':rapporteur_int',$data['rapporteur_int'],PDO::PARAM_STR);
        $preparedQry->bindParam(':rapporteur_ext',$data['rapporteur_ext'],PDO::PARAM_STR);
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
        "DELETE FROM soutenir
        WHERE matricule = :id";

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

    public static function getSoutenanceByDate($date){
        $pdo = Database::connect();

        $qry = 
        "SELECT  
                s.note as `Note`,
                s.annee_univ as `Annee universitaire`, 
                s.matricule as `Matricule`, 
                e.nom_etudiant as `Nom`, 
                e.prenom_etudiant as `Prenom(s)`, 
                o.design as `Organisme`, 
                CONCAT(p1.nom_prof, ' ', p1.prenom_prof) AS `President`, 
                CONCAT(p2.nom_prof, ' ', p2.prenom_prof) AS `Examinateur`, 
                CONCAT(p3.nom_prof, ' ', p3.prenom_prof) AS `Rapporteur Int`, 
                CONCAT(p4.nom_prof, ' ', p4.prenom_prof) AS `Rapporteur Ext`
        FROM soutenir s
        JOIN organismes o ON s.id_org = o.id_org
        JOIN etudiants e ON s.matricule = e.matricule
        JOIN professeurs p1 ON s.president = p1.id_prof
        JOIN professeurs p2 ON s.examinateur = p2.id_prof
        JOIN professeurs p3 ON s.rapporteur_int = p3.id_prof
        JOIN professeurs p4 ON s.rapporteur_ext = p4.id_prof
        WHERE " . $date . " ORDER BY annee_univ;";

        $preparedQry = $pdo->prepare($qry);
        $preparedQry->execute();

        $allSoutenances = array();

        while($result = $preparedQry->fetch(PDO::FETCH_ASSOC)){
            $allSoutenances[] = $result;
        }


        Database::disconnect();

        return $allSoutenances;
    }

    public static function getSoutenanceByMatricule($matricule){
        $pdo = Database::connect();

        $qry = 
        "SELECT s.matricule as `matricule`, 
                e.nom_etudiant as `Nom`, 
                e.prenom_etudiant as `Prenom`, 
                s.id_org as `id_org`,
                o.design as `Organisme`, 
                s.annee_univ as `Annee universitaire`,
                s.note as `Note`,
                p1.id_prof as `id_president`,
                CONCAT(p1.nom_prof, ' ', p1.prenom_prof) AS `President`, 
                p2.id_prof as `id_examinateur`,
                CONCAT(p2.nom_prof, ' ', p2.prenom_prof) AS `Examinateur`, 
                p3.id_prof as `id_rapporteur_int`,
                CONCAT(p3.nom_prof, ' ', p3.prenom_prof) AS `Rapporteur_Int`, 
                p4.id_prof as `id_rapporteur_ext`,
                CONCAT(p4.nom_prof, ' ', p4.prenom_prof) AS `Rapporteur_Ext`
        FROM soutenir s
        JOIN organismes o ON s.id_org = o.id_org
        JOIN etudiants e ON s.matricule = e.matricule
        JOIN professeurs p1 ON s.president = p1.id_prof
        JOIN professeurs p2 ON s.examinateur = p2.id_prof
        JOIN professeurs p3 ON s.rapporteur_int = p3.id_prof
        JOIN professeurs p4 ON s.rapporteur_ext = p4.id_prof
        WHERE s.matricule = :param;";

        $preparedQry = $pdo->prepare($qry);

        $preparedQry->bindParam(':param',$matricule,PDO::PARAM_STR);

        $preparedQry->execute();

        $response = $preparedQry->fetchAll();

        Database::disconnect();

        return $response;
    }

    //  Question 5:
    public static function format(int $begin , int $end) : string
    {
        $intBegin = $begin;
        $intEnd = $end;
        $format = '';
        $annee = [];
        $annee_univ = "annee_univ";
        for($i = $intBegin;$i<$intEnd;$i++){
            $tmp = $annee_univ." = '".$i . '-' . ($i+1). "' ";
            $annee[] = $tmp;
        }
        $separator = ' OR ';
        $format = implode($separator,$annee);
        return $format;
    }

    /**
     * @return $response : list of matricule of all student who don't have already make a soutenance
     */
    public static function allMatricule() : array {
        $pdo = Database::connect();
        $qry = 
        "SELECT e.matricule
        FROM etudiants e 
        LEFT OUTER JOIN soutenir s ON e.matricule=s.matricule
        WHERE s.matricule IS NULL AND e.actif = TRUE AND (e.niveau = 'L3' OR e.niveau = 'M2')";
        $statement = $pdo->prepare($qry);
        $statement->execute();

        $response = $statement->fetchAll();

        Database::disconnect();

        return $response;
    }
    /**
     * Last question : Show the list of student who don't have done 
     */
    public static function allStudentNoSoutenace() {
        $pdo = Database::connect();
        $qry = 
        "SELECT e.matricule as matricule, nom_etudiant as Nom, prenom_etudiant as Prenom, niveau, parcours, adr_email as Email
        FROM etudiants e 
        LEFT OUTER JOIN soutenir s ON e.matricule=s.matricule
        WHERE s.matricule IS NULL AND e.actif = TRUE AND (e.niveau = 'L3' OR e.niveau = 'M2')";
        $statement = $pdo->prepare($qry);
        $statement->execute();

        $allEtudiants = array();

        while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
            $allEtudiants[] = $result;
        }

        Database::disconnect();

        return $allEtudiants;
    }

    public static function generatePDF(string $matricule){
        $pdo = Database::connect();
        function convertir_en_lettre($nombre) {
            $lettres = array(
                0 => 'zéro',
                1 => 'un',
                2 => 'deux',
                3 => 'trois',
                4 => 'quatre',
                5 => 'cinq',
                6 => 'six',
                7 => 'sept',
                8 => 'huit',
                9 => 'neuf',
                10 => 'dix',
                11 => 'onze',
                12 => 'douze',
                13 => 'treize',
                14 => 'quatorze',
                15 => 'quinze',
                16 => 'seize',
                17 => 'dix-sept',
                18 => 'dix-huit',
                19 => 'dix-neuf',
                20 => 'vingt'
            );
            
            if (isset($lettres[$nombre])) {
                return $lettres[$nombre];
            }
            
            if ($nombre < 20) {
                if ($nombre > 16) {
                    return 'dix-' . convertir_en_lettre($nombre - 10);
                } elseif ($nombre > 12) {
                    return 'dix-' . $lettres[$nombre - 10];
                } elseif ($nombre == 11) {
                    return 'onze';
                } else {
                    return $lettres[$nombre % 10] . '-'. $lettres[10];
                }
            }
            
            return '';
        }
        
        $searchString = '%' . $matricule . '%';

            
            //Les requêtes SQL
            $request = "SELECT * FROM etudiants WHERE matricule LIKE ?";
            $query = "SELECT * FROM soutenir WHERE matricule LIKE ?";
            $requete1 = "SELECT professeurs.civilite ,professeurs.nom_prof,professeurs.prenom_prof,grade FROM professeurs JOIN soutenir ON professeurs.id_prof=soutenir.president WHERE soutenir.matricule LIKE ?";
            $requete2 = "SELECT professeurs.civilite ,professeurs.nom_prof,professeurs.prenom_prof,grade FROM professeurs JOIN soutenir ON professeurs.id_prof=soutenir.examinateur WHERE soutenir.matricule LIKE ?";
            $requete3 = "SELECT professeurs.civilite ,professeurs.nom_prof,professeurs.prenom_prof,grade FROM professeurs JOIN soutenir ON professeurs.id_prof=soutenir.rapporteur_int WHERE soutenir.matricule LIKE ?";
            $requete4 = "SELECT professeurs.civilite ,professeurs.nom_prof,professeurs.prenom_prof,grade FROM professeurs JOIN soutenir ON professeurs.id_prof=soutenir.rapporteur_ext WHERE soutenir.matricule LIKE ?";
            //Preparation et execution
            //**___**//
            $preparation = $pdo->prepare($query);
            $prepared_stmnt = $pdo->prepare($request);
            $presider = $pdo->prepare($requete1);
            $examiner = $pdo->prepare($requete2);
            $rapporterInt = $pdo->prepare($requete3);
            $rapporterExt = $pdo->prepare($requete4);
            //bindParam
            $prepared_stmnt->bindParam(1,$searchString);
            $preparation->bindParam(1,$searchString);
            $presider->bindParam(1,$searchString);
            $examiner->bindParam(1,$searchString);
            $rapporterInt->bindParam(1,$searchString);
            $rapporterExt->bindParam(1,$searchString);
            //Execution
            $preparation->execute();
            $prepared_stmnt->execute();
            $presider->execute();
            $examiner->execute();
            $rapporterInt->execute();
            $rapporterExt->execute();
            //**_____**//
            //Liaisons
            $data = $prepared_stmnt->fetch(PDO::FETCH_ASSOC);
            $soutien = $preparation->fetch(PDO::FETCH_ASSOC);
            $president = $presider->fetch(PDO::FETCH_ASSOC);
            $examinateur = $examiner->fetch(PDO::FETCH_ASSOC);
            $rapporteurInt = $rapporterInt->fetch(PDO::FETCH_ASSOC);
            $rapporteurExt = $rapporterExt->fetch(PDO::FETCH_ASSOC);
            //Variable de stockage
            $note = $soutien['note'];
            $niveau = $data['niveau'];
            $parcours = $data['parcours'];
            $nom = $data['nom_etudiant'];
            $prenom = $data['prenom_etudiant'];
            $civiliteP = $president['civilite'];
            $nom_profP = $president['nom_prof'];
            $prenom_profP = $president['prenom_prof'];
            $gradeP = $president['grade'];
            $civiliteE = $examinateur['civilite'];
            $nom_profE = $examinateur['nom_prof'];
            $prenom_profE = $examinateur['prenom_prof'];
            $gradeE = $examinateur['grade'];
            $civiliteRI = $rapporteurInt['civilite'];
            $nom_profRI = $rapporteurInt['nom_prof'];
            $prenom_profRI = $rapporteurInt['prenom_prof'];
            $gradeI = $rapporteurInt['grade'];
            $civiliteRE = $rapporteurExt['civilite'];
            $nom_profRE = $rapporteurExt['nom_prof'];
            $prenom_profRE = $rapporteurExt['prenom_prof'];
            $gradeE = $rapporteurExt['grade'];
            //conversion note en lettre
            $partie_entiere = intval($note);
            $partie_decimale = $note - $partie_entiere;
            
            $lettre_entiere = convertir_en_lettre($partie_entiere);($partie_decimale);
            
            $noteLettre = $lettre_entiere;
            //Lancement du PDF
            ob_start();
            mb_internal_encoding("UTF-8");
            $pdf = new FPDF ();
            $pdf->AddPage ();
            $pdf->SetFont('Times', "", 13);
            $pdf->Cell(0, 10, "PROCES VERBAL", 0, 2, 'C');
            $pdf->Ln(5);
            if($niveau === 'L3')
            {
                $pdf->Cell(0, 10, "SOUTENANCE DE FIN D'ETUDES POUR L'OBTENTION DU DIPLOME DE LICENCE", 0, 2, 'C');
                $pdf->SetFont('Times', "", 13);
                $pdf->Cell(0, 1, "PROFESSIONNELLE", 0, 1, 'C');
                $pdf->Ln(5);
                $pdf->SetFont('Times', "B", 13);
                $pdf->Cell(40);
                $pdf->Cell(50, 10, "Mention:", 0, 0, 'R');
                $pdf->SetFont('Times', "", 13);
                $pdf->Cell(50, 10, "Informatique", 0, 1, 'L');
                $pdf->Ln(5);
                switch($parcours)
                {
                    case 'GB' : 
                        $pdf->SetFont('Times', "B", 13);
                        $pdf->Cell(120, 0, "Parcours:", 0, 1, 'C');
                        $pdf->SetFont('Times', "", 13);
                        $pdf->Cell(135, 0, utf8_decode("Genie Logiciel et Base de Donnée"), 0, 1, 'R');
                    break;
                    case 'SR' : 
                        $pdf->SetFont('Times', "B", 13);
                        $pdf->Cell(140, 0, "Parcours:", 0, 1, 'C');
                        $pdf->SetFont('Times', "", 13);
                        $pdf->Cell(120, 0, utf8_decode("Système et Reseau"), 0, 1, 'R');
                    break;
                    case 'IG' : 
                        $pdf->SetFont('Times', "B", 13);
                        $pdf->Cell(140, 0, "Parcours:", 0, 1, 'C');
                        $pdf->SetFont('Times', "", 13);
                        $pdf->Cell(123, 0, utf8_decode("Informatique général"), 0, 1, 'R');
                    break;
                    default : echo "Improbable";
                }
                $pdf->Ln(5);
                $pdf->SetFont('Times', "", 13);
                $pdf->Cell(30, 10, "Mr/Mlle $nom $prenom", 0, 1);
                $pdf->Ln(5);
                $pdf->SetFont('Times', "", 13);
                if($note < 10){
                    $pdf->MultiCell(0, 5, utf8_decode("a soutenu publiquement son mémoire de fin d'études pour la non obtention du diplôme de Licence professionnelle"), 0, 1);
                }
                else{
                    $pdf->MultiCell(0, 5, utf8_decode("a soutenu publiquement son mémoire de fin d'études pour l'obtention du diplôme de Licence professionnelle"), 0, 1);
                }
                $pdf->Ln(5);
                $pdf->MultiCell(0, 5, utf8_decode("Après la délibération, la commission des membres du Jury a attribué la note de $note/20 ($noteLettre sur vingt)"), 0, 1);
                $pdf->Ln(10);
                $pdf->SetFont('Times', "U", 13);
                $pdf->Cell(0, 10, "Membres du Jury", 0, 1);
                $pdf->SetFont('Times', "B", 13);
                $pdf->Cell(30, 10, utf8_decode("Président :"), 0, 0);
                $pdf->SetFont('Times', "", 13);
                $pdf->Cell(30, 10, utf8_decode("$civiliteP  $nom_profP $prenom_profP , $gradeP"), 0, 1);
                $pdf->SetFont('Times', "B", 13);
                $pdf->Cell(30, 10, "Examinateur : ", 0, 0);
                $pdf->SetFont('Times', "", 13);
                $pdf->MultiCell(180, 10, utf8_decode("$civiliteE  $nom_profE $prenom_profE , $gradeE"), 0, 1);
                $pdf->SetFont('Times', "B", 13);
                $pdf->Cell(30, 10, utf8_decode("Rapporteurs : "), 0, 0);
                $pdf->SetFont('Times', "", 13);
                $pdf->MultiCell(180, 10, utf8_decode("$civiliteRI  $nom_profRI $prenom_profRI , $gradeI" ), 0, 1);
                $pdf->Cell(145, 10, utf8_decode("$civiliteRE  $nom_profRE $prenom_profRE , $gradeE" ), 0, 1 ,'C');
                $pdf->Output ();
                ob_end_flush();
            }
            else
            {
                $pdf->Cell(0, 10, "SOUTENANCE DE FIN D'ETUDES POUR L'OBTENTION DU DIPLOME DE MASTER", 0, 2, 'C');
                $pdf->SetFont('Times', "", 13);
                $pdf->Cell(0, 1, "PROFESSIONNELLE", 0, 1, 'C');
                $pdf->Ln(5);
                $pdf->SetFont('Times', "B", 13);
                $pdf->Cell(40);
                $pdf->Cell(50, 10, "Mention:", 0, 0, 'R');
                $pdf->SetFont('Times', "", 13);
                $pdf->Cell(50, 10, "Informatique", 0, 1, 'L');
                $pdf->Ln(5);
                switch($parcours)
                {
                    case 'GB' : 
                        $pdf->SetFont('Times', "B", 13);
                        $pdf->Cell(120, 0, "Parcours:", 0, 1, 'C');
                        $pdf->SetFont('Times', "", 13);
                        $pdf->Cell(135, 0, utf8_decode("Genie Logiciel et Base de Donnée"), 0, 1, 'R');
                    break;
                    case 'SR' : 
                        $pdf->SetFont('Times', "B", 13);
                        $pdf->Cell(140, 0, "Parcours:", 0, 1, 'C');
                        $pdf->SetFont('Times', "", 13);
                        $pdf->Cell(120, 0, utf8_decode("Système et Reseau"), 0, 1, 'R');
                    break;
                    case 'IG' : 
                        $pdf->SetFont('Times', "B", 13);
                        $pdf->Cell(140, 0, "Parcours:", 0, 1, 'C');
                        $pdf->SetFont('Times', "", 13);
                        $pdf->Cell(123, 0, utf8_decode("Informatique général"), 0, 1, 'R');
                    break;
                    default : echo "Improbable";
                }
                $pdf->Ln(5);
                $pdf->SetFont('Times', "", 13);
                $pdf->Cell(30, 10, "Mr/Mlle $nom $prenom", 0, 1);
                $pdf->Ln(5);
                $pdf->SetFont('Times', "", 13);
                if($note < 10){
                    $pdf->MultiCell(0, 5, utf8_decode("a soutenu publiquement son mémoire de fin d'études pour la non obtention du diplôme de Master professionnelle"), 0, 1);
                }else{
                    $pdf->MultiCell(0, 5, utf8_decode("a soutenu publiquement son mémoire de fin d'études pour l'obtention du diplôme de Master professionnelle"), 0, 1);
                }
                $pdf->Ln(5);
                $pdf->MultiCell(0, 5, utf8_decode("Après la délibération, la commission des membres du Jury a attribué la note de $note/20 ($noteLettre sur vingt)"), 0, 1);
                $pdf->Ln(10);
                $pdf->SetFont('Times', "U", 13);
                $pdf->Cell(0, 10, "Membres du Jury", 0, 1);
                $pdf->SetFont('Times', "B", 13);
                $pdf->Cell(30, 10, utf8_decode("Président :"), 0, 0);
                $pdf->SetFont('Times', "", 13);
                $pdf->Cell(30, 10, utf8_decode("$civiliteP  $nom_profP $prenom_profP , $gradeP"), 0, 1);
                $pdf->SetFont('Times', "B", 13);
                $pdf->Cell(30, 10, "Examinateur : ", 0, 0);
                $pdf->SetFont('Times', "", 13);
                $pdf->MultiCell(180, 10, utf8_decode("$civiliteE  $nom_profE $prenom_profE , $gradeE"), 0, 1);
                $pdf->SetFont('Times', "B", 13);
                $pdf->Cell(30, 10, "Rapporteurs : ", 0, 0);
                $pdf->SetFont('Times', "", 13);
                $pdf->MultiCell(180, 10, utf8_decode("$civiliteRI  $nom_profRI $prenom_profRI , $gradeI" ), 0, 1);
                $pdf->Cell(145, 10, utf8_decode("$civiliteRE  $nom_profRE $prenom_profRE , $gradeE" ), 0, 1 ,'C');
                $pdf->Output ();
                ob_end_flush();
            }
    }



}

?>