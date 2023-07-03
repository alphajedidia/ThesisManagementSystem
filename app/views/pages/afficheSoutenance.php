<?php
require_once("../../models/soutenirModel.php");
require_once("../../connect_database/database.php");
require_once("../../Features/FPDF/fpdf.php");

$allSoutenances = null;
$nbr = 0;
if(isset($_POST['begin']) && isset($_POST['end'])){
  $begin = (int)$_POST['begin'];
  $end = (int)$_POST['end'];
  $nbr = 1;
  if($begin > $end){
    $tmp = $begin;
    $begin = $end;
    $end = $tmp;
  } else if($begin === $end){
    $end += 1;
  }
  $format = Soutenir::format($begin,$end);
  $allSoutenances = Soutenir::getSoutenanceByDate($format);
  if(!empty($allSoutenances)){
    $allKeySoutenances = array_keys($allSoutenances[0]);
  }
} else if(isset($_GET['submit'])){
  Soutenir::generatePDF($_GET['submit']);
  $allSoutenances = Soutenir::readAll();
  $allKeySoutenances = array_keys($allSoutenances[0]);
}else {
  $allSoutenances = Soutenir::readAll();
  if(! empty($allSoutenances)){
    $allKeySoutenances = array_keys($allSoutenances[0]);
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
          <h1 class="m-0">Liste des Soutenances</h1>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-sm-6 ml-auto" style = "position : absolute;margin-top: 40px;">
          <form action="afficheEtudiant.php" method="POST">
            <div class="input-group">
              <button type="submit" class="btn btn-dark" type="button" name="noSoutenance" style="padding: 20px 50px;">
                Afficher la liste des etudiants qui n'ont pas fait de soutenance
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-sm-6 ml-auto" style="width: 400px; padding :20px 50px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-radius : 10px;">
        <h4>Liste des notes des étudiants entre deux dates</h4>
          <form action="afficheSoutenance.php" method="POST">
            <div class="input-group" style = "display : flex; gap : 0px 10px;">
              <label for="begin"><h1>Debut :  </h1></label>
              <select class="form-select mr-0" aria-label="Filtre de recherche" name='begin' id='begin'>
                <option value="2021"<?php if($nbr==1){if($_POST['begin']=='2021'){echo'selected';}}?>>2021</option>
                <option value="2022"<?php if($nbr==1){if($_POST['begin']=='2022'){echo'selected';}}?>>2022</option>
                <option value="2023"<?php if($nbr==1){if($_POST['begin']=='2023'){echo'selected';}}?>>2023</option>
                <option value="2024"<?php if($nbr==1){if($_POST['begin']=='2024'){echo'selected';}}?>>2024</option>
                <option value="2025"<?php if($nbr==1){if($_POST['begin']=='2025'){echo'selected';}}?>>2025</option>
                <option value="2026"<?php if($nbr==1){if($_POST['begin']=='2026'){echo'selected';}}?>>2026</option>
              </select>
              <label for="end"><h1>Fin : </h1></label>
              <select class="form-select mr-0" aria-label="Filtre de recherche" name='end' id='end'>
                <option value="2021"<?php if($nbr==1){if($_POST['end']=='2021'){echo'selected';}}?>>2021</option>
                <option value="2022"<?php if($nbr==1){if($_POST['end']=='2022'){echo'selected';}}?>>2022</option>
                <option value="2023"<?php if($nbr==1){if($_POST['end']=='2023'){echo'selected';}}?>>2023</option>
                <option value="2024"<?php if($nbr==1){if($_POST['end']=='2024'){echo'selected';}}?>>2024</option>
                <option value="2025"<?php if($nbr==1){if($_POST['end']=='2025'){echo'selected';}}?>>2025</option>
                <option value="2026"<?php if($nbr==1){if($_POST['end']=='2026'){echo'selected';}}?>>2026</option>
              </select>
              <button type="submit" class="btn btn-dark" type="button">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col">

          <!-- general form elements -->
          <div class="card">

            <!-- <div class="card-body"> -->
              <div class="table-responsive">
              <table class="table table-striped table-hover">
              <?php 
                if (!empty($allSoutenances)):
                ?>
                <thead class="thead-dark">
                  <tr>
                    <?php
                    foreach ($allKeySoutenances as $key) {
                      echo "<th scope='col'>$key</th>";
                    }
                    ?>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($allSoutenances as $rows) {
                    echo "<tr>";
                    foreach ($rows as $rowElem) {
                      echo "<td scope='col'>$rowElem</td>";
                    }
                    $btnCol =
                    "<td scope='col'>
                    <div class = 'd-flex p-2' style = \"display : flex; gap : 0 10px;\">
                    <button type='button' class='btn btn-primary btn-md editBtn' data-num=\"" . $rows['Matricule'] . "\"><i class=\"fas fa-edit\" data-num=\"" . $rows['Matricule'] . "\"></i></button>
                    <button type=\"button\" class=\"btn btn-danger btn-md deleteBtn\" data-num=\"" . $rows['Matricule'] . "\"><i class=\"fas fa-trash\" data-num=\"" . $rows['Matricule'] . "\"></i></button>
                    </div>
                    <form action=\"afficheSoutenance.php\" method=\"get\">
                    PDF :<input type=\"submit\" name=\"submit\" class = \"btn btn-dark\" value=\"" . $rows['Matricule'] . "\" style = \"margin : 0 5px;\" />
                    </form>
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
              
            <!-- </div> -->

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