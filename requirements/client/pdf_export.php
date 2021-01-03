<?php
  require '../../../fpdf182/fpdf.php';
  require_once '../dbconnect.php';

  $link = connectdb();
  mysqli_set_charset($link , "utf8");

  session_start();


class PDF extends FPDF
{

  function Header() {
  global $borders, $font, $telefon, $adresa, $nume, $prenume, $email, $col1, $col2, $col3, $col4, $data_cerere;

  $cellheight = 6;
  $this->SetFont($font, '', 20);
  $this->SetFillColor(55,0,0);
  $this->SetTextColor(255,255,255);
  $this->Cell(5, 20, "", $borders, 0, 'L', true);
  $this->Cell(90, 20, "Istoric taxare", $borders, 0, 'L', true);
  $this->SetFillColor(255,255,255);
  $this->SetFont($font, '', 14);
  $this->SetTextColor(0,0,0);
  $this->Cell(100, 20, $data_cerere, $borders, 1, 'R', true);
  $this->Cell(220, $cellheight, "", $borders, 1, 'L', true);
  
  // nume si prenume
  $this->SetFont($font, 'B', 10);
  $this->Cell(5, $cellheight, "", $borders, 0, 'L', true);
  $this->Cell(40, $cellheight, "Nume si prenume:", $borders, 0, 'L', true);
  $this->SetFont($font, '', 10);
  $this->Cell(50, $cellheight, $prenume . " " . $nume, $borders, 0, 'L', true);

  // titlul companiei 
  $this->SetFont($font, 'B', 20);
  $this->Cell(50, $cellheight * 2, "", $borders, 0, 'L', true);
  $this->Cell(50, $cellheight * 2, "BIBLIOTECA", $borders, 'L', true);
  $this->Cell(15, $cellheight, "", $borders, 0, 'L', true);
  $this->Ln();

  // email
  $this->SetFont($font, 'B', 10);
  $this->Cell(5, $cellheight, "", $borders, 0, 'L', true);
  $this->Cell(40, $cellheight, "E-mail:", $borders, 0, 'L', true);
  $this->SetFont($font, '', 10);
  $this->MultiCell(50, $cellheight, $email, $borders, 'L', true);

  // titlul companiei 
  $this->SetFont($font, 'B', 20);
  $this->Cell(145, $cellheight * 2, "", $borders, 0, 'L', true);
  $this->Cell(50, $cellheight * 2, "NATIONALA", $borders, 'L', true);
  $this->Cell(15, 0, "", $borders, 0, 'L', true);
  $this->Ln();

  // telefon
  $this->SetFont($font, 'B', 10);
  $this->Cell(5, $cellheight, "", $borders, 0, 'L', true);
  $this->Cell(40, $cellheight, "Telefon:", $borders, 0, 'L', true);
  $this->SetFont($font, '', 10);
  $this->MultiCell(50, $cellheight, $telefon, $borders, 'L', true);

  // adresa
  $this->SetFont($font, 'B', 10);
  $this->Cell(5, $cellheight, "", $borders, 0, 'L', true);
  $this->Cell(40, $cellheight, "Adresa:", $borders, 0, 'L', true);
  $this->SetFont($font, '', 10);
  $this->MultiCell(50, $cellheight, $adresa, $borders, 'L', true);

  $this->Cell(40, $cellheight, "", $borders, 0, 'L', true);
  $this->Ln();

  
  $cellheight = 14;
  $col1 = 20;
  $col2 = 90;
  $col3 = 40;
  $col4 = 60;
  // table header
  $this->SetFillColor(55,0,0);
  $this->SetTextColor(255,255,255); 
  $this->SetFont($font, 'B', 10);
  $this->Cell($col1, $cellheight, 'Nr.Crt.', $borders, 0, 'C', true);
  $this->Cell($col2, $cellheight, 'DESCRIERE', $borders, 0,'C',true);
  $this->Cell($col3, $cellheight, 'SUMA', $borders, 0,'C',true);
  $this->Cell($col4, $cellheight, 'DATA TAXARE', $borders, 0,'C',true);
  $this->Ln();
  }


