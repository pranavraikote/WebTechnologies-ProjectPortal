<?php
require "../fpdf181/fpdf.php";
$db = new PDO('mysql:host=localhost;dbname=project_portal','root','');
class MyPdf extends FPDF{
	function header(){
		$this->Image("../../img/bmsit.png",10,6);
		$this->SetFont('Arial','B',15);
		$this->Cell(40);
		$this->Cell(176,10,'BMS INSTITUTE OF TECHNOLOGY AND MANAGEMENT','C');
		$this->Ln();
		$this->Cell(60);
		$this->SetFont('Arial','B',13);
		$this->Cell(176,10,'YELAHANKHA, BANGALORE - 560064','C');
		$this->Ln();
		$this->Cell(54);
		$this->SetFont('Arial','B',15);
		$this->Cell(176,10,'COMPUTER SCIENCE & ENGG. DEPT','C');
		$this->SetFont('Times','B',18);
		$this->Ln(20);
		$this->Cell(55);
		$this->Cell(50,10,'Registered Student List - VII SEM ','C');
		$this->Ln(10);
	}
	
	function footer(){	
		$this->SetY(-15);
		$this->SetX(($this->GetPageWidth())/2.2);
		$this->SetFont('Arial','',0);
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0);
	}
	
	function headerTable()
	{
		$this->SetFont('Times','B',12);
		$this->SetX(11);
		$this->Cell(17,10,'SL.NO',1,0,'C');
		$this->Cell(35,10,'USN',1,0,'C');
		$this->Cell(60,10,'STUDENT NAME',1,0,'C');
		$this->Cell(80,10,'PROJECT NAME',1,0,'C');
		$this->Ln();
	}
	function viewTable($db)
	{
		$this->SetFont('Times','',12);
		$stmt=$db->query('SELECT s.usn,s.name,p.project_name from student s,projects p,works_on w where w.usn=s.usn and w.project_id = p.project_id order by p.project_name');
		$sl_no = 1;
		while($data=$stmt->fetch(PDO::FETCH_OBJ)){
			$this->SetFont('Times','B',12);
			$this->SetX(11);
			$this->Cell(17,10,$sl_no,1,0,'C');
			$this->Cell(35,10,$data->usn,1,0,'C');
			$this->Cell(60,10,$data->name,1,0,'C');
			$this->Cell(80,10,$data->project_name,1,0,'C');
			$this->Ln();
			$sl_no++;
		}
	}	
}
$pdf=new MyPdf();
$pdf->AliasNBPages();
$pdf->AddPage('P','A4',0);
$pdf->headerTable();
$pdf->viewTable($db);
$pdf->Output();