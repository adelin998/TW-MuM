<?php
require('mysql_table.php');

class PDF extends PDF_MySQL_Table
{
function Header()
{
	// Title
	$this->Image('home.png',30,15,30);
    $this->SetFont('Arial','B',13);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(60,15,'Song Metadata',1,0,'C');
    // Line break
    $this->Ln(30);
	// Ensure table header is printed
	parent::Header();
}
}

// Connect to database
$link = mysqli_connect('localhost','root','','mum');
$id_uploader=$_GET['id'];
$pdf = new PDF();
$pdf->AddPage();
// First table: output all columns
$pdf->AddCol('title',70,'Title','C');
$pdf->AddCol('artist',50,'Artist','C');
$pdf->AddCol('album',50,'Album','C');
$pdf->AddCol('data',30,'Data','C');
$prop = array('HeaderColor'=>array(255,150,100),
            'color1'=>array(210,245,255),
            'color2'=>array(255,255,210),
            'padding'=>2);
$pdf->Table($link,"SELECT title, artist, album, data FROM songs WHERE id='$id_uploader' LIMIT 1",$prop);

$pdf->Output();
?>
