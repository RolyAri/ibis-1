<?php
    class TimmttoModel extends Model{

        public function __construct()
        {
            parent::__construct();
        }

        public function listarMantenimientos($costos,$serie){

            $cc = $costos != -1 ? $costos : "%";
            $serie = $serie != "" ? $serie : "%";

            try {
                $docData = [];

                $sql = $this->db->connect()->prepare("SELECT
                                                        ibis.ti_mmttos.idreg,
                                                        ibis.ti_mmttos.fentrega AS entrega,
                                                        UPPER( ibis.cm_producto.cdesprod ) AS cdesprod,
                                                        ibis.tb_proyectos.ccodproy,
                                                        ibis.tb_proyectos.nidreg,
                                                        UPPER(ibis.ti_mmttos.cserie) AS cserie,
                                                        ibis.ti_mmttos.nrodoc,
                                                        DATEDIFF(
                                                            ibis.ti_mmttos.fmtto,
                                                        NOW()) AS periodo,
                                                        DATE_FORMAT( ibis.ti_mmttos.fmtto, '%d/%m/%Y' ) AS fmtto1,
                                                        DATE_FORMAT( ibis.ti_mmttos.fentrega, '%d/%m/%Y' ) AS fentrega,
                                                        ibis.ti_mmttos.flgestado AS est1,
                                                        DATE_FORMAT( m2.fmtto, '%d/%m/%Y' ) AS fmtto2,
                                                        m2.flgestado AS est2,
                                                        DATE_FORMAT( m3.fmtto, '%d/%m/%Y' ) AS fmtto3,
                                                        m3.flgestado AS est3,
                                                        DATE_FORMAT( m4.fmtto, '%d/%m/%Y' ) AS fmtto4,
                                                        m4.flgestado AS est4,
                                                        ibis.tb_tiespec.cprocesador,
                                                        ibis.tb_tiespec.cram,
                                                        ibis.tb_tiespec.chdd,
                                                        ibis.tb_tiespec.totros
                                                    FROM
                                                        ibis.ti_mmttos
                                                        LEFT JOIN ibis.cm_producto ON ti_mmttos.idprod = cm_producto.id_cprod
                                                        LEFT JOIN ibis.tb_proyectos ON ibis.ti_mmttos.idcostos = ibis.tb_proyectos.nidreg
                                                        LEFT JOIN ( SELECT ti_mmttos.fmtto, ti_mmttos.flgestado, ti_mmttos.cserie FROM ti_mmttos WHERE ti_mmttos.nmtto = 2 ) AS m2 ON m2.cserie = ti_mmttos.cserie
                                                        LEFT JOIN ( SELECT ti_mmttos.fmtto, ti_mmttos.flgestado, ti_mmttos.cserie FROM ti_mmttos WHERE ti_mmttos.nmtto = 3 ) AS m3 ON m3.cserie = ti_mmttos.cserie
                                                        LEFT JOIN ( SELECT ti_mmttos.fmtto, ti_mmttos.flgestado, ti_mmttos.cserie FROM ti_mmttos WHERE ti_mmttos.nmtto = 4 ) AS m4 ON m4.cserie = ti_mmttos.cserie
                                                        LEFT JOIN ibis.tb_tiespec ON ibis.tb_tiespec.cserie = ibis.ti_mmttos.cserie COLLATE utf8_unicode_ci
                                                    WHERE
                                                        ibis.ti_mmttos.flgactivo = 1 
                                                        AND ibis.tb_proyectos.nidreg LIKE :costos 
                                                        AND ibis.ti_mmttos.cserie LIKE :serie 
                                                    GROUP BY
                                                        ibis.ti_mmttos.nrodoc,
                                                        ibis.ti_mmttos.cserie");
                                                    
                $sql->execute(["costos" =>$cc,
                                "serie" =>$serie]);
                $rowCount = $sql->rowCount();
                
                if ($rowCount) {
                    $respuesta = true;
                    $i = 0;
                    
                    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $docData[] = $row;
                    }
                }

                return array("datos"=>$docData,"usuarios"=>$this->usuariosAquarius());

                
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function usuariosAquarius(){
            try {
                $docData = [];

                $sql = $this->db->connect()->query("SELECT
                                                        rrhh.tabla_aquarius.dni,
                                                        CONCAT_WS( ' ', rrhh.tabla_aquarius.nombres, rrhh.tabla_aquarius.apellidos ) AS usuario,
                                                        rrhh.tabla_aquarius.correo 
                                                    FROM
                                                        rrhh.tabla_aquarius 
                                                    WHERE
                                                        rrhh.tabla_aquarius.estado = 'AC' 
                                                    GROUP BY
                                                        rrhh.tabla_aquarius.dni 
                                                    ORDER BY
                                                        rrhh.tabla_aquarius.dni");
                $sql->execute();
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                    $docData[] = $row;
                }

                return $docData;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function registrarMmtto($parametros){
            try {
                $docData = [];
                $respuesta = false;
                $mensaje = "el equipo ya esta registrado";

                if ( !$this->existeSerie($parametros['serie_producto']) ) {
                    $this->grabarEspecificaciones($parametros);

                    $mensaje = "Equipo registrado";
                    $respuesta = true;
                }

                if ($parametros['tipo_mmtto'] === "1"){

                    $respuesta = "mantenimiento programado";
                    $sql = $this->db->connect()->prepare("UPDATE ti_mmttos 
                                                        SET ti_mmttos.frelmtto =:fecha,
                                                            ti_mmttos.flgestado =:estado,
                                                            ti_mmttos.iduser =:user,
                                                            ti_mmttos.cobserva =:observa 
                                                        WHERE ti_mmttos.idreg =:id
                                                            LIMIT 1");
                    $sql->execute(["fecha"      =>$parametros['fmmto'],
                                    "estado"    =>1,
                                    "user"      =>$parametros['user'],
                                    "observa"   =>$parametros['observa'],
                                    "id"        =>$parametros['lastMmtto']]);
                    if ( $sql->rowCount() > 0){
                        $respuesta = true;

                       /* $this->envio_correo_mantenimiento($parametros['correo'],
                                                        $parametros['tecnico'],
                                                        $parametros['correo_tecnico'],
                                                        $parametros['observa'],
                                                        $parametros['fmmto'],
                                                        $parametros['asignado']);*/
                    }
                }else {
                    $respuesta = "otro mantenimiento";
                    $sql = $this->db->connect()->prepare("INSERT ti_mmttos 
                                                            SET ti_mmttos.nrodoc =:documento,
                                                                ti_mmttos.idprod =:producto,
                                                                ti_mmttos.cserie  =:serie,
                                                                ti_mmttos.cobserva =:observa,
                                                                ti_mmttos.ntipo =:tipo,
                                                                ti_mmttos.idcostos =:costos,
                                                                ti_mmttos.iduser =:usuario,
                                                                ti_mmttos.frelmtto =:fecha,
                                                                ti_mmttos.flgestado =:estado");

                    $sql->execute(["documento"  =>$parametros['documento_usuario'],
                                    "producto"  =>$parametros['codigo_producto'],
                                    "serie"     =>$parametros['serie_producto'],
                                    "observa"   =>$parametros['observa'],
                                    "tipo"      =>$parametros['tipo_mmtto'],
                                    "costos"    =>$parametros['codigo_costos'],
                                    "usuario"   =>$parametros['user'],
                                    "fecha"     =>$parametros['fmmto'],
                                    "estado"    =>1]);

                    if ( $sql->rowCount() > 0){
                        $respuesta = true;

                        /*$this->envio_correo_mantenimiento($parametros['correo'],
                                            $parametros['tecnico'],
                                            $parametros['correo_tecnico'],
                                            $parametros['observa'],
                                            $parametros['fmmto'],
                                            $parametros['asignado']);*/
                    }
                }

                return array("respuesta"=>$respuesta);

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function mantenimientosAnteriores($parametros){
            $docData = [];

            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                    DATE_FORMAT(ti_mmttos.frelmtto,'%d/%m/%Y') AS frelmtto,
                                                    UPPER( ti_mmttos.cobserva ) AS cobserva,
                                                    tb_user.cnombres AS tecnico 
                                                FROM
                                                    ti_mmttos
                                                    LEFT JOIN tb_user ON ti_mmttos.iduser = tb_user.iduser COLLATE utf8_unicode_ci 
                                                WHERE
                                                    ti_mmttos.nrodoc =:documento 
                                                    AND ti_mmttos.cserie =:serie
                                                AND ti_mmttos.flgestado = 1");

                $sql->execute(["documento"=>$parametros['documento'],
                                "serie"=>$parametros['serie']]);
                $rowCount = $sql->rowCount();
                
                if ($rowCount) {
                    $respuesta = true;
                    
                    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $docData[] = $row;
                    }
                }

                $pendientes = $this->mmttoUltimoPendiente($parametros['serie'],$parametros['documento']);
                $detallesEquipos = $this->detallesEquipos($parametros['serie']);
        
                return array("mmttos" =>$docData,"lastmmttos" =>$pendientes, "especificaciones" => $detallesEquipos);

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function detallesEquipos($serie){
            try {
                $docData = [];

                $sql = $this->db->connect()->prepare("SELECT tb_tiespec.cprocesador, 
                                                            tb_tiespec.cram, 
                                                            tb_tiespec.chdd, 
                                                            tb_tiespec.nestado
                                                        FROM tb_tiespec
                                                        WHERE  tb_tiespec.cserie = :serie");

                $sql->execute(["serie"=>$serie]);

                $rowCount = $sql->rowCount();
                
                if ($rowCount) {
                    $respuesta = true;
                    
                    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $docData[] = $row;
                    }
                }

                return $docData;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function envio_correo_mantenimiento($correo,$tecnico,$correo_tecnico,$observa,$fecha,$asignado){
            try {
                require_once("public/PHPMailer/PHPMailerAutoload.php");
                $subject    = utf8_decode("Mantenimiento de equipo");

                $messaje= '<div style="width:100%;display: flex;flex-direction: column;justify-content: center;align-items: center;
                                    font-family: Futura, Arial, sans-serif;">
                            <div style="width: 45%;border: 1px solid #c2c2c2;background: #0078D4">
                                <h1 style="text-align: center;font-size:24px">Mantenimento de Equipo</h1>
                            </div>
                            <div style="width: 45%;
                                        border-left: 1px solid #c2c2c2;
                                        border-right: 1px solid #c2c2c2;
                                        border-bottom: 1px solid #c2c2c2;">
                                <p style="padding:.5rem"><strong style="font-style: italic;">Estimado(a):</strong></p>
                                <p style="padding:.5rem;line-height: 1rem;">El presente correo es para informar que se ha realizado el mantenimiento de su equipo</p>
                                <p style="padding:.5rem">Realizado el dia : '. $fecha.'</p>
                                <br><br>
                                <p style="padding:.5rem">Atte: '. $tecnico .'</p>
                            </div>
                        </div>';
                
                $origen = $correo_tecnico;
                $nombre_envio = $tecnico;

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
                $mail->addAddress($correo,$asignado);
                $mail->addAddress($origen,$nombre_envio);

                $mail->Subject = $subject;
                $mail->msgHTML(utf8_decode($messaje));
   
                if (!$mail->send()) {
                    return array("mensaje"=>"Hubo un error, en el envio",
                                "clase"=>"mensaje_error");
                }
                        
                $mail->clearAddresses();

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function enviarNotificacion($parametros){
            try {
                require_once("public/PHPMailer/PHPMailerAutoload.php");

                $respuesta = false;
                $fechaActual = date('Y-m-d');

                $subject    = utf8_decode("Notificación de Mantenimiento de Preventivo");

                $messaje= '<div style="width:100%;display: flex;flex-direction: column;justify-content: center;align-items: center;
                                    font-family: Futura, Arial, sans-serif;">
                            <div style="width: 70%;border: 1px solid #c2c2c2;background: #0078D4">
                                <h3 style="text-align: center;font-size:12px">MANTENIMIENTO PREVENTIVO DE EQUIPOS INFORMÁTICOS</h3>
                            </div>
                            <div style="width: 70%;
                                        border-left: 1px solid #c2c2c2;
                                        border-right: 1px solid #c2c2c2;
                                        border-bottom: 1px solid #c2c2c2;">
                                <p style="padding:.5rem"><strong style="font-style: italic;">Estimado(a):</strong>'.$parametros['usuario'].'</p>
                                <p style="padding:.5rem;line-height: 1rem;">Acorde a la programación semestral de mantenimientos preventivos, su equipo asignado debe ser puesto a disposición del área de T&I para su respectiva atención. </p>
                                <p style="padding:.5rem">El equipo de T&I se estará contactando para programar la fecha exacta del mantenimiento acorde a su disponibilidad.</p>
                                <p style="padding:.5rem">Recordar que es responsabilidad del usuario conservar en buen estado las herramientas, el equipo de oficina, útiles y demás bienes de la organización- En caso de que la pérdida o deterioro de tales bienes hubiera sido causada por negligencia debidamente comprobada de parte del trabajador, este deberá reponerlos, sin perjuicio de las sanciones disciplinarias que puedan corresponder. (PSPC-900-X-RG-002 Reglamento Interno de Trabajo).</p>
                                <br><br>
                                <p style="padding:.5rem">Se agradece su colaboración</p>
                                <br><br>
                                <p style="padding:.5rem">Saludos Cordiales.</p>
                            </div>
                        </div>';
                

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

                $mail->setFrom("ti@sepcon.net",utf8_encode("Dpto. Tecnologia Informatica"));
                $mail->addAddress($parametros['correo'],$parametros['usuario']);


                $mail->Subject = $subject;
                $mail->msgHTML(utf8_decode($messaje));
   
                if (!$mail->send()) {
                    return array("mensaje"=>"Hubo un error, en el envio",
                                "clase"=>"mensaje_error");
                }else{
                    $sql = $this->db->connect()->prepare("UPDATE ti_mmttos
                                                            SET ti_mmttos.fnotify =:fechaActual
                                                            WHERE ti_mmttos.idreg =:id");

                    $sql->execute(["fechaActual"=>$fechaActual,"id"=>$parametros['id']]);

                    $respuesta = true;
                }
                        
                $mail->clearAddresses();

                return array("respuesta"=>$respuesta);

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function existeSerie($serie){
            try {
                $respuesta = false;

                $sql = $this->db->connect()->prepare("SELECT 
                                                        tb_tiespec.idreg 
                                                    FROM  
                                                        tb_tiespec 
                                                    WHERE 
                                                        tb_tiespec.cserie =:serie");
                $sql->execute(["serie"=>$serie]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0){
                    $respuesta = true;
                }

                return $respuesta;

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function grabarEspecificaciones($parametros){
            try {
                $respuesta = false;

                $sql = $this->db->connect()->prepare("INSERT INTO 
                                                        tb_tiespec 
                                                      SET 
                                                        tb_tiespec.idkardex =:kardex,
                                                        tb_tiespec.cserie =:serie,
                                                        tb_tiespec.cprocesador =:procesador,
                                                        tb_tiespec.cram =:ram,
                                                        tb_tiespec.chDd =:hdd,
                                                        tb_tiespec.totros =:otros,
                                                        tb_tiespec.nestado =:estado");

                $sql->execute(["kardex" =>$parametros['id'],
                                "serie"=>$parametros['serie_producto'],
                                "procesador"=>$parametros['procesador'],
                                "ram"=>$parametros['ram'],
                                "hdd"=>$parametros['hdd'],
                                "otros"=>$parametros['otros'],
                                "estado"=>$parametros['estado']]);

                if( $sql->rowCount() > 0){
                    $respuesta = true;
                }

                return $respuesta;

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function actualizarFechas($parametros){
            try {
                $fecha = $parametros['fecha'];
                $serie = $parametros['serie'];
                $documento = $parametros['documento'];
                $nuevas_fechas = [];
                $fmmtto = 1;

                $lapso = array("+6 month","+12 month","+18 month","+24 month");

                for ($i = 0; $i < 4 ; $i++) {
                    $nuevas_fechas[$i] = $this->calcularProximos($fecha,$lapso[$i]);

                    $sql = $this->db->connect()->prepare("UPDATE ti_mmttos 
                                                         SET ti_mmttos.fmtto =:fecha,
                                                             ti_mmttos.fentrega =:entrega
                                                         WHERE ti_mmttos.nrodoc =:documento 
                                                                AND ti_mmttos.cserie =:serie
                                                                AND ti_mmttos.nmtto =:mmtto
                                                        LIMIT 1");
                    
                    $sql->execute(["fecha"=>$nuevas_fechas[$i],
                                    "entrega"=>$fecha,
                                    "documento"=>$documento,
                                    "serie"=>$serie,
                                    "mmtto"=>$fmmtto++]);

                } 

                return array("nuevas_fechas"=>$nuevas_fechas);
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function calcularProximos($fecha,$meses){
            $nuevafecha = date("Y-m-d",strtotime($fecha.$meses));
	 
		    return $nuevafecha;
        }

        private function mmttoUltimoPendiente($serie,$documento){
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                        ti_mmttos.idreg,
                                                        ti_mmttos.cserie,
                                                        ti_mmttos.nrodoc,
                                                        DATE_FORMAT(MIN(ti_mmttos.fmtto),'%d/%m/%Y') as fecha_proxima 
                                                    FROM
                                                        ti_mmttos 
                                                    WHERE
                                                        ti_mmttos.cserie = :serie 
                                                        AND ti_mmttos.nrodoc = :documento 
                                                        AND ti_mmttos.ntipo = 1
                                                        AND ti_mmttos.flgactivo = 1
                                                        AND ti_mmttos.flgestado = 0");
                
                $sql->execute(["serie"=>$serie,"documento"=>$documento]);
                $return = $sql->fetchAll();

                return array("serie"=>$return[0]['cserie'],
                            "id"=>$return[0]['idreg'],
                            "fecha_proxima"=>$return[0]['fecha_proxima']);

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }
    }
?>