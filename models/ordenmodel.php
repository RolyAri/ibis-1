<?php
    class OrdenModel extends Model{

        public function __construct(){
            parent::__construct();
        }

        public function listarOrdenes($user){
           try {
                $salida = "";
                $sql = $this->db->connect()->prepare("SELECT
                                                        tb_costusu.ncodcos,
                                                        tb_costusu.ncodproy,
                                                        tb_costusu.id_cuser,
                                                        lg_ordencab.id_regmov,
                                                        lg_ordencab.cnumero,
                                                        lg_ordencab.ffechadoc,
                                                        lg_ordencab.nNivAten,
                                                        lg_ordencab.nEstadoDoc,
                                                        lg_ordencab.ncodpago,
                                                        lg_ordencab.nplazo,
                                                        lg_ordencab.cdocPDF,
                                                        UPPER( tb_pedidocab.concepto ) AS concepto,
                                                        UPPER( tb_pedidocab.detalle ) AS detalle,
                                                        UPPER(
                                                        CONCAT_WS( tb_area.ccodarea, tb_area.cdesarea )) AS area,
                                                        UPPER(
                                                        CONCAT_WS( tb_proyectos.ccodproy, tb_proyectos.cdesproy )) AS costos,
                                                        lg_ordencab.nfirmaLog,
                                                        lg_ordencab.nfirmaFin,
                                                        lg_ordencab.nfirmaOpe,
                                                        tb_parametros.cdescripcion AS atencion 
                                                    FROM
                                                        tb_costusu
                                                        INNER JOIN lg_ordencab ON tb_costusu.ncodproy = lg_ordencab.ncodpry
                                                        INNER JOIN tb_pedidocab ON lg_ordencab.id_refpedi = tb_pedidocab.idreg
                                                        INNER JOIN tb_area ON lg_ordencab.ncodarea = tb_area.ncodarea
                                                        INNER JOIN tb_proyectos ON lg_ordencab.ncodpry = tb_proyectos.nidreg
                                                        INNER JOIN tb_parametros ON lg_ordencab.nNivAten = tb_parametros.nidreg 
                                                    WHERE
                                                        tb_costusu.id_cuser = :user 
                                                        AND tb_costusu.nflgactivo = 1
                                                        AND lg_ordencab.nEstadoDoc BETWEEN 49 AND 59");
                $sql->execute(["user"=>$_SESSION['iduser']]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()) {

                        $log = is_null($rs['nfirmaLog']) ? '<i class="far fa-square"></i>' : '<i class="far fa-check-square"></i>';
                        $ope = is_null($rs['nfirmaOpe']) ? '<i class="far fa-square"></i>' : '<i class="far fa-check-square"></i>';
                        $fin = is_null($rs['nfirmaFin']) ? '<i class="far fa-square"></i>' : '<i class="far fa-check-square"></i>';

                        $flog = is_null($rs['nfirmaLog']) ? 0 : 1;
                        $fope = is_null($rs['nfirmaOpe']) ? 0 : 1;
                        $ffin = is_null($rs['nfirmaFin']) ? 0 : 1;

                        $resaltado = $rs['nEstadoDoc'] == 59 ? "resaltado_firma" :  "";


                        $salida .='<tr class="pointer '.$resaltado.'" data-indice="'.$rs['id_regmov'].'" 
                                                        data-estado="'.$rs['nEstadoDoc'].'"
                                                        data-finanzas="'.$ffin.'"
                                                        data-logistica="'.$flog.'"
                                                        data-operaciones="'.$fope.'">
                                    <td class="textoCentro">'.str_pad($rs['cnumero'],6,0,STR_PAD_LEFT).'</td>
                                    <td class="textoCentro">'.date("d/m/Y", strtotime($rs['ffechadoc'])).'</td>
                                    <td class="pl20px">'.$rs['concepto'].'</td>
                                    <td class="pl20px">'.utf8_decode($rs['costos']).'</td>
                                    <td class="pl20px">'.$rs['area'].'</td>
                                    <td class="textoCentro '.strtolower($rs['atencion']).'">'.$rs['atencion'].'</td>
                                    <td class="textoCentro">'.$log.'</td>
                                    <td class="textoCentro">'.$ope.'</td>
                                    <td class="textoCentro">'.$fin.'</td>
                                    </tr>';
                    }
                }

                return $salida;                    
           } catch (PDOException $th) {
               echo "Error: " . $th->getMessage();
               return false;
           }
        }

        public function importarPedidos(){
            try {
                $salida = "";
                $sql = $this->db->connect()->prepare("SELECT
                                                        tb_pedidodet.idpedido,
                                                        FORMAT(tb_pedidodet.cant_aprob, 2) AS cantidad,
                                                        FORMAT(tb_pedidodet.cant_resto, 2) AS saldo,
                                                        FORMAT(tb_pedidodet.precio, 2) AS precio,
                                                        FORMAT(tb_pedidodet.cant_pedida,2) AS cantidad_pedida,
                                                        tb_pedidodet.igv,
                                                        FORMAT(tb_pedidodet.total, 2) AS total,
                                                        tb_pedidodet.estadoItem,
                                                        UPPER(
                                                            CONCAT_WS(
                                                                ' ',
                                                                cm_producto.cdesprod,
                                                                tb_pedidodet.observaciones
                                                            )
                                                        ) AS cdesprod,
                                                        cm_producto.ccodprod,
                                                        cm_producto.id_cprod,
                                                        tb_unimed.ncodmed,
                                                        tb_unimed.cabrevia AS unidad,
                                                        UPPER(tb_proyectos.cdesproy) AS costos,
                                                        tb_area.ncodarea,
                                                        UPPER(tb_area.cdesarea) AS area,
                                                        tb_pedidodet.iditem,
                                                        tb_pedidodet.idcostos,
                                                        tb_pedidodet.idarea,
                                                        tb_pedidocab.idreg,
                                                        LPAD(tb_pedidocab.nrodoc,6,0) AS nrodoc,
                                                        tb_pedidocab.emision,
                                                        tb_pedidocab.concepto,
                                                        tb_pedidodet.entidad,
                                                        tb_pedidodet.total AS total_numero
                                                    FROM
                                                        tb_costusu
                                                    INNER JOIN tb_pedidodet ON tb_costusu.ncodproy = tb_pedidodet.idcostos
                                                    INNER JOIN cm_producto ON tb_pedidodet.idprod = cm_producto.id_cprod
                                                    INNER JOIN tb_unimed ON tb_pedidodet.unid = tb_unimed.ncodmed
                                                    INNER JOIN tb_proyectos ON tb_pedidodet.idcostos = tb_proyectos.nidreg
                                                    INNER JOIN tb_area ON tb_pedidodet.idarea = tb_area.ncodarea
                                                    INNER JOIN tb_pedidocab ON tb_pedidodet.idpedido = tb_pedidocab.idreg
                                                    WHERE
                                                        tb_costusu.nflgactivo = 1
                                                    AND tb_costusu.id_cuser = :user
                                                    AND tb_pedidodet.estadoItem = 54
                                                    AND tb_pedidodet.idasigna = :user_asigna
                                                    AND tb_pedidodet.nflgOrden = 0
                                                    AND (tb_pedidodet.cant_aprob > 0 OR ISNULL(tb_pedidodet.cant_aprob))");

            //se cambia el 58 para llama los items directo con aprobacion
                $sql->execute(["user"=>$_SESSION['iduser'],
                                "user_asigna"=>$_SESSION['iduser']]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()) {

                        //hace los cálculos de los saldos 
                        $cantidad = $this->obtenerCantidades($rs['idpedido'],$rs['iditem']);
                        $cant = $cantidad == null  ? $rs['cantidad_pedida'] : $rs['cantidad_pedida']-$cantidad;
                       
                        $salida .='<tr class="pointer" data-pedido="'.$rs['idpedido'].'"
                                                       data-entidad="'.$rs['entidad'].'"
                                                       data-unidad="'.$rs['unidad'].'"
                                                       data-cantidad ="'.$cant.'"
                                                       data-total="'.$rs['total_numero'].'"
                                                       data-codprod="'.$rs['id_cprod'].'"
                                                       data-iditem="'.$rs['iditem'].'"
                                                       data-costos="'.$rs['idcostos'].'"
                                                       data-itord="-">
                                                       data-nropedido="">
                                        <td class="textoCentro">'.str_pad($rs['nrodoc'],6,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.date("d/m/Y", strtotime($rs['emision'])).'</td>
                                        <td class="pl5px">'.$rs['concepto'].'</td>
                                        <td class="pl5px">'.$rs['area'].'</td>
                                        <td class="pl5px">'.$rs['costos'].'</td>
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl5px">'.$rs['cdesprod'].'</td>
                                    </tr>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function obtenerCantidades($pedido,$item){
            try {
                $sql = $this->db->connect()->prepare("SELECT SUM(lg_ordendet.ncanti) 
                                                        AS resto 
                                                        FROM lg_ordendet 
                                                        WHERE lg_ordendet.niddeta = :item 
                                                            AND lg_ordendet.nidPedi=:pedido
                                                            AND ISNULL(lg_ordendet.nflgactivo)");
                $sql->execute(["pedido"=>$pedido,"item"=>$item]);
                $result = $sql->fetchAll();

                return $result[0]['resto'];
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            } 
        }

        public function verDatosCabecera($pedido){
            $datosPedido = $this->datosPedido($pedido);
            
            $api = file_get_contents('https://api.apis.net.pe/v1/tipo-cambio-sunat');
            $cambio = json_decode($api);

            $numero = $this->generarNumeroOrden();

            $salida = array("pedido"=>$datosPedido,
                            "orden"=>str_pad($numero,6,0,STR_PAD_LEFT),
                            "cambio"=>$cambio->compra);

            return $salida;
        }

        public function insertarOrden($cabecera,$detalles,$comentarios,$adjuntos){
            try {
                $salida = false;
                $respuesta = false;
                $mensaje = "Error en el registro";
                $clase = "mensaje_error";
                $cab = json_decode($cabecera);

                $sql = "SELECT COUNT(lg_ordencab.id_regmov) AS numero FROM lg_ordencab WHERE lg_ordencab.ncodcos = :cod";
                
                $entrega = $this->calcularDias($cab->fentrega);
            
                $orden = $this->generarNumeroOrden();
                
                $periodo = explode('-',$cab->emision);

                $this->subirArchivos($orden,$adjuntos);
                
                $sql = $this->db->connect()->prepare("INSERT INTO lg_ordencab SET id_refpedi=:pedi,cper=:anio,cmes=:mes,ntipmov=:tipo,cnumero=:orden,
                                                                                ffechadoc=:fecha,ffechaent=:entrega,id_centi=:entidad,ncodmon=:moneda,ntcambio=:tcambio,
                                                                                nigv=:igv,ntotal=:total,ncodpry=:proyecto,ncodcos=:ccostos,ncodarea=:area,
                                                                                ctiptransp=:transporte,id_cuser=:elabora,ncodpago=:pago,nplazo=:pentrega,cnumcot=:cotizacion,
                                                                                cdocPDF=:adjunto,nEstadoDoc=:est,ncodalm=:almacen,nflgactivo=:flag,nNivAten=:atencion,
                                                                                cverificacion=:verif,cObservacion=:observacion");

                $sql ->execute(["pedi"=>$cab->codigo_pedido,
                                "anio"       =>$periodo[0],
                                "mes"        =>$periodo[1],
                                "tipo"       =>$cab->codigo_tipo,
                                "orden"      =>$orden,
                                "fecha"      =>$cab->emision,
                                "entrega"    =>$cab->fentrega,
                                "entidad"    =>$cab->codigo_entidad,
                                "moneda"     =>$cab->codigo_moneda,
                                "tcambio"    =>$cab->tcambio,
                                "igv"        =>$cab->radioIgv,
                                "total"      =>$cab->total_numero,
                                "proyecto"   =>$cab->codigo_costos,
                                "ccostos"    =>$cab->codigo_costos,
                                "area"       =>$cab->codigo_area,
                                "transporte" =>$cab->codigo_transporte,
                                "elabora"    =>$_SESSION['iduser'],
                                "pago"       =>$cab->codigo_pago,
                                "pentrega"   =>$entrega,
                                "cotizacion" =>$cab->proforma,
                                "adjunto"    =>$cab->vista_previa,
                                "est"        =>49,
                                "almacen"    =>$cab->codigo_almacen,
                                "flag"       =>1,
                                "atencion"   =>$cab->nivel_atencion,
                                "verif"      =>$cab->codigo_verificacion,
                                "cotizacion" =>$cab->ncotiz,
                                "observacion"=>$cab->concepto]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0){
                    $this->subirArchivos($orden,$adjuntos);
                    $this->grabarDetalles($cab->codigo_verificacion,$detalles,$cab->codigo_costos,$orden);
                    $this->grabarComentarios($cab->codigo_orden,$comentarios);
                    $this->actualizarDetallesPedido(84,$detalles,$orden,$cab->codigo_entidad);
                    $this->actualizarCabeceraPedido(58,$cab->codigo_pedido,$orden);
                    $respuesta = true;
                    $mensaje = "Orden Grabada";
                    $clase = "mensaje_correcto";
                }

                $salida = array("respuesta"=>$respuesta,
                                "mensaje"=>$mensaje,
                                "clase"=>$clase);

                
                return $salida;

                
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }    
        }

        private function grabarDetalles($codigo,$detalles,$costos,$idx){
            try {
                $indice = $this->obtenerIndice($codigo,"SELECT id_regmov AS numero FROM lg_ordencab WHERE lg_ordencab.cverificacion =:id");
                
                $datos = json_decode($detalles);
                
                $nreg = count($datos);

                for ($i=0; $i < $nreg; $i++) { 
                    if(!$datos[$i]->grabado) {
                        $sql = $this->db->connect()->prepare("INSERT INTO lg_ordendet SET id_regmov=:id,niddeta=:nidp,id_cprod=:cprod,ncanti=:cant,
                                                                                    nunitario=:unit,nigv=:igv,ntotal=:total,
                                                                                    nestado=:est,cverifica=:verif,nidpedi=:pedido,
                                                                                    nmonref=:moneda,ncodcos=:costos,id_orden=:ordenidx,
                                                                                    nSaldo=:saldo,cobserva=:detalles");
                        $sql->execute(["id"=>$indice,
                                        "nidp"=>$datos[$i]->itped,
                                        "pedido"=>$datos[$i]->refpedi,
                                        "cprod"=>$datos[$i]->codprod,
                                        "cant"=>$datos[$i]->cantidad,
                                        "unit"=>$datos[$i]->precio,
                                        "igv"=>$datos[$i]->igv,
                                        "total"=>$datos[$i]->total,
                                        "est"=>1,
                                        "verif"=>$codigo,
                                        "moneda"=>$datos[$i]->moneda,
                                        "costos"=>$costos,
                                        "ordenidx"=>$idx,
                                        "saldo"=>$datos[$i]->cantidad,
                                        "detalles"=>$datos[$i]->detalles]);
                    }//aca poner para la modificacion de ordenes
                    
                }
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function modificarOrden($cabecera,$detalles,$comentarios){
            try {
                $entrega = $this->calcularDias($cabecera['fentrega']);

                $sql = $this->db->connect()->prepare("UPDATE lg_ordencab 
                                                        SET  ffechaent=:entrega,ntotal=:total,ctiptransp=:transp,
                                                             nplazo=:plazo,ncodalm=:alm,nigv =:igv
                                                        WHERE id_regmov = :id");
                $sql->execute(['entrega'=>$cabecera['fentrega'],
                                "total"=>$cabecera['total_numero'],
                                "transp"=>$cabecera['codigo_transporte'],
                                "plazo"=>$entrega,
                                "alm"=>$cabecera['codigo_almacen'],
                                "igv"=>$cabecera['radioIgv'],
                                "id"=>$cabecera['codigo_orden']]);
                
                $this->grabarDetalles($cabecera['codigo_verificacion'],$detalles,$cabecera['codigo_costos'],$cabecera['codigo_orden']);
                $this->grabarComentarios($cabecera['codigo_verificacion'],$comentarios);

                $salida = array("respuesta"=>true,
                                "mensaje"=>"Registro modificado",
                                "clase"=>"mensaje_correcto");

                
                return $salida;

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            } 
        }

        private function actualizarDetallesPedido($estado,$detalles,$orden,$entidad){
            try {
                $datos = json_decode($detalles);
                $nreg = count($datos);

                for ($i=0; $i <$nreg ; $i++) { 
                    if($datos[$i]->cantidad == $datos[$i]->cantped) {
                        $estado = 84;
                        $swOrden = 1;    
                    }else{
                        $estado = 54;
                        $swOrden = 0;
                    }

                    $sql = $this->db->connect()->prepare("UPDATE tb_pedidodet SET 
                                                        estadoItem=:est,
                                                        idorden=:orden,
                                                        nflgOrden=:swOrden, 
                                                        cant_orden=:pendiente WHERE iditem=:item");
                    $sql->execute(["item"=>$datos[$i]->itped,
                                    "est"=>$estado,
                                    "orden"=>$orden,
                                    "swOrden"=>$swOrden,
                                    "pendiente"=>$datos[$i]->cantidad]);
                    
                    $this->registrarOrdenesItems($datos[$i]->itped,$orden,$entidad);                
                }
                
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function actualizarDetallesPedidoCorreo($estado,$detalles){
            try {
                $datos = json_decode($detalles);
                $nreg = count($datos);

                for ($i=0; $i <$nreg ; $i++) { 
                    $sql = $this->db->connect()->prepare("UPDATE tb_pedidodet SET 
                                                        estadoItem=:est WHERE iditem=:item");
                    $sql->execute(["item"=>$datos[$i]->itped,
                                    "est"=>$estado]);
                }
                
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function registrarOrdenesItems($item,$orden,$entidad){
            try {
                $sql = $this->db->connect()->prepare("INSERT INTO tb_itemorden SET item=:item, orden=:orden, entidad=:entidad");
                $sql->execute(["item"=>$item, "orden"=>$orden, "entidad"=>$entidad]);
            } catch (PDOException $th) {
                echo "Error: ". $th->getMessage();
                return false;
            }
        }

        public function subirArchivos($codigo,$adjuntos){
            $countfiles = count( $adjuntos);

            for( $i=0;$i<$countfiles;$i++ ){
                try {
                    $file = "file-".$i;
                    $ext = explode('.',$adjuntos[$file]['name']);
                    $filename = uniqid().".".end($ext);
                    // Upload file
                    if (move_uploaded_file($adjuntos[$file]['tmp_name'],'public/documentos/ordenes/adjuntos/'.$filename)){
                        $sql= $this->db->connect()->prepare("INSERT INTO lg_regdocumento 
                                                                    SET nidrefer=:cod,cmodulo=:mod,cdocumento=:doc,
                                                                        creferencia=:ref,nflgactivo=:est");
                        $sql->execute(["cod"=>$codigo,
                                        "mod"=>"ORD",
                                        "ref"=>$filename,
                                        "doc"=>$adjuntos[$file]['name'],
                                        "est"=>1]);
                    }
                } catch (PDOException $th) {
                    echo "Error: ".$th->getMessage();
                    return false;
                }
            }

        }

        public function enviarCorreo($cabecera,$detalles,$correos,$asunto,$mensaje){
            try {
                require_once("public/PHPMailer/PHPMailerAutoload.php");

                $documento = $this->generarDocumento($cabecera,1,$detalles);

                $data       = json_decode($correos);
                $nreg       = count($data);
                $subject    = utf8_decode($asunto);
                $messaje    = utf8_decode($mensaje);
                $estadoEnvio= false;
                $clase = "mensaje_error";
                $salida = "";
                
                $origen = $_SESSION['user']."@sepcon.net";
                $nombre_envio = $_SESSION['user'];

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
                
                $mail->setFrom($origen,$nombre_envio);

                for ($i=0; $i < $nreg; $i++) {
                    $mail->addAddress($data[$i]->correo,$data[$i]->nombre);
        
                    $mail->Subject = $subject;
                    $mail->msgHTML(utf8_decode($messaje));

                    if (file_exists( 'public/documentos/ordenes/emitidas/'.$documento)) {
                        $mail->AddAttachment('public/documentos/ordenes/emitidas/'.$documento);
                    }
        
                    if (!$mail->send()) {
                        $mensaje = "Mensaje de correo no enviado";
                        $estadoEnvio = false; 
                    }else {
                        $mensaje = "Mensaje de correo enviado";
                        $estadoEnvio = true; 
                    }
                        
                    $mail->clearAddresses();
                }

                if ($estadoEnvio){
                    $clase = "mensaje_correcto";
                    $this->actualizarCabeceraPedido(59,$cabecera['codigo_pedido'],$cabecera['codigo_orden']);
                    $this->actualizarDetallesPedido(59,$detalles,$cabecera['codigo_orden'],$cabecera['codigo_entidad']);
                    $this->actualizarCabeceraOrden(59,$cabecera['codigo_orden']);
                }

                $salida= array("estado"=>$estadoEnvio,
                                "mensaje"=>$mensaje,
                                "clase"=>$clase );

                return $salida;
            
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            } 
        }

        public function enviarCorreoProveedor($cabecera,$detalles){
            try {
                require_once("public/PHPMailer/PHPMailerAutoload.php");

                $documento = $this->generarDocumento($cabecera,2,$detalles);

                $subject    = utf8_decode("Atención de Orden de Compra");
                $messaje    = utf8_decode("Su atención en la orden de compra adjunta");

                $origen = $_SESSION['user']."@sepcon.net";
                $nombre_envio = $_SESSION['user'];
                
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
                
                $mail->setFrom($origen,$nombre_envio);
                $mail->addAddress($cabecera['correo_entidad'],$cabecera['entidad']);

                $mail->Subject = $subject;
                    $mail->msgHTML(utf8_decode($messaje));

                    if (file_exists( 'public/documentos/ordenes/aprobadas/'.$documento)) {
                        $mail->AddAttachment('public/documentos/ordenes/aprobadas/'.$documento);
                    }
        
                    if (!$mail->send()) {
                        return array("mensaje"=>"Hubo un error, en el envio",
                                    "clase"=>"mensaje_error");
                    }else {
                        $this->actualizarCabeceraPedido(60,$cabecera['codigo_pedido'],$cabecera['codigo_orden']);
                        $this->actualizarDetallesPedidoCorreo(60,$detalles);
                        $this->actualizarCabeceraOrden(60,$cabecera['codigo_orden']);
                        return array("mensaje"=>"Correo enviado",
                                    "clase"=>"mensaje_correcto",
                                    "ordenes"=>$this->listarOrdenes($_SESSION['iduser']));
                    }
                        
                    $mail->clearAddresses();


            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            } 
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

        public function datosEntidad($entidad){
            try {
                $sql=$this->db->connect()->prepare("SELECT
                                                    cm_entidad.cnumdoc,
                                                    cm_entidad.crazonsoc,
                                                    UPPER(cm_entidadcon.cnombres) AS contacto,
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
                                                    cm_entidad.cnumdoc = :entidad
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

        /*private function bancosProveedor($entidad){
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
                                                    cm_entidadbco.nflgactivo = 7 
                                                    AND cm_entidadbco.nitem = :entidad");
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
        }*/

        private function actualizarCabeceraPedido($estado,$pedido,$orden){
            try {
                $sql = $this->db->connect()->prepare("UPDATE tb_pedidocab SET estadodoc=:est,idorden=:orden WHERE idreg=:id");
                $sql->execute(["est"=>$estado,
                                "id"=>$pedido,
                                "orden"=>$orden]);
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function actualizarCabeceraOrden($estado,$orden){
            try {
                $sql = $this->db->connect()->prepare("UPDATE lg_ordencab SET nEstadoDoc=:est WHERE id_regmov=:id");
                $sql->execute(["est"=>$estado,
                                "id"=>$orden]);
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function generarNumeroOrden(){
            try {
                $sql = $this->db->connect()->query("SELECT MAX(id_regmov) AS numero FROM lg_ordencab");
                $sql->execute();

                $result = $sql->fetchAll();
                
                return $result[0]['numero']+1;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function ordenesFiltradas($parametros){
            try {
                $salida = "";
                $mes  = date("m")-1;

                $tipo   = $parametros['tipoSearch'] == -1 ? "%" : "%".$parametros['tipoSearch']."%";
                $costos = $parametros['costosSearch'] == -1 ? "%" : "%".$parametros['costosSearch']."%";
                $mes    = $parametros['mesSearch'] == -1 ? $mes :  $parametros['mesSearch'];
                $anio   = $parametros['anioSearch'];

                 $sql = $this->db->connect()->prepare("SELECT
                                                        tb_costusu.ncodcos,
                                                        tb_costusu.ncodproy,
                                                        tb_costusu.id_cuser,
                                                        lg_ordencab.id_regmov,
                                                        lg_ordencab.cnumero,
                                                        lg_ordencab.ffechadoc,
                                                        lg_ordencab.nNivAten,
                                                        lg_ordencab.nEstadoDoc,
                                                        lg_ordencab.ncodpago,
                                                        lg_ordencab.nplazo,
                                                        lg_ordencab.cdocPDF,
                                                        UPPER( tb_pedidocab.concepto ) AS concepto,
                                                        UPPER( tb_pedidocab.detalle ) AS detalle,
                                                        UPPER(
                                                        CONCAT_WS( tb_area.ccodarea, tb_area.cdesarea )) AS area,
                                                        UPPER(
                                                        CONCAT_WS( tb_proyectos.ccodproy, tb_proyectos.cdesproy )) AS costos,
                                                        lg_ordencab.nfirmaLog,
                                                        lg_ordencab.nfirmaFin,
                                                        lg_ordencab.nfirmaOpe,
                                                        tb_parametros.cdescripcion AS atencion,
                                                        lg_ordencab.ntipdoc,
                                                        lg_ordencab.ntipmov 
                                                    FROM
                                                        tb_costusu
                                                        INNER JOIN lg_ordencab ON tb_costusu.ncodproy = lg_ordencab.ncodpry
                                                        INNER JOIN tb_pedidocab ON lg_ordencab.id_refpedi = tb_pedidocab.idreg
                                                        INNER JOIN tb_area ON lg_ordencab.ncodarea = tb_area.ncodarea
                                                        INNER JOIN tb_proyectos ON lg_ordencab.ncodpry = tb_proyectos.nidreg
                                                        INNER JOIN tb_parametros ON lg_ordencab.nNivAten = tb_parametros.nidreg 
                                                    WHERE
                                                        tb_costusu.id_cuser = :user 
                                                        AND tb_costusu.nflgactivo = 1 
                                                        AND lg_ordencab.nEstadoDoc BETWEEN 49 
                                                        AND 59 
                                                        AND lg_ordencab.ncodpry LIKE :costos 
                                                        AND lg_ordencab.ntipmov LIKE :tipomov 
                                                        AND MONTH ( lg_ordencab.ffechadoc ) = :mes
                                                        AND YEAR ( lg_ordencab.ffechadoc ) = :anio");
                $sql->execute(["user"=>$_SESSION['iduser'],
                                "tipomov"=>$tipo,
                                "costos"=>$costos,
                                "mes"=>$mes,
                                "anio"=>$anio]);
                 $rowCount = $sql->rowCount();
 
                 if ($rowCount > 0){
                     while ($rs = $sql->fetch()) {
 
                         $log = is_null($rs['nfirmaLog']) ? '<i class="far fa-square"></i>' : '<i class="far fa-check-square"></i>';
                         $ope = is_null($rs['nfirmaOpe']) ? '<i class="far fa-square"></i>' : '<i class="far fa-check-square"></i>';
                         $fin = is_null($rs['nfirmaFin']) ? '<i class="far fa-square"></i>' : '<i class="far fa-check-square"></i>';
 
                         $flog = is_null($rs['nfirmaLog']) ? 0 : 1;
                         $fope = is_null($rs['nfirmaOpe']) ? 0 : 1;
                         $ffin = is_null($rs['nfirmaFin']) ? 0 : 1;
 
                         $resaltado = $rs['nEstadoDoc'] == 59 ? "resaltado_firma" :  "";
 
 
                         $salida .='<tr class="pointer '.$resaltado.'" data-indice="'.$rs['id_regmov'].'" 
                                                         data-estado="'.$rs['nEstadoDoc'].'"
                                                         data-finanzas="'.$ffin.'"
                                                         data-logistica="'.$flog.'"
                                                         data-operaciones="'.$fope.'">
                                     <td class="textoCentro">'.str_pad($rs['cnumero'],6,0,STR_PAD_LEFT).'</td>
                                     <td class="textoCentro">'.date("d/m/Y", strtotime($rs['ffechadoc'])).'</td>
                                     <td class="pl20px">'.$rs['concepto'].'</td>
                                     <td class="pl20px">'.utf8_decode($rs['costos']).'</td>
                                     <td class="pl20px">'.$rs['area'].'</td>
                                     <td class="textoCentro '.strtolower($rs['atencion']).'">'.$rs['atencion'].'</td>
                                     <td class="textoCentro">'.$log.'</td>
                                     <td class="textoCentro">'.$ope.'</td>
                                     <td class="textoCentro">'.$fin.'</td>
                                     </tr>';
                     }
                 }
 
                 return $salida;                    
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
         }
    }
?>