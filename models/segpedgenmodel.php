<?php
    class SegPedGenModel extends Model{

        public function __construct()
        {
            parent::__construct();
        }

        public function listarPedidosUsuario(){
            try {
                $salida = "";
                $sql = $this->db->connect()->query("SELECT
                                                    ibis.tb_pedidocab.idreg,
                                                    ibis.tb_pedidocab.idcostos,
                                                    ibis.tb_pedidocab.idarea,
                                                    ibis.tb_pedidocab.emision,
                                                    ibis.tb_pedidocab.vence,
                                                    ibis.tb_pedidocab.estadodoc,
                                                    ibis.tb_pedidocab.nrodoc,
                                                    ibis.tb_pedidocab.idtipomov,
                                                    UPPER(ibis.tb_pedidocab.concepto) AS concepto,
                                                    CONCAT(rrhh.tabla_aquarius.nombres,' ',rrhh.tabla_aquarius.apellidos) AS nombres,
                                                    UPPER(CONCAT(ibis.tb_proyectos.ccodproy,' ',ibis.tb_proyectos.cdesproy)) AS costos,
                                                    ibis.tb_pedidocab.nivelAten,
                                                    atenciones.cdescripcion AS atencion,
                                                    estados.cdescripcion AS estado,
                                                    estados.cabrevia 
                                                FROM
                                                    ibis.tb_pedidocab
                                                    INNER JOIN rrhh.tabla_aquarius ON ibis.tb_pedidocab.idsolicita = rrhh.tabla_aquarius.internal
                                                    INNER JOIN ibis.tb_proyectos ON ibis.tb_pedidocab.idcostos = ibis.tb_proyectos.nidreg
                                                    INNER JOIN ibis.tb_parametros AS atenciones ON ibis.tb_pedidocab.nivelAten = atenciones.nidreg
                                                    INNER JOIN ibis.tb_parametros AS estados ON ibis.tb_pedidocab.estadodoc = estados.nidreg
                                                WHERE YEAR(ibis.tb_pedidocab.emision) = YEAR(NOW())
                                                ORDER BY ibis.tb_pedidocab.emision DESC");
                $sql->execute();
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()) {
                        $tipo = $rs['idtipomov'] == 37 ? "B":"S";
                        $salida .='<tr class="pointer" data-indice="'.$rs['idreg'].'">
                                        <td class="textoCentro">'.str_pad($rs['nrodoc'],4,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.date("d/m/Y", strtotime($rs['emision'])).'</td>
                                        <td class="textoCentro">'.$tipo.'</td>
                                        <td class="pl20px">'.$rs['concepto'].'</td>
                                        <td class="pl20px">'.$rs['costos'].'</td>
                                        <td class="pl20px">'.$rs['nombres'].'</td>
                                        <td class="textoCentro '.$rs['cabrevia'].'">'.$rs['estado'].'</td>
                                        <td class="textoCentro '.strtolower($rs['atencion']).'">'.$rs['atencion'].'</td>
                                    </tr>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function consultarInfo($id){
            try {
                $sql=$this->db->connect()->prepare("SELECT
                                    tb_pedidocab.idcostos,
                                    DATE_FORMAT( tb_pedidocab.emision, '%d/%m/%Y' ) AS emision,
                                    DATE_FORMAT( tb_pedidocab.faprueba, '%d/%m/%Y' ) AS aprobacion,
                                    UPPER(
                                    CONCAT_WS( ' ', tb_proyectos.ccodproy, tb_proyectos.cdesproy )) AS proyecto,
                                    elbora.cnombres AS elaborado,
                                    LPAD( tb_pedidocab.nrodoc, 6, 0 ) AS pedido,
                                    aprueba.cnombres AS aprobador,
                                    tb_parametros.cdescripcion,
                                    FORMAT( tb_parametros.cobservacion, 0 ) AS avance,
                                    tb_pedidocab.idreg 
                                FROM
                                    tb_pedidocab
                                    INNER JOIN tb_proyectos ON tb_pedidocab.idcostos = tb_proyectos.nidreg
                                    INNER JOIN tb_user AS elbora ON tb_pedidocab.usuario = elbora.iduser
                                    LEFT JOIN tb_user AS aprueba ON tb_pedidocab.aprueba = aprueba.iduser
                                    INNER JOIN tb_parametros ON tb_pedidocab.estadodoc = tb_parametros.nidreg 
                                WHERE
                                    tb_pedidocab.idreg =:id");
                $sql->execute(["id"=>$id]);
                $result = $sql->fetchAll();

                $json_result = array("pedido"   =>$result[0]['pedido'],
                                    "emision"   =>$result[0]['emision'],
                                    "costos"    =>$result[0]['proyecto'],
                                    "elaborado" =>$result[0]['elaborado'],
                                    "aprobador" =>$result[0]['aprobador'],
                                    "aprobacion"=>$result[0]['aprobacion'],
                                    "avance"    =>$result[0]['avance'],
                                    "ordenes"   =>$this->ordenesPedido($id),
                                    "ingresos"  =>$this->ingresosPedido($id),
                                    "despachos" =>$this->salidasPedido($id),
                                    "registros" =>$this->registrosPedido($id),
                                    "idpedido"  =>$result[0]['idreg']
                                    );

                return $json_result;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function ordenesPedido($pedido) {
            try {
                $salida =  '<tr><td colspan="3" class="textoCentro">No hay registro</td></tr>';
                $sql = $this->db->connect()->prepare("SELECT
                                LPAD(lg_ordencab.id_regmov,6,0) AS nroorden,
                                DATE_FORMAT(lg_ordencab.ffechadoc,'%d/%m/%Y') AS fechaOrden,
                                lg_ordencab.id_regmov
                        FROM
                            lg_ordencab
                        WHERE
                            lg_ordencab.id_refpedi =:pedido");
                $sql->execute(["pedido"=>$pedido]);
                $rowCount = $sql->rowcount();

                if ($rowCount > 0) {
                    $salida = "";
                    while ($rs = $sql->fetch()) {
                        $salida .= '<tr>
                                        <td class="textoCentro">'.$rs['nroorden'].'</td>
                                        <td class="textoCentro">'.$rs['fechaOrden'].'</td>
                                        <td class="textoCentro"><a href="'.$rs['id_regmov'].'"><i class="fas fa-file-pdf"></i></a></td>
                                    </tr>';
                    }
                }

                return $salida;

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function ingresosPedido($pedido) {
            $salida =  '<tr><td colspan="3" class="textoCentro">No hay registro</td></tr>';
                $sql = $this->db->connect()->prepare("SELECT
                                                            alm_despachocab.id_regalm,
                                                            alm_despachocab.nnronota,
                                                            alm_despachocab.ffecdoc,
                                                            alm_despachocab.id_regalm
                                                        FROM
                                                            alm_despachocab
                                                        WHERE
                                                            alm_despachocab.idref_pedi = :pedido");
                $sql->execute(["pedido"=>$pedido]);
                $rowCount = $sql->rowcount();

                if ($rowCount > 0) {
                    $salida = "";
                    while ($rs = $sql->fetch()) {
                        $salida .= '<tr>
                                        <td class="textoCentro">'.$rs['id_regalm'].'</td>
                                        <td class="textoCentro">'.$rs['fechaDespacho'].'</td>
                                        <td class="textoCentro"><a href="'.$rs['id_regalm'].'"><i class="fas fa-file-pdf"></i></a></td>
                                    </tr>';
                    }
                }

            return $salida;
        }

        private function salidasPedido($pedido) {
            $salida =  '<tr><td colspan="3" class="textoCentro">No hay registro</td></tr>';
                $sql = $this->db->connect()->prepare("SELECT
                                                        LPAD(alm_despachocab.id_regalm,0,6) AS depacho,
                                                        alm_despachocab.nnronota,
                                                        DATE_FORMAT(alm_despachocab.ffecdoc,'%d/%m/%Y') AS fechaDespacho,
                                                        alm_despachocab.id_regalm
                                                    FROM
                                                        alm_despachocab
                                                    WHERE
                                                        alm_despachocab.idref_pedi = :pedido");
                $sql->execute(["pedido"=>$pedido]);
                $rowCount = $sql->rowcount();

                if ($rowCount > 0) {
                    $salida = "";
                    while ($rs = $sql->fetch()) {
                        $salida .= '<tr>
                                        <td class="textoCentro">'.$rs['nroorden'].'</td>
                                        <td class="textoCentro">'.$rs['fechaOrden'].'</td>
                                        <td class="textoCentro"><a href="'.$rs['nroorden'].'"><i class="fas fa-file-pdf"></i></a></td>
                                    </tr>';
                    }
                }

                return $salida;
        }

        private function registrosPedido($pedido) {
            $salida =  '<tr><td colspan="3" class="textoCentro">No hay registro</td></tr>';
                $sql = $this->db->connect()->prepare("SELECT
                                                        LPAD(alm_cabexist.idreg, 6, 0) AS registro,
                                                        DATE_FORMAT(
                                                            alm_cabexist.ffechadoc,
                                                            '%d/%m/&Y)'
                                                        ) AS fechaRegistro,
                                                        alm_cabexist.idreg
                                                    FROM
                                                        alm_cabexist
                                                    WHERE
                                                        alm_cabexist.idped = :pedido");
                $sql->execute(["pedido"=>$pedido]);
                $rowCount = $sql->rowcount();

                if ($rowCount > 0) {
                    $salida = "";
                    while ($rs = $sql->fetch()) {
                        $salida .= '<tr>
                                        <td class="textoCentro">'.$rs['idreg'].'</td>
                                        <td class="textoCentro">'.$rs['fechaRegistro'].'</td>
                                        <td class="textoCentro"><a href="'.$rs['idreg'].'"><i class="fas fa-file-pdf"></i></a></td>
                                    </tr>';
                    }
                }

                return $salida;
        }

        public function generarVistaOrden($id){
            require_once("public/formatos/ordenes.php");

            $datosOrden   = $this->cabeceraOrden($id);
            $detalles     = $this->detallesOrden($id);

            if ($datosOrden[0]['ntipmov'] == "37") {
                $titulo = "ORDEN DE COMPRA" ;

                if ( $datosOrden[0]['userModifica'] != null) {
                    $titulo = "ORDEN DE COMPRA - R1" ;
                }

                $prefix = "OC";
                $tipo = "B";
            }else{
                $titulo = "ORDEN DE SERVICIO";

                if ( $datosOrden[0]['userModifica'] != null) {
                    $titulo = "ORDEN DE SERVICIO - R1" ;
                }

                $prefix = "OS";
                $tipo = "S";
            }

            $anio = explode("-",$datosOrden[0]['ffechadoc']);

            $orden = str_pad($datosOrden[0]['id_regmov'],6,0,STR_PAD_LEFT);
            $titulo = $titulo . " " .$anio[0]. " - " . $orden;
            
            $file = uniqid().".pdf";

            $condicion = 1;

            $pdf = new PDF($titulo,$condicion,$datosOrden[0]['ffechadoc'],$datosOrden[0]['nombre_moneda'],$datosOrden[0]['nplazo'],
                            $datosOrden[0]['cdesalm'],$datosOrden[0]['cnumcot'],$datosOrden[0]['ffechaent'],$datosOrden[0]['pagos'],"",
                            $datosOrden[0]['costos'],$datosOrden[0]['concepto'],$datosOrden[0]['cnameuser'],$datosOrden[0]['crazonsoc'],
                            $datosOrden[0]['cnumdoc'],$datosOrden[0]['cviadireccion'],$datosOrden[0]['ctelefono1'],$datosOrden[0]['cemail'],$datosOrden[0]['nagenret'],
                            $datosOrden[0]['cnombres'],$datosOrden[0]['ctelefono1'],$datosOrden[0]['mail_entidad'],
                            $datosOrden[0]['direccion']);

            $pdf->AddPage();
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(10,15,15,10,95,17,13,15));
            $pdf->SetFont('Arial','',5);
            $lc = 0;
            $rc = 0;
                
            $nreg = count($detalles);
                
            for ($i=0; $i < $nreg; $i++) { 
                $pdf->SetAligns(array("C","C","R","C","L","C","R","R"));
                $pdf->Row(array($detalles[$i]["item"],
                $detalles[$i]['ccodprod'],
                $detalles[$i]['cantidad'],
                $detalles[$i]['unidad'],
                utf8_decode($detalles[$i]['cdesprod']),
                $detalles[$i]['pedido'],
                "",
                ""));
                $lc++;
                $rc++;
                                
                    if ($lc == 52) {
                        $pdf->AddPage();
                        $lc = 0;
                    }
            }
                
            $pdf->Ln(3);

            $pdf->SetFillColor(229, 229, 229);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,6,"TOTAL :","LTB",0,"C",true);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(140,6,"","TBR",0,"L",true); 
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,6,"","1",1,"R",true);

            $pdf->Ln(1);
            $pdf->SetFont('Arial',"","7");
            $pdf->Cell(40,6,"Pedidos Asociados",1,0,"C",true);
            $pdf->Cell(5,6,"",0,0);
            $pdf->Cell(80,6,utf8_decode("Información Bancaria del Proveedor"),1,0,"C",true);
            $pdf->Cell(10,6,"",0,0);

            if ($datosOrden[0]['nigv'] ==  0) {
                $pdf->Cell(48,6,"",0,0);
                $pdf->Cell(20,6,"",0,1);
            }else {
                
                $pdf->Cell(45,6,"",0,0);
                $pdf->Cell(20,6,"",0,1);
            }

            $pdf->Cell(10,6,utf8_decode("Año"),1,0);   
            $pdf->Cell(10,6,"Tipo",1,0);
            $pdf->Cell(10,6,"Pedido",1,0);
            $pdf->Cell(10,6,"Mantto",1,0);
            $pdf->Cell(5,6,"",0,0);
            $pdf->Cell(35,6,"Detalle del Banco",1,0);
            $pdf->Cell(15,6,"Moneda",1,0);
            $pdf->Cell(30,6,"Nro. Cuenta Bancaria",1,1);


            $pdf->SetFont('Arial',"","7");
            $pdf->Cell(10,6,$anio[0],1,0);
            $pdf->Cell(10,6,$tipo,1,0);
            $pdf->Cell(10,6,str_pad($datosOrden[0]['nrodoc'],6,0,STR_PAD_LEFT),1,0);
            $pdf->Cell(10,6,"",1,0);
            $pdf->Cell(5,6,"",0,0);

            $pdf->Cell(90,4,"",0,0);
            $pdf->SetFont('Arial',"B","8");
            $pdf->Cell(20,4,"TOTAL",1,0,"L",true);
            $pdf->Cell(15,4,"",1,0,"C",true);
            $pdf->Cell(20,4,"",1,1,"R",true);
            
            $x = $pdf->GetX();
            $y = $pdf->GetY();

            $pdf->SetXY(55,$y-6);
            $pdf->SetFont('Arial',"B","6");

            $pdf->SetFont('Arial',"B","8");

            if ($datosOrden[0]['nEstadoDoc'] == 59){
                $filename = "public/documentos/ordenes/vistaprevia/".$file;
            }else if ($datosOrden[0]['nEstadoDoc'] == 60){
                $filename = "public/documentos/ordenes/emitidas/".$file;
            }else if ($datosOrden[0]['nEstadoDoc'] == 61){
                $filename = "public/documentos/ordenes/aprobadas/".$file;
            }else if ($datosOrden[0]['nEstadoDoc'] == 49){
                $filename = "public/documentos/ordenes/vistaprevia/".$file;
            }

            $pdf->Output($filename,'F');

            return $filename;
        }

        private function cabeceraOrden($id){
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                                lg_ordencab.id_regmov,
                                                                lg_ordencab.cnumero,
                                                                lg_ordencab.ffechadoc,
                                                                lg_ordencab.ncodcos,
                                                                lg_ordencab.ncodarea,
                                                                lg_ordencab.id_centi,
                                                                lg_ordencab.ctiptransp,
                                                                lg_ordencab.ncodpago,
                                                                lg_ordencab.nplazo,
                                                                lg_ordencab.ncodcot,
                                                                lg_ordencab.cnumcot,
                                                                lg_ordencab.nEstadoDoc,
                                                                lg_ordencab.id_refpedi,
                                                                lg_ordencab.ntcambio,
                                                                lg_ordencab.cnumcot,
                                                                lg_ordencab.userModifica,
                                                                UPPER(tb_pedidocab.concepto) AS concepto,
                                                                UPPER(tb_pedidocab.detalle) AS detalle,
                                                                UPPER(
                                                                    CONCAT_WS(
                                                                        ' ',
                                                                        tb_proyectos.ccodproy,
                                                                        tb_proyectos.cdesproy
                                                                    )
                                                                ) AS costos,
                                                                lg_ordencab.ncodpry,
                                                                lg_ordencab.ncodalm,
                                                                UPPER(
                                                                    CONCAT_WS(
                                                                        ' ',
                                                                        tb_area.ccodarea,
                                                                        tb_area.cdesarea
                                                                    )
                                                                ) AS area,
                                                                lg_ordencab.ncodmon,
                                                                monedas.cdescripcion AS nombre_moneda,
                                                                monedas.cabrevia AS abrevia_moneda,
                                                                lg_ordencab.ntipmov,
                                                                tipos.cdescripcion AS tipo,
                                                                pagos.cdescripcion AS pagos,
                                                                lg_ordencab.ffechaent,
                                                                estados.cabrevia AS estado,
                                                                estados.cdescripcion AS descripcion_estado,
                                                                cm_entidad.crazonsoc,
                                                                cm_entidad.cnumdoc,
                                                                cm_entidad.cnumdoc,
                                                                UPPER(contacto.cnombres) AS cnombres,
                                                                contacto.cemail,
                                                                contacto.ctelefono1,
                                                                transportes.cdescripcion AS transporte,
                                                                UPPER(tb_almacen.cdesalm) AS cdesalm,
                                                                UPPER(tb_almacen.ctipovia) AS direccion,
                                                                cm_entidad.cviadireccion,
                                                                cm_entidad.cemail AS mail_entidad,
                                                                cm_entidad.nagenret,
                                                                lg_ordencab.cverificacion,
                                                                lg_ordencab.ntotal,
                                                                lg_ordencab.nigv,
                                                                FORMAT(lg_ordencab.ntotal, 2) AS ctotal,
                                                                tb_pedidocab.nivelAten,
                                                                tb_pedidocab.nrodoc,
                                                                tb_user.cnameuser
                                                            FROM
                                                                lg_ordencab
                                                            INNER JOIN tb_pedidocab ON lg_ordencab.id_refpedi = tb_pedidocab.idreg
                                                            INNER JOIN tb_proyectos ON lg_ordencab.ncodcos = tb_proyectos.nidreg
                                                            INNER JOIN tb_area ON lg_ordencab.ncodarea = tb_area.ncodarea
                                                            INNER JOIN tb_parametros AS monedas ON lg_ordencab.ncodmon = monedas.nidreg
                                                            INNER JOIN tb_parametros AS tipos ON lg_ordencab.ntipmov = tipos.nidreg
                                                            INNER JOIN tb_parametros AS pagos ON lg_ordencab.ncodpago = pagos.nidreg
                                                            INNER JOIN tb_parametros AS estados ON lg_ordencab.nEstadoDoc = estados.nidreg
                                                            INNER JOIN cm_entidad ON lg_ordencab.id_centi = cm_entidad.id_centi
                                                            LEFT JOIN (
                                                                SELECT
                                                                    cemail,
                                                                    cnombres,
                                                                    ctelefono1,
                                                                    id_centi
                                                                FROM
                                                                    cm_entidadcon
                                                                LIMIT 1
                                                            ) AS contacto ON contacto.id_centi = cm_entidad.id_centi
                                                            INNER JOIN tb_parametros AS transportes ON lg_ordencab.ctiptransp = transportes.nidreg
                                                            INNER JOIN tb_almacen ON lg_ordencab.ncodalm = tb_almacen.ncodalm
                                                            INNER JOIN tb_user ON lg_ordencab.id_cuser = tb_user.iduser
                                                            WHERE
                                                                lg_ordencab.id_regmov = :id
                                                            AND lg_ordencab.nflgactivo = 1");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();
                
                if ($rowCount > 0) {
                    $docData = array();
                    while($row=$sql->fetch(PDO::FETCH_ASSOC)){
                        $docData[] = $row;
                    }
                }

                return $docData;

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function detallesOrden($id){
            try {
                $sql=$this->db->connect()->prepare("SELECT
                                                    lg_ordendet.nitemord,
                                                    lg_ordendet.id_regmov,
                                                    lg_ordendet.niddeta,
                                                    lg_ordendet.nidpedi,
                                                    lg_ordendet.id_cprod,
                                                    FORMAT( lg_ordendet.ncanti, 2 ) AS ncanti,
                                                    lg_ordendet.nunitario AS nunitario,
                                                    FORMAT( lg_ordendet.nigv, 2 ) AS nigv,
                                                    FORMAT( tb_pedidodet.total - lg_ordendet.nigv,2) AS subtotal,
                                                    FORMAT( lg_ordendet.ntotal,2) as ntotal,
                                                    cm_producto.ccodprod,
                                                    UPPER(CONCAT_WS(' ',cm_producto.cdesprod,tb_pedidodet.observaciones,tb_pedidodet.docEspec)) AS cdesprod,
                                                    cm_producto.nund,
                                                    tb_unimed.cabrevia,
                                                    FORMAT( tb_pedidodet.total, 2 ) AS total,
                                                    tb_pedidodet.idpedido,
                                                    tb_pedidodet.nroparte,
                                                    tb_pedidodet.estadoItem,
                                                    monedas.cabrevia AS moneda,
                                                    tb_pedidodet.total AS total_numero,
                                                    LPAD(tb_pedidocab.nrodoc,5,0) AS pedido
                                                FROM
                                                    lg_ordendet
                                                    INNER JOIN cm_producto ON lg_ordendet.id_cprod = cm_producto.id_cprod
                                                    INNER JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed
                                                    INNER JOIN tb_pedidodet ON lg_ordendet.niddeta = tb_pedidodet.iditem
                                                    INNER JOIN tb_parametros AS monedas ON lg_ordendet.nmonref = monedas.nidreg
                                                    INNER JOIN tb_pedidocab ON lg_ordendet.nidpedi = tb_pedidocab.idreg 
                                                WHERE
                                                    lg_ordendet.id_orden = :id
                                                AND ISNULL(lg_ordendet.nflgactivo)");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();
                $item = 1;
                $detalles = [];
                
                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()){
                        $row = array("item" => str_pad($item++,3,0,STR_PAD_LEFT),
                                     "ccodprod" => $rs['ccodprod'],
                                     "cdesprod" => $rs['cdesprod'],
                                     "cantidad" => $rs['ncanti'],
                                     "cdesprod" => $rs['cdesprod'],
                                     "unidad"   => $rs['cabrevia'],
                                     "pedido"   => $rs['pedido']);

                        array_push($detalles,$row);
                    }
                }

                return $detalles;
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function listarPedidosFiltrados($parametros){
            try {
                $salida = "";
                $mes  = date("m");

                $tipo   = $parametros['tipoSearch'] == -1 ? "%" : "%".$parametros['tipoSearch']."%";
                $costos = $parametros['costosSearch'] == -1 ? "%" : $parametros['costosSearch'];
                $mes    = $parametros['mesSearch'] == -1 ? "%" :  $parametros['mesSearch'];
                $anio   = $parametros['anioSearch'];

                
                $sql = $this->db->connect()->prepare("SELECT
                                                        ibis.tb_pedidocab.idreg,
                                                        ibis.tb_pedidocab.idcostos,
                                                        ibis.tb_pedidocab.idarea,
                                                        ibis.tb_pedidocab.emision,
                                                        ibis.tb_pedidocab.vence,
                                                        ibis.tb_pedidocab.estadodoc,
                                                        ibis.tb_pedidocab.nrodoc,
                                                        ibis.tb_pedidocab.idtipomov,
                                                        UPPER(ibis.tb_pedidocab.concepto) AS concepto,
                                                        CONCAT(
                                                            rrhh.tabla_aquarius.nombres,
                                                            ' ',
                                                            rrhh.tabla_aquarius.apellidos
                                                        ) AS nombres,
                                                        UPPER(
                                                            CONCAT(
                                                                ibis.tb_proyectos.ccodproy,
                                                                ' ',
                                                                ibis.tb_proyectos.cdesproy
                                                            )
                                                        ) AS costos,
                                                        ibis.tb_pedidocab.nivelAten,
                                                        atenciones.cdescripcion AS atencion,
                                                        estados.cdescripcion AS estado,
                                                        estados.cabrevia
                                                    FROM
                                                        ibis.tb_pedidocab
                                                    INNER JOIN rrhh.tabla_aquarius ON ibis.tb_pedidocab.idsolicita = rrhh.tabla_aquarius.internal
                                                    INNER JOIN ibis.tb_proyectos ON ibis.tb_pedidocab.idcostos = ibis.tb_proyectos.nidreg
                                                    INNER JOIN ibis.tb_parametros AS atenciones ON ibis.tb_pedidocab.nivelAten = atenciones.nidreg
                                                    INNER JOIN ibis.tb_parametros AS estados ON ibis.tb_pedidocab.estadodoc = estados.nidreg
                                                    WHERE
                                                        ibis.tb_pedidocab.idtipomov LIKE :tipomov
                                                    AND ibis.tb_pedidocab.idcostos LIKE :costos
                                                    AND MONTH (ibis.tb_pedidocab.emision) LIKE :mes
                                                    AND YEAR (ibis.tb_pedidocab.emision) = :anio
                                                    AND ibis.tb_pedidocab.estadodoc
                                                    ORDER BY ibis.tb_pedidocab.emision DESC");
                $sql->execute(["tipomov"=>$tipo,
                                "costos"=>$costos,
                                "mes"=>$mes,
                                "anio"=>$anio]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()) {
                        $tipo = $rs['idtipomov'] == 37 ? "B":"S";
                        $salida .='<tr class="pointer" data-indice="'.$rs['idreg'].'">
                                        <td class="textoCentro">'.str_pad($rs['nrodoc'],4,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.date("d/m/Y", strtotime($rs['emision'])).'</td>
                                        <td class="textoCentro">'.$tipo.'</td>
                                        <td class="pl20px">'.$rs['concepto'].'</td>
                                        <td class="pl20px">'.$rs['costos'].'</td>
                                        <td class="pl20px">'.$rs['nombres'].'</td>
                                        <td class="textoCentro '.$rs['cabrevia'].'">'.$rs['estado'].'</td>
                                        <td class="textoCentro '.strtolower($rs['atencion']).'">'.$rs['atencion'].'</td>
                                    </tr>';
                    }
                }else {
                    $salida = '<tr class="pointer"><td colspan="8" class="textoCentro">No se encontraron registros en la consulta</td></tr>';
                }

                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }
    }
?>