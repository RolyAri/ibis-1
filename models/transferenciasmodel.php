<?php
    class TransferenciasModel extends Model{

        public function __construct()
        {
            parent::__construct();
        }

        public function listarPedidosAtendidos(){
            try {
                $salida = "";
                $sql = $this->db->connect()->prepare("SELECT
                                                    tb_costusu.id_cuser,
                                                    alm_transfercab.almorigen,
                                                    alm_transfercab.almdestino,
                                                    alm_transfercab.idreg,
                                                    UPPER( origen.cdesalm ) AS almacenorigen,
                                                    UPPER( destino.cdesalm ) AS almacendestino,
                                                    UPPER( tb_proyectos.cdesproy ) AS proyecto,
                                                    alm_transfercab.ftraslado 
                                                FROM
                                                    tb_costusu
                                                    INNER JOIN alm_transfercab ON tb_costusu.ncodproy = alm_transfercab.idcc
                                                    INNER JOIN tb_almacen AS origen ON alm_transfercab.almorigen = origen.ncodalm
                                                    INNER JOIN tb_almacen AS destino ON alm_transfercab.almdestino = destino.ncodalm
                                                    INNER JOIN tb_proyectos ON tb_costusu.ncodproy = tb_proyectos.nidreg 
                                                WHERE
                                                    tb_costusu.nflgactivo = 1 
                                                    AND alm_transfercab.nflgactivo = 1
                                                    AND tb_costusu.id_cuser = :user");
                $sql->execute(["user"=>$_SESSION['iduser']]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()) {
                        $salida .='<tr class="pointer" data-indice="'.$rs['idreg'].'">
                                        <td class="textoCentro">'.str_pad($rs['idreg'],4,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.date("d/m/Y", strtotime($rs['ftraslado'])).'</td>
                                        <td class="pl20px">'.$rs['almacenorigen'].'</td>
                                        <td class="pl20px">'.$rs['almacendestino'].'</td>
                                        <td class="pl20px">'.$rs['proyecto'].'</td>
                                    </tr>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function consultarTransferencia($id) {
            try {
                $cabecera = "";
                $result = [];

                $sql = $this->db->connect()->prepare("SELECT
                                                        alm_transfercab.idreg,
                                                        alm_transfercab.idcc,
                                                        alm_transfercab.idaprueba,
                                                        alm_transfercab.almorigen,
                                                        alm_transfercab.almdestino,
                                                        alm_transfercab.ftraslado,
                                                        tb_user.cnombres,
                                                        UPPER( almacenOrigen.cdesalm ) AS origen,
                                                        UPPER( almacenDestino.cdesalm ) AS destino,
                                                        UPPER( tb_proyectos.cdesproy ) AS proyecto,
                                                        tb_parametros.cdescripcion,
                                                        alm_transfercab.ntipmov 
                                                    FROM
                                                        alm_transfercab
                                                        INNER JOIN tb_user ON alm_transfercab.idaprueba = tb_user.iduser COLLATE utf8_unicode_ci
                                                        INNER JOIN tb_almacen AS almacenOrigen ON alm_transfercab.almorigen = almacenOrigen.ncodalm
                                                        INNER JOIN tb_almacen AS almacenDestino ON alm_transfercab.almdestino = almacenDestino.ncodalm
                                                        INNER JOIN tb_proyectos ON alm_transfercab.idcc = tb_proyectos.nidreg
                                                        INNER JOIN tb_parametros ON alm_transfercab.ntipmov = tb_parametros.nidreg 
                                                    WHERE
                                                        alm_transfercab.idreg = :id 
                                                        AND alm_transfercab.nflgactivo = 1");
                
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    $docData = array();
                    while($row=$sql->fetch(PDO::FETCH_ASSOC)){
                        $docData[] = $row;
                    }
                }

                return array("cabecera"=>$docData,
                            "detalles"=>$this->detalles($id));


            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function detalles($id){
            try {
                $salida = "";

                $sql = $this->db->connect()->prepare("SELECT
                                                    alm_transferdet.iditem,
                                                    alm_transferdet.idtransfer,
                                                    alm_transferdet.iddetped,
                                                    alm_transferdet.idcprod,
                                                    alm_transferdet.ncanti,
                                                    alm_transferdet.cobserva,
                                                    alm_transferdet.idPedido,
                                                    cm_producto.ccodprod,
                                                    UPPER(cm_producto.cdesprod) AS producto,
                                                    tb_pedidodet.cant_aprob,
                                                    tb_pedidodet.cant_orden,
                                                    alm_transferdet.nflgactivo,
                                                    tb_unimed.cabrevia,
                                                    LPAD(tb_pedidocab.nrodoc,3,0) AS pedido  
                                                FROM
                                                    alm_transferdet
                                                    INNER JOIN cm_producto ON alm_transferdet.idcprod = cm_producto.id_cprod
                                                    INNER JOIN tb_pedidodet ON alm_transferdet.iddetped = tb_pedidodet.iditem
                                                    INNER JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed
                                                    INNER JOIN tb_pedidocab ON tb_pedidodet.idpedido = tb_pedidocab.idreg  
                                                WHERE
                                                    alm_transferdet.idtransfer = :id 
                                                    AND alm_transferdet.nflgactivo = 1");
                $sql->execute(["id"=>$id]);

                $rowCount = $sql->rowCount();
                $item = 1;

                if ($rowCount > 0) {
                    while ( $rs = $sql->fetch()){
                        $salida .= '<tr class="pointer"
                                            data-grabado="" 
                                            data-idprod="" 
                                            data-codund="" 
                                            data-idx="">
                                        <td class="textoCentro"><a href="#"><i class="fas fa-eraser"></i></a></td>
                                        <td class="textoCentro"><a href="#"><i class="fas fa-exchange-alt"></i></a></td>
                                        <td class="textoCentro">'.str_pad($item++,3,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl20px">'.$rs['producto'].'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                        <td class="textoDerecha">'.$rs['cant_aprob'].'</td>
                                        <td class="textoDerecha">'.$rs['cant_orden'].'</td>
                                        <td class="textoDerecha">'.$rs['ncanti'].'</td>
                                        <td></td>
                                        <td><textarea readonly></textarea>'.$rs['cobserva'].'</textarea></td>
                                        <td class="textoCentro">'.$rs['pedido'].'</td>
                                    </tr>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function consultarStocks($cc,$cod,$desc){
            try {
                $codigo      = $cod == "" ? '%': '%'.$cod.'%';
                $descripcion = $desc == "" ? '%': '%'.$desc.'%' ;

                $salida = '';

                $sql = $this->db->connect()->prepare("SELECT
                                                        cm_producto.id_cprod,
                                                        cm_producto.ccodprod,
                                                        cm_producto.ntipo,
                                                        UPPER( cm_producto.cdesprod ) AS descripcion,
                                                        SUM( alm_inventariodet.cant_ingr ) AS ingreso_inventario,
                                                        SUM( alm_existencia.cant_ingr ) AS ingreso_guias,
                                                        alm_inventariocab.idcostos AS cc_inventario,
                                                        alm_cabexist.idcostos AS cc_guias,
                                                        tb_unimed.cabrevia,
                                                        tb_unimed.ncodmed,
                                                    IF
                                                        ( ISNULL( alm_cabexist.idcostos ), alm_inventariocab.idcostos, alm_cabexist.idcostos ) AS costos 
                                                    FROM
                                                        cm_producto
                                                        LEFT JOIN alm_inventariodet ON cm_producto.id_cprod = alm_inventariodet.codprod
                                                        LEFT JOIN alm_existencia ON cm_producto.id_cprod = alm_existencia.codprod
                                                        LEFT JOIN alm_inventariocab ON alm_inventariodet.idregistro = alm_inventariocab.idreg
                                                        LEFT JOIN alm_cabexist ON alm_existencia.idregistro = alm_cabexist.idreg
                                                        INNER JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed 
                                                    WHERE
                                                        cm_producto.ntipo = 37 
                                                        AND ( alm_inventariocab.idcostos > 0 OR alm_existencia.cant_ingr > 0 )
                                                        AND cm_producto.ccodprod LIKE :codigo
                                                        AND cm_producto.cdesprod LIKE :descripcion
                                                    GROUP BY
                                                        cm_producto.id_cprod
                                                    ORDER BY cm_producto.cdesprod ASC");
                $sql->execute(["codigo"=>$codigo,"descripcion"=>$descripcion]);
                $rowCount = $sql->rowCount();
                $item = 1;
                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()){
                        $saldo = $rs['ingreso_guias']+$rs['ingreso_inventario'];
                        $estado = $saldo > 0 ? "semaforoVerde":"semaforoRojo";

                        if ( $rs['costos'] == $cc ){
                            $salida.='<tr class="pointer" data-idprod="'.$rs['id_cprod'].'" 
                                                          data-costos="'.$rs['costos'].'"
                                                          data-ncomed="'.$rs['ncodmed'].'">
                                            <td class="textoCentro">'.str_pad($item++,4,0,STR_PAD_LEFT).'</td>
                                            <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                            <td class="pl20px">'.$rs['descripcion'].'</td>
                                            <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                            <td class="textoDerecha '.$estado.'"><div>'.number_format($saldo,2).'</div></td>
                                    </tr>';
                        }
                    }
                }else {
                    $salida = '<tr colspan="8">No hay registros</tr>';
                }

                return $salida;

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function listarPedidosAtencion($cc,$pedido){
            try {
                $p = $pedido == "" ? "%" : $pedido;

                $salida = "";
                
                $sql = $this->db->connect()->prepare("SELECT
                                                        ibis.tb_pedidocab.nrodoc,
                                                        UPPER( ibis.tb_pedidocab.concepto ) AS concepto,
                                                        ibis.tb_pedidocab.idreg,
                                                        ibis.tb_pedidocab.estadodoc,
                                                        ibis.tb_pedidocab.emision,
                                                        ibis.tb_pedidocab.vence,
                                                        ibis.tb_pedidocab.idtipomov,
                                                        UPPER(
                                                        CONCAT_WS( ' ', ibis.tb_proyectos.ccodproy, ibis.tb_proyectos.cdesproy )) AS costos,
                                                        ibis.tb_pedidocab.nivelAten,
                                                        CONCAT_WS( ' ', rrhh.tabla_aquarius.apellidos, rrhh.tabla_aquarius.nombres ) AS nombres,
                                                        estados.cdescripcion AS estado,
                                                        atencion.cdescripcion AS atencion,
                                                        estados.cabrevia,
                                                        ibis.tb_pedidocab.idcostos,
                                                        ibis.tb_proyectos.ccodproy,
                                                        ibis.tb_proyectos.cdesproy 
                                                    FROM
                                                        ibis.tb_pedidocab
                                                        LEFT JOIN rrhh.tabla_aquarius ON ibis.tb_pedidocab.idsolicita = rrhh.tabla_aquarius.internal
                                                        LEFT JOIN ibis.tb_parametros AS estados ON ibis.tb_pedidocab.estadodoc = estados.nidreg
                                                        LEFT JOIN ibis.tb_parametros AS atencion ON ibis.tb_pedidocab.nivelAten = atencion.nidreg
                                                        LEFT JOIN ibis.tb_proyectos ON ibis.tb_pedidocab.idcostos = ibis.tb_proyectos.nidreg 
                                                    WHERE
                                                        ( ibis.tb_pedidocab.estadodoc = 54 OR ibis.tb_pedidocab.estadodoc = 59 ) 
                                                        AND ibis.tb_pedidocab.nflgactivo = 1 
                                                        AND ibis.tb_pedidocab.idtipomov = 37 
                                                        AND tb_pedidocab.nrodoc LIKE :pedido 
                                                    ORDER BY
                                                        ibis.tb_pedidocab.emision DESC");
                $sql->execute(["pedido"=>$p]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()) {
                        $tipo = $rs['idtipomov'] == 37 ? "B":"S";
                        $salida .='<tr class="pointer" 
                                        data-indice="'.$rs['idreg'].'" 
                                        data-pedido="'.$rs['nrodoc'].'">
                                        <td class="textoCentro">'.str_pad($rs['nrodoc'],4,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.date("d/m/Y", strtotime($rs['emision'])).'</td>
                                        <td class="pl20px">'.$rs['concepto'].'</td>
                                        <td class="pl20px">'.utf8_decode($rs['costos']).'</td>
                                        <td class="pl20px">'.$rs['nombres'].'</td>
                                    </tr>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function consultarPedidos($indice,$origen){
            try {
                $salida = "";
                $item = 1;

                $sql = $this->db->connect()->prepare("SELECT
                                                    tb_pedidodet.iditem,
                                                    tb_pedidodet.idpedido,
                                                    tb_pedidodet.idprod,
                                                    tb_pedidodet.cant_pedida,
                                                    tb_pedidodet.cant_orden,
                                                    tb_pedidodet.cant_aprob,
                                                    tb_pedidodet.cant_atend,
                                                    cm_producto.ccodprod,
                                                    UPPER(cm_producto.cdesprod) AS cdesprod,
                                                    tb_unimed.cabrevia,
                                                    tb_pedidocab.idreg,
                                                    tb_pedidocab.idcostos,
                                                    LPAD(tb_pedidocab.nrodoc,6,0) AS nrodoc,
                                                    ( SELECT SUM( alm_existencia.cant_ingr ) FROM alm_existencia WHERE alm_existencia.idalm = :ingresos AND alm_existencia.codprod = cm_producto.id_cprod ) AS ingreso,
                                                    ( SELECT SUM( alm_inventariodet.cant_ingr ) FROM alm_inventariodet WHERE alm_inventariodet.idalm = :inventario AND alm_inventariodet.codprod = cm_producto.id_cprod ) AS inventario 
                                                FROM
                                                    tb_pedidodet
                                                    INNER JOIN cm_producto ON tb_pedidodet.idprod = cm_producto.id_cprod
                                                    INNER JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed
                                                    INNER JOIN tb_pedidocab ON tb_pedidodet.idpedido = tb_pedidocab.idreg 
                                                WHERE
                                                    tb_pedidodet.idpedido = :indice
                                                    AND tb_pedidodet.cant_orden != tb_pedidodet.cant_aprob");
                $sql -> execute(['indice'=>$indice,"ingresos"=>$origen,"inventario"=>$origen]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while($rs = $sql->fetch()) {
                        $existencia = $rs['ingreso']+$rs['inventario'];
                        $enviar = $rs['cant_aprob'] - $rs['cant_orden'];

                        $salida .= '<tr data-iditem="'.$rs['iditem'].'" 
                                        data-aprobado="'.$rs['cant_aprob'].'" 
                                        data-pedido="'.$rs['idreg'].'"
                                        data-idprod="'.$rs['idprod'].'"
                                        data-costos="'.$rs['idcostos'].'"
                                        data-orden="'.$rs['cant_orden'].'"
                                        data-almacen="'.$rs['cant_atend'].'"
                                        data-grabado="0">
                                        <td class="textoCentro"><a href="'.$rs['iditem'].'" title="Eliminar" data-accion="delete"><i class="fas fa-eraser"></i></a></td>
                                        <td class="textoCentro"><a href="'.$rs['iditem'].'" title="Cambiar" data-accion="change"><i class="fas fa-exchange-alt"></i></a></td>
                                        <td class="textoCentro">'.str_pad($item++,3,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl20px">'.$rs['cdesprod'].'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                        <td class="textoDerecha">'.$rs['cant_aprob'].'</td>
                                        <td class="textoDerecha">'.$rs['cant_orden'].'</td>
                                        <td><input type="number" value = "'.$enviar.'"></td>
                                        <td class="textoDerecha">'.number_format($existencia,2).'</td>
                                        <td><input type="text"></td>
                                        <td  class="textoCentro">'.$rs['nrodoc'].'</td>
                                    </tr>';
                    }
                }

                return $salida;
            }catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function insertarTransferencia($cabecera,$detalles,$pedido){
            try {
                $mensaje = "Error al grabar el registro";
                $sw = false;

                $sql = $this->db->connect()->prepare("INSERT INTO alm_transfercab 
                                                        SET idcc=:costos,idaprueba=:aprueba,almorigen=:origen,almdestino=:destino,
                                                            ftraslado=:fecha_traslado,ntipmov=:tipo_movimiento,nestado=:estado");
                
                $sql->execute([
                    "costos"=>$cabecera['codigo_costos'],
                    "aprueba"=>$cabecera['codigo_aprueba'],
                    "origen"=>$cabecera['codigo_almacen_origen'],
                    "destino"=>$cabecera['codigo_almacen_destino'],
                    "fecha_traslado"=>$cabecera['fecha'],
                    "tipo_movimiento"=>$cabecera['codigo_movimiento'],
                    "estado"=>1,
                ]);

                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    $mensaje = "Registro insertado";
                    $sw = true;

                    $indice = $this->lastInsertId("SELECT MAX(idreg) AS id FROM alm_transfercab");
                    $this->insertarDetalles($indice,$detalles);

                    if ( $this->verificarAtendidos($pedido) == 0 ){
                       $this->actualizarCabeceraPedido($pedido);
                    }
                }

                return array("mensaje"=>$mensaje,
                             "estado"=>$sw,
                             "documento"=>str_pad($indice,4,8,STR_PAD_LEFT));
                
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function insertarDetalles($indice,$detalles){
            $datos = json_decode($detalles);
            $nreg = count($datos);

            for ($i=0; $i < $nreg; $i++) { 
               try {

                    $sql = $this->db->connect()->prepare("INSERT INTO alm_transferdet 
                                                                SET idtransfer=:transferencia,iddetped=:iditem,
                                                                    idcprod=:producto,ncanti=:cantidad,nflgactivo=:activo,
                                                                    nEstadoReg=:estado,cobserva=:observa,
                                                                    idPedido=:pedido,idcostos=:costos");
                    
                    $sql->execute(["transferencia"=>$indice,
                        "iditem"=>$datos[$i]->iditem,
                        "producto"=>$datos[$i]->idprod,
                        "cantidad"=>$datos[$i]->cantidad,
                        "activo"=>1,
                        "estado"=>52,
                        "observa"=>$datos[$i]->obser,
                        "pedido"=>$datos[$i]->pedido,
                        "costos"=>$datos[$i]->costos]);

                    if ( $datos[$i]->aprobado == ( $datos[$i]->comprado + $datos[$i]->cantidad ) ){
                        $this->actualizarDetallesPedido($datos[$i]->iditem,$datos[$i]->cantidad);
                    }
                } catch (PDOException $th) {
                    echo $th->getMessage();
                    return false;
                }
            }
        }

        private function actualizarDetallesPedido($item,$cantidad){
            try {
                $sql = $this->db->connect()->prepare("UPDATE tb_pedidodet 
                                                        SET tb_pedidodet.estadoItem = 52,
                                                            tb_pedidodet.cant_atend = :cantidad
                                                        WHERE tb_pedidodet.iditem =:item");
                $sql->execute(["item"=>$item,
                                "cantidad"=>$cantidad]);

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function verificarAtendidos($pedido){
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                            COUNT( tb_pedidodet.estadoItem ) AS pendientes 
                                                        FROM
                                                            tb_pedidodet 
                                                        WHERE
                                                            tb_pedidodet.estadoItem = 54 
                                                            AND tb_pedidodet.idpedido =:pedido");
                $sql->execute(["pedido"=>$pedido]);
                $result = $sql->fetchAll();

                return $result[0]['pendientes'];
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function actualizarCabeceraPedido($pedido){
            try {
                $sql = $this->db->connect()->prepare("UPDATE tb_pedidocab 
                                                        SET tb_pedidocab.estadodoc = 52
                                                        WHERE tb_pedidocab.idreg=:pedido");
                $sql->execute(["pedido"=>$pedido]);

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }
    }
?>