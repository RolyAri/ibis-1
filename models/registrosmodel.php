<?php
    class RegistrosModel extends Model{

        public function __construct()
        {
            parent::__construct();
        }

        public function listarGuias(){
            try {
                $salida = "";
                $sql = $this->db->connect()->prepare("");
                $sql->execute(["usr"=>$_SESSION['iduser']]);
                $rowCount = $sql->rowcount();
                $item = 1;
                
                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()) {
                        $salida .= '<tr class="pointer" data-despacho="">
                                        <td class="textoCentro">'.str_pad($item++,4,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.date("d/m/Y", strtotime($rs['ffechdoc'])).'</td>
                                        <td class="pl20px">'.$rs['destino'].'</td>
                                        <td class="pl20px">'.$rs['costos'].'</td>
                                        <td class="textoCentro">'.$rs['anio'].'</td>
                                        <td class="textoCentro"></td>
                                        <td class="textoCentro"></td>
                                        <td class="textoCentro"></td>
                                        <td class="pl20px"></td>
                                        <td class="textoCentro"></td>
                                    </tr>';
                    }
                }

                return $salida;

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function itemsDespachos(){
            $sql = $this->db->connect()->prepare("SELECT
                                                UPPER( tb_almacen.cdesalm ) AS destino,
                                                CONCAT_WS( ' ', rrhh.tabla_aquarius.apellidos, rrhh.tabla_aquarius.nombres ) AS solicita,
                                                UPPER( ibis.tb_pedidocab.concepto ) AS concepto,
                                                LPAD( ibis.tb_pedidocab.nrodoc, 6, 0 ) AS pedido,
                                                ibis.lg_ordencab.cnumero AS orden,
                                                ibis.cm_producto.ccodprod,
                                                UPPER(
                                                CONCAT_WS( ' ', ibis.cm_producto.cdesprod, ibis.tb_pedidodet.observaciones )) AS descripcion,
                                                ibis.tb_proyectos.ccodproy,
                                                ibis.tb_proyectos.cdesproy,
                                                ibis.tb_area.cdesarea,
                                                ibis.tb_partidas.ccodigo,
                                                ibis.tb_partidas.cdescripcion,
                                                ibis.alm_despachodet.niddeta AS itemdespacho,
                                                ibis.tb_pedidodet.iditem AS itempedido,
                                                ibis.alm_despachodet.ncantidad,
                                                ibis.alm_recepserie.cdesserie,
                                                ibis.alm_despachodet.nGuia 
                                            FROM
                                                ibis.tb_almausu
                                                INNER JOIN ibis.alm_despachodet ON tb_almausu.nalmacen = alm_despachodet.ncodalm2
                                                INNER JOIN ibis.tb_almacen ON alm_despachodet.ncodalm2 = tb_almacen.ncodalm
                                                INNER JOIN ibis.tb_pedidodet ON alm_despachodet.niddetaPed = tb_pedidodet.iditem
                                                INNER JOIN ibis.tb_pedidocab ON tb_pedidodet.idpedido = tb_pedidocab.idreg
                                                INNER JOIN rrhh.tabla_aquarius ON ibis.tb_pedidocab.idsolicita = rrhh.tabla_aquarius.internal
                                                INNER JOIN ibis.lg_ordencab ON ibis.tb_pedidocab.idorden = ibis.lg_ordencab.id_regmov
                                                INNER JOIN ibis.cm_producto ON ibis.tb_pedidodet.idprod = ibis.cm_producto.id_cprod
                                                INNER JOIN ibis.tb_proyectos ON ibis.tb_pedidodet.idcostos = ibis.tb_proyectos.nidreg
                                                INNER JOIN ibis.tb_area ON ibis.tb_pedidocab.idarea = ibis.tb_area.ncodarea
                                                LEFT JOIN ibis.tb_partidas ON ibis.tb_pedidocab.idpartida = ibis.tb_partidas.idreg
                                                INNER JOIN ibis.alm_recepdet ON ibis.alm_despachodet.niddetaIng = ibis.alm_recepdet.niddeta
                                                LEFT JOIN ibis.alm_recepserie ON ibis.alm_recepdet.niddeta = ibis.alm_recepserie.idref_movi 
                                            WHERE
                                                tb_almausu.id_cuser =:user 
                                                AND tb_almausu.nflgactivo = 1 
                                                AND alm_despachodet.nestadoreg = 67");
                                            }

        public function importarDespacho($id){
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                        ibis.lg_docusunat.id_despacho,
                                                        ibis.lg_docusunat.cnumero AS guia,
                                                        ibis.lg_docusunat.cdocPDF,
                                                        ibis.lg_docusunat.ffechdoc,
                                                        ibis.lg_docusunat.ffechtrasl,
                                                        ibis.lg_docusunat.nEstadoDoc,
                                                        FORMAT(ibis.lg_docusunat.nbultos,2) AS nbultos,
                                                        FORMAT(ibis.lg_docusunat.npesotot,2) AS npesotot,
                                                        LPAD(ibis.tb_pedidocab.nrodoc,6,0) AS pedido,
                                                        ibis.tb_pedidocab.concepto,
                                                        ibis.tb_proyectos.ccodproy,
                                                        UPPER(ibis.tb_proyectos.cdesproy) AS costos,
                                                        ibis.tb_area.ccodarea,
                                                        UPPER(ibis.tb_area.cdesarea) AS area,
                                                        CONCAT_WS(
                                                                ' ',
                                                                rrhh.tabla_aquarius.apellidos,
                                                                rrhh.tabla_aquarius.nombres
                                                            ) AS solicita,
                                                        UPPER(origen.cdesalm) AS origen,
                                                        UPPER(ibis.tb_almacen.cdesalm) AS destino,
                                                        ibis.tb_pedidocab.emision,
                                                        ibis.lg_ordencab.cnumero AS orden,
                                                        ibis.tb_area.ncodarea AS codigo_area,
                                                        ibis.tb_proyectos.nidreg AS codigo_costos,
                                                        ibis.tb_pedidocab.idreg AS codigo_pedido,
                                                        ibis.lg_ordencab.id_regmov AS codigo_orden,
                                                        ibis.tb_almacen.ncodalm AS codigo_origen,
                                                        origen.ncodalm AS codigo_destino,
                                                        ibis.lg_ordencab.ffechadoc AS fecha_orden
                                                        FROM
                                                            ibis.lg_docusunat
                                                        INNER JOIN ibis.alm_despachocab ON ibis.lg_docusunat.id_despacho = ibis.alm_despachocab.id_regalm
                                                        INNER JOIN ibis.tb_pedidocab ON ibis.alm_despachocab.idref_pedi = ibis.tb_pedidocab.idreg
                                                        INNER JOIN ibis.tb_proyectos ON ibis.tb_pedidocab.idcostos = ibis.tb_proyectos.nidreg
                                                        INNER JOIN ibis.tb_area ON ibis.tb_pedidocab.idarea = ibis.tb_area.ncodarea
                                                        INNER JOIN rrhh.tabla_aquarius ON ibis.tb_pedidocab.idsolicita = rrhh.tabla_aquarius.internal
                                                        INNER JOIN ibis.tb_almacen AS origen ON ibis.alm_despachocab.ncodalm1 = origen.ncodalm
                                                        INNER JOIN ibis.tb_almacen ON ibis.alm_despachocab.ncodalm2 = ibis.tb_almacen.ncodalm
                                                        INNER JOIN ibis.lg_ordencab ON ibis.alm_despachocab.idref_ord = ibis.lg_ordencab.id_regmov
                                                        WHERE
                                                            ibis.lg_docusunat.id_despacho = :id");
                $sql->execute(["id"=>$id]);
                $docData = array();

                while($row=$sql->fetch(PDO::FETCH_ASSOC)){
                    $docData[] = $row;
                }

                return array("cabecera"=>$docData,
                            "detalles"=>$this->detallesDespacho($id),
                            "numero"=>str_pad($this->generarNroIngreso($docData[0]['codigo_costos']),6,0,STR_PAD_LEFT));


            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function generarNroIngreso($costos){
            try {
                $sql = $this->db->connect()->prepare("SELECT MAX(idreg) AS ingreso FROM alm_cabexist WHERE idcostos = :costos");
                $sql->execute(["costos"=>$costos]);
                $resultado = $sql->fetchAll();

                $numero = $resultado[0]['ingreso'] == NULL ? 1 : $resultado[0]['ingreso'];
                return $numero; 
                
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }
        
        private function detallesDespacho($id){
            try {
                $salida="";
                $sql=$this->db->connect()->prepare("SELECT
                                                        alm_despachodet.niddeta,
                                                        alm_despachodet.id_regalm,
                                                        alm_despachodet.ncodalm1,
                                                        alm_despachodet.ncodalm2,
                                                        alm_despachodet.id_cprod,
                                                        alm_despachodet.niddetaOrd,
                                                        alm_despachodet.niddetaPed,
                                                        alm_despachodet.nestadoreg,
                                                        alm_despachodet.fvence,
                                                        cm_producto.ccodprod,
                                                        UPPER(
                                                            CONCAT_WS(
                                                                ' ',
                                                                cm_producto.cdesprod,
                                                                tb_pedidodet.observaciones,
                                                                tb_pedidodet.docEspec
                                                            )
                                                        ) AS cdesprod,
                                                        tb_pedidodet.observaciones,
                                                        tb_unimed.cabrevia,
                                                        FORMAT(alm_despachodet.ncantidad, 2) AS cantidad,
                                                        series.cdesserie,
                                                        series.ncodserie
                                                    FROM
                                                        alm_despachodet
                                                    INNER JOIN cm_producto ON alm_despachodet.id_cprod = cm_producto.id_cprod
                                                    INNER JOIN tb_pedidodet ON alm_despachodet.niddetaPed = tb_pedidodet.iditem
                                                    INNER JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed
                                                    INNER JOIN lg_ordendet ON alm_despachodet.niddetaOrd = lg_ordendet.nitemord
                                                    LEFT JOIN (
                                                        SELECT
                                                            ncodserie,
                                                            cdesserie,
                                                            id_cprod
                                                        FROM
                                                            alm_recepserie
                                                        WHERE
                                                            idref_movi = :despacho
                                                    ) AS series ON alm_despachodet.id_cprod = series.id_cprod
                                                    WHERE
                                                        alm_despachodet.id_regalm = :id");
                $sql->execute(["id"=>$id,"despacho"=>$id]);

                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    $item = 1;
                    while ($rs = $sql->fetch()){

                        $estados = $this->listarSelect(13,$rs['nestadoreg']);

                        $cantidad  = $rs['cdesserie'] == null ? $rs['cantidad'] : 1;

                        $fecha = $rs['fvence'] == '30-11--0001' ? "" : date("d-m-Y", strtotime($rs['fvence']));

                        $salida.='<tr data-itemorden="'.$rs['niddetaOrd'].'" 
                                        data-itempedido="'.$rs['niddetaPed'].'" 
                                        data-itemdespacho="'.$rs['niddeta'].'"
                                        data-idproducto ="'.$rs['id_cprod'].'">
                                        <td class="textoCentro">'.str_pad($item++,3,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl20px">'.$rs['cdesprod'].'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                        <td class="textoDerecha pr20px">'.$cantidad.'</td>
                                        <td><input type="number" step="any" placeholder="0.00" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"></td>
                                        <td class="pl5px"><input type="text"></td>
                                        <td class="textoCentro">'.$rs['cdesserie'].'</td>
                                        <td class="textoCentro"><input type="date" value="'.$rs['fvence'].'"></td>
                                        <td><input type="text"></td>
                                        <td><select name="estado">'. $estados .'</select></td>
                                    </tr>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }
        

        private function actualizarDetallesPedido($detalles,$estado){
            try {
                $datos = json_decode($detalles);
                $nreg = count($datos);

                for ($i=0; $i < $nreg; $i++) { 
                    $sql = $this->db->connect()->prepare("UPDATE tb_pedidodet SET estadoItem =:estado WHERE iditem = :id" );
                    $sql ->execute(["estado"=> 67,
                                    "id"=>$datos[$i]->itempedido]);
                    $rowCount = $sql->rowcount();
                }

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function actualizarCabeceraPedidos($pedido,$estado){
            try {
                $sql = $this->db->connect()->prepare("UPDATE tb_pedidocab SET estadodoc =:estado WHERE idreg = :id" );
                $sql ->execute(["estado"=> $estado,"id"=>$pedido]);
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function actualizarDespacho($salida,$estado){
            try {
                $sql = $this->db->connect()->prepare("UPDATE alm_despachocab SET nEstadoDoc =:estado WHERE id_regalm = :id" );
                $sql ->execute(["estado"=> $estado,"id"=>$salida]);
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function insertarIngreso($detalles,$almacen,$pedido,$orden,$recepciona,$salida,$cabecera){
            try {
                $sql = $this->db->connect()->prepare("INSERT INTO alm_cabexist SET idped=:pedido,
                                                                                    idord=:orden,
                                                                                    idcostos=:costos,
                                                                                    idarea=:area,
                                                                                    iddespacho=:despacho");
                $sql->execute(["pedido"=>$cabecera["pedido"],
                                "orden"=>$cabecera["orden"],
                                "costos"=>$cabecera["codigo_costos"],
                                "area"=>$cabecera["codigo_area"],
                                "despacho"=>$cabecera["codigo_salida"]]);
                
                $rowCount = $sql->rowcount();
                if ($sql->rowCount() > 0){
                    $this->actualizarStocks($detalles,$almacen,$pedido,$orden,$recepciona,$salida,$cabecera);
                }
                
                return true;
                
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function generarindice(){
            try {
                $sql = $this->db->connect()->query("SELECT MAX(idreg) AS ingreso FROM alm_cabexist");
                $sql->execute();
                $resultado = $sql->fetchAll();

                return $resultado[0]['ingreso']; 
                
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        //$salida se refiere al número del despacho
        public function actualizarStocks($detalles,$almacen,$pedido,$orden,$recepciona,$salida,$cabecera){
            try {
                $datos = json_decode($detalles);
                $nreg = count($datos);
                $item = 0;
                for ($i=0; $i < $nreg; $i++) { 
                    $sql = $this->db->connect()->prepare("INSERT INTO alm_existencia SET idalm=:alm,idprod=:prod,serie=:serie,
                                                            cant_ingr=:cantidad,crecepciona=:recepciona,tipo=:tipo,idregistro=:registro,
                                                            iddespacho=:despacho,idpedido=:pedido,idorden=:orden,observaciones=:observac,
                                                            ubicacion=:ubica");
                    $sql ->execute(["alm"=>$almacen,
                                    "prod"=>$datos[$i]->idproducto,
                                    "serie"=>$datos[$i]->series,
                                    "cantidad"=>$datos[$i]->ingreso,
                                    "recepciona"=>$datos[$i]->recepciona,
                                    "tipo"=>1,
                                    "registro"=>$this->generarindice(),
                                    "despacho"=>$datos[$i]->itemdespacho,
                                    "pedido"=>$cabecera['codigo_pedido'],
                                    "orden"=>$cabecera['codigo_orden'],
                                    "observac"=>$datos[$i]->observaciones,
                                    "ubica"=>$datos[$i]->ubicacion]);
                    $rowCount = $sql->rowcount();
                    if ($sql->rowCount() > 0){
                        $item++;
                    }
                }

                if ($item > 0) {
                    $this->actualizarDetallesPedido($detalles,67);
                    $this->actualizarCabeceraPedidos($pedido,67);
                    $this->actualizarDespacho($salida,99);
                }

                return array("item"=>$item);
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }
    }
?>