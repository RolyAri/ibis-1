<?php
    class StocksModel extends Model{

        public function __construct(){
            parent::__construct();
        }

        public function listarItems($parametros){
            try {
                $salida = '';
                $cc = $parametros['costosSearch'];
                $cp = $parametros['codigoBusqueda'] == "" ? "%" : $parametros['codigoBusqueda'];

                $sql = $this->db->connect()->prepare("SELECT
                                                        cm_producto.id_cprod,
                                                        cm_producto.ccodprod,
                                                        tb_unimed.cabrevia,
                                                        UPPER( cm_producto.cdesprod ) AS cdesprod,
                                                        g.ingreso_guias,
                                                        g.idcostos AS guias,
                                                        i.ingreso_inventario,
                                                        i.idcostos AS inventario,
                                                        c.consumo,
                                                        c.devolucion 
                                                    FROM
                                                        cm_producto
                                                        INNER JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed
                                                        LEFT JOIN (
                                                        SELECT
                                                            alm_existencia.codprod,
                                                            SUM( alm_existencia.cant_ingr ) AS ingreso_guias,
                                                            alm_cabexist.idcostos,
                                                            alm_existencia.nflgActivo 
                                                        FROM
                                                            alm_cabexist
                                                            LEFT JOIN alm_existencia ON alm_existencia.idregistro = alm_cabexist.idreg 
                                                        WHERE
                                                            alm_existencia.nflgActivo = 1 
                                                            AND alm_cabexist.idcostos = :guias 
                                                        GROUP BY
                                                            alm_existencia.codprod 
                                                        ) AS g ON cm_producto.id_cprod = g.codprod
                                                        LEFT JOIN (
                                                        SELECT
                                                            alm_inventariodet.codprod,
                                                            SUM( alm_inventariodet.cant_ingr ) AS ingreso_inventario,
                                                            alm_inventariocab.idcostos 
                                                        FROM
                                                            alm_inventariodet
                                                            LEFT JOIN alm_inventariocab ON alm_inventariodet.idregistro = alm_inventariocab.idreg 
                                                        WHERE
                                                            alm_inventariocab.idcostos = :inventarios 
                                                        GROUP BY
                                                            alm_inventariodet.codprod 
                                                        ) AS i ON cm_producto.id_cprod = i.codprod
                                                        LEFT JOIN (
                                                        SELECT
                                                            alm_consumo.idprod,
                                                            SUM( alm_consumo.cantsalida ) AS consumo,
                                                            SUM( alm_consumo.cantdevolucion ) AS devolucion 
                                                        FROM
                                                            alm_consumo 
                                                        WHERE
                                                            alm_consumo.ncostos = :consumo 
                                                        GROUP BY
                                                            alm_consumo.idprod 
                                                        ) AS c ON cm_producto.id_cprod = c.idprod 
                                                    WHERE
                                                        cm_producto.ntipo LIKE 37 
                                                        AND cm_producto.flgActivo = 1 
                                                        AND cm_producto.ccodprod LIKE :codigo
                                                    ORDER BY
                                                        cm_producto.cdesprod");
                $sql->execute(["guias"=>$cc,
                                "inventarios"=>$cc,
                                "consumo"=>$cc,
                                "codigo"=>$cp]);
                $rowCount = $sql->rowCount();
                $item = 1;
                $salida = '<tr><td colspan="9">No hay registros para mostrar</td></tr>';

                if ($rowCount > 0) {
                    $salida="";
                    while ($rs = $sql->fetch()){
                        $saldo = ($rs['ingreso_guias']+$rs['ingreso_inventario']+$rs['devolucion'])-$rs['consumo'];
                        $estado = $saldo > 0 ? "semaforoVerde":"semaforoRojo";

                        if ( $saldo ){
                            $salida.='<tr class="pointer" data-idprod="'.$rs['id_cprod'].'" data-costos="'.$rs['guias'].'">
                                            <td class="textoCentro">'.str_pad($item++,4,0,STR_PAD_LEFT).'</td>
                                            <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                            <td class="pl20px">'.$rs['cdesprod'].'</td>
                                            <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                            <td class="textoDerecha">'.number_format($rs['ingreso_guias'],2).'</td>
                                            <td class="textoDerecha">'.number_format($rs['ingreso_inventario'],2).'</td>
                                            <td class="textoDerecha">'.number_format($rs['consumo'],2).'</td>
                                            <td class="textoDerecha">'.number_format($rs['devolucion'],2).'</td>
                                            <td class="textoDerecha '.$estado.'"><div>'.number_format($saldo,2).'</div></td>
                                    </tr>';
                        }
                    }
                }else {
                    $salida = '<tr colspan="8">No hay registros</tr>';
                }

                return $salida;

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function obtenerResumen($codigo){
            return  array("pedidos"=>$this->numeroPedidos($codigo),
                          "ordenes"=>$this->numeroOrdenes($codigo),
                          "inventario"=>$this->inventarios($codigo),
                          "ingresos"=>$this->verIngresos($codigo),
                          "pendientes"=>$this->pendientesOC($codigo),
                          "precios"=>$this->listaPrecios($codigo),
                          "existencias"=>$this->listaExistencias($codigo));
        }

        private function numeroPedidos($codigo){
            try {
                $sql=$this->db->connect()->prepare("SELECT
                                                        COUNT( tb_pedidodet.idprod ) AS numero_pedidos 
                                                    FROM
                                                        tb_pedidodet 
                                                    WHERE
                                                        tb_pedidodet.idprod = :codigo 
                                                        AND tb_pedidodet.nflgActivo = 1 
                                                        AND tb_pedidodet.idpedido != 0");
                $sql->execute(["codigo"=>$codigo]);
                $result = $sql->fetchAll();

                return $result[0]['numero_pedidos'];

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function numeroOrdenes($codigo){
            try {
                $sql=$this->db->connect()->prepare("SELECT
                                                        COUNT( lg_ordendet.id_cprod ) AS numero_orden 
                                                    FROM
                                                        lg_ordendet 
                                                    WHERE
                                                        lg_ordendet.id_cprod = :codigo
                                                    AND lg_ordendet.id_orden != 0");
                $sql->execute(["codigo"=>$codigo]);
                $result = $sql->fetchAll();

                if ( empty($result[0]['numero_orden'] ) ) 
                    return 0;
                else
                    return $result[0]['numero_orden'];
                
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function verIngresos($codigo){
            try {
                $sql=$this->db->connect()->prepare("SELECT
                                                    SUM( alm_existencia.cant_ingr ) AS ingresos 
                                                FROM
                                                    alm_existencia 
                                                WHERE
                                                    alm_existencia.codprod = :codigo");
                $sql->execute(["codigo"=>$codigo]);
                $result = $sql->fetchAll();

                return isset($result[0]['ingresos']) ? $result[0]['ingresos'] : 0;
                
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function pendientesOC($codigo){
            try {
                $sql=$this->db->connect()->prepare("SELECT
                                                    SUM( lg_ordendet.ncanti ) AS cantidad_pendiente 
                                                FROM
                                                    lg_ordendet 
                                                WHERE
                                                    lg_ordendet.id_cprod = :codigo 
                                                    AND lg_ordendet.nEstadoReg = 60");
                $sql->execute(["codigo"=>$codigo]);
                $result = $sql->fetchAll();

                return isset($result[0]['cantidad_pendiente']) ? $result[0]['cantidad_pendiente'] : 0;
                
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function listaPrecios($codigo){
            try {
                $salida = "";
                $sql=$this->db->connect()->prepare("SELECT
                                                        lg_ordendet.nunitario,
                                                        DATE_FORMAT( lg_ordencab.ffechadoc, '%d/%m/%Y' ) fecha,
                                                        tb_parametros.cabrevia,
                                                        lg_ordencab.ntcambio 
                                                    FROM
                                                        lg_ordendet
                                                        INNER JOIN lg_ordencab ON lg_ordendet.id_regmov = lg_ordencab.id_regmov
                                                        INNER JOIN tb_parametros ON lg_ordencab.ncodmon = tb_parametros.nidreg 
                                                    WHERE
                                                        lg_ordendet.id_cprod = :codigo 
                                                        AND lg_ordendet.id_orden IS NOT NULL
                                                    GROUP BY lg_ordendet.nunitario,lg_ordencab.ffechadoc,lg_ordencab.ntcambio");
                $sql->execute(["codigo"=>$codigo]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()){
                        $salida .='<tr class="pointer">
                                        <td class="textoCentro">'.$rs['fecha'].'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                        <td class="textoDerecha">'.$rs['ntcambio'].'</td>
                                        <td class="textoDerecha">'.$rs['nunitario'].'</td>
                                    </tr>';
                    }
                }else {
                    $salida = '<tr class="textoCentro"><td colspan="4">Sin registros anteriores</td></tr>';
                }

                return $salida;

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function listaExistencias($codigo){
            try {
                $salida = "";
                $sql=$this->db->connect()->prepare("SELECT
                                                        FORMAT(alm_existencia.cant_ingr,2) AS cant_ingr,
                                                        UPPER( tb_almacen.cdesalm ) AS almacen,
                                                        tb_proyectos.ccodproy,
                                                        tb_unimed.cabrevia 
                                                    FROM
                                                        alm_existencia
                                                        INNER JOIN alm_cabexist ON alm_existencia.idregistro = alm_cabexist.idreg
                                                        INNER JOIN tb_almacen ON alm_existencia.idalm = tb_almacen.ncodalm
                                                        INNER JOIN tb_proyectos ON alm_cabexist.idcostos = tb_proyectos.nidreg
                                                        INNER JOIN cm_producto ON alm_existencia.codprod = cm_producto.id_cprod
                                                        INNER JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed 
                                                    WHERE
                                                        alm_existencia.codprod = :codigo");
                $sql->execute(["codigo"=>$codigo]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()){
                        $salida .='<tr class="pointer">
                                        <td class="pl20px">'.$rs['ccodproy'].'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                        <td class="textoDerecha">'.$rs['cant_ingr'].'</td>
                                        <td class="textoDerecha"></td>
                                        <td class="textoDerecha">'.$rs['cant_ingr'].'</td>
                                        <td class="textoDerecha">'.$rs['almacen'].'</td>
                                    </tr>';
                    }
                }else {
                    $salida = '<tr class="textoCentro"><td colspan="4">Sin registros anteriores</td></tr>';
                }

                return $salida;

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }
    
        private function inventarios($codigo){
            try {
                $sql=$this->db->connect()->prepare("SELECT
                                                        SUM( alm_inventariodet.cant_ingr ) AS inventario 
                                                    FROM
                                                        alm_inventariodet 
                                                    WHERE
                                                        alm_inventariodet.codprod = :codigo");
                $sql->execute(["codigo"=>$codigo]);
                $result = $sql->fetchAll();

                
                return isset( $result[0]['inventario'] ) ? $result[0]['inventario'] : 0;

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function exportarExcel($registros) {
            try {
                require_once('public/PHPExcel/PHPExcel.php');
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()
                ->setCreator("Sical")
                ->setLastModifiedBy("Sical")
                ->setTitle("Control Almacen")
                ->setSubject("Template excel")
                ->setDescription("Control Almacen")
                ->setKeywords("Template excel");

                $objWorkSheet = $objPHPExcel->createSheet(1);

                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->setTitle("Inventario");

                //combinar celdas
                $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');

                //alineacion
                $objPHPExcel->getActiveSheet()->getStyle('A1:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A1:H4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $objPHPExcel->getActiveSheet()->getStyle('A1:H5')->getAlignment()->setWrapText(true);

                //ancho de columnas
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(27);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                        
                //Titulo 
                $objPHPExcel->getActiveSheet()->setCellValue('A1','Control de Almacén');

                $objPHPExcel->getActiveSheet()
                    ->getStyle('A1:H4')
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('FDE9D9');

                $objPHPExcel->getActiveSheet()->setCellValue('A4','ITEM'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('B4','CODIGO'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('C4','DESCRIPCION'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('D4','UNIDAD'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('E4','CANTIDAD GUIAS'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('F4','INGRESO INVENTARIO'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('G4','CANTIDAD SALIDAS'); // esto cambia
                $objPHPExcel->getActiveSheet()->setCellValue('H4','SALDO'); // esto cambia

       
                $fila = 5;
                $datos = json_decode($registros);
                $nreg = count($datos);

                for ($i=0; $i < $nreg; $i++) { 
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila,$datos[$i]->item);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila,$datos[$i]->codigo);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila,$datos[$i]->descripcion);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila,$datos[$i]->unidad);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila,$datos[$i]->ingreso);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila,$datos[$i]->inventario);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila,$datos[$i]->salida);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila,$datos[$i]->saldo);
                    
                    $fila++;
                }

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
                $objWriter->save('public/documentos/reportes/control.xlsx');

                return array("documento"=>'public/documentos/reportes/control.xlsx');

                exit();
               
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }
    }
?>