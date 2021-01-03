<?php

  require_once '../dbconnect.php';
  require_once '../../../phpspreadsheet/vendor/autoload.php';

  use PhpOffice\PhpSpreadsheet\IOFactory;
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use \PhpOffice\PhpSpreadsheet\Style\Color;
  use \PhpOffice\PhpSpreadsheet\Style\Alignment;
  use \PhpOffice\PhpSpreadsheet\Style\Fill;

  $link = connectdb();
  mysqli_set_charset($link , "utf8");

  session_start();

  $query = "SELECT DATE_ADD(SYSDATE(), INTERVAL 7 HOUR)
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

  $spreadsheet = new Spreadsheet();
  $spreadsheet->getDefaultStyle()
    ->getFont()
    ->setName('Arial')
    ->setSize(10);

    $spreadsheet->getActiveSheet()->getPageSetup()
    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
$spreadsheet->getActiveSheet()->getPageSetup()
    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
  
  $sheet = $spreadsheet->getActiveSheet();


  $sheet->mergeCells('I2:K2');
  $sheet->getStyle('I2')
          ->getAlignment()
          ->setHorizontal(Alignment::HORIZONTAL_CENTER);
  $sheet->getStyle('I2')->getFont()->setSize(14);
  $sheet->getCell('I2')->setValue($data_cerere);


  // setari titlu
  $title = [
    'font' => [
      'color' => [
        'rgb' => 'FFFFFF'
      ],
    ],
    'fill' => [
      'fillType' => Fill::FILL_SOLID,
      'startColor' => [
        'rgb' => '8b0000'
      ],
    ],
  ];

  // titlu
  $sheet->setTitle("Istoric taxare");
  $sheet->getStyle('A1:G3')
          ->getFont()
          ->setName('Arial Black');
  $sheet->getStyle('A1:G3')
          ->applyFromArray($title);
  $sheet->getColumnDimension('A')->setWidth(4);
  $sheet->getColumnDimension('B')->setWidth(9);
  $sheet->getColumnDimension('C')->setWidth(9);
  $sheet->getColumnDimension('D')->setWidth(9);
  $sheet->getColumnDimension('E')->setWidth(9);
  $sheet->getColumnDimension('F')->setWidth(9);
  $sheet->getColumnDimension('G')->setWidth(4);
  $sheet->getColumnDimension('H')->setWidth(8);
  $sheet->getColumnDimension('I')->setWidth(8);
  $sheet->getColumnDimension('J')->setWidth(9);
  $sheet->getColumnDimension('K')->setWidth(9);
  $sheet->getRowDimension('2')->setRowHeight(40);
  $sheet->mergeCells('B2:F2');
  $sheet->getCell('B2')->setValue('Istoric taxare');
  $sheet->getStyle('B2')
          ->getFont()
          ->setSize(26);
  $sheet->getStyle('B2')
          ->getAlignment()
          ->setHorizontal(Alignment::HORIZONTAL_CENTER);


  // datele clientului
  $sheet->getRowDimension('5')->setRowHeight(20);
  $sheet->getRowDimension('6')->setRowHeight(20);
  $sheet->getRowDimension('7')->setRowHeight(20);
  $sheet->getRowDimension('8')->setRowHeight(20);
  $sheet->getStyle('B5')->getFont()->setBold(true);
  $sheet->getCell('B5')->setValue('Nume si prenume:');
  $sheet->getCell('D5')->setValue($prenume . ' ' . $nume);
  $sheet->getStyle('B6')->getFont()->setBold(true);
  $sheet->getCell('B6')->setValue('Email:');
  $sheet->getCell('D6')->setValue($email);
  $sheet->getStyle('B7')->getFont()->setBold(true);
  $sheet->getCell('B7')->setValue('Telefon:');
  $sheet->getCell('D7')->setValue('(+4' . $telefon[0] . ')' . substr($telefon, 1));
  $sheet->getStyle('B8')->getFont()->setBold(true);
  $sheet->getCell('B8')->setValue('Adresa:');
  $sheet->getCell('D8')->setValue($adresa);

  // titlu 
  $sheet->mergeCells("I5:K6");
  $sheet->getStyle('I5')
          ->getFont()
          ->setSize(20);
  $sheet->getStyle('I5')->getFont()->setBold(true);
  $sheet->getCell('I5')->setValue('BIBLIOTECA');
  $sheet->mergeCells("I7:K8");
  $sheet->getStyle('I7')
          ->getFont()
          ->setSize(20);
  $sheet->getStyle('I7')->getFont()->setBold(true);
  $sheet->getCell('I7')->setValue('NATIONALA');

  // setari table header
  $header = [
    'font' => [
      'color' => [
        'rgb' => 'FFFFFF'
      ],
    ],
    'fill' => [
      'fillType' => Fill::FILL_SOLID,
      'startColor' => [
        'rgb' => '000000'
      ],
    ],
  ];

  //header tabel
  $sheet->getRowDimension('11')->setRowHeight(25);
  $sheet->getStyle('A11:K11')
          ->applyFromArray($header);

  $sheet->getStyle('A11')->getFont()->setBold(true);
  $sheet->getStyle('A11')
          ->getAlignment()
          ->setHorizontal(Alignment::HORIZONTAL_CENTER)
          ->setVertical(Alignment::VERTICAL_CENTER);
  $sheet->getCell('A11')->setValue('Nr.');

  $sheet->mergeCells('B11:F11');
  $sheet->getStyle('B11')->getFont()->setBold(true);
  $sheet->getStyle('B11')
          ->getAlignment()
          ->setHorizontal(Alignment::HORIZONTAL_CENTER)
          ->setVertical(Alignment::VERTICAL_CENTER);
  $sheet->getCell('B11')->setValue('Descriere');

  $sheet->mergeCells('G11:H11');
  $sheet->getStyle('G11')->getFont()->setBold(true);
  $sheet->getStyle('G11')
          ->getAlignment()
          ->setHorizontal(Alignment::HORIZONTAL_CENTER)
          ->setVertical(Alignment::VERTICAL_CENTER);
  $sheet->getCell('G11')->setValue('Suma');

  $sheet->mergeCells('I11:K11');
  $sheet->getStyle('I11')->getFont()->setBold(true);
  $sheet->getStyle('I11')
          ->getAlignment()
          ->setHorizontal(Alignment::HORIZONTAL_CENTER)
          ->setVertical(Alignment::VERTICAL_CENTER);
  $sheet->getCell('I11')->setValue('Data taxarii');


  // continut tabel
  $start = 12;

  for ($i = 0; $i < count($descriere); $i++) {

    if ($i % 2 == 0) {
      $sheet->getStyle('A' . ($start + $i) . ":K" . ($start + $i))
              ->getFill()
              ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
              ->getStartColor()
              ->setARGB('FFFFFF');
    }
    else {
      $sheet->getStyle('A' . ($start + $i) . ":K" . ($start + $i))
              ->getFill()
              ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
              ->getStartColor()
              ->setARGB('D3D3D3');
    }

    $sheet->getRowDimension($start + $i)->setRowHeight(25);
    $sheet->mergeCells('B' . ($start + $i) . ':F' . ($start + $i));
    $sheet->mergeCells('G' . ($start + $i) . ':H' . ($start + $i));
    $sheet->mergeCells('I' . ($start + $i) . ':K' . ($start + $i));

    $sheet->getCell('A' . ($start + $i))->setValue(($i + 1));
    $sheet->getCell('B' . ($start + $i))->setValue($descriere[$i]);
    $sheet->getCell('G' . ($start + $i))->setValue($suma[$i]);
    $sheet->getCell('I' . ($start + $i))->setValue($data[$i]);
    
  $sheet->getStyle('A' . ($start + $i))
          ->getAlignment()
          ->setHorizontal(Alignment::HORIZONTAL_CENTER);
  $sheet->getStyle('B' . ($start + $i))
          ->getAlignment()
          ->setHorizontal(Alignment::HORIZONTAL_LEFT);
  $sheet->getStyle('G' . ($start + $i))
          ->getAlignment()
          ->setHorizontal(Alignment::HORIZONTAL_CENTER);
  $sheet->getStyle('I' . ($start + $i))
          ->getAlignment()
          ->setHorizontal(Alignment::HORIZONTAL_CENTER);
  }


  // total
  $y_total = $start + $i + 2;
  
  $sheet->getRowDimension($y_total)->setRowHeight(20);

  $sheet->mergeCells('F' . $y_total . ':H' . $y_total);
  $sheet->getStyle('F' . $y_total)->getFont()->setBold(true);
  $sheet->getStyle('F' . $y_total)->getFont()->setSize(14);
  $sheet->getStyle('F' . $y_total)
          ->getAlignment()
          ->setHorizontal(Alignment::HORIZONTAL_CENTER);
  $sheet->getCell('F' . $y_total)->setValue('Rest de plata');

  
  $sheet->mergeCells('J' . $y_total . ':K' . $y_total);
  $sheet->getStyle('J' . $y_total)->getFont()->setSize(14);
  $sheet->getStyle('J' . $y_total)
          ->getAlignment()
          ->setHorizontal(Alignment::HORIZONTAL_CENTER);
  $sheet->getCell('J' . $y_total)->setValue($taxa . "RON");


  // footer
  $y_footer = $y_total + 2;

  $sheet->getStyle('B' . $y_footer)->getFont()->setBold(true);
  $sheet->getStyle('B' . $y_footer)->getFont()->setSize(12);
  $sheet->getCell('B' . $y_footer)->setValue('Contact');

  $y_footer += 2;
  $image1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
  $image1->setName('address');
  $image1->setPath('../../pics/location.png');
  $image1->setCoordinates('A' . $y_footer);
  $image1->setWidth(20);
  $image1->setOffsetX(5);
  $image1->setWorksheet($sheet);
  $sheet->getCell('B' . $y_footer)->setValue('Bulevardul Unirii nr. 22, Bucuresti, Sector 3');

  // semnatura
  $image = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
  $image->setName('signature');
  $image->setPath('../../pics/signature2.png');
  $image->setCoordinates('F' . $y_footer);
  $image->setWidth(300);
  $image->setOffsetX(30);
  $image->setWorksheet($sheet);


  $y_footer += 2;
  $image2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
  $image2->setName('phone');
  $image2->setPath('../../pics/phone.png');
  $image2->setCoordinates('A' . $y_footer);
  $image2->setWidth(20);
  $image2->setOffsetX(5);
  $image2->setWorksheet($sheet);
  $sheet->getCell('B' . $y_footer)->setValue('(+40)728653397');


  $y_footer += 2;
  $image3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
  $image3->setName('email');
  $image3->setPath('../../pics/email2.png');
  $image3->setCoordinates('A' . $y_footer);
  $image3->setWidth(20);
  $image3->setOffsetX(5);
  $image3->setWorksheet($sheet);
  $sheet->getCell('B' . $y_footer)->setValue('diana-elena.vasiliu@my.fmi.unibuc.ro');


  $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
  header('Content-Type: Application/vnd.ms-excel');
  header('Content-Disposition: attachment; filename="Istoric_taxare.xlsx"');
  $writer->save('php://output');
  

  header("Location: ../../contulmeu.php");
?>