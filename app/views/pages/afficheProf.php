<?php
require_once("../../models/professeursModel.php");
require_once("../../connect_database/database.php");
$allProfesseurs = Professeur::readAll();
if(!empty($allProfesseurs)){
  $allKeyProfesseurs = array_keys($allProfesseurs[0]);
}
require_once("../layout/header.php");
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Liste des Professeurs</h1>
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

            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <?php
                  if (!empty($allProfesseurs)):
                ?>
                <thead class="thead-dark">
                  <tr>
                    <?php
                    foreach ($allKeyProfesseurs as $key) {
                      echo "<th scope='col'>$key</th>";
                    }
                    ?>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($allProfesseurs as $rows) {
                    echo "<tr>";
                    foreach ($rows as $rowElem) {
                      echo "<td scope='col'>$rowElem</td>";
                    }
                    $btnCol =
                    "<td scope='col'>
                    <button type='button' class='btn btn-primary btn-md editBtn' data-num=\"" . $rows['Identifiant'] . "\"><i class=\"fas fa-edit\" data-num=\"" . $rows['Identifiant'] . "\"></i></button>
                    <button type=\"button\" class=\"btn btn-danger btn-md deleteBtn\" data-num=\"" . $rows['Identifiant'] . "\"><i class=\"fas fa-trash\" data-num=\"" . $rows['Identifiant'] . "\"></i></button>
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