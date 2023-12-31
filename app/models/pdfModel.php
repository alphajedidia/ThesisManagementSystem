<?php
// Création de la class PDF
class PDF extends FPDF {
  // Header
  function Header() {
    // Logo : 8 >position à gauche du document (en mm), 2 >position en haut du document, 80 >largeur de l'image en mm). La hauteur est calculée automatiquement.
    $this->Image('../Images/logoENI.png',8,2);
    // Saut de ligne 20 mm
    $this->Ln(20);

    // Titre gras (B) police Helbetica de 11
    $this->SetFont('Helvetica','B',11);
    // fond de couleur gris (valeurs en RGB)
    $this->setFillColor(230,230,230);
     // position du coin supérieur gauche par rapport à la marge gauche (mm)
    $this->SetX(70);
    // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
    $this->Cell(60,8,'VOYAGE GASTRO',0,1,'C',1);
    // Saut de ligne 10 mm
    $this->Ln(10);    
  }
  // Footer
  function Footer() {
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Helvetica','I',9);
    // Numéro de page, centré (C)
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
  }
}
?>