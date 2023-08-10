<?php
    class SalidaModel extends Model{

        public function __construct()
        {
            parent::__construct();
        }

        public function listarNotasDespacho(){
            $salida = "";

            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                    alm_despachocab.cmes,
                                                    DATE_FORMAT(
                                                            alm_despachocab.ffecdoc,
                                                            '%d/%m/%Y'
                                                        ) AS ffecdoc,
                                                    YEAR(ffecdoc) AS anio,
                                                    alm_despachodet.nropedido AS orden,
                                                    alm_despachodet.nroorden AS pedido,
                                                    UPPER(origen.cdesalm) AS origen,
                                                    UPPER(origen.ctipovia) AS direccion_origen,
                                                    UPPER(destino.cdesalm) AS destino,
                                                    UPPER(destino.ctipovia) AS direccion_destino,
                                                    alm_despachocab.cnumguia,
                                                    alm_despachocab.nEstadoDoc,
                                                    UPPER(
                                                            CONCAT_WS(
                                                                ' ',
                                                                tb_proyectos.ccodproy,
                                                                tb_proyectos.cdesproy
                                                                
                                                            )
                                                        ) AS costos,
                                                    tb_costusu.nflgactivo,
                                                    tb_parametros.cdescripcion,
                                                    tb_parametros.cabrevia,
                                                    alm_despachocab.id_regalm 
                                                FROM
                                                    alm_despachodet
                                                    INNER JOIN alm_despachocab ON alm_despachodet.id_regalm = alm_despachocab.id_regalm
                                                    INNER JOIN tb_almacen AS origen ON alm_despachocab.ncodalm1 = origen.ncodalm
                                                    INNER JOIN tb_almacen AS destino ON alm_despachocab.ncodalm2 = destino.ncodalm
                                                    INNER JOIN tb_proyectos ON alm_despachocab.ncodpry = tb_proyectos.nidreg
                                                    INNER JOIN tb_costusu ON alm_despachocab.ncodpry = alm_despachocab.ncodpry
                                                    INNER JOIN tb_parametros ON alm_despachocab.nEstadoDoc = tb_parametros.nidreg 
                                                WHERE
                                                    tb_costusu.nflgactivo = 1 
                                                    AND tb_costusu.id_cuser = :usr
                                                    AND alm_despachocab.cper = YEAR(NOW())
                                                    AND alm_despachocab.nEstadoDoc = 62
                                                GROUP BY alm_despachocab.id_regalm
                                                    ORDER BY alm_despachocab.ffecdoc DESC");
                $sql->execute(["usr"=>$_SESSION['iduser']]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()){
                        $salida .='<tr data-indice="'.$rs['id_regalm'].'" class="pointer">
                                        <td class="textoCentro">'.str_pad($rs['id_regalm'],6,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.$rs['ffecdoc'].'</td>
                                        <td class="textoCentro">'.$rs['origen'].'</td>
                                        <td class="pl20px">'.$rs['destino'].'</td>
                                        <td class="pl20px">'.$rs['costos'].'</td>
                                        <td class="textoCentro">'.$rs['anio'].'</td>
                                        <td class="textoCentro">'.$rs['cnumguia'].'</td>
                                        <td class="textoCentro ">'.str_pad($rs['orden'],6,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro ">'.str_pad($rs['pedido'],6,0,STR_PAD_LEFT).'</td>
                                    </tr>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        //esto se usara para todos los documentos
        private function ultimoIndice(){
            $indice = $this->lastInsertId("SELECT COUNT(id_regalm) + 1 AS id FROM alm_despachocab"); 
            return str_pad($indice++,6,0,STR_PAD_LEFT);
        }

        public function pasarDetallesOrden($id,$costo){
            try {
                $indice = $this->ultimoIndice();
                return array("numero"=>$indice++,
                            "items"=>$this->ordenDetalles($id),
                            "costos"=>$this->centroCostos($costo));
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function ordenDetalles($id) {
            try {
                $salida ="";

                $sql = $this->db->connect()->prepare("SELECT
                                                        lg_ordendet.nitemord,
                                                        lg_ordendet.id_regmov,
                                                        lg_ordendet.niddeta,
                                                        lg_ordendet.nidpedi,
                                                        lg_ordendet.id_cprod,
                                                        lg_ordendet.id_orden,
                                                        cm_producto.ccodprod,
                                                        LPAD( tb_pedidocab.nrodoc, 6, 0 ) AS pedido,
                                                        UPPER( CONCAT_WS( ' ', cm_producto.cdesprod, tb_pedidodet.observaciones, tb_pedidodet.docEspec ) ) AS cdesprod,
                                                        cm_producto.nund,
                                                        tb_unimed.cabrevia,
                                                        tb_pedidodet.idpedido,
                                                        tb_pedidodet.nroparte,
                                                        REPLACE ( FORMAT( lg_ordendet.ncanti, 2 ), ',', '' ) AS cantidad,
                                                        ( SELECT SUM( alm_recepdet.ncantidad ) FROM alm_recepdet WHERE alm_recepdet.niddetaOrd = lg_ordendet.nitemord 
                                                            AND alm_recepdet.nflgActivo = 1) AS ingresos,
                                                        ( SELECT SUM( alm_despachodet.ndespacho ) FROM alm_despachodet WHERE alm_despachodet.niddetaOrd = lg_ordendet.nitemord 
                                                        AND alm_despachodet.nflgActivo = 1) AS despachos 
                                                    FROM
                                                        lg_ordendet
                                                        INNER JOIN cm_producto ON lg_ordendet.id_cprod = cm_producto.id_cprod
                                                        INNER JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed
                                                        INNER JOIN tb_pedidodet ON lg_ordendet.niddeta = tb_pedidodet.iditem
                                                        INNER JOIN tb_pedidocab ON tb_pedidocab.idreg = tb_pedidodet.idpedido 
                                                    WHERE
                                                        lg_ordendet.id_orden = :id");
                $sql->execute(["id"=>$id]);
                
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    $item=1;
                    
                    while ($rs = $sql->fetch()){
                        $saldo = $rs['ingresos'] - $rs['despachos'];
                        $pendientes = $rs['cantidad'] - $rs['ingresos'];
                       
                        if ( $rs['ingresos'] > 0 ) {
                            if ( $saldo > 0 ) {

                                $series  = strlen($this->itemSeries($rs['niddeta'])) == 0 ? "" : strtoupper("N/S :".$this->itemSeries($rs['niddeta']));

                                $salida.='<tr data-detorden="'.$rs['nitemord'].'" 
                                            data-idprod="'.$rs['id_cprod'].'"
                                            data-iddetped="'.$rs['niddeta'].'"
                                            data-saldo="'.$saldo.'"
                                            data_pedido="'.$rs['nidpedi'].'"
                                            data_orden="'.$rs['id_orden'].'">
                                        <td class="textoCentro"><a href="'.$rs['id_orden'].'" data-accion="deleteItem" class="eliminarItem"><i class="fas fa-minus"></i></a></td>
                                        <td class="textoCentro"><input type="checkbox"></td>
                                        <td class="textoCentro">'.str_pad($item++,3,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl20px">'.$rs['cdesprod'].' '.$series.'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                        <td class="textoDerecha pr20px">'.$rs['cantidad'].'</td>
                                        <td class="textoDerecha pr20px">'.$rs['ingresos'].'</td>
                                        <td>
                                            <input type="number" 
                                                step="any" 
                                                placeholder="0.00" 
                                                onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)" value="'.$saldo.'">
                                        </td>
                                        <td class="textoDerecha pr20px">'. number_format($pendientes,2) .'</td>
                                        <td><input type="text"></td>
                                        <td class="textoCentro">'.$rs['pedido'].'</td>
                                        <td class="textoCentro">'.str_pad($rs['id_orden'],6,0,STR_PAD_LEFT).'</td>
                                    </tr>';
                            }    
                        }
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function generarPdfSalida($cabecera,$detalles,$condicion){
            require_once("public/formatos/notasalida.php");
            try {
                $datos = json_decode($detalles);
                $nreg = count($datos);

                $fecha = explode("-",$cabecera['fecha']);

                $lc = 0;
                $rc = 0;

                $dia = $fecha[2];
                $mes = $fecha[1];
                $anio = $fecha[0];

                $cargo = "Jefe de Almacen";

                $file = uniqid("NS")."_".$cabecera['numero']."_".$cabecera['almacen_origen_despacho'].".pdf";

                if ($condicion == 0){
                    $filename = "public/documentos/notas_salida/vistaprevia/".$file;
                }else if ($condicion == 1){
                    $filename = "public/documentos/notas_salida/emitidas/".$file;
                }
                
                $pdf = new PDF($cabecera['numero'],$condicion,$dia,$mes,$anio,$cabecera['costos'],
                            $cabecera['almacen_origen_despacho'],$cabecera['almacen_destino_despacho'],
                            $cabecera['tipo'],$cabecera['guia'],$cabecera['aprueba'],$cargo);

                $pdf->AliasNbPages();
                $pdf->AddPage();
                $pdf->SetWidths(array(10,15,70,8,10,30,17,15,15));
                $pdf->SetFont('Arial','',4);

                for($i=1;$i<=$nreg;$i++){
                    $pdf->SetAligns(array("C","L","L","L","R","L","L","L","L"));
                    $pdf->Row(array(str_pad($i,3,"0",STR_PAD_LEFT),
                                            $datos[$rc]->codigo,
                                            'P:'.$datos[$rc]->orden.' '.'O:'.$datos[$rc]->pedido.' '.utf8_decode($datos[$rc]->descripcion),
                                            $datos[$rc]->unidad,
                                            $datos[$rc]->cantdesp,
                                            $datos[$rc]->obser,
                                            "",
                                            "",
                                            ""));
                    $lc++;
                    $rc++;
                    
                    if ($lc == 52) {
                        $pdf->AddPage();
                        $lc = 0;
                    }	
                }
                
            $pdf->Output($filename,'F');
                
            return $filename;
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }    
        }

        public function generarVistaPrevia($cabecera,$detalles,$proyecto){
            try {
                require_once("public/formatos/guiaremision.php");
                
                $archivo = "public/documentos/guias_remision/".$cabecera['numero_guia'].".pdf";
                $datos = json_decode($detalles);
                $nreg = count($datos);
                $fecha_emision = date("d/m/Y", strtotime($cabecera['fgemision']));
                $fecha_traslado = date("d/m/Y", strtotime($cabecera['ftraslado']));
                $referido = $this->generarRS(); 
                $anio = explode('-',$cabecera['fgemision']);

                if ($cabecera['ftraslado'] !== "")
                    $fecha_traslado = date("d/m/Y", strtotime($cabecera['ftraslado']));
                else 
                    $fecha_traslado = "";

                $pdf = new PDF($cabecera['numero_guia'],
                                $fecha_emision,
                                $cabecera['destinatario_ruc'],
                                $cabecera['destinatario_razon'],
                                $cabecera['destinatario_direccion'],
                                $cabecera['empresa_transporte_razon'],
                                $cabecera['ruc_proveedor'],
                                $cabecera['direccion_proveedor'],
                                $cabecera['almacen_origen_direccion'],
                                null,
                                null,
                                null,
                                $fecha_traslado,
                                $cabecera['modalidad_traslado'],
                                $cabecera['almacen_destino_direccion'],
                                null,
                                null,
                                null,
                                $cabecera['marca'],
                                $cabecera['placa'],
                                $cabecera['nombre_conductor'],
                                $cabecera['licencia_conducir'],
                                $cabecera['tipo_envio'],
                                $referido,
                                $proyecto,
                                $anio[0],
                                $cabecera["observaciones"],
                                $cabecera["destinatario"],
                                'A4');
                $pdf->AliasNbPages();
                $pdf->AddPage();
                $pdf->SetWidths(array(10,15,15,147));
                $pdf->SetFillColor(255,255,255);
                $pdf->SetTextColor(0,0,0);
                
                $pdf->SetFont('Arial','',7);
                $lc = 0;
                $rc = 0;

                //aca podria sumar la orden

                for($i=1;$i<=$nreg;$i++){

                    $pdf->SetX(13);
                    $pdf->SetCellHeight(3);
                    //$pdf->SetFont('Arial','',3);

                    $pdf->SetAligns(array("R","R","C","L"));
                    $pdf->Row(array(str_pad($i,3,"0",STR_PAD_LEFT),
                                    $datos[$rc]->cantdesp,
                                    $datos[$rc]->unidad,
                                    utf8_decode($datos[$rc]->codigo .' '. $datos[$rc]->descripcion  .' '.'O : '.$datos[$rc]->pedido.' P : '.$datos[$rc]->orden)));
                    $lc++;
                    $rc++;

                    if ($lc == 26) {
                        $pdf->AddPage();
                        $lc = 0;
                    }
                }

                $pdf->Ln(1);
                    $pdf->SetX(13);
                    //$pdf->MultiCell(190,2,utf8_decode($cabecera["observaciones"]));
                    $pdf->Ln(2);
                    $pdf->SetX(13);
                    $pdf->Output($archivo,'F');
                    
                    return array("archivo"=>$archivo);

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function grabarGuia($cabeceraGuia,$detalles,$proyecto,$despacho,$operacion,$guia) {
            try {

                $accion = "";

                if ($cabeceraGuia['ftraslado'] !== "")
                    $fecha_traslado = date("d/m/Y", strtotime($cabeceraGuia['ftraslado']));
                else 
                    $fecha_traslado = "";

                $fecha_emision = date("d/m/Y", strtotime($cabeceraGuia['fgemision']));

                if ($guia == "") {
                    $salida = $this->grabarDatosGuia($cabeceraGuia,$despacho,$fecha_emision,$fecha_traslado);
                    $guia = $cabeceraGuia['numero_guia'];
                }else {
                    $salida = $this->modificarDatosGuia($cabeceraGuia,$despacho,$fecha_emision,$fecha_traslado);
                    $guia = $cabeceraGuia['numero_guia'];
                }

            $referido = $this->generarRS();     
            $this->actualizarGuiaEnDespacho($cabeceraGuia,$referido,$despacho);

            return array("mensaje"=>$salida,"guia"=>$guia);    
                
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        private function actualizarGuiaEnDespacho($cabecera,$referido,$nro_despacho){
            try {
                $sql = $this->db->connect()->prepare("UPDATE alm_despachocab 
                                                        SET ffecenvio=:envio,nReferido=:referido,cnumguia=:guia,id_centi=:entidad
                                                        WHERE id_regalm =:despacho");
                
                $sql->execute(["envio"=>$cabecera['ftraslado'],
                                "referido"=>$referido,
                                "guia"=>$cabecera['numero_guia'],
                                "entidad"=>$cabecera['codigo_entidad_transporte'],
                                "despacho"=>$nro_despacho]);
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function imprimirFormato($cabecera,$detalles,$proyecto,$nro_despacho,$operacion){
            try {
                require_once("public/formatos/grpreimpreso.php");
                
                $archivo = "public/documentos/temp/".uniqid().".pdf";
                $datos = json_decode($detalles);
                $nreg = count($datos);
                
                $fecha_emision = date("d/m/Y", strtotime($cabecera['fgemision']));

                //$series = $this->buscarSeries($rs['id_cprod'],$rs['id_regalm'],$rs['ncodalm1']);
                
                if ($cabecera['ftraslado'] !== "")
                    $fecha_traslado = date("d/m/Y", strtotime($cabecera['ftraslado']));
                else 
                    $fecha_traslado = "";

                $referido = $this->generarRS(); 
                $anio = explode('-',$cabecera['fgemision']);

                
                $pdf = new PDF($cabecera['numero_guia'],
                                $fecha_emision,
                                $cabecera['destinatario_ruc'],
                                $cabecera['destinatario_razon'],
                                $cabecera['destinatario_direccion'],
                                $cabecera['empresa_transporte_razon'],
                                $cabecera['ruc_proveedor'],
                                $cabecera['direccion_proveedor'],
                                $cabecera['almacen_origen_direccion'],
                                null,
                                null,
                                null,
                                $fecha_traslado,
                                $cabecera['modalidad_traslado'],
                                $cabecera['almacen_destino_direccion'],
                                null,
                                null,
                                null,
                                $cabecera['marca'],
                                $cabecera['placa'],
                                $cabecera['nombre_conductor'],
                                $cabecera['licencia_conducir'],
                                $cabecera['tipo_envio'],
                                $referido,
                                $proyecto,
                                $anio[0],
                                $cabecera["observaciones"],
                                $cabecera["destinatario"],
                                'A4');
                $pdf->AliasNbPages();
                $pdf->AddPage();
                $pdf->SetWidths(array(10,15,15,147));
                $pdf->SetFillColor(255,255,255);
                $pdf->SetTextColor(0,0,0);
                
                $pdf->SetFont('Arial','',9);
                $lc = 0;
                $rc = 0;

                //aca podria sumar la orden

                for($i=1;$i<=$nreg;$i++){

                    $pdf->SetX(3);
                    $pdf->SetCellHeight(3);
                    //$pdf->SetFont('Arial','',3);

                    if( $datos[$rc]->cantdesp > 0) {
                        $pdf->SetAligns(array("R","R","C","L"));
                        $pdf->Row(array(str_pad($i,3,"0",STR_PAD_LEFT),
                                        $datos[$rc]->cantdesp,
                                        $datos[$rc]->unidad,
                                        '  O : '.$datos[$rc]->pedido.' P : '.$datos[$rc]->orden .' '. utf8_decode($datos[$rc]->codigo .' '. $datos[$rc]->descripcion )));
                        $lc++;
                        $rc++;

                        if ($lc == 24) {
                            $pdf->AddPage();
                            $lc = 0;
                        }
                    }
                }

                $pdf->Ln(1);
                    
                    $pdf->Output($archivo,'F');
                    
                    return array("archivo"=>$archivo);

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function grabarDespacho($cabecera,$detalles){
            try {
                $mensaje = "Error al grabar el registro";
                $clase = "mensaje_error";
                $error = true;

                $query = "SELECT COUNT( alm_despachocab.id_regalm ) AS numero FROM alm_despachocab WHERE ncodalm1 =:cod";
                $nota = $this->generarNumero($cabecera["codigo_almacen_origen"],$query);
                $indice = $this->lastInsertId("SELECT COUNT(id_regalm) + 1 AS id FROM alm_despachocab");

                $fecha = explode("-",$cabecera['fecha']);

                $sql = $this->db->connect()->prepare("INSERT INTO alm_despachocab SET ntipmov = :ntipmov,
                                                                                        nnromov = :nnromov,
                                                                                        cper = :cper,
                                                                                        cmes = :cmes,
                                                                                        ncodalm1 = :ncodalm1,
                                                                                        ncodalm2 = :ncodalm2,
                                                                                        ffecdoc = :ffecdoc,
                                                                                        ncodpry = :ncodpry,
                                                                                        nnronota=:nnronota,
                                                                                        id_userAprob = :id_userAprob,
                                                                                        id_userElabora = :id_user,
                                                                                        nEstadoDoc = :nEstadoDoc,
                                                                                        nflgactivo = :nflgactivo");

                $sql->execute(["ntipmov"=>$cabecera['codigo_movimiento'],
                                "nnromov"=>null,
                                "cper"=>$fecha[0],
                                "cmes"=>$fecha[1],
                                "ncodalm1"=>$cabecera['codigo_almacen_origen'],
                                "ncodalm2"=>$cabecera['codigo_almacen_destino'],
                                "ffecdoc"=>$cabecera['fecha'],
                                "ncodpry"=>$cabecera['codigo_costos'],
                                "nnronota"=>$nota['numero'],
                                "id_userAprob"=>$cabecera['codigo_aprueba'],
                                "nEstadoDoc"=>62,
                                "nflgactivo"=>1,
                                "id_user"=>$_SESSION['iduser']]);
                
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    $mensaje = "Registro grabado";
                    $clase = "mensaje_correcto";
                    $error = "false";
                    $this->grabarDetallesDespacho($indice,$detalles,$cabecera['codigo_almacen_origen']);
                    $this->actualizarDetallesPedido($indice,$detalles);
                }
                
                return array("mensaje"=>$mensaje, 
                             "clase"=>$clase,
                             "error"=>$error,
                             "indice"=>$indice);

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function grabarDetallesDespacho($id,$detalles,$almacen){
            try {
                $datos = json_decode($detalles);
                $nreg = count($datos);

                for ($i=0; $i < $nreg; $i++) { 
                    try {
                        $sql=$this->db->connect()->prepare("INSERT INTO alm_despachodet SET id_regalm=:cod,
                                                                                            ncodalm1=:ori,
                                                                                            id_cprod=:cpro,
                                                                                            ncantidad=:cant,
                                                                                            niddetaPed=:idpedido,
                                                                                            niddetaOrd=:idorden,
                                                                                            nflgactivo=:flag,
                                                                                            nestadoreg=:estadoItem,
                                                                                            ingreso=:ingreso,
                                                                                            ncodalm2=:destino,
                                                                                            niddetaIng=:itemIngreso,
                                                                                            nroorden=:orden,
                                                                                            nropedido=:pedido,
                                                                                            ndespacho=:candesp,
                                                                                            cobserva=:observac");
                         $sql->execute(["cod"=>$id,
                                        "ori"=>$almacen,
                                        "cpro"=>$datos[$i]->idprod,
                                        "cant"=>$datos[$i]->cantidad,
                                        "idpedido"=>$datos[$i]->iddetped,
                                        "idorden"=>$datos[$i]->iddetorden,
                                        "flag"=>1,
                                        "estadoItem"=>49,
                                        "ingreso"=>null,
                                        "destino"=>$datos[$i]->destino,
                                        "candesp"=>$datos[$i]->cantdesp,
                                        "itemIngreso"=>null,
                                        "pedido"=>$datos[$i]->pedido,
                                        "orden"=>$datos[$i]->orden,
                                        "observac"=>$datos[$i]->obser]);
                    } catch (PDOException $th) {
                        echo $th->getMessage();
                        return false;
                    }
                }

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function actualizarDetallesPedido($despacho,$detalles){
            
            try {
                $datos = json_decode($detalles);
                $nreg = count($datos);

                for ($i=0; $i < $nreg; $i++) {
                    $sql = $this->db->connect()->prepare("UPDATE tb_pedidodet 
                                                            SET iddespacho=:despacho,
                                                                estadoItem=:estado
                                                            WHERE iditem=:id");
                    $sql->execute(["despacho"=>$despacho,
                                    "estado"=>62,
                                    "id"=>$datos[$i]->iddetped]);
                }

            } catch (PDOException $th) {
                        echo $th->getMessage();
                        return false;
            }
        }

        private function centroCostos($id){
            try {
                $sql=$this->db->connect()->prepare("SELECT UPPER(CONCAT_WS(' ',tb_proyectos.ccodproy,tb_proyectos.cdesproy)) AS nombre
                                                    FROM tb_proyectos
                                                    WHERE tb_proyectos.nidreg =:id");
                $sql->execute(["id"=>$id]);
                $result=$sql->fetchAll();

                return $result[0]['nombre'];

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function filtrarOrdenesID($id){
            try {
                $salida = "";
                $sql = $this->db->connect()->prepare("SELECT
                                                        lg_ordencab.id_regmov,
                                                        tb_costusu.ncodproy,
                                                        lg_ordencab.id_refpedi,
                                                        lg_ordencab.ntipdoc,
                                                        LPAD( lg_ordencab.cnumero, 6, 0 ) AS cnumero,
                                                        DATE_FORMAT( lg_ordencab.ffechadoc, '%d/%m/%Y' ) AS ffechadoc,
                                                        lg_ordencab.nEstadoDoc,
                                                        tb_proyectos.ccodproy,
                                                        tb_proyectos.nidreg,
                                                        CONCAT_WS(
                                                            ' ',
                                                            tb_proyectos.ccodproy,
                                                        UPPER( tb_proyectos.cdesproy )) AS costos,
                                                        CONCAT_WS(
                                                            ' ',
                                                            tb_area.ccodarea,
                                                        UPPER( tb_area.cdesarea )) AS area,
                                                        cm_entidad.crazonsoc 
                                                    FROM
                                                        tb_costusu
                                                        INNER JOIN lg_ordencab ON tb_costusu.ncodproy = lg_ordencab.ncodpry
                                                        INNER JOIN tb_proyectos ON lg_ordencab.ncodpry = tb_proyectos.nidreg
                                                        INNER JOIN tb_area ON lg_ordencab.ncodarea = tb_area.ncodarea
                                                        INNER JOIN cm_entidad ON lg_ordencab.id_centi = cm_entidad.id_centi 
                                                    WHERE
                                                        tb_costusu.id_cuser = :usr
                                                        AND lg_ordencab.id_regmov = :id 
                                                        AND tb_costusu.nflgactivo = 1 
                                                        AND lg_ordencab.nEstadoDoc BETWEEN 60 AND 62
                                                    ORDER BY id_regmov DESC");
                $sql->execute(["usr"=>$_SESSION['iduser'],"id"=>$id]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()) {
                        //compara la orden si fue ingresada esta completa y no la muestra
                        //$diferencia_ingreso = $this->calcularIngresosOrden($rs['id_regmov']) - $this->calcularCantidadDespacha($rs['id_regmov']);

                        //if (($diferencia_ingreso) > 0 ) {
                            $salida.='<tr data-orden="'.$rs['id_regmov'].'" data-idcosto="'.$rs['nidreg'].'">
                                    <td class="textoCentro">'.$rs['cnumero'].'</td>
                                    <td class="textoCentro">'.$rs['ffechadoc'].'</td>
                                    <td class="pl20px">'.$rs['area'].'</td>
                                    <td class="textoDerecha pr5px">'.$rs['ccodproy'].'</td>
                                    <td class="pl20px">'.$rs['crazonsoc'].'</td>
                                </tr>';
                        //}
                    }
                }
                return $salida;
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function generarRS() {
            try {
                $sql = $this->db->connect()->query("SELECT MAX(nReferido) AS rs FROM alm_despachocab");
                $sql->execute();
                $resultado = $sql->fetchAll();

                $rs = gettype($resultado[0]['rs']) == "NULL" ? 5000 : $resultado[0]['rs'];
                $rs = $rs+1; 

                return $rs;
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function consultarSalidaId($indice){
            try {
                $sql=$this->db->connect()->prepare("SELECT
                                                    alm_despachocab.id_regalm,
                                                    alm_despachocab.ncodalm1,
                                                    alm_despachocab.ncodalm2,
                                                    DATE_FORMAT(
                                                        alm_despachocab.ffecdoc,
                                                        '%d/%m/%Y'
                                                    ) AS fecha_despacho,
                                                    alm_despachocab.ffecdoc,
                                                    alm_despachocab.cnumguia,
                                                    alm_despachocab.ncodpry,
                                                    alm_despachocab.nEstadoDoc,
                                                    UPPER(origen.cdesalm) AS origen,
                                                    UPPER(origen.ctipovia) AS direccion_origen,
                                                    UPPER(destino.cdesalm) AS destino,
                                                    UPPER(destino.ctipovia) AS direccion_destino,
                                                    UPPER(
                                                        CONCAT_WS(
                                                            ' ',
                                                            tb_proyectos.ccodproy,
                                                            tb_proyectos.cdesproy
                                                        )
                                                    ) AS costos,
                                                    alm_despachocab.id_userAprob,
                                                    tb_user.cnombres,
                                                    movimientos.nidreg,
                                                    movimientos.cdescripcion AS tipo_movimiento,
                                                    estado.cdescripcion AS estado,
                                                    origen.ncubigeo AS ubigeo_origen,
                                                    destino.ncubigeo AS ubigeo_destino
                                                FROM
                                                    alm_despachocab
                                                INNER JOIN tb_almacen AS origen ON alm_despachocab.ncodalm1 = origen.ncodalm
                                                INNER JOIN tb_almacen AS destino ON alm_despachocab.ncodalm2 = destino.ncodalm
                                                INNER JOIN tb_proyectos ON alm_despachocab.ncodpry = tb_proyectos.nidreg
                                                INNER JOIN tb_user ON alm_despachocab.id_userAprob = tb_user.iduser
                                                INNER JOIN tb_parametros AS movimientos ON alm_despachocab.ntipmov = movimientos.nidreg
                                                INNER JOIN tb_parametros AS estado ON alm_despachocab.nEstadoDoc = estado.nidreg
                                                WHERE id_regalm = :indice");
                $sql->execute(["indice"=>$indice]);
                $docData = array();
                while($row=$sql->fetch(PDO::FETCH_ASSOC)){
                    $docData[] = $row;
                }

                return array("cabecera"=>$docData,
                            "detalles"=>$this->salidaDetalles($indice),
                            "guias"=>$this->consultarDatosGuia($indice));
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }  
        }

        private function salidaDetalles($indice){
            try {
                //aca hubo un problema orden por pedido
                $salida="";
                $sql=$this->db->connect()->prepare("SELECT
                                                    alm_despachodet.id_regalm,
                                                    alm_despachodet.ncodalm1,
                                                    alm_despachodet.fvence,
                                                    alm_despachodet.ncantidad,
                                                    alm_despachodet.id_cprod,
                                                    alm_despachodet.niddetaPed,
                                                    alm_despachodet.niddetaOrd,
                                                    alm_despachodet.niddeta,
                                                    alm_despachodet.ndespacho,
                                                    alm_despachodet.cobserva,
                                                    alm_despachodet.niddetaIng,
                                                    LPAD( alm_despachodet.nropedido, 6, 0 ) AS orden,
                                                    LPAD( alm_despachodet.nroorden, 6, 0 ) AS pedido,
                                                    alm_despachodet.ingreso,
                                                    FORMAT( alm_despachodet.nsaldo, 2 ) AS nsaldo,
                                                    cm_producto.ccodprod,
                                                    REPLACE ( FORMAT( alm_despachodet.ncantidad, 2 ), ',', '' ) AS cantidad,
                                                    UPPER( CONCAT_WS( ' ', cm_producto.cdesprod, tb_pedidodet.observaciones ) ) AS cdesprod,
                                                    tb_unimed.nfactor,
                                                    tb_unimed.cabrevia,
                                                    tb_pedidocab.nrodoc,
                                                    (SELECT	 SUM(alm_recepdet.ncantidad) FROM alm_recepdet 
                                                        WHERE alm_recepdet.niddetaOrd = alm_despachodet.niddetaOrd 
                                                         AND  alm_recepdet.nflgactivo = 1) AS ingresado
                                                FROM
                                                    alm_despachodet
                                                    LEFT JOIN cm_producto ON alm_despachodet.id_cprod = cm_producto.id_cprod
                                                    LEFT JOIN tb_pedidodet ON alm_despachodet.niddetaPed = tb_pedidodet.iditem
                                                    LEFT JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed
                                                    LEFT JOIN tb_pedidocab ON alm_despachodet.nropedido = tb_pedidocab.idreg 
                                                WHERE
                                                    alm_despachodet.id_regalm = :id
                                                    AND alm_despachodet.nflgactivo = 1");
                $sql->execute(["id"=>$indice]);

                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    $item = 1;
                    while ($rs = $sql->fetch()){

                        //$series = $this->buscarSeries($rs['id_cprod'],$rs['id_regalm'],$rs['ncodalm1']);
                        
                        $pendiente = $rs['cantidad'] - $rs['ingresado'];

                        if ( $rs['ndespacho'] > 0 ) {
                            $salida.='<tr data-idorden="'.$rs['niddetaOrd'].'" 
                                        data-idpedido="'.$rs['niddetaPed'].'" 
                                        data-idingreso="'.$rs['niddetaIng'].'"
                                        data-iddespacho="'.$rs['niddeta'].'"
                                        data-idproducto ="'.$rs['id_cprod'].'"
                                        data-pedido ="'.$rs['pedido'].'"
                                        data-orden ="'.$rs['orden'].'">
                                        <td class="textoCentro"><a href="'.$rs['niddeta'].'" data-accion="deleteItem" class="eliminarItem"><i class="fas fa-minus"></i></a></td>
                                        <td class="textoCentro"><input type="checkbox" checked></td>
                                        <td class="textoCentro">'.str_pad($item++,3,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl20px">'.$rs['cdesprod'].'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                        <td class="textoDerecha pr20px">'.$rs['cantidad'].'</td>
                                        <td class="textoDerecha pr20px">'.$rs['ingresado'].'</td>
                                        <td><input type="number" step="any" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"
                                        value="'.$rs['ndespacho'].'" ></td>
                                        <td class="textoDerecha pr20px">'.$pendiente.'</td>
                                        <td class="pr20px"><input type="text" value="'.$rs['cobserva'].'"></td>
                                        <td class="textoCentro">'.str_pad($rs['pedido'],6,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.str_pad($rs['orden'],6,0,STR_PAD_LEFT).'</td>
                                    </tr>';
                        }

                        
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function calcularSaldosItemsDespachados($orden,$idprod){
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                        alm_despachodet.niddetaPed,
                                                        lg_ordendet.nitemord,
                                                        lg_ordendet.id_orden,
                                                        alm_despachodet.ncantidad,
                                                        lg_ordendet.ncanti,
                                                        SUM( alm_despachodet.ndespacho ) AS totalItemDespachado 
                                                    FROM
                                                        alm_despachodet
                                                        INNER JOIN lg_ordendet ON alm_despachodet.niddetaPed = lg_ordendet.niddeta 
                                                    WHERE
                                                        alm_despachodet.nropedido = :orden 
                                                        AND lg_ordendet.nitemord = :producto");
                $sql->execute(["orden"=>$orden,"producto"=>$idprod]);
                $result = $sql->fetchAll();

                return $result[0]['totalItemDespachado'];
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        private function ingresosRegistrados($orden,$idOrden){
            try {
                $sql = $this->db->connect()->prepare("SELECT 
                                                        FORMAT(SUM(ncantidad),2) AS  totalItemIngresado 
                                                        FROM alm_recepdet 
                                                        WHERE pedido = :orden AND niddetaOrd=:item");
                $sql->execute(["orden"=>$orden,"item"=>$idOrden]);
                $result = $sql->fetchAll();

                return $result[0]['totalItemIngresado'];
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function filtrarNotasDespacho($parametros){
            try {

                $mes  = date("m");

                $orden  = $parametros['ordenSearch'] == "" ? "%" : $parametros['ordenSearch'];
                $costos = $parametros['costosSearch'] == -1 ? "%" : "%".$parametros['costosSearch']."%";
                $mes    = $parametros['mesSearch'] == -1 ? "%" :  $parametros['mesSearch'];
                $anio   = $parametros['anioSearch'] == "" ? "%" : $parametros['anioSearch'];

                $salida = "";
                $sql = $this->db->connect()->prepare("SELECT
                                                        alm_despachocab.cmes,
                                                        DATE_FORMAT( alm_despachocab.ffecdoc, '%d/%m/%Y' ) AS ffecdoc,
                                                        YEAR ( ffecdoc ) AS anio,
                                                        alm_despachodet.nropedido AS orden,
                                                        alm_despachodet.nroorden AS pedido,
                                                        UPPER( origen.cdesalm ) AS origen,
                                                        UPPER( origen.ctipovia ) AS direccion_origen,
                                                        UPPER( destino.cdesalm ) AS destino,
                                                        UPPER( destino.ctipovia ) AS direccion_destino,
                                                        alm_despachocab.cnumguia,
                                                        alm_despachocab.nEstadoDoc,
                                                        UPPER( CONCAT_WS( ' ', tb_proyectos.ccodproy, tb_proyectos.cdesproy ) ) AS costos,
                                                        tb_costusu.nflgactivo,
                                                        tb_parametros.cdescripcion,
                                                        tb_parametros.cabrevia,
                                                        alm_despachocab.id_regalm 
                                                    FROM
                                                        alm_despachodet
                                                        INNER JOIN alm_despachocab ON alm_despachodet.id_regalm = alm_despachocab.id_regalm
                                                        INNER JOIN tb_almacen AS origen ON alm_despachocab.ncodalm1 = origen.ncodalm
                                                        INNER JOIN tb_almacen AS destino ON alm_despachocab.ncodalm2 = destino.ncodalm
                                                        INNER JOIN tb_proyectos ON alm_despachocab.ncodpry = tb_proyectos.nidreg
                                                        INNER JOIN tb_costusu ON alm_despachocab.ncodpry = alm_despachocab.ncodpry
                                                        INNER JOIN tb_parametros ON alm_despachocab.nEstadoDoc = tb_parametros.nidreg 
                                                    WHERE
                                                        tb_costusu.nflgactivo = 1 
                                                        AND alm_despachocab.nEstadoDoc = 62
                                                        AND tb_costusu.id_cuser = :usr 
                                                        AND alm_despachodet.nropedido = :orden 
                                                        AND alm_despachocab.ncodpry LIKE :costos 
                                                        AND alm_despachocab.cper LIKE :anio 
                                                        AND alm_despachocab.cmes LIKE :mes 
                                                        GROUP BY alm_despachocab.id_regalm");
                
                $sql->execute(["usr"=>$_SESSION['iduser'],
                                "orden"=>$orden,
                                "costos"=>$costos,
                                "mes"=>$mes,
                                "anio"=>$anio]);

                $rowCount = $sql->rowcount();
                if ($rowCount > 0){
                    while($rs = $sql->fetch()){
                        $salida .='<tr data-indice="'.$rs['id_regalm'].'" class="pointer">
                                        <td class="textoCentro">'.str_pad($rs['id_regalm'],6,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.$rs['ffecdoc'].'</td>
                                        <td class="textoCentro">'.$rs['origen'].'</td>
                                        <td class="pl20px">'.$rs['destino'].'</td>
                                        <td class="pl20px">'.$rs['costos'].'</td>
                                        <td class="textoCentro">'.$rs['anio'].'</td>
                                        <td class="textoCentro">'.$rs['cnumguia'].'</td>
                                        <td class="textoCentro ">'.str_pad($rs['orden'],6,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro ">'.str_pad($rs['pedido'],6,0,STR_PAD_LEFT).'</td>
                                    </tr>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function modificar($cabecera,$detalles){
            try {
                $sql = $this->db->connect()->prepare("UPDATE alm_despachocab SET ncodalm1 = :ncodalm1,
                                                                                 ncodalm2 = :ncodalm2,
                                                                                 id_userAprob = :id_userAprob
                                                                            WHERE id_regalm = :despacho
                                                                            LIMIT 1");

                $sql->execute(["ncodalm1"=>$cabecera['codigo_almacen_origen'],
                               "ncodalm2"=>$cabecera['codigo_almacen_destino'],
                               "id_userAprob"=>$cabecera['codigo_aprueba'],
                               "despacho"=>$cabecera['codigo_salida']]);

                $rowCount = $sql->rowCount();

                $this->modificarDetalles($detalles);

                if ($rowCount > 0) {
                    return true;
                }
                
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        private function modificarDetalles($detalles){
            try {
                $datos = json_decode($detalles);
                $nreg = count($datos);

                for ($i=0; $i < $nreg; $i++) { 
                        try {
                            $sql = $this->db->connect()->prepare("UPDATE alm_despachodet SET 
                                                                                cobserva=:observac,
                                                                                ncodalm1=:origen,
                                                                                ncodalm2=:destino,
                                                                                ndespacho=:candesp
                                                                        WHERE niddeta=:id");
                            $sql->execute(["id"=>$datos[$i]->iddespacho,
                                            "origen"=>$datos[$i]->almacen,
                                            "destino"=>$datos[$i]->destino,
                                            "candesp"=>$datos[$i]->cantdesp,
                                            "observac"=>$datos[$i]->obser]);
                    
                    } catch (PDOException $th) {
                        echo "Error: ".$th->getMessage();
                        return false;
                    }
                }
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function grabarDatosGuia($cabeceraGuia,$despacho,$emision,$traslado){
            try {
                $sql = $this->db->connect()->prepare("INSERT INTO lg_guias SET id_regalm=:despacho,cnumguia=:guia,corigen=:origen,
                                                                                cdirorigen=:direccion_origen,cdestino=:destino,
                                                                                cdirdest=:direccion_destino,centi=:entidad,centidir=:direccion_entidad,
                                                                                centiruc=:ruc_entidad,ctraslado=:traslado,cenvio=:envio,
                                                                                cautoriza=:autoriza,cdestinatario=:destinatario,cobserva=:observaciones,
                                                                                cnombre=:nombres,cmarca=:marca,clicencia=:licencia,cplaca=:placa,
                                                                                ftraslado=:fecha_traslado,fguia=:fecha_guia");

                $sql->execute([ "despacho"=>$despacho,
                                "guia"=>$cabeceraGuia['numero_guia'],
                                "origen"=>$cabeceraGuia['almacen_origen'],
                                "direccion_origen"=>$cabeceraGuia['almacen_origen_direccion'],
                                "destino"=>$cabeceraGuia['almacen_destino'],
                                "direccion_destino"=>$cabeceraGuia['almacen_destino_direccion'],
                                "entidad"=>$cabeceraGuia['empresa_transporte_razon'],
                                "direccion_entidad"=>$cabeceraGuia['direccion_proveedor'],
                                "ruc_entidad"=>$cabeceraGuia['ruc_proveedor'],
                                "traslado"=>$cabeceraGuia['modalidad_traslado'],
                                "envio"=>$cabeceraGuia['tipo_envio'],
                                "autoriza"=>$cabeceraGuia['autoriza'],
                                "destinatario"=>$cabeceraGuia['destinatario'],
                                "observaciones"=>$cabeceraGuia['observaciones'],
                                "nombres"=>$cabeceraGuia['nombre_conductor'],
                                "marca"=>$cabeceraGuia['marca'],
                                "licencia"=>$cabeceraGuia['licencia_conducir'],
                                "placa"=>$cabeceraGuia['placa'],
                                "fecha_traslado"=>$traslado,
                                "fecha_guia"=>$emision]);
                
                $rowCount = $sql->rowcount();

                if ($rowCount > 0) {
                    $mensaje = "Registro grabado";
                }else {
                    $mensaje = "Error al crear el registro";
                }

                return $mensaje;                
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function modificarDatosGuia($cabeceraGuia,$despacho,$emision,$traslado){
            try {
                $sql = $this->db->connect()->prepare("UPDATE lg_guias SET cnumguia=:guia,corigen=:origen,
                                                                          cdirorigen=:direccion_origen,cdestino=:destino,
                                                                          cdirdest=:direccion_destino,centi=:entidad,centidir=:direccion_entidad,
                                                                          centiruc=:ruc_entidad,ctraslado=:traslado,cenvio=:envio,
                                                                          cautoriza=:autoriza,cdestinatario=:destinatario,cobserva=:observaciones,
                                                                          cnombre=:nombres,cmarca=:marca,clicencia=:licencia,cplaca=:placa,
                                                                          ftraslado=:fecha_traslado,fguia=:fecha_guia
                                                                    WHERE idreg =:idguia");

                $sql->execute([ "idguia"=>$cabeceraGuia['id_guia'],
                                "guia"=>$cabeceraGuia['numero_guia'],
                                "origen"=>$cabeceraGuia['almacen_origen'],
                                "direccion_origen"=>$cabeceraGuia['almacen_origen_direccion'],
                                "destino"=>$cabeceraGuia['almacen_destino'],
                                "direccion_destino"=>$cabeceraGuia['almacen_destino_direccion'],
                                "entidad"=>$cabeceraGuia['empresa_transporte_razon'],
                                "direccion_entidad"=>$cabeceraGuia['direccion_proveedor'],
                                "ruc_entidad"=>$cabeceraGuia['ruc_proveedor'],
                                "traslado"=>$cabeceraGuia['modalidad_traslado'],
                                "envio"=>$cabeceraGuia['tipo_envio'],
                                "autoriza"=>$cabeceraGuia['autoriza'],
                                "destinatario"=>$cabeceraGuia['destinatario'],
                                "observaciones"=>$cabeceraGuia['observaciones'],
                                "nombres"=>$cabeceraGuia['nombre_conductor'],
                                "marca"=>$cabeceraGuia['marca'],
                                "licencia"=>$cabeceraGuia['licencia_conducir'],
                                "placa"=>$cabeceraGuia['placa'],
                                "fecha_traslado"=>$cabeceraGuia['ftraslado'],
                                "fecha_guia"=>$cabeceraGuia['fgemision']]);

                $rowCount = $sql->rowcount();

                if ($rowCount > 0) {
                    $mensaje = "Registro modificado";
                }else {
                    $mensaje = "Error al modificar el registro";
                }
                
                return $mensaje; 
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        private function consultarDatosGuia($despacho){
            try {
                $docData="";
                $sql=$this->db->connect()->prepare("SELECT
                                                        lg_guias.idreg,
                                                        lg_guias.id_regalm,
                                                        lg_guias.cnumguia,
                                                        lg_guias.corigen,
                                                        lg_guias.cdirorigen,
                                                        lg_guias.cdestino,
                                                        lg_guias.cdirdest,
                                                        lg_guias.centi,
                                                        lg_guias.centidir,
                                                        lg_guias.centiruc,
                                                        lg_guias.ctraslado,
                                                        lg_guias.cenvio,
                                                        lg_guias.cautoriza,
                                                        lg_guias.cmarca,
                                                        lg_guias.cplaca,
                                                        lg_guias.cnombre,
                                                        lg_guias.clicencia,
                                                        lg_guias.ftraslado,
                                                        lg_guias.fguia,
                                                        lg_guias.cobserva,
                                                        lg_guias.cdestinatario,
                                                        lg_guias.cmotivo 
                                                FROM
                                                    lg_guias 
                                                WHERE
                                                    lg_guias.id_regalm =:despacho");
                $sql->execute(["despacho"=>$despacho]);

                $rowCount = $sql->rowCount();
                
                if ($rowCount > 0) {
                    $docData = array();
                    while($row=$sql->fetch(PDO::FETCH_ASSOC)){
                        $docData[] = $row;
                    }
                }

                return $docData;

            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function verificarItem($id){
            try {
                $sql = $this->db->connect()->prepare("SELECT COUNT(alm_existencia.idpedido) AS existe 
                                                        FROM alm_existencia WHERE alm_existencia.idpedido =:id");
                $sql->execute(["id"=>$id]);

                $result =$sql->fetchAll();
               
                return $result[0]['existe'];
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function marcarItemDespacho($id){
            try {
                $sql = $this->db->connect()->prepare("UPDATE alm_despachodet SET alm_despachodet.nflgactivo = 0
                                                    WHERE alm_despachodet.niddetaPed =:id");
                $sql->execute(["id"=>$id]);
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function enviarSunat($cabecera,$detalles) {
            header('Access-Control-Allow-Origin: *');
            require 'public/libraries/efactura.php';

            $header = json_decode($cabecera);
            $body = json_decode($detalles);

            $empresa = $header->destinatario_razon;
            $guia    = $header->numero_guia;

           ///////////////////////////////////////////////////////////////////////////////////////////////////////

            $path = "public/documentos/guia_electronica/";

            $nombre_archivo = $header->destinatario_ruc.'-31-'.$header->serie_guia.'-'.$header->numero_guia;

            if(file_exists($path."XML/".$nombre_archivo.".xml")){
                unlink($path."XML/".$nombre_archivo.".xml");  
            }

            $token_access = $this->token('d12d8bf5-4b57-4c57-9569-9072b3e1bfcd', 'iLMGwQBEehJMXQ+Z/LR2KA==', '20504898173SISTEMA1', 'Lima123');
            $firma = $this->crear_files($path, $nombre_archivo, $header, $body);
            $respuesta = $this->envio_xml($path.'FIRMA/', $nombre_archivo, $token_access);
            $numero_ticket = $respuesta->numTicket;

            var_dump($respuesta);

            //sleep(2);//damos tiempo para que SUNAT procese y responda.
            //$respuesta_ticket = $this->envio_ticket($path.'CDR/', $numero_ticket, $token_access, $header->destinatario_ruc, $nombre_archivo);
            
            //return array("archivo" => $nombre_archivo,"ticket" => $respuesta_ticket);
        }

        private function crear_files($path,$nombre_archivo,$header,$body){
            $xml = $this->desarrollo_xml($header, $body);
            $archivo = fopen($path."XML/".$nombre_archivo.".xml", "w+");
            fwrite($archivo, utf8_decode($xml));
            fclose($archivo);

            $this->firmar_xml($nombre_archivo.".xml", "1");

            $zip = new ZipArchive();
            if($zip->open($path."FIRMA/".$nombre_archivo.".zip", ZipArchive::CREATE) === true){
                $zip->addFile($path."FIRMA/".$nombre_archivo.".xml", $nombre_archivo.".xml");
            }

            return $nombre_archivo;
        }

        private function desarrollo_xml($header,$detalles){
            $xml = '<?xml version="1.0" encoding="UTF-8"?>
                    <DespatchAdvice xmlns="urn:oasis:names:specification:ubl:schema:xsd:DespatchAdvice-2" 
                        xmlns:ds="http://www.w3.org/2000/09/xmldsig#" 
                        xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" 
                        xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" 
                        xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">                    
                        <ext:UBLExtensions>
                            <ext:UBLExtension>
                                <ext:ExtensionContent>
                                </ext:ExtensionContent>
                            </ext:UBLExtension>
                        </ext:UBLExtensions>
                        <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
                        <cbc:CustomizationID>2.0</cbc:CustomizationID>
                        <cbc:ID></cbc:ID>
                        <cbc:IssueDate>'.$header->fgemision.'</cbc:IssueDate>
                        <!-- FECHA Y HORA DE EMISION -->
                        <cbc:IssueTime>'.date("H:i:s").'</cbc:IssueTime>
                        <cbc:DespatchAdviceTypeCode 
                            listAgencyName="PE:SUNAT" 
                            listName="Tipo de Documento" 
                            listURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01">09
                        </cbc:DespatchAdviceTypeCode>
                        <!-- DOCUMENTOS ADICIONALES (Catalogo 41)-->
                        <cac:Signature>
                        <cbc:ID>'.$header->destinatario_ruc.'</cbc:ID>
                        <cac:SignatoryParty>
                            <cac:PartyIdentification>
                            <cbc:ID>'.$header->destinatario_ruc.'</cbc:ID>
                            </cac:PartyIdentification>
                        </cac:SignatoryParty>
                        <cac:DigitalSignatureAttachment>
                            <cac:ExternalReference>
                            <cbc:URI>'.$header->destinatario_ruc.'</cbc:URI>
                            </cac:ExternalReference>
                        </cac:DigitalSignatureAttachment>
                        </cac:Signature>
                        <!-- DATOS DEL EMISOR (REMITENTE) -->
                        <cac:DespatchSupplierParty>
                            <cac:Party>
                            <cac:PartyIdentification>
                            <cbc:ID schemeID="6" 
                                schemeName="Documento de Identidad" 
                                schemeAgencyName="PE:SUNAT" 
                                schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06">'.$header->destinatario_ruc.'</cbc:ID>
                            </cac:PartyIdentification>
                            <cac:PartyLegalEntity>
                            <cbc:RegistrationName>'.$header->destinatario_razon.'</cbc:RegistrationName>
                            </cac:PartyLegalEntity>
                            </cac:Party>
                        </cac:DespatchSupplierParty>
                        <!-- DATOS DEL RECEPTOR (DESTINATARIO) -->
                        <cac:DeliveryCustomerParty>
                            <cac:Party>
                            <cac:PartyIdentification>
                            <cbc:ID schemeID="6" 
                                schemeName="Documento de Identidad" 
                                schemeAgencyName="PE:SUNAT" 
                                schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06">'.$header->destinatario_ruc.'</cbc:ID>
                            </cac:PartyIdentification>
                            <cac:PartyLegalEntity>
                            <cbc:RegistrationName>'.$header->destinatario_razon.'</cbc:RegistrationName>
                            </cac:PartyLegalEntity>
                            </cac:Party>
                        </cac:DeliveryCustomerParty>
                        <!-- DATOS DEL PROVEEDOR -->

                        <!-- DATOS DEL TRASLADO -->
                        <cac:Shipment>
                            <!-- ID OBLIGATORIO POR UBL -->
                            <cbc:ID>SUNAT_Envio</cbc:ID>
                            
                            <!-- MOTIVO DEL TRASLADO -->
                            <cbc:HandlingCode listAgencyName="PE:SUNAT" 
                                listName="Motivo de traslado" 
                                listURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogoD05">04</cbc:HandlingCode>
                            <cbc:HandlingInstructions>Traslado entre establecimientos de la misma empresa</cbc:HandlingInstructions>
                                
                            <!-- PESO BRUTO TOTAL DE LA CARGA-->
                            <cbc:GrossWeightMeasure unitCode="KGM">'.$header->peso.'</cbc:GrossWeightMeasure>
                            <cac:ShipmentStage>
                                    <!-- MODALIDAD DE TRASLADO  -->
                                    <cbc:TransportModeCode 
                                        listName="Modalidad de traslado" 
                                        listAgencyName="PE:SUNAT" 
                                        listURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo18">01</cbc:TransportModeCode>
                                    
                                    <!-- FECHA DE INICIO DEL TRASLADO o FECHA DE ENTREGA DE BIENES AL TRANSPORTISTA -->
                                    <cac:TransitPeriod>
                                            <cbc:StartDate>'.$header->ftraslado.'</cbc:StartDate>
                                            <cbc:StartDate>'.$header->ftraslado.'</cbc:StartDate>
                                    </cac:TransitPeriod>                                        
                                    <!-- DATOS DEL TRANSPORTISTA -->
                                        <cac:CarrierParty>
                                        <cac:PartyIdentification>
                                            <cbc:ID schemeID="6" 
                                                schemeName="Documento de Identidad" 
                                                schemeAgencyName="PE:SUNAT" 
                                                schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06">'.$header->ruc_proveedor.'</cbc:ID>
                                        </cac:PartyIdentification>
                                        <cac:PartyLegalEntity>
                                            <!-- NOMBRE/RAZON SOCIAL DEL TRANSPORTISTA-->
                                            <cbc:RegistrationName>'.$header->empresa_transporte_razon.'</cbc:RegistrationName>
                                            
                                            <!-- NUMERO DE REGISTRO DEL MTC -->
                                            <cbc:CompanyID>'.$header->registro_mtc.'</cbc:CompanyID>
                                        </cac:PartyLegalEntity>
                                        </cac:CarrierParty>
                            </cac:ShipmentStage>
                            <cac:Delivery>
                                <!-- DIRECCION DEL PUNTO DE LLEGADA -->
                                    <cac:DeliveryAddress>
                                    <!-- UBIGEO DE LLEGADA -->
                                        <cbc:ID schemeName="Ubigeos" schemeAgencyName="PE:INEI">'.$header->ubig_destino.'</cbc:ID>
                                    <!-- CODIGO DE ESTABLECIMIENTO ANEXO DE LLEGADA -->
                                            <cbc:AddressTypeCode listID="20504898173" listAgencyName="PE:SUNAT" listName="Establecimientos anexos">13</cbc:AddressTypeCode>
                                    <!-- DIRECCION COMPLETA Y DETALLADA DE LLEGADA -->
                                        <cac:AddressLine>
                                            <cbc:Line>'.$header->almacen_destino_direccion.'</cbc:Line>
                                        </cac:AddressLine>
                                    </cac:DeliveryAddress>
                                    <cac:Despatch>
                                        <!-- DIRECCION DEL PUNTO DE PARTIDA -->
                                        <cac:DespatchAddress>
                                            <!-- UBIGEO DE PARTIDA -->
                                            <cbc:ID schemeName="Ubigeos" schemeAgencyName="PE:INEI">15'.$header->ubig_origen.'0119</cbc:ID>
                                            <!-- CODIGO DE ESTABLECIMIENTO ANEXO DE PARTIDA -->
                                                <cbc:AddressTypeCode listID="20504898173" listAgencyName="PE:SUNAT" listName="Establecimientos anexos">8</cbc:AddressTypeCode>
                                            <!-- DIRECCION COMPLETA Y DETALLADA DE PARTIDA -->
                                            <cac:AddressLine>
                                                <cbc:Line>'.$header->almacen_origen_direccion.'</cbc:Line>
                                            </cac:AddressLine>
                                        </cac:DespatchAddress>
			                        </cac:Despatch>
                            </cac:Delivery>
                            <cac:TransportHandlingUnit>
                                    <cac:TransportEquipment>
                                    </cac:TransportEquipment>
                            </cac:TransportHandlingUnit>
                            <!-- PUERTO O AEROPUERTO DE EMBARQUE / DESEMBARQUE -->
                    </cac:Shipment>
                    <!-- DETALLES DE BIENES A TRASLADAR -->';

                $i = 1;
                foreach($detalles as $detalle){
                    $xml .=  '<cac:DespatchLine>
                            <cbc:ID>'.$i.'</cbc:ID>
                            <cbc:DeliveredQuantity unitCode="'.$detalle->unidad.'">'.$detalle->cantidad.'</cbc:DeliveredQuantity>
                            <cac:OrderLineReference>
                                <cbc:LineID>1</cbc:LineID>
                            </cac:OrderLineReference>
                            <cac:Item>
                                <cbc:Description>'.utf8_encode($detalle->descripcion).'</cbc:Description>
                                <cac:SellersItemIdentification>
                                <cbc:ID>'.$detalle->codigo.'</cbc:ID>
                                </cac:SellersItemIdentification>
                            </cac:Item>
                        </cac:DespatchLine>';                        
                        $i++; 
                }

                $xml.='</DespatchAdvice>';
            
            return $xml;
        }

        private function token($client_id, $client_secret, $usuario_secundario, $usuario_password){
            $url = "https://api-seguridad.sunat.gob.pe/v1/clientessol/".$client_id."/oauth2/token/";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_POST, true);

            $datos = array(
                    'grant_type'    =>  'password',     
                    'scope'         =>  'https://api-cpe.sunat.gob.pe',
                    'client_id'     =>  $client_id,
                    'client_secret' =>  $client_secret,
                    'username'      =>  $usuario_secundario,
                    'password'      =>  $usuario_password
            );
            
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($datos));
            curl_setopt($curl, CURLOPT_COOKIEJAR, "public/documentos/cookies/cookies.txt");

            $headers = array('Content-Type' => 'Application/json');
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($curl);
            curl_close($curl);

            $response = json_decode($result);
            return $response->access_token;
        }

        private function envio_xml($path,$nombre_file,$token_access){
            $curl = curl_init();
            $data = array(
                        'nomArchivo'  =>  $nombre_file.".zip",
                        'arcGreZip'   =>  base64_encode(file_get_contents($path.$nombre_file.'.zip')),
                        'hashZip'     =>  hash_file("sha256", $path.$nombre_file.'.zip')
                    );
            curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api-cpe.sunat.gob.pe/v1/contribuyente/gem/comprobantes/".$nombre_file,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>json_encode(array('archivo' => $data)),
                        CURLOPT_HTTPHEADER => array(
                            'Authorization: Bearer '. $token_access,
                            'Content-Type: application/json'
                        ),
                    ));
                
            $response2 = curl_exec($curl);
            curl_close($curl);
            return json_decode($response2);

            

            $original_file =  $path."XML/".$nombre_file.'.xml';
            $destination_file = $path."FIRMA/".$nombre_file.'.zip';
            
            $zip = new ZipArchive();
            $zip->open($destination_file,ZipArchive::CREATE);
            $zip->addFile($original_file);
            $zip->close();
        }

        private function firmar_xml($name_file, $entorno, $baja = ''){        
            $xmlstr = file_get_contents("public/documentos/guia_electronica/XML/".$name_file);
        
            $domDocument = new \DOMDocument();
            $domDocument->loadXML($xmlstr);
            $factura  = new Factura();
            $xml = $factura->firmar($domDocument, '', $entorno);
            $content = $xml->saveXML();
            file_put_contents("public/documentos/guia_electronica/FIRMA/".$name_file, $content);
        }

        function envio_ticket($ruta_archivo_cdr, $ticket, $token_access, $ruc, $nombre_file){
            if(($ticket == "") || ($ticket == null)){
                $mensaje['cdr_hash'] = '';
                $mensaje['cdr_msj_sunat'] = 'Ticket vacio';
                $mensaje['cdr_ResponseCode']  = null;
                $mensaje['numerror'] = null;
            }else{
            
                $mensaje['ticket'] = $ticket;
                $curl = curl_init();
        
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api-cpe.sunat.gob.pe/v1/contribuyente/gem/comprobantes/envios/'.$ticket,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'numRucEnvia: '.$ruc,
                        'numTicket: '.$ticket,
                        'Authorization: Bearer '. $token_access,
                    ),
                ));
        
                $response_1  = curl_exec($curl);
                $response3  = json_decode($response_1);
                $codRespuesta = $response3->codRespuesta;
                curl_close($curl);                    
                //var_dump($response3);exit;
                
                $mensaje['ticket_rpta'] = $codRespuesta;
                if($codRespuesta == '99'){
                    $error = $response3->error;
                    $mensaje['cdr_hash'] = '';
                    $mensaje['cdr_msj_sunat'] = $error->desError;
                    $mensaje['cdr_ResponseCode'] = '99';
                    $mensaje['numerror'] = $error->numError;            	            
                }else if($codRespuesta == '98'){
                    $mensaje['cdr_hash'] = '';
                    $mensaje['cdr_msj_sunat'] = 'Envío en proceso';
                    $mensaje['cdr_ResponseCode']  = '98';
                    $mensaje['numerror'] = '98';                        
                }else if($codRespuesta == '0'){
                    $mensaje['arcCdr'] = $response3->arcCdr;
                    $mensaje['indCdrGenerado'] = $response3->indCdrGenerado;
                    
                    file_put_contents($ruta_archivo_cdr . 'R-' . $nombre_file . '.ZIP', base64_decode($response3->arcCdr));
        
                    $zip = new ZipArchive;
                    if ($zip->open($ruta_archivo_cdr . 'R-' . $nombre_file . '.ZIP') === TRUE) {
                        $zip->extractTo($ruta_archivo_cdr);
                        $zip->close();
                    }
                    //unlink($ruta_archivo_cdr . 'R-' . $nombre_file . '.ZIP');
        
                 //=============hash CDR=================
                    $doc_cdr = new DOMDocument();
                    $doc_cdr->load($ruta_archivo_cdr . 'R-' . $nombre_file . '.xml');
                    
                    $mensaje['cdr_hash']            = $doc_cdr->getElementsByTagName('DigestValue')->item(0)->nodeValue;
                    $mensaje['cdr_msj_sunat']       = $doc_cdr->getElementsByTagName('Description')->item(0)->nodeValue;
                    $mensaje['cdr_ResponseCode']    = $doc_cdr->getElementsByTagName('ResponseCode')->item(0)->nodeValue;        
                    $mensaje['numerror']            = '';
                }else{
                    $mensaje['cdr_hash']            = '';
                    $mensaje['cdr_msj_sunat']       = 'SUNAT FUERA DE SERVICIO';
                    $mensaje['cdr_ResponseCode']    = '88';            
                    $mensaje['numerror']            = '88';
                }
            }
            return $mensaje;
        }
    } 
?>