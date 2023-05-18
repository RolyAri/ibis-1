<?php 
    require_once "public/fpdf/mc_table.inc.php";

    class PDF extends PDF_MC_Table{
        public function __construct($ndoc,$nombre,$almacenero,$proyecto,$fecha,$cargo)
        {
            parent::__construct();
            $this->ndoc         = $ndoc;
            $this->nombre       = $nombre;
            $this->almacenero   = $almacenero;
            $this->proyecto     = $proyecto;
            $this->fecha        = $fecha;
            $this->cargo        = $cargo;
        }

        function Header(){
            $this->Rect(10,10,30,20); //marco de la imagen
        	$this->Rect(10,10,190,20); //marco general

        	$this->SetFillColor(229, 229, 229);
        	//$this->Rect(70,24,70,5,"F"); //fondo de mensaje
        	$this->Image('public/img/logo.png',12,12,25);
	        $this->SetFont('Arial','B',8);
			$this->SetTextColor(0,0,0);
           // $this->SetFillColor(229, 229, 229);
	        $this->Cell(190,7,"KARDEX DE EPP Y/O EQUIPOS",0,1,'C');
	        $this->SetFont('Arial','B',10);
            $this->SetXY(170,11);
	        $this->SetFont('Arial','',6);
	        $this->MultiCell(30,5,utf8_decode('PSPC-420-X-PR-001-FR-003 Revisión: 1 Emisión: 11/05/2023 Pagina: 1 de 1'),0,'L',false);

            $this->SetXY(10,30);
	        $this->Cell(25,6,utf8_decode("Razón Social:"),"LB",0);
            $this->Cell(80,6,utf8_decode("SERVICIOS PETROLEROS Y CONSTRUCCIONES SEPCON S.A.C."),"LB",0);
            $this->Cell(35,6,utf8_decode("RUC:"),"LB",0);
            $this->Cell(50,6,utf8_decode("20504898173:"),"LRB",1,'C');
            $this->Cell(25,6,utf8_decode("Domicilio:"),"LB",0);
            $this->Cell(165,6,utf8_decode("Av. San Borja Norte 445, San Borja - Lima"),"LBR",1);
            $this->Cell(25,6,utf8_decode("Actividad Económica:"),"LB",0);
            $this->Cell(165,6,utf8_decode("Prestación de Servicios de Construcción para los Sectores de Energía y Minería. "),"LRB",1);
            $this->Cell(25,6,utf8_decode("Proyecto:"),"LB",0);
            $this->Cell(80,6,utf8_decode($this->proyecto),"LB",0);
            $this->Cell(35,6,utf8_decode("N° Trabajadores Proyecto/Sede:"),"LB",0);
            $this->Cell(50,6,"","LRB",1,'C');
            $this->Cell(25,6,utf8_decode("Nombre del Trabajador:"),"LB",0);
            $this->Cell(80,6,utf8_decode($this->nombre),"LB",0);
            $this->Cell(35,6,utf8_decode("DNI:"),"LB",0);
            $this->Cell(50,6,utf8_decode($this->ndoc),"LRB",1,'C');
            $this->Cell(25,6,utf8_decode("Cargo :"),"LB",0);
            $this->Cell(80,6,utf8_decode($this->cargo),"LB",0);
            $this->Cell(35,6,utf8_decode("Área :"),"LB",0);
            $this->Cell(50,6,"","LRB",1,'C');
            $this->Cell(190,6,utf8_decode("Para los equipos renovables -EPPS, la fecha de renovación será aplicada de acuerdo a lo establecido en el procedimiento PSPC-110-X-PR-007 EQUIPO DE PROTECCION PERSONAL"),0,1);

            $this->ln(1);

            $this->SetFont('Arial','B',6);
    		//$this->Rect(10,30,190,4,"F"); //fondo de mensaje
    		$this->SetWidths(array(5,15,90,20,20,20,20));
    		$this->SetAligns(array("C","C","C","C","C","C","C"));
    		$this->Row(array(utf8_decode('N°'),utf8_decode('Cantidad'),utf8_decode('Descripción'),'Equipo Renovable','Fecha Retiro',utf8_decode('Firma Devolución'),utf8_decode('N° Registro')));
        }

        // Pie de página
		/*function Footer(){
		    $this->SetY(-70);
		    //$this->Ln(20);
		    $this->Line(20, 225, 65, 225);
		    $this->Line(80, 225, 130, 225);
		    $this->Line(150, 225, 190, 225);

		   
		   	$this->Cell(64,4,"FIRMA JEFE DE OBRA",0,0,"C");
		    $this->Cell(64,4,"FIRMA DEL TRABAJADOR",0,0,"C");
		    $this->Cell(64,4,"FIRMA ALMACEN",0,1,"C");
		}*/
    }
?>