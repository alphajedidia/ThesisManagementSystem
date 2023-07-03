<?php 
require_once("../../models/etudiantsModel.php");
// Connexion base de donnee
require_once("../../connect_database/database.php");
//Echec 
$echec = NULL;
// Verifier si la variable post est definit
require_once("../../functions/isVariableSet.php");
$isDevine = isVariableSet($_POST,['matricule', 'nom_etudiant', 'prenom_etudiant', 'niveau', 'parcours', 'adr_email']);
//Traitements
if($isDevine){
    $etudiant = new Etudiant($_POST['matricule'], $_POST['nom_etudiant'], $_POST['prenom_etudiant'], $_POST['niveau'], $_POST['parcours'], $_POST['adr_email'],true);
    if($etudiant->create()){
        // header('Location: index.php');
        header('Location: /gestion_de_soutenance/app/views/pages/afficheEtudiant.php');
    }else{
        // $echec = "<script defer>alert('Matricule Déja Présent');</script>";
        $echec = "<div class='alert alert-danger'>Echec d'envoye de donnée : matricule Déja Présent</div>";

    }
}

require_once("../layout/header.php");
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"></h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <!-- general form elements -->
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class = "card-title">Ajouter un etudiant</h3>
                        </div>
                        <!-- ECHEC -->
                         <?php
                            if($echec !== NULL){
                                echo $echec;
                            }
                         ?>   

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="ajoutEtudiant.php" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="matricule">Matricule</label>
                                    <input type="text" class="form-control" id="matricule" name="matricule" placeholder="Enter Matricule" required>
                                </div>
                                <div class="form-group">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom_etudiant" required placeholder="Enter nom">
                                </div>
                                <div class="form-group">
                                    <label for="prenom">Prenom(s)</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom_etudiant" placeholder="Enter prenom">
                                </div>
                                <div class="form-group">
                                    <label for="niveau">Niveau</label>
                                    <select class="form-select form-control" name="niveau" id="niveau" required>
                                        <option value="L1">L1</option>
                                        <option value="L2">L2</option>
                                        <option value="L3">L3</option>
                                        <option value="M1">M1</option>
                                        <option value="M2">M2</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="parcours">Parcours</label>
                                    <select class="form-select form-control" name="parcours" id="parcours" required>
                                        <option value="GB">GB</option>
                                        <option value="SR">SR</option>
                                        <option value="IG">IG</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="adr_email">Email address</label>
                                    <input type="email" class="form-control" id="adr_email" name="adr_email" placeholder="Enter email">
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">Ajouter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<?php 
// if($echec!== NULL){
//     echo $echec;
// }
require_once("../layout/footer.php");
?>