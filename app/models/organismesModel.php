<?php

class Organisme
{
    private $id_org;
    private $design;
    private $lieu;
    private $actif_org;

    public function __construct($id_org, $design, $lieu, $actif_org)
    {
        $this->id_org = $id_org;
        $this->design = $design;
        $this->lieu = $lieu;
        $this->actif_org = $actif_org;
    }

    public function getIdOrg()
    {
        return $this->id_org;
    }
    public function getDesign()
    {
        return $this->design;
    }
    public function getLieu()
    {
        return $this->lieu;
    }
    public function getActifOrg()
    {
        return $this->actif_org;
    }

    // SET FUNCTIONS
    public function SetIdOrg($id_org)
    {
        $this->id_org = $id_org;
    }
    public function setDesign($design)
    {
        $this->design = $design;
    }
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }
    public function setActifOrg($actif_org)
    {
        $this->actif_org = $actif_org;
    }

    // CRUD 
    public function create()
    {
        $pdo = Database::connect();

        $qry =
            "INSERT INTO organismes 
        (id_org, design, lieu, actif_org) 
        VALUES(:id_org, :design, :lieu, True);";

        $preparedQuery = $pdo->prepare($qry);
        $preparedQuery->bindParam(':id_org', $this->id_org, PDO::PARAM_INT);
        $preparedQuery->bindParam(':design', $this->design, PDO::PARAM_STR);
        $preparedQuery->bindParam(':lieu', $this->lieu, PDO::PARAM_STR);

        $success = true;
        try {
            $preparedQuery->execute();
        } catch (PDOException $e) {
            // echo $e->getMessage();
            $success = false;
        }

        Database::disconnect();

        return $success;
    }

    public static function readAll()
    {
        $pdo = Database::connect();

        $qry =
            "SELECT id_org as `Identifiant`, design as `Designation`, lieu as `Lieu` 
        FROM organismes 
        WHERE actif_org = True";

        $preparedQuery = $pdo->prepare($qry);
        $preparedQuery->execute();

        $response = $preparedQuery->fetchAll();

        Database::disconnect();

        return $response;
    }

    public static function update($id, $data)
    {
        $pdo = Database::connect();

        $qry =
        "UPDATE organismes 
        SET id_org = :id_org,
            design = :design,
            lieu = :lieu
        WHERE id_org = :id";

        $preparedQuery = $pdo->prepare($qry);
        $preparedQuery->bindParam(':id_org', $data['id_org'], PDO::PARAM_INT);
        $preparedQuery->bindParam(':design', $data['design'], PDO::PARAM_STR);
        $preparedQuery->bindParam(':lieu', $data['lieu'], PDO::PARAM_STR);
        $preparedQuery->bindParam(':id', $id, PDO::PARAM_INT);

        $success = true;
        try {
            $preparedQuery->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            $success = false;
        }

        Database::disconnect();

        return $success;
    }

    public static function delete($id_org)
    {
        $pdo = Database::connect();

        $qry =
        "UPDATE organismes 
        SET actif_org = False
        WHERE id_org = :id_org;";

        $preparedQuery = $pdo->prepare($qry);
        $preparedQuery->bindParam(':id_org', $id_org, PDO::PARAM_STR);

        $success = true;
        try {
            $preparedQuery->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            $success = false;
        }

        Database::disconnect();

        return $success;
    }

    public static function getOrganisme($data)
    {
        $pdo = Database::connect();

        $preparedQuery = null;

        if (isset($data['id_org'])) {
            $qry =
            "SELECT * 
            FROM organismes
            WHERE id_org = :param;";
            $preparedQuery = $pdo->prepare($qry);
            $preparedQuery->bindParam(':param', $data['id_org'], PDO::PARAM_STR);
        } else if (isset($data['design'])) {
            $qry =
            "SELECT * 
            FROM organismes
            WHERE design = :param;";
            $preparedQuery = $pdo->prepare($qry);
            $preparedQuery->bindParam(':param', $data['design'], PDO::PARAM_STR);
        } else if (isset($data['lieu'])) {
            $qry =
            "SELECT * 
            FROM organismes
            WHERE lieu = :param;";
            $preparedQuery = $pdo->prepare($qry);
            $preparedQuery->bindParam(':param', $data['lieu'], PDO::PARAM_STR);
        }
        $success = true;
        try {
            $preparedQuery->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            $success = false;
        }

        $response = $preparedQuery->fetch();

        Database::disconnect();

        return $response;
    }
}
