
<?php
    class ConsumoModel extends Model{

        public function __construct()
        {
            parent::__construct();
        }

        public function buscarDatos($doc,$cc) {
            $registrado = false;
            $url = "http://sicalsepcon.net/api/activesapi.php?documento=".$doc;
            $img = "http://sicalsepcon.net/api/firmasapi.php?doc=".$doc;
            
            
            $api = file_get_contents($url);
            $ap2 = file_get_contents($img);


            $datos =  json_decode($api);
            $nreg = count($datos);

            $registrado = $nreg > 0 ? true: false;

            return array("datos" => $datos,
                        "registrado"=>$registrado,
                        "anteriores"=>$this->kardexAnterior($doc,$cc),
                        "ruta"=>'https://rrhhperu.sepcon.net/postulante/documentos/pdf/'.$ap2);
        }

        public function buscarProductos($codigo){
            try {
                $salida = "";
                $sql = $this->db->connect()->prepare("SELECT
                                                        cm_producto.id_cprod,
                                                        cm_producto.ccodprod,
                                                        UPPER(cm_producto.cdesprod) AS cdesprod,
                                                        tb_unimed.cabrevia,
                                                        NOW() AS fecha
                                                    FROM
                                                        cm_producto
                                                        INNER JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed 
                                                    WHERE
                                                        cm_producto.flgActivo = 1 
                                                        AND cm_producto.ccodprod = :codigo 
                                                        AND cm_producto.ntipo = 37");
                $sql->execute(["codigo"=>$codigo]);

                $rowCount = $sql->rowCount();
                $result = $sql->fetchAll();

                if ($rowCount > 0) {
                    $respuesta = array("descripcion"=>$result[0]['cdesprod'],
                                        "codigo"=>$result[0]['ccodprod'],
                                        "unidad"=>$result[0]['cabrevia'],
                                        "idprod"=>$result[0]['id_cprod'],
                                        "fecha"=>$result[0]['fecha'],
                                        "registrado"=>true);
                }else{
                    $respuesta = array("registrado"=>false); 
                }

                return $respuesta;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        //regresar cuando este en produccion
        public function subirFirma($detalles,$correo,$nombre,$cc) {
            if (array_key_exists('img',$_REQUEST)) {
                // convierte la imagen recibida en base64
                // Eliminamos los 22 primeros caracteres, que 
                // contienen el substring "data:image/png;base64,"
                $imgData = base64_decode(substr($_REQUEST['img'],22));
                
                $fechaActual = date('Y-m-d');
                $respuesta = false;
        
                $namefile = uniqid();

                // Path en donde se va a guardar la imagen
                $file = 'public/documentos/firmas/'.$namefile.'.png';
            
                // borrar primero la imagen si existía previamente
                if (file_exists($file)) { unlink($file); }
            
                // guarda en el fichero la imagen contenida en $imgData
                $fp = fopen($file, 'w');
                fwrite($fp, $imgData);
                fclose($fp);
                
                if ( file_exists($file) ){
                    $respuesta = true;

                    $datos = json_decode($detalles);
                    $nreg = count($datos);
                    $kardex = time();

                    for ($i=0; $i<$nreg; $i++){
                        $sql = $this->db->connect()->prepare("INSERT INTO alm_consumo 
                                                                    SET reguser=:user,
                                                                        nrodoc=:documento,
                                                                        idprod=:producto,
                                                                        cantsalida=:cantidad,
                                                                        fechasalida=:salida,
                                                                        nhoja=:hoja,
                                                                        cisometrico=:isometrico,
                                                                        cobserentrega=:observaciones,
                                                                        flgdevolver=:patrimonio,
                                                                        cestado=:estado,
                                                                        nkardex=:kardex,
                                                                        cfirma=:firma,
                                                                        cserie=:serie,
                                                                        ncostos=:cc,
                                                                        ncambioepp=:cambio");
                        $sql->execute(["user"=>$_SESSION['iduser'],
                                        "documento"=>$datos[$i]->nrodoc,
                                        "producto"=>$datos[$i]->idprod,
                                        "cantidad"=>$datos[$i]->cantidad,
                                        "salida"=>$datos[$i]->fecha,
                                        "hoja"=>$datos[$i]->hoja,
                                        "isometrico"=>$datos[$i]->isometrico,
                                        "observaciones"=>$datos[$i]->observac,
                                        "patrimonio"=>$datos[$i]->patrimonio,
                                        "estado"=>$datos[$i]->estado,
                                        "kardex"=>$kardex,
                                        "firma"=>$namefile,
                                        "serie"=>$datos[$i]->serie,
                                        "cc"=>$datos[$i]->costos,
                                        "cambio"=>$datos[$i]->cambio]);
                    }
                }            
            }

            $this->correoMovimiento($detalles,$nombre,$correo,$kardex,$cc);
        
            return  $respuesta;
        }

        /* este es sin biometrico //
        public function subirFirma($detalles,$correo,$nombre,$cc) {
           
                    $respuesta = true;
                    $namefile = "";

                    $datos = json_decode($detalles);
                    $nreg = count($datos);
                    $kardex = time();

                    for ($i=0; $i<$nreg; $i++){
                        $sql = $this->db->connect()->prepare("INSERT INTO alm_consumo 
                                                                    SET reguser=:user,
                                                                        nrodoc=:documento,
                                                                        idprod=:producto,
                                                                        cantsalida=:cantidad,
                                                                        fechasalida=:salida,
                                                                        nhoja=:hoja,
                                                                        cisometrico=:isometrico,
                                                                        cobserentrega=:observaciones,
                                                                        flgdevolver=:patrimonio,
                                                                        cestado=:estado,
                                                                        nkardex=:kardex,
                                                                        cfirma=:firma,
                                                                        cserie=:serie,
                                                                        ncostos=:cc,
                                                                        ncambioepp=:cambio");
                        $sql->execute(["user"=>$_SESSION['iduser'],
                                        "documento"=>$datos[$i]->nrodoc,
                                        "producto"=>$datos[$i]->idprod,
                                        "cantidad"=>$datos[$i]->cantidad,
                                        "salida"=>$datos[$i]->fecha,
                                        "hoja"=>$datos[$i]->hoja,
                                        "isometrico"=>$datos[$i]->isometrico,
                                        "observaciones"=>$datos[$i]->observac,
                                        "patrimonio"=>$datos[$i]->patrimonio,
                                        "estado"=>$datos[$i]->estado,
                                        "kardex"=>$kardex,
                                        "firma"=>$namefile,
                                        "serie"=>$datos[$i]->serie,
                                        "cc"=>$datos[$i]->costos,
                                        "cambio"=>$datos[$i]->cambio]);
                    }
            
            //$this->correoMovimiento($detalles,$nombre,$correo,$kardex,$cc);

            return  $respuesta;
        }*/

        private function correoMovimiento($detalles,$nombre,$correo,$kardex,$cc){
            require_once("public/PHPMailer/PHPMailerAutoload.php");

            $datos      = json_decode($detalles);
            $nreg       = count($datos);
            $subject    = utf8_decode('Entrega de EPPS/Materiales '.' - '.$nombre.' - '.$kardex);
            $fecha_actual = date("d-m-Y h:i:s");
            
            $origen = $_SESSION['correo'];
            $nombre_envio = $_SESSION['nombres'];

            $estadoEnvio= false;
            $clase = "mensaje_error";
            $salida = "";

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';
            $mail->Host = 'mail.sepcon.net';
            $mail->SMTPAuth = true;
            $mail->Username = 'sistema_ibis@sepcon.net';
            $mail->Password = $_SESSION['password'];
            $mail->Port = 465;
            $mail->SMTPSecure = "ssl";
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => false
                )
            );

            try {
                $mail->setFrom('kardex@sepcon.net', 'Almacen Sepcon'); 
                $mail->addAddress($origen,$nombre_envio);
                $mail->addAddress($correo,utf8_decode($nombre));
                $mail->addAddress('kardex@sepcon.net','kardex@sepcon.net');
                //$mail->addAddress('lgrock@sepcon.net','Luis Grock');

                $mail->Subject = $subject;
                $contador = 1;

                $mensaje = '<p>Estimado : <strong style="font-style: italic;">'. utf8_decode($nombre) .' </strong></p>';
                $mensaje .=  utf8_decode('<p>Realizaste un retiro de almacén: '.$cc.', con el registro de kardex Nro: <strong>'. $kardex.'</strong></p>');
                $mensaje .= '<p>Para constancia de lo entregado te enviamos los datos de tu retiro:</p>';

                $mensaje.= '<table style="width: 80%; border:1px solid #c2c2c2; border-collapse: collapse; font-size:.9rem">
                                <thead>
                                    <tr style="color:white; background:#0364B8; padding: 0 5px">
                                        <th>ITEM</th>
                                        <th>CODIGO</th>
                                        <th>DESCRIPCION</th>
                                        <th>UNIDAD</th>
                                        <th>FECHA</th>
                                        <th>SERIE</th>
                                        <th>CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody>';
                
                for ($i=0; $i < $nreg; $i++) { 
                    $mensaje .= '<tr style="border:1px dotted #c2c2c2">
                                    <td>'.$contador++.'</td>
                                    <td>'.$datos[$i]->codigo.'</td>
                                    <td>'.$datos[$i]->descripcion.'</td>
                                    <td>'.$datos[$i]->unidad.'</td>
                                    <td>'.$fecha_actual.'</td>
                                    <td>'.$datos[$i]->serie.'</td>
                                    <td>'.$datos[$i]->cantidad.'</td>
                                </tr>';
                }

                $mensaje.='</tbody></table>';
                $mensaje.= '<p>Atentamente</p>';
                $mensaje.= '<p>Almacenes Sepcon</p>';

                $mensaje.= '<p style="font-size:.6rem; color:#0364B8; font-style:italic;">No responda este correo</p>';


                $mail->msgHTML($mensaje);

                $mail->send();
                $mail->ClearAddresses();

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            } 
        }

        private function kardexAnterior($d,$c){
            try {
                $salida = "";
                $sql = $this->db->connect()->prepare("SELECT
                                                        alm_consumo.idreg,
                                                        alm_consumo.reguser,
                                                        alm_consumo.idprod,
                                                        alm_consumo.cantsalida,
                                                        DATE_FORMAT(alm_consumo.fechasalida,'%d/%m/%Y') AS fechasalida,
                                                        DATE_FORMAT(alm_consumo.fechadevolucion,'%d/%m/%Y') AS fechadevolucion,
                                                        alm_consumo.nhoja,
                                                        alm_consumo.cisometrico,
                                                        alm_consumo.cobserentrega,
                                                        alm_consumo.cobserdevuelto,
                                                        alm_consumo.cestado,
                                                        alm_consumo.cserie,
                                                        alm_consumo.flgdevolver,
                                                        alm_consumo.cfirma,
                                                        cm_producto.ccodprod,
                                                        alm_consumo.nkardex,
                                                        alm_consumo.calmacen,
                                                        UPPER(cm_producto.cdesprod) AS cdesprod,
                                                        tb_unimed.cabrevia,
                                                        tb_parametros.cdescripcion  AS motivo_epp
                                                    FROM
                                                        alm_consumo
                                                        LEFT JOIN cm_producto ON alm_consumo.idprod = cm_producto.id_cprod
                                                        LEFT JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed
                                                        LEFT JOIN tb_parametros ON alm_consumo.ncambioepp = tb_parametros.nidreg  
                                                    WHERE
                                                        alm_consumo.nrodoc = :documento 
                                                        AND ncostos = :cc
                                                        AND alm_consumo.flgactivo = 1
                                                    ORDER BY alm_consumo.freg DESC" );
                $sql->execute(["documento"=>$d,"cc"=>$c]);
                $rowCount = $sql->rowCount();
                $item = 1;
                $salida ="";
                $numero_item = $this->cantidadItems($d,$c);


                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()){

                        $marcado = $rs['flgdevolver'] == 1 ? "checked" : "";
                        $firma = "public/documentos/firmas/".$rs['cfirma'].".png";

                        $salida .= '<tr class="pointer" data-grabado="1" 
                                                        data-registrado="1" 
                                                        data-kardex = "'.$rs['nkardex'].'"
                                                        data-firma = "'.$rs['cfirma'].'"
                                                        data-devolucion = "'.$rs['fechadevolucion'].'"
                                                        data-firmadevolucion ="'.$rs['calmacen'].'"
                                                        data-registro="'.$rs['idreg'].'">
                                        <td class="textoDerecha">'.$rowCount--.'</td>
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl5px">'.$rs['cdesprod'].'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                        <td class="textoDerecha">'.$rs['cantsalida'].'</td>
                                        <td class="textoCentro">'.$rs['fechasalida'].'</td>
                                        <td class="textoCentro">'.$rs['nhoja'].'</td>
                                        <td class="pl5px">'.$rs['cisometrico'].'</td>
                                        <td class="pl5px">'.$rs['cobserentrega'].'</td>
                                        <td class="pl5px">'.$rs['cserie'].'</td>
                                        <td class="textoCentro"><input type="checkbox" '.$marcado.'></td>
                                        <td class="pl5px">'.$rs['motivo_epp'].'</td>
                                        <td class="pl5px">'.$rs['cestado'].'</td>
                                        <td class="textoCentro">
                                            <div style ="width:110px !important; text-align:center">
                                                <img src = '.$firma.' style ="width:100% !important">
                                            </div>
                                        </td>
                                        <td class="textoCentro"><a href="'.$rs['idreg'].'"><i class="far fa-trash-alt"></i></a></td>
                                    </tr>';
                    }
                }

                return $salida;

            }catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }  
        }

        public function buscarConsumoPersonal($cod,$d,$cc){
            try {
                $salida = "";
                $sql = $this->db->connect()->prepare("SELECT
                                                        alm_consumo.idreg,
                                                        alm_consumo.reguser,
                                                        alm_consumo.idprod,
                                                        alm_consumo.cantsalida,
                                                        DATE_FORMAT(alm_consumo.fechasalida,'%d/%m/%Y') AS fechasalida,
                                                        alm_consumo.nhoja,
                                                        alm_consumo.cisometrico,
                                                        alm_consumo.cobserentrega,
                                                        alm_consumo.cobserdevuelto,
                                                        alm_consumo.cestado,
                                                        alm_consumo.flgdevolver,
                                                        alm_consumo.cfirma,
                                                        alm_consumo.cserie,
                                                        cm_producto.ccodprod,
                                                        alm_consumo.nkardex,
                                                        UPPER(cm_producto.cdesprod) AS cdesprod,
                                                        tb_unimed.cabrevia,
                                                        DATEDIFF(alm_consumo.fechasalida,NOW()) AS dias_ultima_entrega
                                                    FROM
                                                        alm_consumo
                                                        INNER JOIN cm_producto ON alm_consumo.idprod = cm_producto.id_cprod
                                                        INNER JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed 
                                                    WHERE
                                                        alm_consumo.nrodoc = :documento 
                                                        AND ncostos = :cc
                                                        AND cm_producto.ccodprod = :codigo
                                                        AND alm_consumo.flgactivo = 1
                                                        GROUP BY
                                                            alm_consumo.idprod,
                                                            alm_consumo.fechasalida,
                                                            cm_producto.ccodprod,
                                                            alm_consumo.cantsalida,
                                                            alm_consumo.nhoja
                                                    ORDER BY alm_consumo.freg DESC");

                $sql->execute(["documento"=>$d,"cc"=>$cc,"codigo"=>$cod]);
                $rowCount = $sql->rowCount();
                $item = 1;
                $salida ="No hay registros";
                $numero_item = $this->cantidadItems($d,$cc);

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()){

                        $marcado = $rs['flgdevolver'] == 1 ? "checked" : "";
                        $firma = "public/documentos/firmas/".$rs['cfirma'].".png";

                        $alerta = $rs['dias_ultima_entrega'] < 15 ? "inactivo" : "";

                        $salida .= '<tr class="pointer" data-grabado="1" data-kardex="'.$rs['nkardex'].'" data-firma="'.$rs['cfirma'].'">
                                        <td class="textoDerecha hideItem" data-idreg="'.$rs['idreg'].'">'.$numero_item--.'</td>
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl5px">'.$rs['cdesprod'].'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                        <td class="textoDerecha">'.$rs['cantsalida'].'</td>
                                        <td class="textoCentro '.$alerta.'">'.$rs['fechasalida'].'</td>
                                        <td class="textoCentro">'.$rs['nhoja'].'</td>
                                        <td class="pl5px">'.$rs['cisometrico'].'</td>
                                        <td class="pl5px">'.$rs['cobserentrega'].'</td>
                                        <td class="pl5px">'.$rs['cserie'].'</td>
                                        <td class="textoCentro"><input type="checkbox" '.$marcado.'></td>
                                        <td class="pl5px">'.$rs['cestado'].'</td>
                                        <td class="textoCentro">
                                            <div style ="width:110px !important; text-align:center">
                                                <img src = '.$firma.' style ="width:100% !important">
                                            </div>
                                        </td>
                                        <td class="textoCentro"><a href="'.$rs['idreg'].'">X</a> </td>
                                    </tr>';
                    }
                }

                return $salida;

            }catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }  
        }

        public function eliminar($parametros) {
            $id = $parametros['id'];
            $menssaje = "Error al eliminar";

            try {
                $sql = $this->db->connect()->prepare("UPDATE alm_consumo 
                                                        SET alm_consumo.flgactivo = 0 
                                                        WHERE alm_consumo.idreg =:id");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();

                if ($rowCount) {
                    $mensaje = "Fila eliminada...";
                }
                
                return array("mensaje"=>$mensaje);
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            } 
        }
        
        public function generarReporte($cc) {
            require_once('public/PHPExcel/PHPExcel.php');
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                                ibis.alm_consumo.nrodoc,
                                                                ibis.alm_consumo.cserie,
                                                                FORMAT( ibis.alm_consumo.cantsalida, 2 ) AS cantsalida,
                                                                FORMAT( ibis.alm_consumo.cantdevolucion, 2 ) AS cantdevolucion,
                                                                DATE_FORMAT( ibis.alm_consumo.fechasalida, '%d/%m/%Y' ) AS fechasalida,
                                                                DATE_FORMAT( ibis.alm_consumo.fechadevolucion, '%d/%m/%Y' ) AS fechadevolucion,
                                                                FORMAT( ibis.alm_consumo.nhoja, 2 ) AS nhoja,
                                                                ibis.alm_consumo.cisometrico,
                                                                ibis.alm_consumo.cobserentrega,
                                                                ibis.alm_consumo.cobserdevuelto,
                                                                ibis.alm_consumo.cestado,
                                                                UPPER( ibis.cm_producto.ccodprod ) AS codigo,
                                                                UPPER( ibis.cm_producto.cdesprod ) AS descripcion,
                                                                ibis.tb_grupo.cdescrip AS grupo,
                                                                ibis.tb_clase.cdescrip AS clase,
                                                                ibis.tb_familia.cdescrip AS familia,
                                                                CONCAT_WS( ' ', aquarius.apellidos, aquarius.nombres ) AS nombres,
                                                                UPPER(aquarius.dcargo ) AS cargo,
                                                                ibis.tb_user.cnombres 
                                                            FROM
                                                                ibis.alm_consumo
                                                                LEFT JOIN ibis.cm_producto ON alm_consumo.idprod = cm_producto.id_cprod
                                                                LEFT JOIN ibis.tb_grupo ON cm_producto.ngrupo = tb_grupo.ncodgrupo
                                                                LEFT JOIN ibis.tb_clase ON cm_producto.nclase = tb_clase.ncodclase
                                                                LEFT JOIN ibis.tb_familia ON cm_producto.nfam = tb_familia.ncodfamilia
                                                                LEFT JOIN (SELECT rrhh.tabla_aquarius.apellidos, rrhh.tabla_aquarius.nombres, rrhh.tabla_aquarius.dni,
                                                            rrhh.tabla_aquarius.dcargo	FROM rrhh.tabla_aquarius GROUP BY rrhh.tabla_aquarius.dni) AS aquarius ON ibis.alm_consumo.nrodoc = aquarius.dni
                                                                LEFT JOIN ibis.tb_user ON ibis.alm_consumo.reguser = ibis.tb_user.iduser 
                                                            WHERE
                                                                alm_consumo.flgactivo = 1 
                                                                AND alm_consumo.ncostos =:cc
                                                            ORDER BY
                                                                ibis.alm_consumo.fechasalida ASC");
                $sql->execute(["cc"=>$cc]);
                $rowCount = $sql->rowCount();

                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()
                    ->setCreator("Sical")
                    ->setLastModifiedBy("Sical")
                    ->setTitle("Cargo Plan")
                    ->setSubject("Template excel")
                    ->setDescription("Reporte Ordenes")
                    ->setKeywords("Template excel");

                $cuerpo = array(
                    'font'  => array(
                    'bold'  => false,
                    'size'  => 7,
                ));

                $objWorkSheet = $objPHPExcel->createSheet(1);

                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->setTitle("Reporte Consumo ");

                $objPHPExcel->getActiveSheet()->mergeCells('A1:Q1');
                $objPHPExcel->getActiveSheet()->setCellValue('A1','REPORTE CONSUMO');

                $objPHPExcel->getActiveSheet()->getStyle('A1:S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A1:S2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(60);

                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(70);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(80);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(50);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(50);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(50);
                $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(50);
                $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(50);
                $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(40);
                

                $objPHPExcel->getActiveSheet()
                            ->getStyle('A2:S2')
                            ->getFill()
                            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB('BFCDDB');

                $objPHPExcel->getActiveSheet()->getStyle('A1:Q2')->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('A2','Número'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('B2','Documento'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('C2','Nombres'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('D2','Cargo'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('E2','Código'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('F2','Descripcion'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('G2','Fecha Salida'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('H2','Cantidad Salida'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('I2','Fecha Devolucion'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('J2','Cantidad Devolucion'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('K2','Hoja'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('L2','Isometrico'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('M2','Observaciones'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('N2','Serie'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('O2','Grupo'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('P2','Clase'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('Q2','Familia'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('R2','Fecha'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('S2','Registrado'); // esto cambia

                $fila = 3;
                $item = 1;

                if ($rowCount > 0) {
                    while($rs = $sql->fetch()) {

                        $date = DateTime::createFromFormat('Y-m-d H:i', $rs['fechasalida']);

                        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$fila, $item,PHPExcel_Cell_DataType::TYPE_STRING);
                        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$fila, $rs['nrodoc'],PHPExcel_Cell_DataType::TYPE_STRING);
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila,$rs['nombres']);
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila,$rs['cargo']);
                        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila,$rs['codigo']);
                        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$fila, $rs['descripcion'],PHPExcel_Cell_DataType::TYPE_STRING);
                        
                        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila,PHPExcel_Shared_Date::PHPToExcel($rs['fechasalida']));
                        $objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->getNumberFormat()->setFormatCode('dd/mm/yyyy');

                        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila,$rs['cantsalida']);
                        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila,$rs['fechadevolucion']);
                        
                        $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila,$rs['cantdevolucion']);
                        $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila,$rs['nhoja']);
                        $objPHPExcel->getActiveSheet()->setCellValue('L'.$fila,$rs['cisometrico']);
                        $objPHPExcel->getActiveSheet()->setCellValue('M'.$fila,$rs['cobserentrega']);
                        $objPHPExcel->getActiveSheet()->setCellValue('N'.$fila,$rs['cserie']);
                        $objPHPExcel->getActiveSheet()->setCellValue('O'.$fila,$rs['grupo']);
                        $objPHPExcel->getActiveSheet()->setCellValue('P'.$fila,$rs['clase']);
                        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila,$rs['familia']);
                        $objPHPExcel->getActiveSheet()->setCellValue('R'.$fila,$rs['fechasalida']);
                        $objPHPExcel->getActiveSheet()->setCellValue('S'.$fila,$rs['cnombres']);

                        $fila++;
                        $item++;
                    }
                }

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
                $objWriter->save('public/documentos/reportes/consumos.xlsx');

                return array("documento"=>'public/documentos/reportes/consumos.xlsx');

                exit();

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            } 
        }

        public function anularItem($id){
            try {
                $respuesta = false;

                $sql = $this->db->connect()->prepare("UPDATE alm_consumo 
                                                            SET alm_consumo.flgactivo = 0
                                                            WHERE alm_consumo.idreg = :id");
                $sql->execute(['id'=>$id]);

                $rowCount = $sql->rowCount();	

                if ($rowCount > 0) {
                    $respuesta = true;
                }

                return $respuesta;

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            } 
        }

        public function generarKardex($parametros){
            require_once("public/formatos/kardex.php");

            $costo  = $parametros['cc'];
            $doc    = $parametros['doc'];
            $nombre = $parametros['nombre'];
            $cargo  = $parametros['cargo'];
            $almacen= "";
            $fecha = "";
            $existe = "NO";

            $detalle  = json_decode($parametros['detalles']);
            $nreg     = count($detalle);
            $item     = 1;

            $file = $doc.".pdf";

            $pdf = new PDF($doc,$nombre,$almacen,$costo,$fecha,$cargo);

            $pdf->AddPage();
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(5,10,85,15,15,15,15,15,15));
            $pdf->SetFont('Arial','',4);

            $lc = 0;

            for ($i=0; $i < $nreg; $i++) {
                $y=$pdf->GetY();

                
                $pdf->SetXY(10,$y);
                $pdf->Multicell(5,5,$detalle[$i]->item,"LRB","R");
                $pdf->SetXY(15,$y);
                $pdf->Multicell(10,5,$detalle[$i]->cantidad,"LRB","R");
                $pdf->SetXY(25,$y);
                $pdf->Multicell(85,5,substr($detalle[$i]->descripcion,0,100),"LRB","L");
                $pdf->SetXY(110,$y);
                $pdf->Multicell(15,5,"","LRB","C");
                $pdf->SetXY(125,$y);
                $pdf->Multicell(15,5,$detalle[$i]->fecha,"LRB","C");
                $pdf->SetXY(140,$y);
                $pdf->Multicell(15,5,"","LRB","C");
                if ( file_exists("public/documentos/firmas/".$detalle[$i]->firma.".png") )
                    $pdf->Image("public/documentos/firmas/".$detalle[$i]->firma.".png",142,$y+2,13);
                $pdf->SetXY(155,$y);
                $pdf->Multicell(15,5,$detalle[$i]->devolucion,"LRB","C");
                $pdf->SetXY(170,$y);
                $pdf->Multicell(15,5,"","LRB","C");
                //$pdf->Multicell(15,6,$detalle[$i]->fdevolucion,"LRB","C");
                $pdf->SetXY(185,$y);
                $pdf->Multicell(15,5,$detalle[$i]->kardex,"LRB","C");
                
                $lc++;

                if ($pdf->getY() >= 250) {
                    $pdf->AddPage();
                    $lc = 0;
                }
            }

            $filename = "public/documentos/kardex/".$file;

            $pdf->Output($filename,'F');

            return $file;
        }

        public function registrarMantenimientos($parametros){
            try {
                $fechaActual = date('Y-m-d');
                $fechas = array("+6 month","+12 month","+18 month","+24 month","+30 month","+36 month");
                $numero = 1;
                $respuesta = false;

                $existe = $this->verificarSerie($parametros['serie']);

                if ($existe == 0){

                    for ($i=0; $i < 4; $i++) { 
                        $respuesta = false;
                        $fechaMtto = $this->calcularProximos($fechas[$i]);
                        $sql = $this->db->connect()->prepare("INSERT INTO ti_mmttos 
                                                                SET ti_mmttos.nrodoc =:doc,
                                                                    ti_mmttos.fentrega =:entrega,
                                                                    ti_mmttos.fmtto =:fecmmtto,
                                                                    ti_mmttos.idprod=:idprod,
                                                                    ti_mmttos.nmtto=:numero,
                                                                    ti_mmttos.idcostos=:costos,
                                                                    ti_mmttos.cserie=:serie");
                        $sql->execute(["doc"=>$parametros['documento'],
                                        "entrega"=>$fechaActual,
                                        "fecmmtto"=>$fechaMtto,
                                        "idprod"=>$parametros['codigo'],
                                        "numero"=>$numero++,
                                        "costos"=>$parametros['costos'],
                                        "serie"=>$parametros['serie']]);
                        $rowCount = $sql->rowCount();
                    }

                }else {
                    $respuesta = true;
                }
                    

                return array("respuesta"=>$respuesta,"existe"=>$existe);
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            } 
        }

        private function calcularProximos($meses){
            $fecha_actual = date("d-m-Y");
            $nuevafecha = date("Y-m-d",strtotime($fecha_actual.$meses));
	 
		    return $nuevafecha;
        }

        private function verificarSerie($serie){
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                        COUNT( alm_consumo.idreg )  AS serie
                                                    FROM
                                                        alm_consumo 
                                                    WHERE
                                                        alm_consumo.cserie = :serie
                                                    AND ISNULL(alm_consumo.cantdevolucion) ");

                $sql -> execute(["serie"=>$serie]);
                $result = $sql->fetchAll();

                return $result[0]['serie'];

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            } 
        }
    }
?>
