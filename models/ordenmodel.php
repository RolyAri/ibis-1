<?php
    class OrdenModel extends Model{

        public function __construct()
        {
            parent::__construct();
        }

        public function listarOrdenes($user){

        }

        public function importarPedidos(){
            try {
                $salida = "";
                $sql = $this->db->connect()->prepare("SELECT
                                                        tb_pedidocab.idcostos,
                                                        tb_pedidocab.idarea,
                                                        tb_pedidocab.idtrans,
                                                        tb_pedidocab.nrodoc,
                                                        UPPER(
                                                        CONCAT_WS( ' ', tb_proyectos.ccodproy, tb_proyectos.cdesproy )) AS costos,
                                                        UPPER(
                                                        CONCAT_WS( ' ', tb_area.ccodarea, tb_area.cdesarea )) AS area,
                                                        cm_producto.id_cprod,
                                                        cm_producto.ccodprod,
                                                        cm_producto.cdesprod,
                                                        tb_pedidodet.idpedido,
                                                        tb_pedidocab.emision,
                                                        UPPER( tb_pedidocab.concepto ) AS concepto,
                                                        tb_pedidocab.detalle,
                                                        tb_pedidodet.iditem,
                                                        cm_entidad.crazonsoc,
                                                        cm_entidad.id_centi,
                                                        tb_pedidodet.idproforma,
                                                        FORMAT( tb_pedidodet.cant_aprob, 2 ) AS cantidad,
                                                        FORMAT( tb_pedidodet.precio, 2 ) AS precio,
                                                        FORMAT((
                                                                tb_pedidodet.precio * tb_pedidodet.cant_aprob 
                                                                ) + ( tb_pedidodet.precio * tb_pedidodet.cant_aprob ) *
                                                        IF
                                                            ( lg_proformacab.nigv > 0, 0.18, 0 ),
                                                            2 
                                                        ) AS total,
                                                        FORMAT(( tb_pedidodet.precio * tb_pedidodet.cant_aprob ) * IF ( lg_proformacab.nigv > 0, 0.18, 0 ), 2 ) AS igv,
                                                        tb_unimed.cabrevia AS desunidad,
                                                        monedas.cdescripcion,
                                                        monedas.cabrevia AS abrmoneda,
                                                        tb_pedidodet.nroparte,
                                                        monedas.nidreg AS moneda,
                                                        pagos.cdescripcion AS pago,
                                                        pagos.ccod,
                                                        lg_proformacab.cnumero 
                                                    FROM
                                                        tb_pedidodet
                                                        INNER JOIN tb_pedidocab ON tb_pedidodet.idpedido = tb_pedidocab.idreg
                                                        INNER JOIN tb_costusu ON tb_pedidocab.idcostos = tb_costusu.ncodproy
                                                        INNER JOIN tb_proyectos ON tb_pedidocab.idcostos = tb_proyectos.nidreg
                                                        INNER JOIN tb_area ON tb_pedidocab.idarea = tb_area.ncodarea
                                                        INNER JOIN cm_producto ON tb_pedidodet.idprod = cm_producto.id_cprod
                                                        INNER JOIN cm_entidad ON tb_pedidodet.entidad = cm_entidad.cnumdoc
                                                        INNER JOIN lg_proformacab ON tb_pedidodet.idproforma = lg_proformacab.nprof
                                                        INNER JOIN tb_unimed ON tb_pedidodet.unid = tb_unimed.ncodmed
                                                        INNER JOIN tb_parametros AS monedas ON lg_proformacab.ncodmon = monedas.nidreg
                                                        INNER JOIN tb_parametros AS pagos ON lg_proformacab.ccondpago = pagos.nidreg 
                                                    WHERE
                                                        tb_costusu.id_cuser =:user 
                                                        AND tb_costusu.nflgactivo = 1 
                                                        AND tb_pedidocab.estadodoc = 58");
                $sql->execute(["user"=>$_SESSION['iduser']]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()) {
                        $salida .='<tr class="pointer" data-pedido="'.$rs['idpedido'].'" 
                                                       data-iditem="'.$rs['iditem'].'" 
                                                       data-entidad="'.$rs['id_centi'].'"
                                                       data-proforma="'.$rs['idproforma'].'"
                                                       data-unidad="'.$rs['desunidad'].'"
                                                       data-cantidad="'.$rs['cantidad'].'"
                                                       data-precio="'.$rs['precio'].'"
                                                       data-igv="'.$rs['igv'].'"
                                                       data-total="'.$rs['total'].'"
                                                       data-nroparte="'.$rs['nroparte'].'"
                                                       data-moneda="'.$rs['moneda'].'"
                                                       data-abrmoneda="'.$rs['abrmoneda'].'"
                                                       data-desmoneda="'.$rs['cdescripcion'].'"
                                                       data-pago="'.$rs['pago'].'"
                                                       data-codprod="'.$rs['id_cprod'].'"
                                                       data-nroprofoma="'.$rs['cnumero'].'">
                                        <td class="textoCentro">'.str_pad($rs['nrodoc'],6,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.date("d/m/Y", strtotime($rs['emision'])).'</td>
                                        <td class="pl5px">'.$rs['concepto'].'</td>
                                        <td class="pl5px">'.$rs['area'].'</td>
                                        <td class="pl5px">'.$rs['costos'].'</td>
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl5px">'.$rs['cdesprod'].'</td>
                                        <td class="pl5px">'.$rs['crazonsoc'].'</td>
                                    </tr>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function verDatosCabecera($pedido,$profoma,$entidad){
            $datosPedido = $this->datosPedido($pedido);
            $sql = "SELECT COUNT(lg_ordencab.id_regmov) AS numero FROM lg_ordencab WHERE lg_ordencab.ncodcos =:cod";
            
            $numero = $this->generarNumero($datosPedido[0]["idcostos"],$sql);
            $entidad = $this->datosEntidad($entidad);

            $salida = array("pedido"=>$datosPedido,
                            "orden"=>$numero,
                            "entidad"=>$entidad);

            return $salida;
        }

        public function generarDocumento($cabecera,$condicion,$detalles){
            require_once("public/formatos/ordenes.php");

            
            $bancos = $this->bancosProveedor($cabecera['codigo_entidad']);

            $sql = "SELECT COUNT(lg_ordencab.id_regmov) AS numero FROM lg_ordencab WHERE lg_ordencab.ncodcos =:cod";
            $numero = $this->generarNumero($cabecera['codigo_costos'],$sql);
            
            if ($cabecera['codigo_tipo'] == "37") {
                $titulo = "ORDEN DE COMPRA" ;
                $prefix = "OC";
                $tipo = "B";
            }else{
                $titulo = "ORDEN DE SERVICIO";
                $prefix = "OS";
                $tipo = "S";
            }

            $anio = explode("-",$cabecera['emision']);
            $titulo = $titulo . " " . $numero['numero'];
            
            $file = $prefix.$numero['numero']."_".$cabecera['codigo_costos'].".pdf";
            $entrega = $this->calcularDias($cabecera['fentrega']);

            $pdf = new PDF($titulo,$condicion,$cabecera['emision'],$cabecera['moneda'],$entrega,
                            $cabecera['lentrega'],$cabecera['proforma'],$cabecera['fentrega'],$cabecera['cpago'],$cabecera['total'],
                            $cabecera['costos'],$cabecera['detalle'],$_SESSION['nombres'],$cabecera['entidad'],$cabecera['ruc_entidad'],
                            $cabecera['direccion_entidad'],$cabecera['telefono_entidad'],$cabecera['correo_entidad'],$cabecera['retencion'],
                            $cabecera['atencion'],$cabecera['telefono_contacto'],$cabecera['correo_contacto']);

            $pdf->AddPage();
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(10,15,15,10,95,17,13,15));
            $pdf->SetFont('Arial','',5);
            $lc = 0;
            $rc = 0;

            //$pdf->Ln(3);

            $datos = json_decode($detalles);
            $nreg = count($datos);

            for ($i=0; $i < $nreg; $i++) { 
                $pdf->SetAligns(array("C","C","R","C","L","C","R","R"));
                $pdf->Row(array($datos[$i]->item,
                                $datos[$i]->codigo,
                                $datos[$i]->cantidad,
                                $datos[$i]->unidad,
                                utf8_decode($datos[$i]->descripcion),
                                $datos[$i]->pedido,
                                $datos[$i]->precio,
                                $datos[$i]->total));
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
            $pdf->Cell(140,6,$this->convertir($cabecera['total']),"TBR",0,"L",true); 
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(30,6,$cabecera['total'],"1",1,"R",true);

            $pdf->Ln(1);
            $pdf->SetFont('Arial',"","7");
            $pdf->Cell(40,6,"Pedidos Asociados",1,0,"C",true);
            $pdf->Cell(5,6,"",0,0);
            $pdf->Cell(80,6,utf8_decode("Información Bancaria del Proveedor"),1,0,"C",true);
            $pdf->Cell(10,6,"",0,0);
            $pdf->Cell(40,6,"Valor Venta",0,0);
            $pdf->Cell(20,6,$cabecera['total'],0,1);
                                        
            $pdf->Cell(10,4,utf8_decode("Año"),1,0);
                    
            $pdf->Cell(10,4,"Tipo",1,0);
            $pdf->Cell(10,4,"Pedido",1,0);
            $pdf->Cell(10,4,"Mantto",1,0);
            $pdf->Cell(5,6,"",0,0);
            $pdf->Cell(35,4,"Detalle del Banco",1,0);
            $pdf->Cell(15,4,"Moneda",1,0);
            $pdf->Cell(30,4,"Nro. Cuenta Bancaria",1,0);
            
            $pdf->Cell(10,4,"",0,0);
            $pdf->SetFont('Arial',"B","8");
            $pdf->Cell(20,4,"TOTAL",1,0,"L",true);
            $pdf->Cell(15,4,$cabecera['moneda'],1,0,"C",true);
            $pdf->Cell(20,4,$cabecera['total'],1,1,"R",true);

            $pdf->SetFont('Arial',"","7");
            $pdf->Cell(10,4,$anio[0],1,0);
            $pdf->Cell(10,4,$tipo,1,0);
            $pdf->Cell(10,4,str_pad($cabecera['codigo_pedido'],6,0,STR_PAD_LEFT),1,0);
            $pdf->Cell(10,4,"",1,0);
            $pdf->Cell(5,6,"",0,0);
            
            $nreg = count($bancos);

            for ($i=0;$i<$nreg;$i++){
                $pdf->Cell(35,4,$bancos[$i]['banco'],1,0);
                $pdf->Cell(15,4,$bancos[$i]['moneda'],1,0);
                $pdf->Cell(30,4,$bancos[$i]['cuenta'],1,1);
                $pdf->Cell(45,4,"",0,0);
            }

            if ($condicion == 0){
                $filename = "public/documentos/ordenes/vistaprevia/".$file;
            }else{
                $filename = "public/documentos/ordenes/aprobadas/".$file;
            }

            $pdf->Output($filename,'F');

            return $file;
        }

        private function calcularDias($fechaEntrega){
            $date1 = new DateTime(Date('Y-m-d'));
            $date2 = new DateTime($fechaEntrega);
            $diff = $date1->diff($date2);
            // will output 2 days
            return $diff->days . ' dias ';
        }

        private function datosPedido($pedido){
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                        ibis.tb_pedidocab.idreg,
                                                        ibis.tb_pedidocab.idcostos,
                                                        ibis.tb_pedidocab.idarea,
                                                        ibis.tb_pedidocab.idtrans,
                                                        ibis.tb_pedidocab.idsolicita,
                                                        ibis.tb_pedidocab.idtipomov,
                                                        ibis.tb_pedidocab.emision,
                                                        ibis.tb_pedidocab.vence,
                                                        ibis.tb_pedidocab.estadodoc,
                                                        ibis.tb_pedidocab.nrodoc,
                                                        ibis.tb_pedidocab.usuario,
                                                        UPPER(ibis.tb_pedidocab.concepto) AS concepto,
                                                        UPPER(ibis.tb_pedidocab.detalle) AS detalle,
                                                        ibis.tb_pedidocab.nivelAten,
                                                        ibis.tb_pedidocab.docPdfAprob,
                                                        ibis.tb_pedidocab.verificacion,
                                                        UPPER(
                                                        CONCAT( ibis.tb_proyectos.ccodproy, ' ', ibis.tb_proyectos.cdesproy )) AS proyecto,
                                                        UPPER(
                                                        CONCAT( ibis.tb_area.ccodarea, ' ', ibis.tb_area.cdesarea )) AS area,
                                                        UPPER(
                                                        CONCAT( ibis.tb_parametros.nidreg, ' ', ibis.tb_parametros.cdescripcion )) AS transporte,
                                                        estados.cdescripcion AS estado,
                                                        estados.cabrevia,
                                                        UPPER(
                                                        CONCAT_WS( ' ', tipos.nidreg, tipos.cdescripcion )) AS tipo,
                                                        ibis.tb_proyectos.veralm 
                                                    FROM
                                                        ibis.tb_pedidocab
                                                        INNER JOIN ibis.tb_proyectos ON ibis.tb_pedidocab.idcostos = ibis.tb_proyectos.nidreg
                                                        INNER JOIN ibis.tb_area ON ibis.tb_pedidocab.idarea = ibis.tb_area.ncodarea
                                                        INNER JOIN ibis.tb_parametros ON ibis.tb_pedidocab.idtrans = ibis.tb_parametros.nidreg
                                                        INNER JOIN ibis.tb_parametros AS transportes ON ibis.tb_pedidocab.idtrans = transportes.nidreg
                                                        INNER JOIN ibis.tb_parametros AS estados ON ibis.tb_pedidocab.estadodoc = estados.nidreg
                                                        INNER JOIN ibis.tb_parametros AS tipos ON ibis.tb_pedidocab.idtipomov = tipos.nidreg 
                                                    WHERE
                                                        tb_pedidocab.idreg = :pedido ");
                $sql->execute(["pedido"=>$pedido]);
                
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

        private function datosEntidad($entidad){
            try {
                $sql=$this->db->connect()->prepare("SELECT
                                                        cm_entidad.cnumdoc,
                                                        cm_entidad.crazonsoc,
                                                        UPPER( cm_entidadcon.cnombres ) AS contacto,
                                                        cm_entidadcon.cemail AS correo_contacto,
                                                        cm_entidadcon.ctelefono1 AS telefono_contacto,
                                                        cm_entidad.id_centi,
                                                        cm_entidad.cemail AS correo_entidad,
                                                        cm_entidad.cviadireccion,
                                                        cm_entidad.ctelefono,
                                                        cm_entidad.nagenret  
                                                    FROM
                                                        cm_entidadcon
                                                        INNER JOIN cm_entidad ON cm_entidadcon.id_centi = cm_entidad.id_centi 
                                                    WHERE
                                                        cm_entidad.id_centi =:entidad 
                                                        LIMIT 1");
                $sql->execute(["entidad"=>$entidad]);

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

        private function bancosProveedor($entidad){
            try {
                $bancos = [];
                $item = array();

                $sql = $this->db->connect()->prepare("SELECT
                                                    bancos.cdescripcion AS banco,
                                                    cm_entidadbco.cnrocta AS cuenta,
                                                    monedas.cdescripcion AS moneda
                                                FROM
                                                    cm_entidadbco
                                                    INNER JOIN tb_parametros AS bancos ON cm_entidadbco.ncodbco = bancos.nidreg
                                                    INNER JOIN tb_parametros AS monedas ON cm_entidadbco.cmoneda = monedas.nidreg 
                                                WHERE
                                                    cm_entidadbco.nflgactivo = 1 
                                                    AND cm_entidadbco.id_centi = :entidad");
                $sql->execute(["entidad"=>$entidad]);
                $rowCount = $sql->rowCount();

                if($rowCount > 0){
                    while ($rs = $sql->fetch()) {
                        $item['banco'] = $rs['banco'];
                        $item['moneda'] = $rs['moneda'];
                        $item['cuenta'] = $rs['cuenta'];
                        
                        array_push($bancos,$item);
                    }
                }

                return $bancos;

            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }
    }
?>