<?php
    class RepopersoModel extends Model{

        public function __construct()
        {
            parent::__construct();
        }

        public function consultarDatos($doc,$cc) {
            $registrado = false;
            $url = "http://sicalsepcon.net/api/consultapi.php?documento=".$doc;
            
            $api = file_get_contents($url);

            $datos =  json_decode($api);
            $nreg = count($datos);

            $registrado = $nreg > 0 ? true: false;

            return array("datos" => $datos,
                        "registrado"=>$registrado,
                        "anteriores"=>$this->grupoProyectos($doc));
        }

        private function itemsKardex($d,$c){
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
                                                        alm_consumo.ncostos,
                                                        UPPER(cm_producto.cdesprod) AS cdesprod,
                                                        tb_unimed.cabrevia,COUNT(*),
                                                        tb_proyectos.ccodproy,
	                                                    tb_proyectos.cdesproy 
                                                    FROM
                                                        alm_consumo
                                                        LEFT JOIN cm_producto ON alm_consumo.idprod = cm_producto.id_cprod
                                                        LEFT JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed
                                                        INNER JOIN tb_proyectos ON alm_consumo.ncostos = tb_proyectos.nidreg  
                                                    WHERE
                                                        alm_consumo.nrodoc = :documento 
                                                    AND alm_consumo.ncostos = :costos
                                                    
                                                    GROUP BY
                                                            alm_consumo.idprod,
                                                            alm_consumo.fechasalida,
                                                            cm_producto.ccodprod,
                                                            alm_consumo.cantsalida,
                                                            alm_consumo.nhoja
                                                    HAVING COUNT(*) >= 1
                                                    ORDER BY alm_consumo.freg DESC" );
                $sql->execute(["documento"=>$d,"costos"=>$c]);
                $rowCount = $sql->rowCount();
                $item = 1;
                $salida ="";

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()){

                        $marcado = $rs['flgdevolver'] == 1 ? "checked" : "";
                        $firma = "public/documentos/firmas/".$rs['cfirma'].".png";

                        $salida .= '<tr class="pointer" data-grabado="1" 
                                                        data-registrado="1" 
                                                        data-kardex = "'.$rs['nkardex'].'"
                                                        data-firma = "'.$rs['cfirma'].'"
                                                        data-devolucion = "'.$rs['fechadevolucion'].'"
                                                        data-firmadevolucion ="'.$rs['calmacen'].'">
                                        <td class="textoDerecha">'.$rowCount--.'</td>
                                        <td class="pl5px">'.$rs['ccodproy'].'</td>
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

        private function grupoProyectos($d){
            try {
                $salida = "";
                $sql = $this->db->connect()->prepare("SELECT
                                                        UPPER(CONCAT_WS(' ',tb_proyectos.ccodproy,tb_proyectos.cdesproy)) AS proyecto,
                                                        alm_consumo.ncostos 
                                                    FROM
                                                        alm_consumo
                                                        INNER JOIN tb_proyectos ON alm_consumo.ncostos = tb_proyectos.nidreg 
                                                    WHERE
                                                        alm_consumo.nrodoc = :documento
                                                    GROUP BY alm_consumo.ncostos");
                $sql->execute(["documento"=>$d]);
                $rowCount = $sql->rowCount();
                $salida ="";

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()){
                        $salida .= '<tr class="separatortr">
                                        <th class="pl5px" colspan="15">'.$rs['proyecto'].'</th>
                                    </tr>';
                        $salida .= $this->itemsKardex($d,$rs['ncostos']);            
                    }
                }

                return $salida;

            }catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }  
        }

    }
?>