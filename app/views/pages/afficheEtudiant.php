<?php
require_once("../../models/etudiantsModel.php");
require_once("../../models/soutenirModel.php");
require_once("../../connect_database/database.php");

$allEtudiants = null;
$allKeyEtudiants = null;
$nbr = 0;
if(isset($_GET['searchEngine'])){
  $allEtudiants = Etudiant::searchEngine($_GET['searchEngine']);
  if(!empty($allEtudiants)){
    $allKeyEtudiants = array_keys($allEtudiants[0]);
  }
} else if (isset($_GET['filtre'])){
  $allEtudiants = Etudiant::filtre($_GET['filtre']);
  $nbr = 1;
if(!empty($allEtudiants)){
    $allKeyEtudiants = array_keys($allEtudiants[0]);
}
} else if (isset($_POST['noSoutenance'])) {
  $allEtudiants = Soutenir::allStudentNoSoutenace();
  if(!empty($allEtudiants)){
    $allKeyEtudiants = array_keys($allEtudiants[0]);
  }
}
else {
    $allEtudiants = Etudiant::readAll();
    if(!empty($allEtudiants)){
      $allKeyEtudiants = array_keys($allEtudiants[0]);
    }
}
require_once("../layout/header.php");
?>

<div class="content-wrapper" >
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Liste des étudiants</h1>
        </div>
      </div>
          <form action="afficheEtudiant.php" method="GET">
            <div class="input-group" style = "position : absolute;margin-top: 5px;">
              <select class="form-select mr-0" name = "filtre">
                <option value="1"  <?php if($nbr==1){if($_GET['filtre']=='1'){echo'selected';}}?>>Tous les Etudiants</option>
                <option value="L1" <?php if($nbr==1){if($_GET['filtre']=='L1'){echo'selected';}}?>>L1</option>
                <option value="L2" <?php if($nbr==1){if($_GET['filtre']=='L2'){echo'selected';}}?>>L2</option>
                <option value="L3" <?php if($nbr==1){if($_GET['filtre']=='L3'){echo'selected';}}?>>L3</option>
                <option value="M1" <?php if($nbr==1){if($_GET['filtre']=='M1'){echo'selected';}}?>>M1</option>
                <option value="M2" <?php if($nbr==1){if($_GET['filtre']=='M2'){echo'selected';}}?>>M2</option>
              </select>
              <input type="submit" class="btn btn-outline-secondary" value="Afficher">
            </div>
          </form>
      <div class="row mb-2">
        <div class="col-sm-6 ml-auto" style="width: 400px;">
          <form action="afficheEtudiant.php" method="GET">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Rechercher par matricule ou par nom" name="searchEngine">
              <button class="btn btn-outline-secondary" type="submit" >
                <i class="fas fa-search"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php
 if($nbr == 1){
  if($_GET['filtre']==1)echo"<h2 style='text-align : center;'>Effectif Total de tous les étudiants : " . count ($allEtudiants) . "</h2>";
  else echo"<h2 style='text-align : center;'>Effectif Total " . $_GET['filtre'] . " : " . count ($allEtudiants) . "</h2>";
 }
 ?>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col">

          <!-- general form elements -->
          <div class="card">

            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <?php 
                if (!empty($allEtudiants)):
                ?>
                <thead class="thead-dark">
                  <tr>
                    <?php
                    foreach ($allKeyEtudiants as $key) {
                      echo "<th scope='col'>$key</th>";
                    }
                    ?>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($allEtudiants as $rows) {
                    echo "<tr>";
                    foreach ($rows as $rowElem) {
                      echo "<td scope='col'>$rowElem</td>";
                    }
                    $btnCol =
                      "<td scope='col'>
                    <button type='button' class='btn btn-primary btn-md editBtn' data-num=\"" . $rows['matricule'] . "\"><i class=\"fas fa-edit\" data-num=\"" . $rows['matricule'] . "\"></i></button>
                    <button type=\"button\" class=\"btn btn-danger btn-md deleteBtn\" data-num=\"" . $rows['matricule'] . "\"><i class=\"fas fa-trash\" data-num=\"" . $rows['matricule'] . "\"></i></button>
                    </td>";
                    echo $btnCol;
                    echo "</tr>";
                  }
                  ?>
                <?php 
                else:
                ?>
                <h1 style="color:'red';text-align:center;">Aucun resultat</h1>
                <?php 
                endif;
                ?>
                </tbody>
              </table>
            </div>

          </div>
          <!-- !general element -->
        </div>

      </div>
    </div>
  </section>
</div>
<?php
require_once("../layout/footer.php");
?>