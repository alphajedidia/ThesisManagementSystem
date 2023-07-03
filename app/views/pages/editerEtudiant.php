<?php
require_once("../../models/etudiantsModel.php");
require_once("../../connect_database/database.php");
require_once("../../functions/isVariableSet.php");

// Premiere redirection || afficher du formulaire
if (isset($_GET['id'])) {
  $data['matricule'] = $_GET['id'];
  $etudiant = Etudiant::getEtudiant($data);
  
} 

// Verifier si la variable post est definit soumission du formulaire

$isDevine = isVariableSet($_POST, ['matricule', 'nom_etudiant', 'prenom_etudiant', 'niveau', 'parcours', 'adr_email']);
//Traitements
if ($isDevine) {
  if (Etudiant::update($_POST['matricule'], $_POST)) {
    header('Location: /gestion_de_soutenance/app/views/pages/afficheEtudiant.php');
  } else {
    echo "<div class='alert alert-danger'>Echec</div>";
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
          <div class="card card-body">

            <!-- general form elements -->
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Modifier les informations d'un étudiant</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="editerEtudiant.php" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="matricule">Matricule</label>
                    <input type="text" class="form-control" id="matricule" name="matricule" <?php echo "value='" . $etudiant['matricule'] . "'" ?> readonly>
                  </div>
                  <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom_etudiant" required <?php echo "value='" . $etudiant['nom_etudiant'] . "'" ?>>
                  </div>
                  <div class="form-group">
                    <label for="prenom">Prenom(s)</label>
                    <input type="text" class="form-control" id="prenom" name="prenom_etudiant" <?php echo "value='" . $etudiant['prenom_etudiant'] . "'" ?>>
                  </div>
                  <div class="form-group">
                    <label for="niveau">Niveau</label>
                    <select class="form-select form-control" name="niveau" id="niveau" required>
                      <option value="L1" <?php echo ($etudiant['niveau'] === 'L1') ? 'selected' : '' ?>>L1</option>
                      <option value="L2" <?php echo ($etudiant['niveau'] === 'L2') ? 'selected' : '' ?>>L2</option>
                      <option value="L3" <?php echo ($etudiant['niveau'] === 'L3') ? 'selected' : '' ?>>L3</option>
                      <option value="M1" <?php echo ($etudiant['niveau'] === 'M1') ? 'selected' : '' ?>>M1</option>
                      <option value="M2" <?php echo ($etudiant['niveau'] === 'M2') ? 'selected' : '' ?>>M2</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="parcours">Parcours</label>
                    <select class="form-select form-control" name="parcours" id="parcours" required>
                      <option value="GB" <?php echo ($etudiant['niveau'] === 'GB') ? 'selected' : '' ?>>GB</option>
                      <option value="SR" <?php echo ($etudiant['niveau'] === 'SR') ? 'selected' : '' ?>>SR</option>
                      <option value="IG" <?php echo ($etudiant['niveau'] === 'IG') ? 'selected' : '' ?>>IG</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="adr_email">Email address</label>
                    <input type="email" class="form-control" id="adr_email" name="adr_email" <?php echo "value='" . $etudiant['adr_email'] . "'" ?> >
                  </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-dark">Modifier</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
  </section>
</div>
<?php
require_once("../layout/footer.php");
?>