  function Footer()
  {
    global $font, $borders;

    $this->SetY(255);

    // Contact us
    $this->Cell(10);
    $this->SetFont($font, 'B', 12);
    $this->Cell(65, 10, 'Contact', $borders, 0, 'L');

    $x = 100;
    $y = 266;
    $w = 100;
    $this->Image('../../pics/signature2.png', $x, $y, $w);

    $this->Ln();

    $this->SetFont($font, '', 8);
    $this->Cell(15);
    $this->Cell(60, 7, 'Bulevardul Unirii nr. 22, Bucuresti, Sector 3', $borders, 0, 'L');
    $this->Ln();
    $this->SetFont($font, '', 8);
    $this->Cell(15);
    $this->Cell(60, 7, '+40723456789', $borders, 0, 'L');
    $this->Ln();
    $this->Cell(15);
    $this->Cell(60, 7, 'exemplu@gmail.com', $borders, 0, 'L');
    $x = 7;
    $y = 266;
    $w = 5;
    $this->Image('../../pics/location.png', $x, $y, $w);
    $y = $y + 7;
    $this->Image('../../pics/phone.png', $x, $y, $w);
    $y = $y + 7;
    $this->Image('../../pics/email2.png', $x, $y, $w);
    $this->Ln();
    $this->Ln();
    $this->Ln();

    $this->Cell(210,20);
  }
}

  $query = "SELECT SYSDATE()
            FROM dual";

  $res = mysqli_query($link, $query);

  $data_cerere = mysqli_fetch_array($res)[0];


  $query = "SELECT prenume, nume, telefon, email, adresa, taxa
            FROM client
            WHERE id_client = " . $_SESSION['id'];

  $prenume = "";
  $nume = "";
  $telefon = "";
  $email = "";
  $adresa = "";
  $taxa = 0;

  if ($res = mysqli_query($link, $query)) {
    $row = mysqli_fetch_array($res);
    $prenume = $row[0];
    $nume = $row[1];
    $telefon = $row[2];
    $email = $row[3];
    $adresa = $row[4];
    $taxa = $row[5];
  }

  $query = "SELECT descriere, suma, data_taxare
            FROM taxe
            WHERE id_client = " . $_SESSION['id'];

  $descriere = array();
  $suma = array();
  $data = array();

  if ($res = mysqli_query($link, $query)) {
    while ($row = mysqli_fetch_array($res)) {
      array_push($descriere, $row[0]);
      array_push($suma, $row[1]);
      array_push($data, $row[2]);
    }
  }

  ///////////////////////////////////////////////

  $cellheight = 6;
  $borders = 0;
  $font = 'Poppins';

  $pdf = new PDF();
  $pdf->SetMargins(0,0,0);
  $pdf->SetAutoPageBreak(true, 10);
  $pdf->SetFillColor(255,255,255);
  $pdf->AddFont('Poppins', '', 'Poppins-Regular.php');
  $pdf->AddFont('Poppins', 'B', 'Poppins-Bold.php');
  $pdf->AddPage();
  
  
  $cellheight = 14;

  // table content
  $pdf->SetFont($font, '', 10);
  $pdf->SetTextColor(0,0,0); 

  for ($i = 0; $i < count($descriere); $i++) {

    if ($i % 2 == 0) {
      $pdf->SetFillColor(255,255,255);
    }
    else {
      $pdf->SetFillColor(240,240,240);
    }

    if ($i % 10 == 0 && $i != 0 && count($descriere) % 10 != 0) {
      $pdf->SetAutoPageBreak(true, 10);
      $pdf->AddPage();
    }

    $pdf->SetFont($font, '', 10);
    $pdf->Cell($col1, $cellheight, $i + 1, $borders, 0, 'C', true);

    if (strlen($descriere[$i]) <= 50) {
      $pdf->Cell($col2, $cellheight, $descriere[$i], $borders, 0, 'C', true);
      $pdf->Cell($col3, $cellheight, $suma[$i], $borders, 0, 'C', true);
      $pdf->Cell($col4, $cellheight, $data[$i], $borders, 0, 'C', true);
    }
    else {
      $subcellheight = $cellheight / 2;

      $poz = strpos($descriere[$i], " ", 40);
      $poz1 = strpos($descriere[$i], ";", 40);
      if ($poz1 >= 0) {
        $poz = $poz1 + 1;
      }
      if ($poz < 0) {
        $poz = strlen($descriere[$i]);
      }
      $pdf->Cell($col2, $subcellheight, substr($descriere[$i], 0, $poz) , $borders, 0, 'C', true);
      $pdf->Cell($col3, $cellheight, $suma[$i], $borders, 0, 'C', true);
      $pdf->Cell($col4, $cellheight, $data[$i], $borders, 0, 'C', true);
      $pdf->Cell(1, $subcellheight, "", $borders, 0, 'C', true);
      $pdf->Ln();

      if (strlen($descriere[$i]) >= $poz) {
        $pdf->SetFont($font, '', 7);
        $pdf->Cell($col1, $subcellheight, "", $borders, 0, 'C', false);
        $pdf->Cell($col2, $subcellheight, substr($descriere[$i], $poz), $borders, 0, 'C', true);
      }
    }

    $pdf->Ln();
  }

  $pdf->Cell(110,$cellheight, "", $borders, 1, 'C', false);

  //Subtotal
  $pdf->SetFont($font, 'B', 15);
  $pdf->Cell(110, $cellheight);
  $pdf->Cell(45, $cellheight, 'Rest de plata:', $borders, 0, 'C', true);  
  $pdf->Cell(55, $cellheight, $taxa . "RON", $borders, 0, 'C', true);
  $pdf->Ln();
  

  $pdf->Output('D', 'Istoric taxare.pdf');

  header("Location: ../../contulmeu.php");
?>