<?php
    setlocale(LC_MONETARY, 'en_US');
    class Model{
        function __construct()
        {
            $this->db = new Database();
        }

        //funcion para convertir numeros
        public function unidad($numuero){
            switch ($numuero)
            {
                case 9:
                {
                    $numu = "NUEVE";
                    break;
                }
                case 8:
                {
                    $numu = "OCHO";
                    break;
                }
                case 7:
                {
                    $numu = "SIETE";
                    break;
                }
                case 6:
                {
                    $numu = "SEIS";
                    break;
                }
                case 5:
                {
                    $numu = "CINCO";
                    break;
                }
                case 4:
                {
                    $numu = "CUATRO";
                    break;
                }
                case 3:
                {
                    $numu = "TRES";
                    break;
                }
                case 2:
                {
                    $numu = "DOS";
                    break;
                }
                case 1:
                {
                    $numu = "UNO";
                    break;
                }
                case 0:
                {
                    $numu = "";
                    break;
                }
            }
            return $numu;
        }
         
        public function decena($numdero){
         
                if ($numdero >= 90 && $numdero <= 99)
                {
                    $numd = "NOVENTA ";
                    if ($numdero > 90)
                        $numd = $numd."Y ".($this->unidad($numdero - 90));
                }
                else if ($numdero >= 80 && $numdero <= 89)
                {
                    $numd = "OCHENTA ";
                    if ($numdero > 80)
                        $numd = $numd."Y ".($this->unidad($numdero - 80));
                }
                else if ($numdero >= 70 && $numdero <= 79)
                {
                    $numd = "SETENTA ";
                    if ($numdero > 70)
                        $numd = $numd."Y ".($this->unidad($numdero - 70));
                }
                else if ($numdero >= 60 && $numdero <= 69)
                {
                    $numd = "SESENTA ";
                    if ($numdero > 60)
                        $numd = $numd."Y ".($this->unidad($numdero - 60));
                }
                else if ($numdero >= 50 && $numdero <= 59)
                {
                    $numd = "CINCUENTA ";
                    if ($numdero > 50)
                        $numd = $numd."Y ".($this->unidad($numdero - 50));
                }
                else if ($numdero >= 40 && $numdero <= 49)
                {
                    $numd = "CUARENTA ";
                    if ($numdero > 40)
                        $numd = $numd."Y ".($this->unidad($numdero - 40));
                }
                else if ($numdero >= 30 && $numdero <= 39)
                {
                    $numd = "TREINTA ";
                    if ($numdero > 30)
                        $numd = $numd."Y ".($this->unidad($numdero - 30));
                }
                else if ($numdero >= 20 && $numdero <= 29)
                {
                    if ($numdero == 20)
                        $numd = "VEINTE ";
                    else
                        $numd = "VEINTI".($this->unidad($numdero - 20));
                }
                else if ($numdero >= 10 && $numdero <= 19)
                {
                    switch ($numdero){
                    case 10:
                    {
                        $numd = "DIEZ ";
                        break;
                    }
                    case 11:
                    {
                        $numd = "ONCE ";
                        break;
                    }
                    case 12:
                    {
                        $numd = "DOCE ";
                        break;
                    }
                    case 13:
                    {
                        $numd = "TRECE ";
                        break;
                    }
                    case 14:
                    {
                        $numd = "CATORCE ";
                        break;
                    }
                    case 15:
                    {
                        $numd = "QUINCE ";
                        break;
                    }
                    case 16:
                    {
                        $numd = "DIECISEIS ";
                        break;
                    }
                    case 17:
                    {
                        $numd = "DIECISIETE ";
                        break;
                    }
                    case 18:
                    {
                        $numd = "DIECIOCHO ";
                        break;
                    }
                    case 19:
                    {
                        $numd = "DIECINUEVE ";
                        break;
                    }
                    }
                }
                else
                    $numd = $this->unidad($numdero);
            return $numd;
        }
         
        public function centena($numc){
                if ($numc >= 100)
                {
                    if ($numc >= 900 && $numc <= 999)
                    {
                        $numce = "NOVECIENTOS ";
                        if ($numc > 900)
                            $numce = $numce.($this->decena($numc - 900));
                    }
                    else if ($numc >= 800 && $numc <= 899)
                    {
                        $numce = "OCHOCIENTOS ";
                        if ($numc > 800)
                            $numce = $numce.($this->decena($numc - 800));
                    }
                    else if ($numc >= 700 && $numc <= 799)
                    {
                        $numce = "SETECIENTOS ";
                        if ($numc > 700)
                            $numce = $numce.($this->decena($numc - 700));
                    }
                    else if ($numc >= 600 && $numc <= 699)
                    {
                        $numce = "SEISCIENTOS ";
                        if ($numc > 600)
                            $numce = $numce.($this->decena($numc - 600));
                    }
                    else if ($numc >= 500 && $numc <= 599)
                    {
                        $numce = "QUINIENTOS ";
                        if ($numc > 500)
                            $numce = $numce.($this->decena($numc - 500));
                    }
                    else if ($numc >= 400 && $numc <= 499)
                    {
                        $numce = "CUATROCIENTOS ";
                        if ($numc > 400)
                            $numce = $numce.($this->decena($numc - 400));
                    }
                    else if ($numc >= 300 && $numc <= 399)
                    {
                        $numce = "TRESCIENTOS ";
                        if ($numc > 300)
                            $numce = $numce.($this->decena($numc - 300));
                    }
                    else if ($numc >= 200 && $numc <= 299)
                    {
                        $numce = "DOSCIENTOS ";
                        if ($numc > 200)
                            $numce = $numce.($this->decena($numc - 200));
                    }
                    else if ($numc >= 100 && $numc <= 199)
                    {
                        if ($numc == 100)
                            $numce = "CIEN ";
                        else
                            $numce = "CIENTO ".($this->decena($numc - 100));
                    }
                }
                else
                    $numce = $this->decena($numc);
         
                return $numce;
        }
         
        public function miles($nummero){
                if ($nummero >= 1000 && $nummero < 2000){
                    $numm = "MIL ".($this->centena($nummero%1000));
                }
                if ($nummero >= 2000 && $nummero <10000){
                    $numm = $this->unidad(Floor($nummero/1000))." MIL ".($this->centena($nummero%1000));
                }
                if ($nummero < 1000)
                    $numm = $this->centena($nummero);
         
                return $numm;
        }
         
        public function decmiles($numdmero){
                if ($numdmero == 10000)
                    $numde = "DIEZ MIL";
                if ($numdmero > 10000 && $numdmero <20000){
                    $numde = $this->decena(Floor($numdmero/1000))."MIL ".($this->centena($numdmero%1000));
                }
                if ($numdmero >= 20000 && $numdmero <100000){
                    $numde = $this->decena(Floor($numdmero/1000))." MIL ".($this->miles($numdmero%1000));
                }
                if ($numdmero < 10000)
                    $numde = $this->miles($numdmero);
         
                return $numde;
        }
         
        public function cienmiles($numcmero){
                if ($numcmero == 100000)
                    $num_letracm = "CIEN MIL";
                if ($numcmero >= 100000 && $numcmero <1000000){
                    $num_letracm = $this->centena(Floor($numcmero/1000))." MIL ".($this->centena($numcmero%1000));
                }
                if ($numcmero < 100000)
                    $num_letracm = $this->decmiles($numcmero);
                return $num_letracm;
        }
         
        public function millon($nummiero){
                if ($nummiero >= 1000000 && $nummiero <2000000){
                    $num_letramm = "UN MILLON ".($this->cienmiles($nummiero%1000000));
                }
                if ($nummiero >= 2000000 && $nummiero <10000000){
                    $num_letramm = $this->unidad(Floor($nummiero/1000000))." MILLONES ".($this->cienmiles($nummiero%1000000));
                }
                if ($nummiero < 1000000)
                    $num_letramm = $this->cienmiles($nummiero);
         
                return $num_letramm;
        }
         
        public function decmillon($numerodm){
                if ($numerodm == 10000000)
                    $num_letradmm = "DIEZ MILLONES";
                if ($numerodm > 10000000 && $numerodm <20000000){
                    $num_letradmm = $this->decena(Floor($numerodm/1000000))."MILLONES ".($this->cienmiles($numerodm%1000000));
                }
                if ($numerodm >= 20000000 && $numerodm <100000000){
                    $num_letradmm = $this->decena(Floor($numerodm/1000000))." MILLONES ".($this->millon($numerodm%1000000));
                }
                if ($numerodm < 10000000)
                    $num_letradmm = $this->millon($numerodm);
         
                return $num_letradmm;
        }
         
        public function cienmillon($numcmeros){
                if ($numcmeros == 100000000)
                    $num_letracms = "CIEN MILLONES";
                if ($numcmeros >= 100000000 && $numcmeros <1000000000){
                    $num_letracms = $this->centena(Floor($numcmeros/1000000))." MILLONES ".($this->millon($numcmeros%1000000));
                }
                if ($numcmeros < 100000000)
                    $num_letracms = $this->decmillon($numcmeros);
                return $num_letracms;
        }
         
        public function milmillon($nummierod){
                if ($nummierod >= 1000000000 && $nummierod <2000000000){
                    $num_letrammd = "MIL ".($this->cienmillon($nummierod%1000000000));
                }
                if ($nummierod >= 2000000000 && $nummierod <10000000000){
                    $num_letrammd = $this->unidad(Floor($nummierod/1000000000))." MIL ".($this->cienmillon($nummierod%1000000000));
                }
                if ($nummierod < 1000000000)
                    $num_letrammd = $this->cienmillon($nummierod);
         
                return $num_letrammd;
        }
         
         
        public function convertir($numero){
            $num = str_replace(",","",$numero);
            $num = number_format($num,2,'.','');
            $cents = substr($num,strlen($num)-2,strlen($num)-1);
            $num = (int)$num;

            $numf = $this->milmillon($num);
         
            return $numf." y ".$cents."/100";
        }

        //grabar las acciones de los modulos
        public function saveAction($accion,$codigo,$modulo,$user){
            try {
                $query = $this->db->connect()->prepare("INSERT INTO lg_seguimiento SET cmodulo=:cmod,id_regmov=:cod,cproceso=:acc,id_cuser=:usr");
                $query->execute(["cmod" => $modulo,
                                 "cod"  => $codigo,
                                 "acc"  => $accion,
                                 "usr"  => $user]);
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        //obtener el ultimo id creado
        public function lastInsertId($query) {
            try {
                $sql = $this->db->connect()->query($query);
                $sql->execute();
                $result = $sql->fetchAll();
                
                return $result[0]['id'];
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;

            }
        }

        public function encryptPass($password){
            $sSalt = '20adeb83e85f03cfc84d0fb7e5f4d290';
            $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
            $method = 'aes-256-cbc';
        
            $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        
            $encrypted = base64_encode(openssl_encrypt($password, $method, $sSalt, OPENSSL_RAW_DATA, $iv));
            return $encrypted;
        }

        public function decryptPass($password){
            $sSalt = '20adeb83e85f03cfc84d0fb7e5f4d290';
            $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
            $method = 'aes-256-cbc';
        
            $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        
            $decrypted = openssl_decrypt(base64_decode($password), $method, $sSalt, OPENSSL_RAW_DATA, $iv);
            return $decrypted;
        }

        //llamar valores de la tabla general al pasar un parametro
        public function listarParametros($clase) {
            try {
                $salida = "";
                $query = $this->db->connect()->prepare("SELECT nidreg,cdescripcion 
                                                        FROM tb_parametros
                                                        WHERE cclase=:clase
                                                            AND ccod != '00'
                                                            AND ( nactivo = 1 OR nactivo IS NULL)
                                                        ORDER BY cdescripcion");
                $query->execute(["clase" => $clase]);
                $rowcount = $query->rowcount();

                if ($rowcount > 0) {
                    while ($row = $query->fetch()) {
                        $salida.='<li>
                                    <a href="'.$row['nidreg'].'">'.$row['cdescripcion'].'</a>
                                 </li>';
                    }
                }
                return $salida;
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function listarConductores() {
            try {
                $salida = "";
                $query = $this->db->connect()->query("SELECT idreg,cnombres,clicencia,cnrodoc 
                                                        FROM cm_conductores
                                                        WHERE nflgactivo = 1
                                                        ORDER BY cnombres");
                $query->execute();
                $rowcount = $query->rowcount();

                if ($rowcount > 0) {
                    while ($row = $query->fetch()) {
                        $salida.='<li>
                                    <a href="'.$row['idreg'].'" 
                                              data-licencia="'.$row['clicencia'].'"
                                              data-dni="'.$row['cnrodoc'].'"  >'.$row['cnombres'].'</a>
                                 </li>';
                    }
                }
                return $salida;
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function rrhhCargo($codigo){
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                        ibis.tb_user.iduser, 
                                                        rrhh.tabla_aquarius.dcargo, 
                                                        rrhh.tabla_aquarius.ccargo 
                                                    FROM
                                                        ibis.tb_user
                                                        INNER JOIN
                                                        rrhh.tabla_aquarius
                                                        ON 
                                                            ibis.tb_user.ncodper = rrhh.tabla_aquarius.internal
                                                    WHERE
                                                        ibis.tb_user.iduser =:codigo");
                $sql->execute(["codigo"=>$codigo]);
                $result = $sql->fetchAll();

                return $result[0]['dcargo'];
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function listarSelect($clase,$activo) {
            try {
                $salida = "";
                $query = $this->db->connect()->prepare("SELECT nidreg,cdescripcion,cobservacion 
                                                        FROM tb_parametros
                                                        WHERE cclase=:clase
                                                        AND ccod != '00' 
                                                        ORDER BY cdescripcion");
                $query->execute(["clase" => $clase]);
                $rowcount = $query->rowcount();

                if ($rowcount > 0) {
                    while ($row = $query->fetch()) {
                        $selected = $activo == $row['nidreg'] ? "selected" : "";
                        
                        $salida.='<option value="'.$row['nidreg'].'" '.$selected.'>'.$row['cdescripcion'].'</option>';
                    }
                }
                return $salida;
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        } 

        public function listarPais() {
            try {
                $salida = "";
                $query = $this->db->connect()->query("SELECT ncodpais,cdespais 
                                                        FROM tb_pais
                                                        ORDER BY cdespais");
                $query->execute();
                $rowcount = $query->rowcount();

                if ($rowcount > 0) {
                    while ($row = $query->fetch()) {
                        $salida.='<li>
                                    <a href="'.$row['ncodpais'].'">'.$row['cdespais'].'</a>
                                 </li>';
                    }
                }
                return $salida;
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function listarAquarius(){
            try {
                $salida = "";
                $query = $this->db->connectrrhh()->query("SELECT dni, CONCAT(nombres,' ',apellidos) AS nombres, internal,ccargo,dcargo,
                                                        nombres AS nomb,
                                                        apellidos AS apell
                                                        FROM tabla_aquarius 
                                                        WHERE estado = 'AC' ORDER BY apellidos ASC");
                $query->execute();
                $rowcount = $query->rowcount();

                if ($rowcount > 0) {
                    while ($row = $query->fetch()) {
                        $salida.='<li>
                                    <a href="'.$row['internal'].'" 
                                                data-ccargo="'.$row['ccargo'].'" 
                                                data-dcargo="'.$row['dcargo'].'"
                                                data-nom="'.$row['nomb'].'"
                                                data-apell="'.$row['apell'].'">'.$row['nombres'].'</a>
                                 </li>';
                    }
                }
                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function actualizarCabecera($tabla,$valor,$id,$emitido,$aprueba){
            try {
                $sql = $this->db->connect()->prepare("UPDATE $tabla SET estadodoc=:est,docPdfEmit=:emit,aprueba=:aut WHERE idreg=:id");
                $sql->execute(["est"=>$valor,
                                "id"=>$id,
                                "emit"=>$emitido,
                                "aut"=>$aprueba]);
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function actualizarDetalles($tabla,$valor,$detalles){
            $datos = json_decode($detalles);
            $nreg =  count($datos);

            try {
                for ($i=0; $i < $nreg; $i++) { 

                    if ( $valor == 53 ){
                        $sql = $this->db->connect()->prepare("UPDATE $tabla SET estadoItem=:est,
                                                                                observAlmacen=:obs
                                                                            WHERE iditem=:id");
                        $sql->execute(["est"=>$valor,
                                        "id"=>$datos[$i]->itempedido,
                                        "obs"=>$datos[$i]->observac]);
                    }
                }
                
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function actualizarAtenciones($tabla,$valor,$detalles){
            $datos = json_decode($detalles);
            $nreg =  count($datos);

            try {
                for ($i=0; $i < $nreg; $i++) { 

                    if ( $valor == 53 ){
                       //esta linea es para cambiar los items 52 -- atendido en su totalidad por almacen
                       $estado = floatval( $datos[$i]->cantidad) - floatval($datos[$i]->atendida ) == 0 ? 52: $valor;
                       $resto = floatval($datos[$i]->cantidad) - floatval($datos[$i]->atendida);
 
                       $sql = $this->db->connect()->prepare("UPDATE $tabla SET estadoItem=:est,
                                                                                 observAlmacen=:obs, 
                                                                                 cant_atend=:aten,
                                                                                 cant_resto=:resto
                                                                             WHERE iditem=:id");
                       $sql->execute(["est"=>$estado,
                                         "id"=>$datos[$i]->itempedido,
                                         "obs"=>$datos[$i]->observac,
                                         "aten"=>$datos[$i]->atendida,
                                         "resto"=>$resto]);
                    }
                }
                
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function crearMenu($user){
           $salida = "";
           try {
               $ul = ['CATALOGOS',];
           } catch (PDOException $th) {
               echo $th->getMessage();
               return false;
           }
        }

        public function llamarParametrosSelect($clase){
            try {
                $salida = '<option value="-1" class="oculto">Elija una opción</option>';
                $sql = $this->db->connect()->prepare("SELECT nidreg,cclase,ccod,cdescripcion,cabrevia
                                                        FROM tb_parametros
                                                        WHERE cclase=:clase 
                                                        AND nactivo = 1
                                                        AND ccod !='00' 
                                                        ORDER BY cdescripcion");
                $sql->execute(["clase"=>$clase]);
                $rowcount = $sql->rowCount();

                if($rowcount > 0){
                    while ($rs = $sql->fetch()) {
                        $salida .= '<option value="'.$rs['nidreg'].'" data-abrevia="">'.$rs['cdescripcion'].'</option>';
                    }
                } 

                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function selectAlmacen(){
            try {
                $salida = '<option value="-1" class="oculto">Elija una opción</option>';
                $sql = $this->db->connect()->query("SELECT ncodalm,UPPER(cdesalm) AS almacen FROM tb_almacen WHERE nflgactivo = 1");
                $sql->execute();
                $rowCount = $sql->rowCount();

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .= '<option value="'.$rs['ncodalm'].'" data-abrevia="">'.$rs['almacen'].'</option>';
                    }

                    return $salida;
                } 
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function selectCostos(){
            try {
                $salida = "";

                $sql = $this->db->connect()->prepare("SELECT
                                                    UPPER( tb_proyectos.ccodproy ) AS codigo_costos,
                                                    UPPER( tb_proyectos.cdesproy ) AS descripcion_costos,
                                                    tb_proyectos.veralm,
                                                    tb_costusu.ncodproy 
                                                FROM
                                                    tb_costusu
                                                    INNER JOIN tb_proyectos ON tb_costusu.ncodproy = tb_proyectos.nidreg 
                                                WHERE
                                                    tb_costusu.id_cuser = :id 
                                                    AND tb_proyectos.nflgactivo = 1
                                                    AND tb_costusu.nflgactivo = 1");
                $sql->execute(["id"=>$_SESSION['iduser']]);
                $rowCount = $sql->rowCount(); 

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .= '<option value="'.$rs['ncodproy'].'" data-abrevia="">'.$rs['codigo_costos']." ".$rs['descripcion_costos'].'</option>';
                    }

                    return $salida;
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function obtenerUnidades(){
            try {
                $salida = '';
                $sql = $this->db->connect()->query("SELECT ncodmed,ccodmed,cdesmed,cabrevia,nfactor
                                                    FROM tb_unimed");
                $sql->execute();
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ( $rs = $sql->fetch()){
                        $salida .='<li><a href="'.$rs['ncodmed'].'">'.$rs['ccodmed'] .' - '.strtoupper($rs['cdesmed']).'</a></li>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function obtenerGrupos(){
            $salida = "";
            try {
                $sql = $this->db->connect()->query("SELECT ncodgrupo,ccodcata,cdescrip 
                                                    FROM tb_grupo 
                                                    WHERE nflgactivo=1 
                                                    ORDER BY cdescrip ASC");
                $sql->execute();
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ( $rs = $sql->fetch()){
                        $salida .='<li><a href="'.$rs['ncodgrupo'].'" data-grupo="'.$rs['ccodcata'].'">'.$rs['ccodcata'] .' - '.strtoupper($rs['cdescrip']).'</a></li>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function obtenerClases($grupo) {
            $salida = "";
            try {
                $sql = $this->db->connect()->prepare("SELECT ncodgrupo,ncodclase,ccodcata,cdescrip 
                                                    FROM tb_clase 
                                                    WHERE nflgactivo=1 AND ncodgrupo = :grupo 
                                                    ORDER BY cdescrip ASC");
                $sql->execute(["grupo"=>$grupo]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ( $rs = $sql->fetch()){
                        $salida .='<li><a href="'.$rs['ncodclase'].'" data-catalogo="'.$rs['ccodcata'] .'">'.$rs['ccodcata'] .' - '.strtoupper($rs['cdescrip']).'</a></li>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function crearCodigoClase($grupo,$clase){
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                            LPAD( COUNT(tb_familia.ncodfamilia ) + 1, 4, 0 ) AS numero 
                                                        FROM
                                                            tb_familia 
                                                        WHERE
                                                            tb_familia.ncodgrupo =:grupo 
                                                            AND tb_familia.ncodclase =:clase");
                $sql->execute(['grupo' =>$grupo,'clase'=>$clase]);
                $result=$sql->fetchAll();

                return str_pad($result[0]['numero'],4,0,STR_PAD_LEFT);
                
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function obtenerFamilias($grupo,$clase) {
            $salida = "";
            try {
                $sql = $this->db->connect()->prepare("SELECT ncodgrupo,ncodclase,ncodfamilia,ccodcata,cdescrip 
                                                    FROM tb_familia 
                                                    WHERE nflgactivo=1 
                                                    AND ncodgrupo = :grupo
                                                    AND ncodclase = :clase 
                                                    ORDER BY cdescrip ASC");
                $sql->execute(["grupo"=>$grupo,
                                "clase"=>$clase]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ( $rs = $sql->fetch()){
                        $salida .='<li><a href="'.$rs['ncodfamilia'].'" data-catalogo="'.$rs['ccodcata'] .'">'.$rs['ccodcata'] .' - '.strtoupper($rs['cdescrip']).'</a></li>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }
      
        public function listarClases($grupo){
            try {
                $salida = "";
                $sql = $this->db->connect()->prepare("SELECT ncodclase,ccodcata,UPPER(cdescrip) AS cdescrip 
                                                        FROM tb_clase
                                                        WHERE ncodgrupo =:grupo AND nflgactivo = 1
                                                        ORDER BY cdescrip DESC");
                $sql->execute(['grupo'=>$grupo]);
                $rowCount = $sql->rowCount();

                if($rowCount > 0) {
                    while($rs = $sql->fetch()){
                        $salida .='<tr class="pointer" data-id="'.$rs['ncodclase'].'">
                                        <td class="textoCentro">'.$rs['ccodcata'].'</td>
                                        <td class="pl20px">'.$rs['cdescrip'].'</td>
                                        <td class="textoCentro"><a href="'.$rs['ncodclase'].'"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';

                    }
                }
                
                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function listarGrupos(){
            try {
                $salida = "";
                $sql = $this->db->connect()->query("SELECT ncodgrupo,ccodcata,cdescrip 
                                                        FROM tb_grupo
                                                        WHERE nflgactivo = 1
                                                        ORDER BY ccodcata DESC");
                $sql->execute();
                $rowCount = $sql->rowCount();

                if($rowCount > 0) {
                    while($rs = $sql->fetch()){
                        $salida .='<tr class="pointer" data-id="'.$rs['ncodgrupo'].'" data-grupo="'.$rs['ccodcata'].'">
                                        <td class="textoCentro">'.$rs['ccodcata'].'</td>
                                        <td class="pl20px">'.$rs['cdescrip'].'</td>
                                        <td class="textoCentro"><a href="'.$rs['ccodcata'].'"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>';

                    }
                }
                
                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function listarAlmacen(){
            try {
                $salida = "";
                $sql = $this->db->connect()->query("SELECT
                                                    tb_almacen.ncodalm,
                                                    UPPER(cdesalm) AS almacen,
                                                    UPPER(tb_almacen.ctipovia) AS direccion
                                                    FROM tb_almacen
                                                    WHERE nflgactivo = 1");
                $sql->execute();
                $rowCount = $sql->rowCount();

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .='<li><a href="'.$rs['ncodalm'].'" data-direccion="'.$rs['direccion'].'">'.$rs['almacen'].'</a></li>';
                    }

                    return $salida;
                } 
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function listarEntidades(){
            try {
                $salida = "";
                $sql = $this->db->connect()->query("SELECT
                                                    cm_entidad.id_centi, 
                                                    UPPER(cm_entidad.crazonsoc) AS crazonsoc, 
                                                    cm_entidad.cnumdoc,
                                                    cm_entidad.cviadireccion,
                                                    cm_entidad.cdigcateg
                                                FROM
                                                    cm_entidad
                                                WHERE
                                                    cm_entidad.nflgactivo = 7
                                                ORDER BY 
                                                    cm_entidad.crazonsoc");
                $sql->execute();
                $rowCount = $sql->rowCount();

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .='<li>
                                    <a href="'.$rs['id_centi'].'" 
                                        data-direccion="'.$rs['cviadireccion'].'" 
                                        data-ruc="'.$rs['cnumdoc'].'"
                                        data-mtc="'.$rs['cdigcateg'].'">'.$rs['crazonsoc'].'</a></li>';
                    }

                    return $salida;
                } 
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function listarEntidadesMTC(){
            try {
                $salida = "";
                $sql = $this->db->connect()->query("SELECT
                                                    cm_entidad.id_centi, 
                                                    UPPER(cm_entidad.crazonsoc) AS crazonsoc, 
                                                    cm_entidad.cnumdoc,
                                                    cm_entidad.cviadireccion,
                                                    cm_entidad.cdigcateg
                                                FROM
                                                    cm_entidad
                                                WHERE
                                                    cm_entidad.nflgactivo = 7
                                                    AND cm_entidad.cdigcateg IS NOT NULL
                                                ORDER BY 
                                                    cm_entidad.crazonsoc");
                $sql->execute();
                $rowCount = $sql->rowCount();

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .='<li>
                                    <a href="'.$rs['id_centi'].'" 
                                        data-direccion="'.$rs['cviadireccion'].'" 
                                        data-ruc="'.$rs['cnumdoc'].'"
                                        data-mtc="'.$rs['cdigcateg'].'">'.$rs['crazonsoc'].'</a></li>';
                    }

                    return $salida;
                } 
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function listarAlmacenGuia(){
            try {
                $salida = "";
                $sql = $this->db->connect()->query("SELECT
                                                        ncodalm,
                                                        UPPER( cdesalm ) AS almacen,
                                                        UPPER( ctipovia ) AS direccion,
                                                        distritos.cdubigeo AS dist,
                                                        provincias.cdubigeo AS prov,
                                                        dptos.cdubigeo AS dpto,
                                                        tb_almacen.csunatalm,
                                                        tb_almacen.ncubigeo,
                                                        tb_almacen.rucEnti,
                                                         tb_almacen.razonEnti
                                                    FROM
                                                        tb_almacen
                                                        LEFT JOIN tb_ubigeo AS distritos ON tb_almacen.ncubigeo = distritos.ccubigeo
                                                        LEFT JOIN tb_ubigeo AS provincias ON SUBSTR( tb_almacen.ncubigeo, 1, 4 ) = provincias.ccubigeo
                                                        LEFT JOIN tb_ubigeo AS dptos ON SUBSTR( tb_almacen.ncubigeo, 1, 2 ) = dptos.ccubigeo 
                                                    WHERE
                                                        nflgactivo = 1");
                $sql->execute();
                $rowCount = $sql->rowCount();

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .='<li><a href="'.$rs['ncodalm'].'" 
                                        data-direccion="'.$rs['direccion'].'"
                                        data-sunat="'.$rs['csunatalm'].'"
                                        data-dpto="'.$rs['dpto'].'"
                                        data-prov="'.$rs['prov'].'"
                                        data-ubigeo="'.$rs['ncubigeo'].'"
                                        data-ruc="'.$rs['rucEnti'].'"
                                        data-razon="'.$rs['razonEnti'].'"
                                        data-dist="'.$rs['dist'].'">'.$rs['almacen'].'</a></li>';
                    }

                    return $salida;
                } 
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function listarAlmacenSepcon(){
            try {
                $salida = "";
                $sql = $this->db->connect()->query("SELECT
                                                    tb_almacen.ncodalm,
                                                    UPPER( cdesalm ) AS almacen,
                                                    UPPER( ctipovia ) AS direccion,
                                                    distritos.cdubigeo AS dist,
                                                    provincias.cdubigeo AS prov,
                                                    dptos.cdubigeo AS dpto,
                                                    tb_almacen.csunatalm,
                                                    tb_almacen.ncubigeo,
                                                    tb_almacen.rucEnti,
                                                    tb_almacen.razonEnti 
                                                FROM
                                                    tb_almacen
                                                    LEFT JOIN tb_ubigeo AS distritos ON tb_almacen.ncubigeo = distritos.ccubigeo
                                                    LEFT JOIN tb_ubigeo AS provincias ON SUBSTR( tb_almacen.ncubigeo, 1, 4 ) = provincias.ccubigeo
                                                    LEFT JOIN tb_ubigeo AS dptos ON SUBSTR( tb_almacen.ncubigeo, 1, 2 ) = dptos.ccubigeo 
                                                WHERE
                                                    tb_almacen.nflgactivo = 1
                                                    AND tb_almacen.rucEnti = '20504898173'");
                $sql->execute();
                $rowCount = $sql->rowCount();

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .='<li><a href="'.$rs['ncodalm'].'" 
                                        data-direccion="'.$rs['direccion'].'"
                                        data-sunat="'.$rs['csunatalm'].'"
                                        data-dpto="'.$rs['dpto'].'"
                                        data-prov="'.$rs['prov'].'"
                                        data-ubigeo="'.$rs['ncubigeo'].'"
                                        data-ruc="'.$rs['rucEnti'].'"
                                        data-razon="'.$rs['razonEnti'].'"
                                        data-dist="'.$rs['dist'].'">'.$rs['almacen'].'</a></li>';
                    }

                    return $salida;
                } 
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function listarPersonalRol($nrol){
            try {
                $salida = "";
                $sql = $this->db->connect()->prepare("SELECT
                                            tb_user.iduser,
                                            tb_user.cnombres 
                                        FROM
                                            tb_user 
                                        WHERE
                                            nrol =:rol 
                                            AND nflgactivo = 1 
                                            AND nestado = 7");
                $sql->execute(['rol'=>4]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .='<li><a href="'.$rs['iduser'].'" >'.$rs['cnombres'].'</a></li>';
                    }

                    return $salida;
                } 
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        //centro de costos por usuario
        public function costosPorUsuario($id){
            try {
                $salida = "";

                $sql = $this->db->connect()->prepare("SELECT
                                                    UPPER( tb_proyectos.ccodproy ) AS codigo_costos,
                                                    UPPER( tb_proyectos.cdesproy ) AS descripcion_costos,
                                                    tb_proyectos.veralm,
                                                    tb_costusu.ncodproy,
                                                    tb_proyectos.nalmacen
                                                FROM
                                                    tb_costusu
                                                    INNER JOIN tb_proyectos ON tb_costusu.ncodproy = tb_proyectos.nidreg 
                                                WHERE
                                                    tb_costusu.id_cuser = :id 
                                                    AND tb_proyectos.nflgactivo = 1
                                                    AND tb_costusu.nflgactivo = 1
                                                ORDER BY tb_proyectos.ccodproy");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount(); 

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .='<li><a href="'.$rs['ncodproy'].'" 
                                    data-aprobacion="'.$rs['veralm'].'"
                                    data-almacen="'.$rs['nalmacen'].'">'.$rs['codigo_costos']." ".$rs['descripcion_costos'].'</a></li>';
                    }

                    return $salida;
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function costosPorUsuarioSelect($id){
            try {
                $salida = "<option value='-1' selected >Seleccione una opción</option>";

                $sql = $this->db->connect()->prepare("SELECT
                                                    UPPER( tb_proyectos.ccodproy ) AS codigo_costos,
                                                    UPPER( tb_proyectos.cdesproy ) AS descripcion_costos,
                                                    tb_proyectos.veralm,
                                                    tb_costusu.ncodproy 
                                                FROM
                                                    tb_costusu
                                                    INNER JOIN tb_proyectos ON tb_costusu.ncodproy = tb_proyectos.nidreg 
                                                WHERE
                                                    tb_costusu.id_cuser = :id 
                                                    AND tb_proyectos.nflgactivo = 1
                                                    AND tb_costusu.nflgactivo = 1
                                                ORDER BY tb_proyectos.ccodproy");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount(); 

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .='<option value="'.$rs['ncodproy'].'">'.$rs['codigo_costos']." ".$rs['descripcion_costos'].'</option>';
                    }

                    return $salida;
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }
        
        public function costosPorUsuarioSelector($id){
            try {
                $salida = "<option value='0' selected >Todos</option>";

                $sql = $this->db->connect()->prepare("SELECT
                                                    UPPER( tb_proyectos.ccodproy ) AS codigo_costos,
                                                    UPPER( tb_proyectos.cdesproy ) AS descripcion_costos,
                                                    tb_proyectos.veralm,
                                                    tb_costusu.ncodproy 
                                                FROM
                                                    tb_costusu
                                                    INNER JOIN tb_proyectos ON tb_costusu.ncodproy = tb_proyectos.nidreg 
                                                WHERE
                                                    tb_costusu.id_cuser = :id 
                                                    AND tb_proyectos.nflgactivo = 1
                                                    AND tb_costusu.nflgactivo = 1
                                                    ORDER BY tb_proyectos.ccodproy");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount(); 

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .='<option value="'.$rs['ncodproy'].'">'.$rs['codigo_costos']." ".$rs['descripcion_costos'].'</option>';
                    }

                    return $salida;
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function obtenerAreas(){
            try {
                $salida = "";

                $sql = $this->db->connect()->query("SELECT ncodarea,ccodarea,UPPER(cdesarea) AS cdesarea 
                                                    FROM tb_area 
                                                    WHERE nflgactivo = 1");
                $sql->execute();
                $rowCount = $sql->rowCount(); 

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .='<li><a href="'.$rs['ncodarea'].'">'.$rs['ccodarea']." ".$rs['cdesarea'].'</a></li>';
                    }

                    return $salida;
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function listaAreas(){
            try {
                $salida = "<option value='-1'>Seleccione una opción</option>";

                $sql = $this->db->connect()->query("SELECT ncodarea,ccodarea,UPPER(cdesarea) AS cdesarea 
                                                    FROM tb_area 
                                                    WHERE nflgactivo = 1
                                                    ORDER BY cdesarea");
                $sql->execute();
                $rowCount = $sql->rowCount(); 

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .='<option value="'.$rs['ncodarea'].'">'.$rs['cdesarea'].'</option>';
                    }

                    return $salida;
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        //genera los numero de los documentos
        public function generarNumero($id,$query){
            try {
                $sql = $this->db->connect()->prepare($query);
                $sql->execute(["cod"=>$id]);
                $result = $sql->fetchAll();

                $inicial = 0;

                if( $id == 3){
                    $inicial = 880;
                }else if ( $id ==  18) {
                    $inicial = 371;
                }else if( $id == 19 ){
                    $inicial = 73;
                }

                return $salida = array("numero"=>str_pad(($result[0]['numero']+$inicial) + 1,6,0,STR_PAD_LEFT),
                                        "codigo"=>uniqid(),
                                        "movimiento"=>str_pad($this->genNumberIngresos($id)+1,6,0,STR_PAD_LEFT)); 
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage;
                return false;
            }
        }

        public function ultimoIndiceTabla($query) {
            try {
                $sql = $this->db->connect()->query($query);
                $sql->execute();
                $result = $sql->fetchAll();

                return $result[0]['indice'];
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage;
                return false;
            }
        }
    
        public function generarNumeroPedido($id,$query){
            try {
                $sql = $this->db->connect()->prepare($query);
                $sql->execute(["cod"=>$id]);
                $result = $sql->fetchAll();

                $inicial = 0;

                if( $id == 3){
                    $inicial = 880;
                }else if ( $id ==  18) {
                    $inicial = 371;
                }else if( $id == 19 ){
                    $inicial = 73;
                }

                return $salida = array("numero"=>str_pad(($result[0]['numero'] + $inicial) + 1,6,0,STR_PAD_LEFT),
                                        "codigo"=>uniqid(),
                                        "movimiento"=>str_pad($this->genNumberIngresos($id)+1,6,0,STR_PAD_LEFT),
                                        "partidas"=>$this->listarPartidas($id),
                                        "numeromtto"=>$result[0]['numero'] + 1 ); 
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage;
                return false;
            }
        }

        public function obtenerIndice($codigo,$query){
            try {
                $sql = $this->db->connect()->prepare("$query");
                $sql->execute(["id"=>$codigo]);
                $result = $sql->fetchAll();

                return $result[0]['numero'];
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }
        
        public function lastInsertOrder(){
            try {
                $sql = $this->db->connect()->query("SELECT MAX(id_regmov) AS numero FROM lg_ordencab");
                $sql->execute();
                $result = $sql->fetchAll();

                return $result[0]['numero'];
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function listarPartidas($codigo) {
            try {
                $salida = "";
                $sql = $this->db->connect()->prepare("SELECT
                                                        tb_partidas.idreg,
                                                        tb_partidas.idcc,
                                                        tb_partidas.ccodigo,
                                                        UPPER(tb_partidas.cdescripcion) AS cdescripcion
                                                    FROM
                                                        tb_partidas
                                                    WHERE
                                                        tb_partidas.idcc = :costo
                                                    AND tb_partidas.nflgactivo = 1");
                $sql->execute(["costo" => $codigo]);
                $rowCount = $sql->rowCount(); 

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .='<li><a href="'.$rs['idreg'].'">'.$rs['ccodigo']." ".$rs['cdescripcion'].'</a></li>';
                    }
                }

                return $salida;

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

         //listado de productos
        public function listarProductos($tipo){
             try {
                 $salida = "";
                 $sql = $this->db->connect()->prepare("SELECT
                                                        cm_producto.id_cprod,
                                                        cm_producto.ccodprod,
                                                        UPPER(cm_producto.cdesprod) AS cdesprod,
                                                        tb_unimed.ncodmed,
                                                        tb_unimed.cabrevia,
                                                        tb_unimed.nfactor,
                                                        tb_parametros.cdescripcion 
                                                    FROM
                                                        cm_producto
                                                        INNER JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed
                                                        INNER JOIN tb_parametros ON cm_producto.ntipo = tb_parametros.nidreg
                                                    WHERE ntipo = :tipo
                                                    AND cm_producto.flgActivo = 1
                                                    LIMIT 100");
                $sql->execute(["tipo"=>$tipo]);
                $rowCount = $sql->rowCount();
                if ($rowCount > 0){
                    while ($rs = $sql->fetch()) {
                        $salida .='<tr class="pointer" data-idprod="'.$rs['id_cprod'].'" data-ncomed="'.$rs['ncodmed'].'" data-unidad="'.$rs['cabrevia'].'">
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl20px">'.$rs['cdesprod'].'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                    </tr>';
                    }
                }

                return $salida;
             } catch (PDOException $th) {
                echo "Error: ".$th->getMessage;
                return false;
            }
        }

        public function listarProductosSoporte($tipo){
            try {
                $salida = "No existen productos en el catalogo";
                $sql = $this->db->connect()->prepare("SELECT
                                                        cm_producto.id_cprod,
                                                        cm_producto.ccodprod,
                                                        UPPER(cm_producto.cdesprod) AS cdesprod,
                                                        tb_unimed.ncodmed,
                                                        tb_unimed.cabrevia,
                                                        tb_unimed.nfactor,
                                                        tb_parametros.cdescripcion 
                                                    FROM
                                                        cm_producto
                                                        INNER JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed
                                                        INNER JOIN tb_parametros ON cm_producto.ntipo = tb_parametros.nidreg
                                                    WHERE ntipo = :tipo
                                                    AND cm_producto.flgActivo = 1
                                                    AND ( cm_producto.ccodprod LIKE '%B05010002%' 
                                                          OR cm_producto.ccodprod LIKE '%B05010006%'
                                                          OR cm_producto.ccodprod LIKE '%B05010005%')
                                                    LIMIT 100");
               $sql->execute(["tipo"=>$tipo]);
               $rowCount = $sql->rowCount();
               if ($rowCount > 0){
                   while ($rs = $sql->fetch()) {
                       $salida .='<tr class="pointer" data-idprod="'.$rs['id_cprod'].'" data-ncomed="'.$rs['ncodmed'].'" data-unidad="'.$rs['cabrevia'].'">
                                       <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                       <td class="pl20px">'.$rs['cdesprod'].'</td>
                                       <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                   </tr>';
                   }
               }

               return $salida;
            } catch (PDOException $th) {
               echo "Error: ".$th->getMessage;
               return false;
           }
        }

        //codigo de ubigeo
        public function getUbigeo($nivel,$prefijo){
            try {
                $salida = "";
                $query= $this->db->connect()->prepare("SELECT
                    tb_ubigeo.ccubigeo,
                    tb_ubigeo.cdubigeo
                FROM
                    tb_ubigeo
                WHERE
                    tb_ubigeo.nnivel = :nivel AND
                    tb_ubigeo.ccubigeo LIKE :prefijo");
                $query->execute(['nivel'=>$nivel,'prefijo'=>$prefijo]);
                $rowcount = $query->rowCount();
                if ($rowcount > 0 ){
                    while ($row = $query->fetch()) {
                        $salida.='<li><a href="'.$row['ccubigeo'].'">'.$row['cdubigeo'].'</a></li>';
                    }
                }

                return $salida;
                
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        //codigo de ubigeo
        public function getUbigeoSelect($nivel,$prefijo){
            try {
                $salida = null;
                $query= $this->db->connect()->prepare("SELECT
                    tb_ubigeo.ccubigeo,
                    tb_ubigeo.cdubigeo
                FROM
                    tb_ubigeo
                WHERE
                    tb_ubigeo.nnivel = :nivel 
                    AND tb_ubigeo.ccubigeo LIKE :prefijo");

                $query->execute(['nivel'=>$nivel,'prefijo'=>$prefijo.'%']);
                $rowcount = $query->rowCount();

                while($row = $query->fetch(PDO::FETCH_ASSOC)){
                    $docData[] = $row;
                }

                return array("datos"=>$docData);
                
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        //filtrar para que no vean los correos deben poner el centro de costos
        public function buscarRol($rol,$cc){
            try {
                $salida = "";

                $sql = $this->db->connect()->prepare("SELECT
                                                        ibis.tb_costusu.ncodcos,
                                                        ibis.tb_costusu.ncodproy,
                                                        ibis.tb_costusu.id_cuser,
                                                        ibis.tb_user.ccorreo AS correo,
                                                        rrhh.tabla_aquarius.apellidos,
                                                        rrhh.tabla_aquarius.nombres,
                                                        ibis.tb_proyectos.cdesproy 
                                                    FROM
                                                        ibis.tb_costusu
                                                        INNER JOIN ibis.tb_user ON tb_costusu.id_cuser = tb_user.iduser
                                                        INNER JOIN rrhh.tabla_aquarius ON ibis.tb_user.ncodper = rrhh.tabla_aquarius.internal
                                                        INNER JOIN ibis.tb_proyectos ON ibis.tb_costusu.ncodproy = ibis.tb_proyectos.nidreg 
                                                    WHERE
                                                        (ibis.tb_user.nrol = :rol OR ibis.tb_user.nrol = 228) 
                                                        AND ibis.tb_costusu.ncodproy = :cc
                                                        AND ibis.tb_costusu.nflgactivo = 1");
                $sql->execute(["rol"=>$rol,"cc"=>$cc]);
                
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while($rs = $sql->fetch()){
                    $nom = $this->primerosNombres($rs['nombres'],$rs['apellidos']);

                        $salida .='<tr>
                                    <td class="pl10px">'.$nom.'</td>
                                    <td class="pl10px">'.$rs['correo'].'</td>
                                    <td class="textoCentro"><input type="checkbox"></td>
                                </tr>';
                    }
                     
                }

                return $salida;

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function buscarFirmas($rol,$doc){
            try {
                $salida = "";
                if ( $doc == "o" ){
                    $sql = $this->db->connect()->prepare("SELECT
                                                        ibis.tb_user.ccorreo AS correo,
                                                        ibis.tb_user.nrol,
                                                        ibis.tb_user.cnombres,
                                                        ibis.tb_user.ccargo 
                                                    FROM
                                                        ibis.tb_user
                                                    WHERE
                                                        tb_user.nrol =:rol AND ( tb_user.nflgvista = 1 OR tb_user.nflgvista = 3)");
                }elseif( $doc == "c" ){
                    $sql = $this->db->connect()->prepare("SELECT
                        ibis.tb_user.ccorreo AS correo,
                        ibis.tb_user.nrol,
                        ibis.tb_user.cnombres,
                        ibis.tb_user.ccargo 
                    FROM
                        ibis.tb_user
                    WHERE
                        tb_user.nrol =:rol AND  ( tb_user.nflgvista = 2 OR tb_user.nflgvista = 3)");
                }
                
                $sql->execute(["rol"=>$rol]);
                
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while($rs = $sql->fetch()){
                        $activo = $rs['ccargo'] == 1 ? "checked":"";

                        $salida .='<tr>
                                    <td class="pl10px">'.$rs['cnombres'].'</td>
                                    <td class="pl10px">'.strtolower($rs['correo']).'</td>
                                    <td class="textoCentro"><input type="checkbox" '.$activo.'></td>
                                </tr>';
                    }
                     
                }

                return $salida;

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function primerosNombres($nombres,$apellidos){
            $nombre_array = explode(" ",$nombres);
            $apellido_array= explode(" ",$apellidos);
            
            $nnom = count($nombre_array);
            $napell = count($apellido_array);
             
            if( $nnom  <= 2){
                $nom  = $nombre_array[0];
            }
            
            if( $napell == 2){
                $apell = $apellido_array[0];
            }else {
                $apell = $apellido_array[0] . " " . $apellido_array[1];
            }
            
            return $nom . " " . $apell;
        }

        //subir los adjuntos de los Correos
        public function subirAdjuntoCorreo($archivos){
            $countfiles = count( $archivos['name'] );
            $upload = false;

            for($i=0;$i<$countfiles;$i++){
                try {
                    // Upload file
                    if (move_uploaded_file($archivos['tmp_name'][$i],'public/documentos/correos/adjuntos/'.$archivos['name'][$i])){
                        $upload = true;
                    }
                } catch (PDOException $th) {
                    echo "Error: ".$th->getMessage();
                    return false;
                }
            }

            return $upload;
        }

        //consultas pedidos
        public function consultarReqId($id,$min,$max,$proceso){
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
                                                        ibis.tb_pedidocab.concepto, 
                                                        ibis.tb_pedidocab.detalle, 
                                                        ibis.tb_pedidocab.nivelAten, 
                                                        ibis.tb_pedidocab.docfPdfPrev, 
                                                        ibis.tb_pedidocab.docPdfEmit, 
                                                        ibis.tb_pedidocab.docPdfAprob, 
                                                        ibis.tb_pedidocab.verificacion,
                                                        ibis.tb_pedidocab.nmtto,
                                                        ibis.tb_pedidocab.asigna,
                                                        CONCAT( rrhh.tabla_aquarius.apellidos, ' ', rrhh.tabla_aquarius.nombres ) AS nombres, 
                                                        UPPER(
                                                        CONCAT( ibis.tb_proyectos.ccodproy, ' ', ibis.tb_proyectos.cdesproy )) AS proyecto, 
                                                        UPPER(
                                                        CONCAT( ibis.tb_area.ccodarea, ' ', ibis.tb_area.cdesarea )) AS area, 
                                                        UPPER(
                                                        CONCAT( ibis.tb_parametros.nidreg, ' ', ibis.tb_parametros.cdescripcion )) AS transporte,
                                                        tb_parametros.cobservacion, 
                                                        estados.cdescripcion AS estado, 
                                                        estados.cabrevia, 
                                                        UPPER(
                                                        CONCAT_WS( ' ', tipos.nidreg, tipos.cdescripcion )) AS tipo, 
                                                        ibis.tb_proyectos.veralm, 
                                                        ibis.tb_user.cnombres,
                                                        ibis.tb_partidas.cdescripcion,
                                                        ibis.tb_pedidocab.idpartida
                                                    FROM
                                                        ibis.tb_pedidocab
                                                        INNER JOIN
                                                        rrhh.tabla_aquarius
                                                        ON 
                                                            ibis.tb_pedidocab.idsolicita = rrhh.tabla_aquarius.internal
                                                        INNER JOIN
                                                    ibis.tb_proyectos ON ibis.tb_pedidocab.idcostos = ibis.tb_proyectos.nidreg
                                                    INNER JOIN ibis.tb_area ON ibis.tb_pedidocab.idarea = ibis.tb_area.ncodarea
                                                    INNER JOIN ibis.tb_parametros ON ibis.tb_pedidocab.idtrans = ibis.tb_parametros.nidreg
                                                    INNER JOIN ibis.tb_parametros AS transportes ON ibis.tb_pedidocab.idtrans = transportes.nidreg
                                                    INNER JOIN ibis.tb_parametros AS estados ON ibis.tb_pedidocab.estadodoc = estados.nidreg
                                                    INNER JOIN ibis.tb_parametros AS tipos ON ibis.tb_pedidocab.idtipomov = tipos.nidreg
                                                    INNER JOIN ibis.tb_user ON ibis.tb_pedidocab.usuario = ibis.tb_user.iduser
                                                    LEFT JOIN ibis.tb_partidas ON ibis.tb_pedidocab.idpartida = ibis.tb_partidas.idreg 
                                                    WHERE
                                                        tb_pedidocab.idreg = :id 
                                                    AND tb_pedidocab.estadodoc BETWEEN :min 
                                                    AND :max");
                $sql->execute(['id'=>$id, 'min'=>$min, 'max'=>$max]);
                $rowCount = $sql->rowCount();
                
                if ($rowCount > 0) {
                    $docData = array();
                    while($row=$sql->fetch(PDO::FETCH_ASSOC)){
                        $docData[] = $row;
                    }
                }

                if ( $proceso == 49){
                    $detalles = $this->consultarDetallesProceso($id);
                }else if ( $proceso == 51){
                    $detalles = $this->consultarDetallesStock($id);
                }else if ( $proceso == 53 ){
                    $detalles = $this->consultarDetallesAprobacion($id);
                }else if ( $proceso == 54 ){
                    $detalles = $this->consultarDetallesAsignacion($id);
                }else if ( $proceso == 56 ){
                    $detalles = $this->obtenerProformas($id);
                }else if ($proceso == 57) {
                    $detalles = $this->consultarDetallesConformidad($id);
                }

                return array("cabecera"=>$docData,
                            "detalles"=>$detalles,
                            "total_adjuntos"=>$this->contarAdjuntos($id,"PED"));
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        //pedidosMtto
        public function consultarReqIdMtto($id,$min,$max,$proceso){
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
                                                        ibis.tb_pedidocab.concepto, 
                                                        ibis.tb_pedidocab.detalle, 
                                                        ibis.tb_pedidocab.nivelAten, 
                                                        ibis.tb_pedidocab.docfPdfPrev, 
                                                        ibis.tb_pedidocab.docPdfEmit, 
                                                        ibis.tb_pedidocab.docPdfAprob, 
                                                        ibis.tb_pedidocab.verificacion,
                                                        ibis.tb_pedidocab.nmtto, 
                                                        CONCAT( rrhh.tabla_aquarius.apellidos, ' ', rrhh.tabla_aquarius.nombres ) AS nombres, 
                                                        UPPER(
                                                        CONCAT( ibis.tb_proyectos.ccodproy, ' ', ibis.tb_proyectos.cdesproy )) AS proyecto, 
                                                        UPPER(
                                                        CONCAT( ibis.tb_area.ccodarea, ' ', ibis.tb_area.cdesarea )) AS area, 
                                                        UPPER(
                                                        CONCAT( ibis.tb_parametros.nidreg, ' ', ibis.tb_parametros.cdescripcion )) AS transporte,
                                                        tb_parametros.cobservacion, 
                                                        estados.cdescripcion AS estado, 
                                                        estados.cabrevia, 
                                                        UPPER(
                                                        CONCAT_WS( ' ', tipos.nidreg, tipos.cdescripcion )) AS tipo, 
                                                        ibis.tb_proyectos.veralm, 
                                                        ibis.tb_user.cnombres,
                                                        ibis.tb_partidas.cdescripcion,
                                                        ibis.tb_pedidocab.idpartida
                                                    FROM
                                                        ibis.tb_pedidocab
                                                        INNER JOIN
                                                        rrhh.tabla_aquarius
                                                        ON 
                                                            ibis.tb_pedidocab.idsolicita = rrhh.tabla_aquarius.internal
                                                        INNER JOIN
                                                    ibis.tb_proyectos ON ibis.tb_pedidocab.idcostos = ibis.tb_proyectos.nidreg
                                                    INNER JOIN ibis.tb_area ON ibis.tb_pedidocab.idarea = ibis.tb_area.ncodarea
                                                    INNER JOIN ibis.tb_parametros ON ibis.tb_pedidocab.idtrans = ibis.tb_parametros.nidreg
                                                    INNER JOIN ibis.tb_parametros AS transportes ON ibis.tb_pedidocab.idtrans = transportes.nidreg
                                                    INNER JOIN ibis.tb_parametros AS estados ON ibis.tb_pedidocab.estadodoc = estados.nidreg
                                                    INNER JOIN ibis.tb_parametros AS tipos ON ibis.tb_pedidocab.idtipomov = tipos.nidreg
                                                    INNER JOIN ibis.tb_user ON ibis.tb_pedidocab.usuario = ibis.tb_user.iduser
                                                    LEFT JOIN ibis.tb_partidas ON ibis.tb_pedidocab.idpartida = ibis.tb_partidas.idreg 
                                                    WHERE
                                                        tb_pedidocab.idreg = :id 
                                                        AND tb_pedidocab.estadodoc BETWEEN :min 
                                                        AND :max");
                $sql->execute(['id'=>$id, 'min'=>$min, 'max'=>$max]);
                $rowCount = $sql->rowCount();
                
                if ($rowCount > 0) {
                    $docData = array();
                    while($row=$sql->fetch(PDO::FETCH_ASSOC)){
                        $docData[] = $row;
                    }
                }

                if ( $proceso == 49){
                    $detalles = $this->consultarDetallesProcesoMtto($id);
                }

                return array("cabecera"=>$docData,
                            "detalles"=>$detalles);
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function consultarDetallesProcesoMtto($id){
            try {
                $salida ="";

                $sql=$this->db->connect()->prepare("SELECT
                                                tb_pedidodet.iditem,
                                                tb_pedidodet.idpedido,
                                                tb_pedidodet.idprod,
                                                tb_pedidodet.idtipo,
                                                tb_pedidodet.nroparte,
                                                tb_pedidodet.unid,
                                                tb_pedidodet.observaciones,
                                                tb_pedidodet.nregistro,
                                                REPLACE ( FORMAT( tb_pedidodet.cant_pedida, 2 ), ',', '' ) AS cant_pedida,
                                                tb_pedidodet.estadoItem,
                                                cm_producto.ccodprod,
                                                cm_producto.cdesprod,
                                                tb_unimed.cabrevia,
                                                tb_pedidodet.nflgqaqc,
                                                CONCAT_WS( '/', tb_equipmtto.cregistro, tb_equipmtto.cdescripcion ) AS desc_registro 
                                            FROM
                                                tb_pedidodet
                                                INNER JOIN cm_producto ON tb_pedidodet.idprod = cm_producto.id_cprod
                                                INNER JOIN tb_unimed ON tb_pedidodet.unid = tb_unimed.ncodmed
                                                LEFT JOIN tb_equipmtto ON tb_pedidodet.nregistro = tb_equipmtto.idreg 
                                            WHERE
                                                tb_pedidodet.idpedido = :id 
                                                AND tb_pedidodet.nflgActivo = 1");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();
                
                if ($rowCount > 0){
                    $filas = 1;
                    while ($rs = $sql->fetch()) {
                        $salida .='<tr data-grabado="1" 
                                        data-idprod="'.$rs['idprod'].'" 
                                        data-codund="'.$rs['unid'].'" 
                                        data-idx="'.$rs['iditem'].'"
                                        data-registro="'.$rs['nregistro'].'">
                                        <td class="textoCentro"><a href="'.$rs['iditem'].'" title="Eliminar" data-accion="delete"><i class="fas fa-eraser"></i></a></td>
                                        <td class="textoCentro"><a href="'.$rs['iditem'].'" title="Cambiar" data-accion="change"><i class="fas fa-exchange-alt"></i></a></td>
                                        <td class="textoCentro duplicate">'.str_pad($filas++,3,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl20px">'.strtoupper($rs['cdesprod']).'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                        <td>
                                            <input type="number" 
                                                        step="any" 
                                                        placeholder="0.00" 
                                                        onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"
                                                        onclick="this.select()" 
                                                        value="'.$rs['cant_pedida'].'">
                                        </td>
                                        <td class="pl20px"><textarea>'.$rs['observaciones'].'</textarea></td>
                                        <td class="textoCentro"><input type="text" value="'.$rs['nroparte'].'"></td>
                                        <td class="textoCentro select">'.$rs['desc_registro'].'</td>
                                    </tr>';
                    }
                }
                
                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function buscarSeries($idprod,$ingreso,$almacen){
            try {
                $salida = "";

                $sql = $this->db->connect()->prepare("SELECT cdesserie FROM alm_recepserie 
                                                         WHERE id_cprod = :producto
                                                            AND idref_movi = :salida
                                                            AND idref_alma = :almacen");
                $sql ->execute(["producto"=>$idprod,"salida"=>$ingreso,"almacen"=>$almacen]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()) {
                        $salida .= $rs['cdesserie']." "; 
                    }
                }
                
                return $salida;
                
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function itemSeries($id) {
            try {
                $salida = "";

                $sql = $this->db->connect()->prepare("SELECT cdesserie FROM alm_recepserie 
                                                         WHERE idref_pedido = :id");
                $sql ->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()) {
                        $salida .= $rs['cdesserie'].", "; 
                    }
                }
                
                return $salida;
                
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function consultarDetallesProceso($id){
            try {
                $salida ="";

                $sql=$this->db->connect()->prepare("SELECT
                                                        tb_pedidodet.iditem,
                                                        tb_pedidodet.idpedido,
                                                        tb_pedidodet.idprod,
                                                        tb_pedidodet.idtipo,
                                                        tb_pedidodet.nroparte,
                                                        tb_pedidodet.unid,
                                                        UPPER(tb_pedidodet.observaciones) AS observaciones,
                                                        REPLACE(FORMAT(tb_pedidodet.cant_pedida,2),',','') AS cant_pedida,
                                                        tb_pedidodet.estadoItem,
                                                        cm_producto.ccodprod,
                                                        UPPER(cm_producto.cdesprod) AS cdesprod,
                                                        tb_unimed.cabrevia,
                                                        tb_pedidodet.nflgqaqc,
                                                        tb_equipmtto.cdescripcion,
                                                        tb_equipmtto.cregistro 
                                                    FROM
                                                        tb_pedidodet
                                                        LEFT JOIN cm_producto ON tb_pedidodet.idprod = cm_producto.id_cprod
                                                        LEFT JOIN tb_unimed ON tb_pedidodet.unid = tb_unimed.ncodmed
                                                        LEFT JOIN tb_equipmtto ON tb_pedidodet.nregistro = tb_equipmtto.idreg 
                                                    WHERE
                                                        tb_pedidodet.idpedido = :id 
                                                        AND tb_pedidodet.nflgActivo = 1");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();
                
                if ($rowCount > 0){
                    $filas = 1;
                    while ( $rs = $sql->fetch() ) {

                        $checked = $rs['nflgqaqc'] == 1 ? "checked ": " ";
                        
                        $salida .='<tr data-grabado="1" data-idprod="'.$rs['idprod'].'" data-codund="'.$rs['unid'].'" data-idx="'.$rs['iditem'].'">
                                        <td class="textoCentro"><a href="'.$rs['iditem'].'"><i class="fas fa-eraser"></i></a></td>
                                        <td class="textoCentro">'.str_pad($filas++,3,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl20px">'.$rs['cdesprod'].'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                        <td>
                                            <input type="number" 
                                                        step="any" 
                                                        placeholder="0.00" 
                                                        onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"
                                                        onclick="this.select()" 
                                                        value="'.$rs['cant_pedida'].'">
                                        </td>
                                        <td class="pl20px"><textarea>'.$rs['observaciones'].'</textarea></td>
                                        <td class="textoCentro">'.$rs['nroparte'].'</td>
                                        <td class="textoCentro">'.$rs['cregistro'].'</td>
                                    </tr>';
                    }
                }
                
                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function consultarDetallesStock($id){
            try {
                $salida ="";

                $sql=$this->db->connect()->prepare("SELECT
                                                    tb_pedidodet.iditem, 
                                                    tb_pedidodet.idpedido, 
                                                    tb_pedidodet.idprod,
                                                    tb_pedidodet.cant_resto, 
                                                    tb_pedidodet.idtipo, 
                                                    tb_pedidodet.nroparte, 
                                                    tb_pedidodet.unid, 
                                                    REPLACE(FORMAT(tb_pedidodet.cant_pedida,2),',','') AS cant_pedida, 
                                                    tb_pedidodet.estadoItem, 
                                                    cm_producto.ccodprod, 
                                                    CONCAT_WS(' ',cm_producto.cdesprod,tb_pedidodet.observaciones) AS cdesprod, 
                                                    tb_unimed.cabrevia, 
                                                    tb_pedidodet.nflgqaqc, 
                                                    tb_pedidodet.especificaciones 
                                                FROM
                                                    tb_pedidodet
                                                    INNER JOIN
                                                    cm_producto
                                                    ON 
                                                        tb_pedidodet.idprod = cm_producto.id_cprod
                                                    INNER JOIN
                                                    tb_unimed
                                                    ON 
                                                        tb_pedidodet.unid = tb_unimed.ncodmed
                                                WHERE
                                                    tb_pedidodet.idpedido = :id
                                                    AND tb_pedidodet.nflgActivo = 1");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();
                
                if ($rowCount > 0){
                    $filas = 1;
                    while ($rs = $sql->fetch()) {
                        $salida .='<tr data-grabado="1" data-idprod="'.$rs['idprod'].'" data-codund="'.$rs['unid'].'" data-idx="'.$rs['iditem'].'">
                                        <td class="textoCentro"><a href="'.$rs['idprod'].'"><i class="far fa-eye"></i></a></td>
                                        <td class="textoCentro">'.str_pad($filas++,3,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl20px">'.strtoupper($rs['cdesprod']).'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                        <td class="textoCentro">'.$rs['cant_pedida'].'</td>
                                        <td>
                                            <input type="number" 
                                                        step="any" 
                                                        placeholder="0.00" 
                                                        onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"
                                                        onclick="this.select()" 
                                                        value=""
                                                        class="valorAtendido"
                                                        tabIndex='.$filas.'>
                                        </td>
                                        <td></td>
                                        <td class="textoCentro"><input type="text"></td>
                                    </tr>';
                    }
                }
                
                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function consultarDetallesAprobacion($id){
            try {
                $salida ="";

                $sql=$this->db->connect()->prepare("SELECT
                                                    tb_pedidodet.iditem,
                                                    tb_pedidodet.idpedido,
                                                    tb_pedidodet.idprod,
                                                    tb_pedidodet.idtipo,
                                                    tb_pedidodet.nroparte,
                                                    tb_pedidodet.unid,
                                                    tb_pedidodet.obsAprueba,
                                                    REPLACE ( FORMAT( tb_pedidodet.cant_pedida, 2 ), ',', '' ) AS cant_pedida,
                                                    REPLACE ( FORMAT( tb_pedidodet.cant_resto, 2 ), ',', '' ) AS cant_pendiente,
                                                    REPLACE ( FORMAT( tb_pedidodet.cant_atend, 2 ), ',', '' ) AS cant_atendida,
                                                    REPLACE ( FORMAT( tb_pedidodet.cant_aprob, 2 ), ',', '' ) AS cant_aprob,
                                                    tb_pedidodet.estadoItem,
                                                    cm_producto.ccodprod,
                                                    CONCAT_WS( ' ', cm_producto.cdesprod, tb_pedidodet.observaciones ) AS cdesprod,
                                                    tb_unimed.cabrevia,
                                                    tb_pedidodet.nflgqaqc,
                                                    tb_pedidodet.especificaciones,
                                                    CONCAT_WS('/', tb_equipmtto.cregistro, tb_equipmtto.cdescripcion ) AS registro 
                                                FROM
                                                    tb_pedidodet
                                                    INNER JOIN cm_producto ON tb_pedidodet.idprod = cm_producto.id_cprod
                                                    INNER JOIN tb_unimed ON tb_pedidodet.unid = tb_unimed.ncodmed
                                                    LEFT JOIN tb_equipmtto ON tb_pedidodet.nregistro = tb_equipmtto.idreg 
                                                WHERE
                                                    tb_pedidodet.idpedido = :id 
                                                    AND tb_pedidodet.nflgActivo = 1");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();
                
                if ($rowCount > 0){
                    $filas = 1;
                    while ($rs = $sql->fetch()) {

                        if ( $rs['estadoItem'] ==  53 || $rs['estadoItem'] ==  52) {

                            $atendida = $rs['cant_atendida'] == NULL ? 0 : $rs['cant_atendida'];
                            $aprobar =  number_format($rs['cant_pedida'] - $rs['cant_atendida'],2,'.','');

                            $estado_aprobar = $aprobar == 0 ? "desactivado" : "";

                            $salida .='<tr data-grabado="1" data-idprod="'.$rs['idprod'].'" data-codund="'.$rs['unid'].'" data-idx="'.$rs['iditem'].'" class="'.$estado_aprobar.'">
                                            <td class="textoCentro">'.str_pad($filas++,3,0,STR_PAD_LEFT).'</td>
                                            <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                            <td class="pl20px">'.strtoupper($rs['cdesprod']).'</td>
                                            <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                            <td class="textoDerecha">'.$rs['cant_pedida'].'</td>
                                            <td class="textoCentro">'.number_format($atendida,2).'</td>
                                            <td>
                                                <input type="number" 
                                                            step="any" 
                                                            placeholder="0.00" 
                                                            onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"
                                                            onclick="this.select()" 
                                                            value="'.$aprobar.'"
                                                            class="valorAtendido">
                                            </td>
                                            <td class="textoCentro">'.$rs['nroparte'].'</td>
                                            <td class="textoCentro"><input type="text" value="'.$rs['obsAprueba'].'"></td>
                                            <td class="textoCentro">'.$rs['registro'].'</td>
                                            <td class="textoCentro"><input type="checkbox" checked></td>
                                        </tr>';
                        }
                    }
                }
                
                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function consultarDetallesAsignacion($id){
            try {
                $salida ="";

                $sql=$this->db->connect()->prepare("SELECT
                                                    tb_pedidodet.iditem,
                                                    tb_pedidodet.idpedido,
                                                    tb_pedidodet.idprod,
                                                    tb_pedidodet.idtipo,
                                                    tb_pedidodet.nroparte,
                                                    tb_pedidodet.unid,
                                                    UPPER(tb_pedidodet.obsAprueba) AS observaAprueba,
                                                    REPLACE ( FORMAT( tb_pedidodet.cant_pedida, 2 ), ',', '' ) AS cant_pedida,
                                                    REPLACE ( FORMAT( tb_pedidodet.cant_resto, 2 ), ',', '' ) AS cant_pendiente,
                                                    REPLACE ( FORMAT( tb_pedidodet.cant_atend, 2 ), ',', '' ) AS cant_atendida,
                                                    REPLACE ( FORMAT( tb_pedidodet.cant_aprob, 2 ), ',', '' ) AS cant_aprob,
                                                    tb_pedidodet.estadoItem,
                                                    cm_producto.ccodprod,
                                                    UPPER(CONCAT_WS( ' ', cm_producto.cdesprod, tb_pedidodet.observaciones )) AS cdesprod,
                                                    tb_unimed.cabrevia,
                                                    tb_pedidodet.nflgqaqc,
                                                    tb_pedidodet.especificaciones,
                                                    CONCAT_WS('/', tb_equipmtto.cregistro, tb_equipmtto.cdescripcion ) AS registro 
                                                FROM
                                                    tb_pedidodet
                                                    LEFT JOIN cm_producto ON tb_pedidodet.idprod = cm_producto.id_cprod
                                                    LEFT JOIN tb_unimed ON tb_pedidodet.unid = tb_unimed.ncodmed
                                                    LEFT JOIN tb_equipmtto ON tb_pedidodet.nregistro = tb_equipmtto.idreg 
                                                WHERE
                                                    tb_pedidodet.idpedido = :id 
                                                    AND tb_pedidodet.nflgActivo = 1
                                                    AND (tb_pedidodet.estadoItem = 54 OR tb_pedidodet.estadoItem = 230)");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();
                
                if ($rowCount > 0){
                    $filas = 1;
                    while ($rs = $sql->fetch()) {

                        $atendida = $rs['cant_atendida'] == NULL || $rs['cant_atendida'] == '' ? 0 : $rs['cant_atendida'];
                        //$aprobar =  $rs['cant_pedida'] - $rs['cant_atendida'];
                        $aprobar = $rs['cant_aprob'];

                        $estado_aprobar = $aprobar == 0 ? "desactivado" : "";
                        
                        $salida .='<tr data-grabado="1" data-idprod="'.$rs['idprod'].'" data-codund="'.$rs['unid'].'" data-idx="'.$rs['iditem'].'" class="'.$estado_aprobar.'">
                                        <td class="textoCentro">'.str_pad($filas++,3,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl20px">'.$rs['cdesprod'].'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                        <td class="textoCentro">'.$rs['cant_pedida'].'</td>
                                        <td class="textoCentro">'.$rs['cant_atendida'].'</td>
                                        <td>
                                            <input type="text" 
                                                        step="any" 
                                                        placeholder="0.00" 
                                                        onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"
                                                        onclick="this.select()" 
                                                        value="'.number_format($aprobar,2).'"
                                                        class="textoDerecha">
                                        </td>
                                        <td class="textoCentro">'.$rs['nroparte'].'</td>
                                        <td class="pl20px">'.$rs['observaAprueba'].'</td>
                                        <td class="textoCentro">'.$rs['registro'].'</td>
                                        <td class="textoCentro"><input type="checkbox" checked></td>
                                    </tr>';
                    }
                }
                
                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function generateRequestPDF($pedido){
            try{
                require_once('public/formatos/pedidos.php');
                $cabecera = $this->requestCab($pedido);
                $detalles = $this->requestDetails($pedido);

                $num = $cabecera[0]['numero'];
                $fec = $cabecera[0]['emision'];
                $usr = $cabecera[0]['cnombres'];
                $pry = $cabecera[0]['proyecto'];
                $are = $cabecera[0]['area'];
                $cos = $cabecera[0]['proyecto'];
                $tra = $cabecera[0]['transporte'];
                $con = $cabecera[0]['concepto'];
                $sol = $cabecera[0]['nombres'];
                $esp = $cabecera[0]['detalle'];

                $reg = ''; 
                $dti = $cabecera[0]['idtipomov'] == 37 ? "PEDIDO DE COMPRA":"PEDIDO DE SERVICIO";
                $mmt = "";
                $cla = "NORMAL";
                $msj = $cabecera[0]['estadodoc'] == 49 ? "VISTA PREVIA":"EMITIDO";
                $ruta = "public/documentos/temp/";
                $filename =  uniqid().".pdf";

                $pdf = new PDF($num,$fec,$pry,$cos,$are,$con,$mmt,$cla,$tra,$usr,$sol,$reg,$esp,$dti,$msj,"");
                $pdf->AddPage();
                $pdf->AliasNbPages();
                $pdf->SetWidths(array(10,15,70,8,10,17,15,15,15,15));
                $pdf->SetFont('Arial','',5);

                $item = 1;
                $lc = 0;
                $rc = 0; 

                foreach($detalles as $detalle) {
                    $pdf->SetAligns(array("L","L","L","L","R","L","L","L","L","L"));
                    $pdf->Row(array($item,
                                    $detalle['ccodprod'],
                                    utf8_decode($detalle['cdesprod']."\n".$detalle['observaciones']),
                                    $detalle['cabrevia'],
                                    $detalle['cant_pedida'],
                                    '',
                                    '',
                                    '',
                                    '',
                                    ''));

                    $lc++;
                    $rc++;
                    $item++;

                    if ($lc == 17) {
                        $pdf->AddPage();
                        $lc = 0;
                    }
                }

                $lc = 0;
                $rc = 0;


                $pdf->Output($ruta.$filename,'F');
            
                return $filename;

            }catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function requestCab($pedido){
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
                                                        LPAD(ibis.tb_pedidocab.nrodoc,6,0) AS numero, 
                                                        ibis.tb_pedidocab.usuario, 
                                                        ibis.tb_pedidocab.concepto, 
                                                        ibis.tb_pedidocab.detalle, 
                                                        ibis.tb_pedidocab.nivelAten,
                                                        ibis.tb_pedidocab.detalle,  
                                                        ibis.tb_pedidocab.docfPdfPrev, 
                                                        ibis.tb_pedidocab.docPdfEmit, 
                                                        ibis.tb_pedidocab.docPdfAprob, 
                                                        ibis.tb_pedidocab.verificacion, 
                                                        CONCAT( rrhh.tabla_aquarius.apellidos, ' ', rrhh.tabla_aquarius.nombres ) AS nombres, 
                                                        UPPER(
                                                        CONCAT( ibis.tb_proyectos.ccodproy, ' ', ibis.tb_proyectos.cdesproy )) AS proyecto, 
                                                        UPPER(
                                                        CONCAT( ibis.tb_area.ccodarea, ' ', ibis.tb_area.cdesarea )) AS area, 
                                                        UPPER(
                                                        CONCAT( ibis.tb_parametros.nidreg, ' ', ibis.tb_parametros.cdescripcion )) AS transporte,
                                                        tb_parametros.cobservacion, 
                                                        estados.cdescripcion AS estado, 
                                                        estados.cabrevia, 
                                                        UPPER(
                                                        CONCAT_WS( ' ', tipos.nidreg, tipos.cdescripcion )) AS tipo, 
                                                        ibis.tb_proyectos.veralm, 
                                                        ibis.tb_user.cnombres,
                                                        ibis.tb_partidas.cdescripcion,
                                                        ibis.tb_pedidocab.idpartida
                                                    FROM
                                                        ibis.tb_pedidocab
                                                        INNER JOIN
                                                        rrhh.tabla_aquarius
                                                        ON 
                                                            ibis.tb_pedidocab.idsolicita = rrhh.tabla_aquarius.internal
                                                        INNER JOIN
                                                    ibis.tb_proyectos ON ibis.tb_pedidocab.idcostos = ibis.tb_proyectos.nidreg
                                                    INNER JOIN ibis.tb_area ON ibis.tb_pedidocab.idarea = ibis.tb_area.ncodarea
                                                    INNER JOIN ibis.tb_parametros ON ibis.tb_pedidocab.idtrans = ibis.tb_parametros.nidreg
                                                    INNER JOIN ibis.tb_parametros AS transportes ON ibis.tb_pedidocab.idtrans = transportes.nidreg
                                                    INNER JOIN ibis.tb_parametros AS estados ON ibis.tb_pedidocab.estadodoc = estados.nidreg
                                                    INNER JOIN ibis.tb_parametros AS tipos ON ibis.tb_pedidocab.idtipomov = tipos.nidreg
                                                    INNER JOIN ibis.tb_user ON ibis.tb_pedidocab.usuario = ibis.tb_user.iduser
                                                    LEFT JOIN ibis.tb_partidas ON ibis.tb_pedidocab.idpartida = ibis.tb_partidas.idreg 
                                                    WHERE
                                                        tb_pedidocab.idreg = :id 
                                                    LIMIT 1");
                $sql->execute(['id'=>$pedido]);
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

        private function requestDetails($pedido) {
            try {
                $sql=$this->db->connect()->prepare("SELECT
                                                    tb_pedidodet.iditem,
                                                    tb_pedidodet.idpedido,
                                                    tb_pedidodet.idprod,
                                                    tb_pedidodet.idtipo,
                                                    tb_pedidodet.nroparte,
                                                    tb_pedidodet.unid,
                                                    UPPER(tb_pedidodet.observaciones) AS observaciones,
                                                    REPLACE(FORMAT(tb_pedidodet.cant_pedida,2),',','') AS cant_pedida,
                                                    tb_pedidodet.estadoItem,
                                                    cm_producto.ccodprod,
                                                    UPPER(cm_producto.cdesprod) AS cdesprod,
                                                    tb_unimed.cabrevia,
                                                    tb_pedidodet.nflgqaqc 
                                                FROM
                                                    tb_pedidodet
                                                    INNER JOIN cm_producto ON tb_pedidodet.idprod = cm_producto.id_cprod
                                                    INNER JOIN tb_unimed ON tb_pedidodet.unid = tb_unimed.ncodmed 
                                                WHERE
                                                    tb_pedidodet.idpedido = :id 
                                                    AND tb_pedidodet.nflgActivo = 1");
                $sql->execute(["id"=>$pedido]);
                $rowCount = $sql->rowCount();
                $detalles = [];
                if ($rowCount > 0) {
                    while($rs = $sql->fetch()) {
                        $detalles[] = $rs;
                    }
                }

                return $detalles;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        private function obtenerProformas($id){
            try {
                $proveedores = 0;
                $codpr = [];
                $salida ='<thead>
                            <tr>
                                <th rowspan="2" width="3%">ITEM</th>
                                <th rowspan="2" width="35%">DESCRIPCION</th>
                                <th rowspan="2" width="3%">UND</th>';
                $sql = $this->db->connect()->prepare("SELECT
                                                            lg_proformacab.id_regmov,
                                                            lg_proformacab.id_centi,
                                                            cm_entidad.crazonsoc,
                                                            cm_entidad.id_centi AS id_proveedor 
                                                        FROM
                                                            lg_proformacab
                                                            INNER JOIN cm_entidad ON lg_proformacab.id_centi = cm_entidad.cnumdoc 
                                                        WHERE
                                                            lg_proformacab.id_regmov = :id");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .= '<th colspan="5">'.$rs['crazonsoc'].'</th>';
                        $codpr[$proveedores] = $rs['id_centi'];
                        $proveedores++;
                    }
                }

                $salida .= '</tr><tr>';

                for ($i=0; $i < $proveedores ; $i++) { 
                    $salida .= '<th width="6%">Precio Unit</th>
					            <th width="6%">F.Entrega</th>
					            <th width="3%">Dias</th>
					            <th width="3%">Adj.</th>
                                <th width="3%">...</th>';
                }

                $salida .= '</tr></thead>';

                $cuerpo = $this->detalleProductosProforma($id,$codpr);

                return $salida.$cuerpo;

            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }
        
        private function detalleProductosProforma($id,$codpr){
            try {
                $detalle = "<tbody>";
                $item=1;
                $linea = 1;

                $sql = $this->db->connect()->prepare("SELECT
                                                        tb_pedidodet.iditem,
                                                        tb_pedidodet.idprod,
                                                        UPPER(
                                                        CONCAT_WS(' ', cm_producto.cdesprod, tb_pedidodet.observaciones )) AS producto,
                                                        tb_pedidodet.cant_aprob,
                                                        tb_unimed.cabrevia 
                                                    FROM
                                                        tb_pedidodet
                                                        INNER JOIN cm_producto ON tb_pedidodet.idprod = cm_producto.id_cprod
                                                        INNER JOIN tb_unimed ON tb_pedidodet.unid = tb_unimed.ncodmed 
                                                    WHERE
                                                        tb_pedidodet.idpedido = :id 
                                                        AND cant_aprob > 0
                                                        AND tb_pedidodet.nflgActivo = 1");
                $sql->execute(["id"=>$id]);
                $rowcount = $sql->rowcount();

                if ($rowcount > 0){
                    while ($rs = $sql->fetch()) {
                        $detalle .= '<tr data-fila="'.$item.'">
                                        <td class="textoCentro">'.str_pad($linea++,3,"0",STR_PAD_LEFT).'</td>
                                        <td class="pl10px">'.$rs['producto'].'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td> '.$this->preciosProforma($id,$codpr,$rs['iditem']);
                        $item++;
                    }
                }

                $detalle.="</tr></tbody>";
                

                return $detalle;

            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        private function preciosProforma($id,$codpr,$item){
            $nreg = count($codpr);
            $precios = "";
            $opc = 1;

           for ($i=0; $i < $nreg; $i++) { 
                $sql = $this->db->connect()->prepare("SELECT
                                                        lg_proformadet.id_regmov,
                                                        lg_proformadet.niddet,
                                                        lg_proformadet.id_centi,
                                                        lg_proformadet.cantcoti,
                                                        lg_proformadet.id_cprod,
                                                        lg_proformadet.ffechaent,
                                                        lg_proformadet.precunit,
                                                        lg_proformadet.nitemprof,
                                                        lg_proformadet.cdetalle,
                                                        lg_proformadet.cotref,
                                                        DATE_FORMAT( lg_proformadet.fregsys, '%Y-%m-%d' ) AS emitido,
                                                        DATEDIFF(
                                                            lg_proformadet.ffechaent,
                                                        DATE_FORMAT( lg_proformadet.fregsys, '%Y-%m-%d' )) AS dias,
                                                        lg_proformadet.cdocPDF,
                                                        lg_proformadet.total,
                                                        tb_parametros.cabrevia 
                                                    FROM
                                                        lg_proformadet
                                                        INNER JOIN tb_parametros ON lg_proformadet.ncodmon = tb_parametros.nidreg 
                                                    WHERE
                                                        lg_proformadet.id_regmov = :cod 
                                                        AND lg_proformadet.id_centi = :ent 
                                                        AND lg_proformadet.niddet = :item");

                $sql->execute(["cod"=>$id,"ent"=>$codpr[$i],"item"=>$item]);
                $rs = $sql->fetchAll();
                $url = "public/documentos/pedidos/especificaciones/";

                //$adjunto = $rs[0]["cdocPDF"] == "" ? "": '<a href="'.$url.$rs[0]['cdocPDF'].'"><i class="far fa-sticky-note"></i></a>';
                $adjunto = "";
                    
                $precios .= '<td class="textoDerecha pr20px '.$codpr[$i].'">'.$rs[0]['cabrevia']." ".number_format($rs[0]['precunit'], 2, '.', ',').'</td>
                             <td class="textoCentro '.$codpr[$i].'">'.date("d/m/Y", strtotime($rs[0]['ffechaent'])).'</td>
                             <td class="textoDerecha pr20px '.$codpr[$i].'">'.$rs[0]['dias'].'</td>
                             <td class="textoCentro '.$codpr[$i].'">'.$adjunto.'</td>
                             <td class="textoCentro '.$codpr[$i].'" data-position="'.$i.'"
                                                         data-pedido="'.$id.'"
                                                         data-entidad="'.$codpr[$i].'"
                                                         data-detprof="'.$rs[0]["nitemprof"].'"
                                                         data-total="'.$rs[0]['total'].'"
                                                         data-precio="'.$rs[0]['precunit'].'"
                                                         data-detped="'.$rs[0]['niddet'].'"
                                                         data-entrega="'.$rs[0]['ffechaent'].'"
                                                         data-dias="'.$rs[0]['dias'].'"
                                                         data-detalle="'.$rs[0]['cdetalle'].'"
                                                         data-idproforma="'.$rs[0]['cotref'].'"
                                                         data-espec="'.$rs[0]['cdocPDF'].'"><input type="checkbox" name="opcion'.$nreg.'" class="chkVerificado"</td>';
           }

           return $precios;
        }

        private function consultarDetallesConformidad($id){
            try {
                $salida ="";

                $sql=$this->db->connect()->prepare("SELECT
                                                    tb_pedidodet.iditem,
                                                    tb_pedidodet.idpedido,
                                                    tb_pedidodet.idprod,
                                                    tb_pedidodet.idtipo,
                                                    tb_pedidodet.nroparte,
                                                    tb_pedidodet.unid,
                                                    UPPER(tb_pedidodet.docEspec) AS docEspec,
                                                    FORMAT(tb_pedidodet.cant_aprob,2) AS cant_aprob,
                                                    FORMAT(tb_pedidodet.cant_atend,2) AS cant_atendida,
                                                    FORMAT(tb_pedidodet.cant_resto,2) AS cant_pendiente,
                                                    tb_pedidodet.estadoItem,
                                                    tb_pedidodet.docEspec,
                                                    cm_producto.ccodprod,
                                                    UPPER(CONCAT_WS(' ',cm_producto.cdesprod, tb_pedidodet.observaciones)) AS cdesprod,
                                                    tb_unimed.cabrevia,
                                                    tb_pedidodet.nflgqaqc 
                                                FROM
                                                    tb_pedidodet
                                                    INNER JOIN cm_producto ON tb_pedidodet.idprod = cm_producto.id_cprod
                                                    INNER JOIN tb_unimed ON tb_pedidodet.unid = tb_unimed.ncodmed 
                                                WHERE
                                                    tb_pedidodet.idpedido = :id 
                                                AND tb_pedidodet.nflgAdjudicado  = 1
                                                AND tb_pedidodet.nflgActivo = 1");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();
                
                if ($rowCount > 0){
                    $filas = 1;
                    while ($rs = $sql->fetch()) {
                        
                        $salida .='<tr data-grabado="1" data-idprod="'.$rs['idprod'].'" data-codund="'.$rs['unid'].'" data-idx="'.$rs['iditem'].'">
                                        <td class="textoCentro">'.str_pad($filas++,3,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl20px">'.$rs['cdesprod'].'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                        <td class="numeroTabla">'.$rs['cant_aprob'].'</td>
                                        <td></td>
                                        <td class="pl20px">'.$rs['docEspec'].'</td>
                                        <td class="textoCentro"><input type="text"></td>
                                        <td class="textoCentro"><input type="checkbox" checked></td>
                                        <td class="textoCentro"><a href="'.$rs['docEspec'].'"><i class="far fa-sticky-note"></i</a></td>
                                    </tr>';
                    }
                }
                
                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        //aca estan todas las funciones de las ordenes
        public function consultarOrdenId($id){
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                        lg_ordencab.id_regmov,
                                                        LPAD( lg_ordencab.cnumero, 6, 0 ) AS cnumero,
                                                        lg_ordencab.ffechadoc,
                                                        lg_ordencab.ncodcos,
                                                        lg_ordencab.ncodarea,
                                                        lg_ordencab.id_centi,
                                                        lg_ordencab.ctiptransp,
                                                        lg_ordencab.ncodpago,
                                                        lg_ordencab.nplazo,
                                                        lg_ordencab.ncodcot,
                                                        lg_ordencab.nEstadoDoc,
                                                        lg_ordencab.id_refpedi,
                                                        lg_ordencab.ntcambio,
                                                        lg_ordencab.cnumcot,
                                                        lg_ordencab.userModifica,
                                                        UPPER( lg_ordencab.cObservacion ) AS concepto,
                                                        UPPER( tb_pedidocab.detalle ) AS detalle,
                                                        tb_pedidocab.docPdfAprob,
                                                        UPPER(
                                                        CONCAT_WS( ' ', tb_proyectos.ccodproy, tb_proyectos.cdesproy )) AS costos,
                                                        lg_ordencab.ncodpry,
                                                        lg_ordencab.ncodalm,
                                                        UPPER(
                                                        CONCAT_WS( ' ', tb_area.ccodarea, tb_area.cdesarea )) AS area,
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
                                                        UPPER( cm_entidadcon.cnombres ) AS cnombres,
                                                        cm_entidadcon.cemail,
                                                        cm_entidadcon.ctelefono1,
                                                        transportes.cdescripcion AS transporte,
                                                        UPPER( tb_almacen.cdesalm ) AS cdesalm,
                                                        UPPER( tb_almacen.ctipovia ) AS direccion,
                                                        cm_entidad.cviadireccion,
                                                        cm_entidad.cemail AS mail_entidad,
                                                        cm_entidad.nagenret,
                                                        lg_ordencab.cverificacion,
                                                        lg_ordencab.ntotal,
                                                        lg_ordencab.nigv,
                                                        lg_ordencab.lentrega,
                                                        lg_ordencab.cReferencia,
                                                        FORMAT( lg_ordencab.ntotal, 2 ) AS ctotal,
                                                        tb_pedidocab.nivelAten,
                                                        lg_ordencab.nNivAten AS autorizado,
                                                        lg_ordencab.nfirmaLog,
                                                        lg_ordencab.nfirmaFin,
                                                        lg_ordencab.nfirmaOpe,
                                                        LPAD( tb_pedidocab.nrodoc, 6, 0 ) AS nrodoc,
                                                        ( SELECT SUM( lg_ordendet.nunitario * lg_ordendet.ncanti ) FROM lg_ordendet WHERE lg_ordendet.id_orden = lg_ordencab.id_regmov ) AS total_multiplicado,
                                                        UPPER(lg_ordenextras.cdescription) AS condiciones
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
                                                        INNER JOIN cm_entidadcon ON cm_entidad.id_centi = cm_entidadcon.id_centi
                                                        INNER JOIN tb_parametros AS transportes ON lg_ordencab.ctiptransp = transportes.nidreg
                                                        INNER JOIN tb_almacen ON lg_ordencab.ncodalm = tb_almacen.ncodalm
                                                        INNER JOIN lg_ordendet ON lg_ordencab.id_regmov = lg_ordendet.id_regmov
                                                        LEFT JOIN lg_ordenextras ON lg_ordencab.id_regmov = lg_ordenextras.idorden
                                                    WHERE
                                                        lg_ordencab.id_regmov = :id 
                                                        AND lg_ordencab.nflgactivo = 1 
                                                        LIMIT 1");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();
                
                if ($rowCount > 0) {
                    $docData = array();
                    while($row=$sql->fetch(PDO::FETCH_ASSOC)){
                        $docData[] = $row;
                    }
                }

                $detalles = $this->consultarDetallesOrden($id);
                $comentarios = $this->consultarComentarios($id);
                $total = $this->calculaTotalOrden($id);
                $ncomentarios = $this->consultarTotalComentarios($id);
                $adjuntos = $this->verAdjuntosOrden($id);
                $adicionales = $this->consultarAdicionales($id);
                $nro_adjuntos = $this->contarAdjuntos($id,"ORD");

                return array("cabecera"=>$docData,
                            "detalles"=>$detalles,
                            "comentarios"=>$comentarios,
                            "total"=>$total,
                            "bocadillo"=>$ncomentarios,
                            "adjuntos"=>$adjuntos,
                            "adicionales"=>$adicionales,
                            "total_adicionales"=>$this->totalAdicionales($id),
                            "total_adjuntos"=>$nro_adjuntos);

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function grabarComentarios($codigo,$comentarios,$usuario) {
            try {
                $datos = json_decode($comentarios);
                $nreg = count($datos);

                for ($i=0; $i < $nreg; $i++) { 
                    $sql = $this->db->connect()->prepare("INSERT INTO lg_ordencomenta 
                                                        SET id_regmov=:id,id_cuser=:usr,ffecha=:fecha,ccomenta=:comentario");
                    $sql->execute(["id"=>$codigo,
                                    "usr"=>$usuario,
                                    "fecha"=>$datos[$i]->fecha,
                                    "comentario"=>$datos[$i]->comentario]);
                }

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function buscarUserComentario($id,$user){
            try {
                $sql= $this->db->connect()->prepare("SELECT
                                                        COUNT( lg_ordencomenta.id_regmov ) AS total_comentario
                                                    FROM
                                                        lg_ordencomenta
                                                        INNER JOIN tb_user ON lg_ordencomenta.id_cuser = tb_user.iduser 
                                                    WHERE
                                                        lg_ordencomenta.id_regmov = :id 
                                                        AND lg_ordencomenta.id_cuser = :user");
                $sql->execute(["id"=>$id,"user"=>$user]);
                $result = $sql->fetchAll();

                return $result[0]['total_comentario'];
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function detallesComentarios($orden){
            try {
                $sql= $this->db->connect()->prepare("SELECT
                                                        IF( ISNULL( tb_user.rol ), '-', tb_user.rol ) AS rol
                                                    FROM
                                                        lg_ordencomenta
                                                        LEFT JOIN
                                                        tb_user
                                                        ON lg_ordencomenta.id_cuser = tb_user.iduser
                                                    WHERE
                                                        lg_ordencomenta.id_regmov = :orden
                                                    ORDER BY lg_ordencomenta.fregsys DESC
                                                    LIMIT 1");
                $sql->execute(["orden"=>$orden]);

                $result = $sql->fetchAll();

                return array("rol"=>$result[0]['rol']);
            }catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function creaComentario($orden){
            try {
                $sql= $this->db->connect()->prepare("SELECT
                                            tb_user.rol 
                                        FROM
                                            lg_ordencomenta
                                            INNER JOIN tb_user ON lg_ordencomenta.id_cuser = tb_user.iduser 
                                        WHERE
                                            lg_ordencomenta.id_regmov =:orden 
                                            AND NOT ISNULL(tb_user.rol)");
                
                $sql->execute(["orden"=>$orden]);

                $result = $sql->fetchAll();

                return array("rol"=>$result[0]['rol']);
            }catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function verificarComentario($orden){
            try {
                $sql= $this->db->connect()->prepare("SELECT
                                                            tb_user.nrol 
                                                        FROM
                                                            lg_ordencomenta
                                                            INNER JOIN tb_user ON lg_ordencomenta.id_cuser = tb_user.iduser 
                                                        WHERE
                                                            lg_ordencomenta.id_regmov = :orden 
                                                        ORDER BY
                                                            lg_ordencomenta.fregsys ASC 
                                                        LIMIT 1");
                
                $sql->execute(["orden"=>$orden]);

                $result = $sql->fetchAll();

                return array("nrol"=>$result[0]['nrol']);
            }catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function contarComentarios($orden) {
            try {
                $sql= $this->db->connect()->prepare("SELECT
                                                        COUNT( lg_ordencomenta.id_regmov ) AS numero
                                                    FROM
                                                        lg_ordencomenta
                                                    WHERE
                                                        lg_ordencomenta.id_regmov = :orden");
                $sql->execute(["orden"=>$orden]);

                $result = $sql->fetchAll();

                return array("numero"=>$result[0]['numero']);
            }catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function calcularTotalOrden($id) {
            try {
                $sql= $this->db->connect()->prepare("SELECT
                                                        SUM( lg_ordendet.nunitario * lg_ordendet.ncanti ) AS total,
                                                    FROM
                                                        lg_ordendet 
                                                    WHERE
                                                        lg_ordendet.id_orden = :id");
                $sql->execute(["id"=>$id]);

                $result = $sql->fetchAll();

                return $result[0]['total'];

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function consultarDetallesOrden($id){
            try {
                $salida = "";
                $sql=$this->db->connect()->prepare("SELECT
                                            lg_ordendet.nitemord,
                                            lg_ordendet.id_regmov,
                                            lg_ordendet.niddeta,
                                            lg_ordendet.nidpedi,
                                            lg_ordendet.cobserva,
                                            lg_ordendet.id_cprod,
                                            REPLACE ( FORMAT( lg_ordendet.ncanti, 2 ), ',', '' ) AS ncanti,
                                            REPLACE ( FORMAT(lg_ordendet.nunitario,4), ',', '') AS nunitario,
                                            FORMAT( lg_ordendet.nigv, 4 ) AS nigv,
                                            FORMAT( tb_pedidodet.total - lg_ordendet.nigv, 2 ) AS subtotal,
                                            FORMAT( lg_ordendet.ntotal, 4 ) AS ntotal,
                                            REPLACE ( FORMAT( lg_ordendet.nunitario * lg_ordendet.ncanti, 2 ), ',', '' ) AS total_real,
                                            cm_producto.ccodprod,
                                            UPPER(cm_producto.cdesprod) AS cdesprod,
                                            cm_producto.nund,
                                            tb_unimed.cabrevia,
                                            FORMAT( tb_pedidodet.total, 2 ) AS total,
                                            tb_pedidodet.idpedido,
                                            tb_pedidodet.nroparte,
                                            tb_pedidodet.estadoItem,
                                            monedas.cabrevia AS moneda,
                                            tb_pedidodet.total AS total_numero,
                                            LPAD( tb_pedidocab.nrodoc, 6, 0 ) AS nro_pedido 
                                        FROM
                                            lg_ordendet
                                            INNER JOIN cm_producto ON lg_ordendet.id_cprod = cm_producto.id_cprod
                                            INNER JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed
                                            INNER JOIN tb_pedidodet ON lg_ordendet.niddeta = tb_pedidodet.iditem
                                            INNER JOIN tb_parametros AS monedas ON lg_ordendet.nmonref = monedas.nidreg
                                            INNER JOIN tb_pedidocab ON lg_ordendet.nidpedi = tb_pedidocab.idreg 
                                        WHERE
                                            lg_ordendet.id_regmov = :id 
                                            AND ISNULL(
                                            lg_ordendet.nflgactivo)");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();
                $item = 1;
                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()){

                        $observa = $rs['cobserva'] == 'undefined' ? '' : $rs['cobserva'];
                        $nroparte = $rs['nroparte'] == 'undefined' ? '' : $rs['nroparte'];


                        $salida.='<tr data-grabado="1" 
                                        data-total="'.$rs['ntotal'].'" 
                                        data-codprod="'.$rs['id_cprod'].'" 
                                        data-itPed="'.$rs['niddeta'].'"
                                        data-itOrd="'.$rs['nitemord'].'"
                                        data-cant="'.$rs['ncanti'].'"
                                        data-proceso="'.$rs['estadoItem'].'"
                                        data-pedido="'.$rs['nidpedi'].'">
                                    <td class="textoCentro"><a href="'.$rs['nitemord'].'"><i class="fas fa-ban"></i></a></td>
                                    <td class="textoCentro">'.str_pad($item++,3,0,STR_PAD_LEFT).'</td>
                                    <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                    <td class="pl20px">'.$rs['cdesprod'].'</td>
                                    <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                    <td class="textoDerecha pr5px"><input type="number" 
                                                                    step="any" 
                                                                    placeholder="0.00" 
                                                                    onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"
                                                                    onclick="this.select()"
                                                                    value='.$rs['ncanti'].'>
                                    </td>
                                    <td class="textoDerecha pr5px">
                                    <input type="number"
                                        step="any" 
                                        placeholder="0.00" 
                                        onclick="this.select()"
                                        onchange="(function(el){el.value=parseFloat(el.value).toFixed(4);})(this)"
                                        value='.$rs['nunitario'].'
                                        class="textoDerecha">
                                    </td>
                                    <td class="textoDerecha pr5px">'.$rs['total_real'].'</td>
                                    <td class="textoCentro">'.$nroparte.'</td>
                                    <td class="pl20px">'.$rs['nro_pedido'].'</td>
                                    <td><textarea>'.$observa.'</textarea></td>
                                </tr>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function consultarComentarios($id){
            try {
                $salida="";
                $sql = $this->db->connect()->prepare("SELECT
                                                    UPPER(lg_ordencomenta.ccomenta) AS ccomenta,
                                                    lg_ordencomenta.ffecha,
                                                    tb_user.cnombres 
                                                FROM
                                                    lg_ordencomenta
                                                    INNER JOIN tb_user ON lg_ordencomenta.id_cuser = tb_user.iduser 
                                                WHERE
                                                    lg_ordencomenta.id_regmov = :id
                                                ORDER BY fregsys DESC");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()){
                        $salida.='<tr data-grabar="1">
                                    <td >'.$rs['cnombres'].'</td>
                                    <td><input type="date" value="'.$rs['ffecha'].'" readonly></td>
                                    <td>'.$rs['ccomenta'].'</td>
                                    <td class="con_borde centro"><a href="#"><i class="far fa-trash-alt"></i></a></td>
                                </tr>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }


        private function consultarAdicionales($id){
            try {
                $salida="";
                $sql = $this->db->connect()->prepare("SELECT
                                                        UPPER(lg_ordenadic.cconcepto) AS cconcepto,
                                                        lg_ordenadic.nmonto,
                                                        tb_parametros.cabrevia,
                                                        lg_ordenadic.idorden,
                                                        tb_parametros.cdescripcion 
                                                    FROM
                                                        lg_ordenadic
                                                        INNER JOIN lg_ordencab ON lg_ordenadic.idorden = lg_ordencab.id_regmov
                                                        INNER JOIN tb_parametros ON lg_ordencab.ncodmon = tb_parametros.nidreg 
                                                    WHERE
                                                        lg_ordenadic.idorden = :id");
                $sql->execute(["id"=>$id]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()){
                        $salida.='<tr>
                                    <td><input type="text" value="'.$rs['cconcepto'].'" readonly></td>
                                    <td>'.$rs['cdescripcion'].'</td>
                                    <td><input type="number" value="'.$rs['nmonto'].'" readonly></td>
                                    <td class="con_borde centro"><a href="#"><i class="far fa-trash-alt"></i></a></td>
                                </tr>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function consultarTotalComentarios($id){
            try {
                $salida="";
                $sql = $this->db->connect()->prepare("SELECT
                                                COUNT(id_regmov) AS comments__number
                                            FROM
                                                lg_ordencomenta
                                            WHERE
                                                lg_ordencomenta.id_regmov = :id");
                $sql->execute(["id"=>$id]);
                $result = $sql->fetchAll();

                return $result[0]["comments__number"];
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function calculaTotalOrden($id){
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                        FORMAT( SUM( lg_ordendet.ncanti * lg_ordendet.nunitario ) + lg_ordendet.nigv, 2 ) AS total 
                                                    FROM
                                                        lg_ordendet 
                                                    WHERE
                                                        lg_ordendet.id_regmov = :id");
                $sql->execute(["id"=>$id]);
                $result = $sql->fetchAll();

                return $result[0]["total"];
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function totalAdicionales($id){
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                        SUM( lg_ordenadic.nmonto ) AS total_adicionales 
                                                    FROM
                                                        lg_ordenadic 
                                                    WHERE
                                                        lg_ordenadic.idorden = :id");
                $sql->execute(['id'=>$id]);
                $result = $sql->fetchAll();

                return $result[0]['total_adicionales'];

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function detallesAdicionalesOrden($id){
            try {
                $docData = [];

                $sql = $this->db->connect()->prepare("SELECT
                                                        UPPER(lg_ordenadic.cconcepto) AS cconcepto,
                                                        lg_ordenadic.nmonto
                                                    FROM
                                                        lg_ordenadic 
                                                    WHERE
                                                        lg_ordenadic.idorden = :id");
                $sql->execute(['id'=>$id]);
                
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                    $docData[] = $row;
                }

                return $docData;

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function contarAdjuntos($id,$tipo){
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                        COUNT( lg_regdocumento.id_regmov ) AS total_adjuntos 
                                                    FROM
                                                        lg_regdocumento 
                                                    WHERE
                                                        lg_regdocumento.nidrefer = :id
                                                        AND lg_regdocumento.nflgactivo = 1
                                                        AND lg_regdocumento.cmodulo = :tipo");
                $sql->execute(['id'=>$id,"tipo"=>$tipo]);
                $result = $sql->fetchAll();

                return $result[0]['total_adjuntos'];

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function verAdjuntosOrden($id){
            try {
                $salida = "";

                $sql = $this->db->connect()->prepare("SELECT creferencia,
                                                            cdocumento,
                                                            id_regmov 
                                                        FROM lg_regdocumento 
                                                        WHERE nidrefer=:id
                                                        AND nflgactivo = 1
                                                        AND cmodulo='ORD'");
                $sql->execute(['id'=>$id]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()) {

                        $icono = $this->tipoArchivo($rs['creferencia']);

                        $salida .= '<li>
                                        <a href="'.$rs['creferencia'].'" data-archivo="'.$rs['creferencia'].'" class="icono_archivo">'.$icono.'<p>'.$rs['cdocumento'].'</p></a>
                                        <a href="'.$rs['id_regmov'].'" class="file_delete"><i class="fas fa-ban"></i></a>
                                    </li>';
                    }
                }
                
                $ret = array("adjuntos"=>$salida,
                            "archivos"=>$rowCount);

                return $ret;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function verAdjuntosDocs($id,$tipo){
            try {
                $salida = "";

                $sql = $this->db->connect()->prepare("SELECT creferencia,
                                                            cdocumento,
                                                            id_regmov 
                                                        FROM lg_regdocumento 
                                                        WHERE nidrefer=:id
                                                        AND nflgactivo = 1
                                                        AND cmodulo=:tipo");
                $sql->execute(['id'=>$id,"tipo"=>$tipo]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()) {

                        $icono = $this->tipoArchivo($rs['creferencia']);

                        $salida .= '<li>
                                        <a href="'.$rs['creferencia'].'" data-archivo="'.$rs['creferencia'].'" class="icono_archivo">'.$icono.'<p>'.$rs['cdocumento'].'</p></a>
                                        <a href="'.$rs['id_regmov'].'" class="file_delete"><i class="fas fa-ban"></i></a>
                                    </li>';
                    }
                }
                
                $ret = array("adjuntos"=>$salida,
                            "archivos"=>$rowCount);

                return $ret;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        //marcar items para no ser consultados
        public function itemMarcado($id,$estado,$io){
            try {

                $estado_registro = 54;
                $estado_orden = 0;

                $sql = $this->db->connect()->prepare("UPDATE tb_pedidodet 
                                                        SET nflgOrden =:estado,
                                                            idorden = NULL,
                                                            cant_orden = 0,
                                                            estadoItem = :estadoItem
                                                        WHERE iditem =:id");
                                                        
                $sql->execute(["id" => $id,"estado" => $estado_orden, "estadoItem" => $estado_registro]);

                if ($io != '-') {
                    $this->quitarItemOrden($io);
                }
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        //cuando se quita lel item de la orden y sigue sumando
        private function quitarItemOrden($io) {
            try {
                $sql = $this->db->connect()->prepare("UPDATE lg_ordendet 
                                                        SET nflgactivo = NULL,
                                                            id_regmov = NULL,
                                                            nEstadoReg = 105,
                                                            ncanti = 0
                                                        WHERE nitemord =:id");
                $sql->execute(["id" => $io]);
            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        //genera la vista de la orden
        public function generarDocumento($cabecera,$condicion,$detalles){
            //genera vista previa
            require_once("public/formatos/ordenes.php");

            $bancos = $this->bancosProveedor($cabecera['codigo_entidad']);

            //verificar para el numero de orden
            $sql = "SELECT COUNT(lg_ordencab.id_regmov) AS numero FROM lg_ordencab WHERE lg_ordencab.ncodcos =:cod";

            $noc = $cabecera['numero'];
            
            if ($cabecera['codigo_tipo'] == "37") {
                $titulo = "ORDEN DE COMPRA" ;

                if ( $cabecera['user_modifica'] != "" ) {
                    $titulo = "ORDEN DE COMPRA - R1" ;
                }

                $prefix = "OC";
                $tipo = "B";
            }else{
                $titulo = "ORDEN DE SERVICIO";

                if ( $cabecera['user_modifica'] != "" ) {
                    $titulo = "ORDEN DE SERVICIO - R1" ;
                }

                $prefix = "OS";
                $tipo = "S";
            }
            

            $anio = explode("-",$cabecera['emision']);

            $orden = $cabecera['sw'] == 0 ? $noc : $cabecera['numero'];
            $titulo = $titulo . " " .$anio[0]. " - " . $orden;
            
            $file = $cabecera['entidad']."_".$prefix.$noc."_".$anio[0].".pdf";
            //$entrega = $this->calcularDias($cabecera['fentrega']);

            $pdf = new PDF($titulo,$condicion,$cabecera['emision'],$cabecera['moneda'],$cabecera['dias'] ." dias",
                            $cabecera['lentrega'],$cabecera['ncotiz'],$cabecera['fentrega'],$cabecera['cpago'],$cabecera['total'],
                            $cabecera['costos'],$cabecera['concepto'],$_SESSION['nombres'],$cabecera['entidad'],$cabecera['ruc_entidad'],
                            $cabecera['direccion_entidad'],$cabecera['telefono_entidad'],$cabecera['correo_entidad'],$cabecera['retencion'],
                            $cabecera['atencion'],$cabecera['telefono_contacto'],$cabecera['correo_contacto'],
                            $cabecera['direccion_almacen'],$cabecera['referencia'],$cabecera['procura'],$cabecera['finanzas'],$cabecera['operaciones'],
                            $cabecera['codigo_tipo'],$cabecera['nivel_autorizacion']);

            $pdf->AddPage();
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(10,15,15,10,93,17,15,15));
            $pdf->SetFont('Arial','',4.8);
            
            $lc = 0;
            $rc = 0;
            $do = false; //para imprimir los detalles de la oc

            $datos = json_decode($detalles);
            $nreg = count($datos);

            for ($i=0; $i < $nreg; $i++) { 
               
                $nparte = $datos[$i]->nroparte != "" ? "NP:". $datos[$i]->nroparte : "";
                
                $pdf->SetAligns(array("C","C","R","C","L","C","R","R"));
                $pdf->Row(array($datos[$i]->item,
                                $datos[$i]->codigo,
                                $datos[$i]->cantidad,
                                $datos[$i]->unidad,
                                TRIM(utf8_decode(strtoupper($datos[$i]->descripcion .' '. $datos[$i]->detalles .' '. $nparte))),
                                $datos[$i]->pedido,
                                $datos[$i]->precio,
                                $datos[$i]->total));
                    $lc++;

                    //aca controla la linea de impresion 
                    if ($pdf->getY() >= 181) {
                        $pdf->AddPage();
                        $lc = 0;
                    }
            }
            
            $pdf->Ln(2);

            $pdf->SetFillColor(229, 229, 229);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(15,6,"TOTAL :","LTB",0,"C",true);
            
            $pdf->SetFont('Arial','B',7);

            $total_adicional = $cabecera['total_adicional'] == ""  ? 0 :  $cabecera['total_adicional'];
            
            $detallesAdicionales = $this->detallesAdicionalesOrden($cabecera['codigo_orden']);
            $totalAdicional = $cabecera['total_adicional'];

            if ($cabecera['radioIgv'] == 0){
                $pdf->Cell(145,6,$this->convertir($cabecera['total_numero']+$total_adicional)." ".$cabecera['moneda'],"TBR",0,"L",true); 
                $pdf->Cell(30,6,number_format($cabecera['total_numero']+$total_adicional,2),"1",1,"R",true);
            }
            else {
                $pdf->Cell(145,6,$this->convertir(($cabecera['total_numero']*1.18)+$total_adicional)." ".$cabecera['moneda'],"TBR",0,"L",true);
                $pdf->Cell(30,6,number_format(($cabecera['total_numero']*1.18)+$total_adicional,2),"1",1,"R",true);
            }

            $pdf->Ln(1);
            $pdf->SetFont('Arial',"","7");
            $pdf->Cell(40,6,"Pedidos Asociados",1,0,"C",true);
            $pdf->Cell(5,6,"",0,0);
            $pdf->Cell(80,6,utf8_decode("Información Bancaria del Proveedor"),1,0,"C",true);
            $pdf->Cell(10,6,"",0,0);

            $pdf->SetX(146);

            $pdf->Cell(33,6,"Valor Venta",0,0);
            $pdf->Cell(20,6,number_format($cabecera['total_numero'],2),0,1,"R");
            

            $pdf->Cell(10,6,utf8_decode("Año"),1,0);   
            $pdf->Cell(10,6,"Tipo",1,0);
            $pdf->Cell(10,6,"Pedido",1,0);
            $pdf->Cell(10,6,"Mantto",1,0);
            $pdf->Cell(5,6,"",0,0);
            $pdf->Cell(35,6,"Detalle del Banco",1,0);
            $pdf->Cell(15,6,"Moneda",1,0);
            $pdf->Cell(30,6,"Nro. Cuenta Bancaria",1,0);

            $pdf->SetX(146);

            if($cabecera['radioIgv'] ==  0) {
                $pdf->SetX(146);
                $pdf->Cell(8,3,"",0,0);
                $pdf->Cell(20,3,"",0,0);
                $pdf->SetX(185);
                $pdf->Cell(20,3,"",0,1); 
            }else{
                $igv = round((floatval($cabecera['total_numero'])*0.18),2);
                $pdf->SetX(146);
                $pdf->Cell(13,3,"IGV",0,0);
                $pdf->Cell(20,3,"(18%)",0,0);
                $pdf->Cell(20,3,number_format($igv,2),0,1,"R");
            }

            $linea = 7;
            
            if ( $totalAdicional ) {
                foreach($detallesAdicionales as $detalle){
                    $pdf->SetX(146);
                    $pdf->Cell(33,6,$detalle['cconcepto'],0,0);
                    $pdf->Cell(20,6,number_format($detalle['nmonto'],2),0,1,"R");
                    $linea = 13;
                }

            }else {
                $pdf->Cell(43,6,"",0,0);
                $pdf->Cell(30,6,"",0,1);
            }
            
            $pdf->SetX(146);
            $pdf->SetFont('Arial',"B","8");
            $pdf->Cell(20,4,"TOTAL",1,0,"L",true);
            $pdf->Cell(15,4,$cabecera['moneda'],1,0,"C",true);

            if ( $cabecera['radioIgv'] == 0 ){
                $pdf->Cell(20,4,number_format($cabecera['total_numero'] +  $total_adicional ,2),1,1,"R",true);
            }        
            else {
                $pdf->Cell(20,4,number_format((($cabecera['total_numero']*1.18)+ $total_adicional ),2),1,1,"R",true);
            }
           
            $nreg = count($bancos);

            $x = $pdf->GetX();
            $y = $pdf->GetY();

            $pdf->SetXY(10,$y-$linea);
            $pdf->SetFont('Arial',"","7");
            $pdf->Cell(10,6,$anio[0],1,0);
            $pdf->Cell(10,6,$tipo,1,0,"C");
            $pdf->Cell(10,6,str_pad($cabecera['nro_pedido'],6,0,STR_PAD_LEFT),1,0);
            $pdf->Cell(10,6,"",1,0);
            
            $pdf->SetXY(55,$y-$linea);
            $pdf->SetFont('Arial',"","6");

            for ($i=0;$i<$nreg;$i++){
                $pdf->Cell(35,4,$bancos[$i]['banco'],1,0);
                $pdf->Cell(15,4,$bancos[$i]['moneda'],1,0);
                $pdf->Cell(30,4,$bancos[$i]['cuenta'],1,1);
                $pdf->Cell(45,4,"",0,0);
            }

            if ($condicion == 0){
                $filename = "public/documentos/ordenes/vistaprevia/".$file;
            }else if ($condicion == 1){
                $filename = "public/documentos/ordenes/emitidas/".$file;
            }else if ($condicion == 2){
                $filename = "public/documentos/ordenes/aprobadas/".$file;
            }else if ($condicion == 3){
                $filename = "public/documentos/ordenes/descargadas/".$file;
            }else if ($condicion == 4){
                $filename = "public/documentos/ordenes/modificadas/".$file;
            }

            $pdf->Output($filename,'F');

            return $file;
        }

        /*para generar la vista de los previas*/
        public function generarVistaOrden($id){
            require_once("public/formatos/ordenes.php");

            $datosOrden         = $this->cabeceraOrden($id);
            $detalles           = $this->detallesOrden($id);

            if ($datosOrden[0]['ntipmov'] == "37") {
                $titulo = "ORDEN DE COMPRA" ;

                if ( $datosOrden[0]['userModifica'] != null) {
                    $titulo = "ORDEN DE COMPRA" ;
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

            $orden = str_pad($datosOrden[0]['cnumero'],6,0,STR_PAD_LEFT);
            $titulo = $titulo . " " .$anio[0]. " - " . $orden;
            
            $file = uniqid().".pdf";

            $condicion = 1;

            $pdf = new PDF($titulo,$condicion,$datosOrden[0]['ffechadoc'],$datosOrden[0]['nombre_moneda'],$datosOrden[0]['nplazo'],
                            $datosOrden[0]['cdesalm'],$datosOrden[0]['cnumcot'],$datosOrden[0]['ffechaent'],$datosOrden[0]['pagos'],"",
                            $datosOrden[0]['costos'],$datosOrden[0]['concepto'],$datosOrden[0]['cnameuser'],$datosOrden[0]['crazonsoc'],
                            $datosOrden[0]['cnumdoc'],$datosOrden[0]['cviadireccion'],$datosOrden[0]['ctelefono1'],$datosOrden[0]['cemail'],$datosOrden[0]['nagenret'],
                            $datosOrden[0]['cnombres'],$datosOrden[0]['ctelefono1'],$datosOrden[0]['mail_entidad'],
                            $datosOrden[0]['direccion'],$datosOrden[0]['cReferencia'],null,null,null,$datosOrden[0]['ntipmov'],null);

            $pdf->AddPage();
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(10,15,15,10,95,17,13,15));
            $pdf->SetFont('Arial','',4);
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
                                
                if ($pdf->getY() >= 190) {
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

            
            $filename = "public/documentos/ordenes/vistaprevia/".$file;

            $pdf->Output($filename,'F');

            return $filename;
        }

        public function generarNotaIngreso(){
            try {
                //code...
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function generarNotaSalida(){
            try {
                //code...
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

         //genera la vista de la orden
         public function generarContrato($cabecera,$condicion,$detalles,$condiciones){
            //genera vista previa
            require_once("public/formatos/contratos.php");

            $bancos = $this->bancosProveedor($cabecera['codigo_entidad']);

            $noc = $cabecera['numero'];
            
            if ($cabecera['codigo_tipo'] == "37") {
                $titulo = "ORDEN DE COMPRA" ;

                if ( $cabecera['user_modifica'] != null) {
                    $titulo = "ORDEN DE COMPRA - R1" ;
                }

                $prefix = "OC";
                $tipo = "B";
            }else{
                $titulo = "ORDEN DE SERVICIO";

                if ( $cabecera['user_modifica'] != null) {
                    $titulo = "ORDEN DE SERVICIO - R1" ;
                }

                $prefix = "OS";
                $tipo = "S";
            }

            $anio = explode("-",$cabecera['emision']);

            $orden = $cabecera['sw'] == 0 ? $noc : $cabecera['numero'];
            $titulo = $titulo . " " .$anio[0]. " - " . $orden;
            
            $file = $cabecera['entidad']."_".$prefix.$noc.".pdf";
            //$entrega = $this->calcularDias($cabecera['fentrega']);

            $pdf = new PDF($titulo,$condicion,$cabecera['emision'],$cabecera['moneda'],$cabecera['dias'] ." dias",
                            $cabecera['lentrega'],$cabecera['ncotiz'],$cabecera['fentrega'],$cabecera['cpago'],$cabecera['total'],
                            $cabecera['costos'],$cabecera['concepto'],$_SESSION['nombres'],$cabecera['entidad'],$cabecera['ruc_entidad'],
                            $cabecera['direccion_entidad'],$cabecera['telefono_entidad'],$cabecera['correo_entidad'],$cabecera['retencion'],
                            $cabecera['atencion'],$cabecera['telefono_contacto'],$cabecera['correo_contacto'],
                            $cabecera['direccion_almacen'],$cabecera['referencia'],$cabecera['procura'],$cabecera['finanzas'],$cabecera['operaciones'],
                            $condiciones);

            $pdf->AddPage();
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(10,15,15,15,10,80,15,15,15));
            $pdf->SetFont('Arial','',5);
            
            $lc = 0;
            $rc = 0;
            $do = false; //para imprimir los detalles de la oc

            $datos = json_decode($detalles);
            $nreg = count($datos);

            for ($i=0; $i < $nreg; $i++) { 
               
                $nparte = $datos[$i]->nroparte != "" ? "NP:". $datos[$i]->nroparte : "";

                $pdf->SetAligns(array("C","C","C","R","C","L","C","R","R"));
                $pdf->Row(array($datos[$i]->item,
                                $datos[$i]->codigo,
                                null,
                                $datos[$i]->cantidad,
                                $datos[$i]->unidad,
                                TRIM(utf8_decode(strtoupper($datos[$i]->descripcion .' '. $datos[$i]->detalles .' '. $nparte))),
                                $datos[$i]->pedido,
                                $datos[$i]->precio,
                                $datos[$i]->total));
                    $lc++;

                    //aca controla la linea de impresion 
                    if ($pdf->getY() >= 160) {
                        $pdf->AddPage();
                        $lc = 0;
                    }
            }

            $pdf->Ln(2);
            $posY = $pdf->getY();

            $pdf->SetFillColor(229, 229, 229);
            
            $pdf->SetFont('Arial','B',6);
            $pdf->Cell(15,6,"TOTAL :","LTB",0,"L",true);

            $total_adicional = $cabecera['total_adicional'] == ""  ? 0 :  $cabecera['total_adicional']; 

            if ($cabecera['radioIgv'] == 0){
                $pdf->Cell(135,6,$this->convertir($cabecera['total_numero']+$total_adicional)." ".$cabecera['moneda'],"TBR",0,"L",true); 
                $pdf->Cell(40,6,number_format($cabecera['total_numero']+$total_adicional,2),"1",1,"R",true);
            }
            else {
                $pdf->Cell(135,6,$this->convertir(($cabecera['total_numero']*1.18)+$total_adicional)." ".$cabecera['moneda'],"TBR",0,"L",true);
                $pdf->Cell(40,6,number_format(($cabecera['total_numero']*1.18)+$total_adicional,2),"1",1,"R",true);
            }

            $pdf->Ln(1);
            $pdf->SetFont('Arial',"",7);
            $pdf->Cell(40,6,"Pedidos Asociados",1,0,"C",true);
            $pdf->Cell(5,6,"",0,0);
            $pdf->Cell(80,6,utf8_decode("Información Bancaria del Proveedor"),1,1,"C",true);
            

            $pdf->Cell(10,6,utf8_decode("Año"),"LRB",0);   
            $pdf->Cell(10,6,"Tipo","RB",0);
            $pdf->Cell(10,6,"Pedido","RB",0);
            $pdf->Cell(10,6,"Mantto","RB",0);
            $pdf->Cell(5,6,"",0,0);
            $pdf->Cell(35,6,"Detalle del Banco",1,0);
            $pdf->Cell(15,6,"Moneda",1,0);
            $pdf->Cell(30,6,"Nro. Cuenta Bancaria",1,1);

            $pdf->SetFont('Arial',"","7");
            $pdf->Cell(10,6,$anio[0],"LRB",0);
            $pdf->Cell(10,6,$tipo,"RB",0,"C");
            $pdf->Cell(10,6,str_pad($cabecera['nro_pedido'],6,0,STR_PAD_LEFT),"RB",0);
            $pdf->Cell(10,6,"","RB",0);
            
            $pdf->Ln(7);
            $nreg = count($bancos);

            $x = $pdf->GetX();
            $y = $pdf->GetY();

            
            $pdf->SetXY(55,$y-7);
            $pdf->SetFont('Arial',"","6");

            for ($i=0;$i<$nreg;$i++){
                $pdf->Cell(35,4,$bancos[$i]['banco'],1,0);
                $pdf->Cell(15,4,$bancos[$i]['moneda'],1,0);
                $pdf->Cell(30,4,$bancos[$i]['cuenta'],1,1);
                $pdf->Cell(45,4,"",0,0);
            }

            $pdf->SetXY(146,$pdf->GetY() -10);
            
            $pdf->Cell(33,6,"Valor Venta",0,0);
            $pdf->Cell(20,6,number_format($cabecera['total_numero'],2),0,1,"R");

            if($cabecera['radioIgv'] ==  0) {
                $pdf->SetX(146);
                $pdf->Cell(8,3,"",0,0);
                $pdf->Cell(20,3,"",0,0);
                $pdf->SetX(185);
                $pdf->Cell(20,3,"",0,1); 
            }else{
                $igv = round((floatval($cabecera['total_numero'])*0.18),2);
                $pdf->SetX(146);
                $pdf->Cell(13,3,"IGV",0,0);
                $pdf->Cell(20,3,"(18%)",0,0);
                $pdf->Cell(20,3,number_format($igv,2),0,1,"R");
            }

            $pdf->SetX(146);

            if ( $cabecera['total_adicional'] ) {
                $pdf->Cell(33,6,"CARGO(0)",0,0);
                $pdf->Cell(20,6,number_format($cabecera['total_adicional'],2),0,1,"R");
            }else {
                $pdf->Cell(43,6,"",0,0);
                $pdf->Cell(30,6,"",0,1);
            }
            
            $pdf->SetX(146);
            $pdf->SetFont('Arial',"B","8");
            $pdf->Cell(20,4,"TOTAL",1,0,"L",true);
            $pdf->Cell(15,4,$cabecera['moneda'],1,0,"C",true);


            if ( $cabecera['radioIgv'] == 0 ){
                $pdf->Cell(20,4,number_format($cabecera['total_numero'] +  $total_adicional ,2),1,1,"R",true);
            }        
            else {
                $pdf->Cell(20,4,number_format((($cabecera['total_numero']*1.18)+ $total_adicional ),2),1,1,"R",true);
            }

            $pdf->SetFont('Arial',"","6");

            if ($condicion == 0){
                $filename = "public/documentos/ordenes/vistaprevia/".$file;
            }else if ($condicion == 1){
                $filename = "public/documentos/ordenes/emitidas/".$file;
            }else if ($condicion == 2){
                $filename = "public/documentos/ordenes/aprobadas/".$file;
            }

            $pdf->Output($filename,'F');

            return $file;
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
                                                    cm_entidadbco.nflgactivo = 7 
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

        public function calcularDias($fechaEntrega){
            $date1 = new DateTime(Date('Y-m-d'));
            $date2 = new DateTime($fechaEntrega);
            $diff = $date1->diff($date2);
            // will output 2 days
            return $diff->days . ' dias ';
        }

        public function fechaOrden(){
            $date = date("Y-m-d");
            //Incrementando 2 dias
            $mod_date = strtotime($date."+ 3 days");

            return date("Y-m-d",$mod_date);
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
                                                                lg_ordencab.nAdicional,
                                                                lg_ordencab.cReferencia,
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
                                                    lg_ordendet.cobserva,
                                                    lg_ordendet.id_cprod,
                                                    FORMAT( lg_ordendet.ncanti, 2 ) AS ncanti,
                                                    lg_ordendet.nunitario AS nunitario,
                                                    FORMAT( lg_ordendet.nigv, 2 ) AS nigv,
                                                    FORMAT( tb_pedidodet.total - lg_ordendet.nigv,2) AS subtotal,
                                                    FORMAT( lg_ordendet.ntotal,2) as ntotal,
                                                    cm_producto.ccodprod,
                                                    UPPER(CONCAT_WS(' ',cm_producto.cdesprod,tb_pedidodet.observaciones,lg_ordendet.cobserva)) AS cdesprod,
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

        //recepcion
        public function apruebaRecepción(){
            try {
                $salida = "";
                $sql = $this->db->connect()->query("SELECT
                                                tb_user.iduser,
                                                tb_user.cnombres 
                                            FROM
                                                tb_user 
                                            WHERE
                                                tb_user.nrol = 4");
                $sql->execute();
                $rowCount = $sql->rowCount();

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .='<li><a href="'.$rs['iduser'].'" >'.$rs['cnombres'].'</a></li>';
                    }

                    return $salida;
                } 
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function consultarNotaID($indice,$clase){
            try {
                $sql=$this->db->connect()->prepare("SELECT
                                                        ibis.alm_recepcab.id_regalm,
                                                        ibis.alm_recepcab.ctipmov,
                                                        ibis.alm_recepcab.ncodmov,
                                                        ibis.alm_recepcab.nnronota,
                                                        ibis.alm_recepcab.cper,
                                                        ibis.alm_recepcab.cmes,
                                                        ibis.alm_recepcab.ncodalm1,
                                                        ibis.alm_recepcab.ffecdoc,
                                                        ibis.alm_recepcab.cnumguia,
                                                        ibis.alm_recepcab.ncodpry,
                                                        ibis.alm_recepcab.ncodarea,
                                                        ibis.alm_recepcab.ncodcos,
                                                        ibis.alm_recepcab.idref_pedi,
                                                        ibis.alm_recepcab.idref_abas,
                                                        ibis.alm_recepcab.id_userAprob,
                                                        ibis.alm_recepcab.nEstadoDoc,
                                                        ibis.tb_proyectos.ccodproy,
                                                        UPPER( ibis.tb_proyectos.cdesproy ) AS proyecto,
                                                        ibis.tb_area.ccodarea,
                                                        UPPER ( ibis.tb_area.cdesarea ) AS area,
                                                        ibis.tb_user.cnombres,
                                                        CONCAT_WS( ' ', rrhh.tabla_aquarius.nombres, rrhh.tabla_aquarius.apellidos ) AS nombres,
                                                        ibis.tb_pedidocab.idsolicita,
                                                        ibis.tb_almacen.ccodalm,
                                                        UPPER( ibis.tb_almacen.cdesalm ) AS almacen,
                                                        ibis.alm_recepcab.nnromov,
                                                        ibis.tb_parametros.cdescripcion,
                                                        ibis.cm_entidad.id_centi,
                                                        ibis.cm_entidad.cnumdoc,
                                                        ibis.cm_entidad.crazonsoc,
                                                        LPAD( ibis.tb_pedidocab.nrodoc, 6, 0 ) AS pedido,
                                                        LPAD(ibis.lg_ordencab.cnumero,6,0) AS orden,
                                                        UPPER( ibis.tb_pedidocab.concepto ) AS concepto,
                                                        UPPER( ibis.tb_pedidocab.detalle ) AS detalle,
                                                        estados.cabrevia AS estado,
	                                                    ibis.alm_recepcab.nflgCalidad 
                                                    FROM
                                                        ibis.alm_recepcab
                                                        INNER JOIN ibis.tb_proyectos ON alm_recepcab.ncodpry = tb_proyectos.nidreg
                                                        INNER JOIN ibis.tb_area ON alm_recepcab.ncodarea = tb_area.ncodarea
                                                        INNER JOIN ibis.tb_user ON alm_recepcab.id_userAprob = tb_user.iduser
                                                        INNER JOIN ibis.tb_pedidocab ON ibis.alm_recepcab.idref_pedi = ibis.tb_pedidocab.idreg
                                                        INNER JOIN rrhh.tabla_aquarius ON ibis.tb_pedidocab.idsolicita = rrhh.tabla_aquarius.internal
                                                        INNER JOIN ibis.tb_almacen ON ibis.alm_recepcab.ncodalm1 = ibis.tb_almacen.ncodalm
                                                        INNER JOIN ibis.tb_parametros ON ibis.alm_recepcab.ncodmov = ibis.tb_parametros.nidreg
                                                        INNER JOIN ibis.cm_entidad ON ibis.alm_recepcab.id_centi = ibis.cm_entidad.id_centi
                                                        INNER JOIN ibis.lg_ordencab ON ibis.alm_recepcab.idref_abas = ibis.lg_ordencab.id_regmov
                                                        INNER JOIN ibis.tb_parametros AS estados ON ibis.alm_recepcab.nEstadoDoc = estados.nidreg 
                                                    WHERE
                                                        alm_recepcab.id_regalm = :id 
                                                        LIMIT 1");
                $sql->execute(["id"=>$indice]);

                $rowCount = $sql->rowCount();
                
                if ($rowCount > 0) {
                    $docData = array();
                    while($row=$sql->fetch(PDO::FETCH_ASSOC)){
                        $docData[] = $row;
                    }
                }

                return array("cabecera"=>$docData,
                            "detalles"=>$this->detallesNota($indice,$clase),
                            "series"=>$this->seriesNota($indice),
                            "adjuntos"=>$this->adjuntosNota($indice),
                            "total_adjuntos"=>$this->contarAdjuntos($indice,"NI"));

            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        private function detallesNota($indice,$clase){
            try {
                $salida='<tr><td colspan="12">No hay registros</td></tr>';
                $sql=$this->db->connect()->prepare("SELECT
                                                    alm_recepdet.niddeta,
                                                    alm_recepdet.id_regalm,
                                                    alm_recepdet.ncodalm1,
                                                    alm_recepdet.id_cprod,
                                                    alm_recepdet.ncantidad AS ncantidad,
                                                    alm_recepdet.niddetaPed,
                                                    alm_recepdet.niddetaOrd,
                                                    alm_recepdet.nestadoreg,
                                                    cm_producto.ccodprod,
                                                    UPPER(
                                                        CONCAT_WS(
                                                            ' ',
                                                            cm_producto.cdesprod,
                                                            tb_pedidodet.observaciones,
                                                            tb_pedidodet.docEspec
                                                        )
                                                    ) AS cdesprod,
                                                    lg_ordendet.ncanti AS cantidad_orden,
                                                    tb_unimed.cabrevia,
                                                    alm_recepdet.cobserva,
                                                    alm_recepdet.fvence,
                                                    FORMAT(lg_ordendet.ncanti - alm_recepdet.ncantidad,2) AS saldo_ingresar
                                                FROM
                                                    alm_recepdet
                                                INNER JOIN tb_pedidodet ON alm_recepdet.niddetaPed = tb_pedidodet.iditem
                                                INNER JOIN cm_producto ON alm_recepdet.id_cprod = cm_producto.id_cprod
                                                INNER JOIN lg_ordendet ON alm_recepdet.niddetaOrd = lg_ordendet.nitemord
                                                INNER JOIN tb_unimed ON cm_producto.nund = tb_unimed.ncodmed
                                                WHERE
                                                    alm_recepdet.id_regalm = :id
                                                AND alm_recepdet.nflgactivo = 1");
                $sql->execute(['id'=>$indice]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    $salida="";
                    $item = 1;
                    while($rs = $sql->fetch()){
                        $fecha = $rs['fvence'] == "" ? date("d/m/Y", strtotime($rs['fvence'])) : "";
                        
                        $salida .= '<tr data-detorden="'.$rs['niddetaOrd'].'" 
                                        data-idprod="'.$rs['id_cprod'].'"
                                        data-iddetped="'.$rs['niddetaPed'].'"
                                        data-iddetnota="'.$rs['niddeta'].'">
                                        <td class="textoCentro"><a href="'.$rs['id_regalm'].'" class="eliminarItem"><i class="fas fa-minus"></i></a></td>
                                        <td class="textoCentro"><input type="checkbox" checked readonly></td>
                                        <td class="textoCentro">'.str_pad($item++,3,0,STR_PAD_LEFT).'</td>
                                        <td class="textoCentro">'.$rs['ccodprod'].'</td>
                                        <td class="pl20px">'.$rs['cdesprod'].'</td>
                                        <td class="textoCentro">'.$rs['cabrevia'].'</td>
                                        <td class="pr20px textoDerecha">'.$rs['cantidad_orden'].'</td>
                                        <td class="pr5px"><input type="text" class="textoDerecha" value="'.$rs['ncantidad'].'" onClick="this.select();"></td>
                                        <td><input type="text" value="'.$rs['cobserva'].'" readonly></td>
                                        <td class="pr20px textoDerecha"></td>
                                        <td class="textoCentro"><a href="'.$rs['id_regalm'].'" data-accion="series"><i class="fas fa-barcode"></i></a></td>
                                    </tr>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        private function seriesNota($indice){
            try {
                $salida="";
                $item = 1;
                $sql=$this->db->connect()->prepare("SELECT
                                                    alm_recepserie.ncodserie,
                                                    alm_recepserie.id_cprod,
                                                    alm_recepserie.idref_movi,
                                                    alm_recepserie.idref_alma,
                                                    alm_recepserie.cdesserie,
                                                    alm_recepserie.cdetalle,
                                                    cm_producto.cdesprod 
                                                FROM
                                                    alm_recepserie
                                                    INNER JOIN cm_producto ON alm_recepserie.id_cprod = cm_producto.id_cprod 
                                                WHERE
                                                    alm_recepserie.idref_movi = :id");
                $sql->execute(['id'=>$indice]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while($rs = $sql->fetch()){
                        $salida .= '<tr>
                                        <td>'.$item++.'</td>
                                        <td>'.$rs['cdesserie'].'</td>
                                    </tr>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        private function adjuntosNota($indice){
            try {
                $salida="";
                $sql=$this->db->connect()->prepare("SELECT
                                                    lg_regdocumento.id_regmov,
                                                    lg_regdocumento.nidrefer,
                                                    lg_regdocumento.creferencia,
                                                    lg_regdocumento.cdocumento,
                                                    lg_regdocumento.cmodulo 
                                                FROM
                                                    lg_regdocumento 
                                                WHERE
                                                    lg_regdocumento.nidrefer = :id 
                                                    AND lg_regdocumento.cmodulo = 'NI'");
                $sql->execute(['id'=>$indice]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while($rs = $sql->fetch()){
                        $salida .= '<li><p><i class="far fa-file"></i></p>
                                    <p>'.$rs['cdocumento'].'</p></li>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function genNumberSalidas($cod){
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                            COUNT(alm_despachocab.nnromov) AS nummov 
                                                        FROM
                                                            alm_despachocab 
                                                        WHERE
                                                            alm_despachocab.ncodalm1 = :cod");
                $sql->execute(["cod"=>$cod]);

                $row = $sql->fetchAll();

                return $row[0]['nummov'];

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function genNumberIngresos($cod){
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                            COUNT(alm_recepcab.nnromov) AS nummov 
                                                        FROM
                                                            alm_recepcab 
                                                        WHERE
                                                            alm_recepcab.ncodalm1 = :cod");
                $sql->execute(["cod"=>$cod]);

                $row = $sql->fetchAll();

                return $row[0]['nummov'];

            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function listarOperadores(){
            try {
                $salida = "";
                $sql =  $this->db->connect()->query("SELECT
                                        ibis.tb_user.iduser, 
                                        ibis.tb_user.ccorreo, 
                                        ibis.tb_user.nrol, 
                                        ibis.tb_user.nflgactivo, 
                                        rrhh.tabla_aquarius.apellidos, 
                                        rrhh.tabla_aquarius.nombres
                                    FROM
                                        ibis.tb_user
                                        INNER JOIN
                                        rrhh.tabla_aquarius
                                        ON 
                                            ibis.tb_user.ncodper = rrhh.tabla_aquarius.internal
                                    WHERE
                                        (ibis.tb_user.nrol = 68 OR ibis.tb_user.nrol = 228) 
                                        AND ibis.tb_user.nestado = 7");
                $sql->execute();
                $rowcount = $sql->rowcount();

                if($rowcount > 0){
                    
                    while($rs = $sql->fetch()){
                        $nom = $this->primerosNombres($rs['nombres'],$rs['apellidos']);
                        $salida .= '<li><a href="'.$rs['iduser'].'">'.$nom.'</a></li>';
                    }
                }

                return $salida;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function desactivarItem($post,$est) {
            try {
                $sql = $this->db->connect()->prepare($post['query']);
                $sql->execute(["estado"=>$est,"id"=>$post['id']]);

                return true;
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        //listar las ordenes para los ingresos y salidas
        public function listarOrdenes($tipoMov){
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
                                                        UPPER( cm_entidad.crazonsoc ) AS crazonsoc,
                                                        i.ingresos,
                                                        d.despachos,
                                                        c.cantidad_orden 
                                                    FROM
                                                        tb_costusu
                                                        INNER JOIN lg_ordencab ON tb_costusu.ncodproy = lg_ordencab.ncodpry
                                                        INNER JOIN tb_proyectos ON lg_ordencab.ncodpry = tb_proyectos.nidreg
                                                        INNER JOIN tb_area ON lg_ordencab.ncodarea = tb_area.ncodarea
                                                        INNER JOIN cm_entidad ON lg_ordencab.id_centi = cm_entidad.id_centi
                                                        LEFT JOIN ( SELECT SUM( alm_recepdet.ncantidad ) AS ingresos, pedido FROM alm_recepdet WHERE nflgactivo = 1 GROUP BY pedido ) AS i ON i.pedido = lg_ordencab.id_regmov
                                                        LEFT JOIN ( SELECT SUM( alm_despachodet.ndespacho ) AS despachos, alm_despachodet.nropedido FROM alm_despachodet WHERE nflgactivo = 1 GROUP BY nropedido ) AS d ON d.nropedido = lg_ordencab.id_regmov
                                                        LEFT JOIN ( SELECT SUM( lg_ordendet.ncanti ) AS cantidad_orden, lg_ordendet.id_orden FROM lg_ordendet GROUP BY lg_ordendet.id_orden ) AS c ON c.id_orden = lg_ordencab.id_regmov 
                                                    WHERE
                                                        tb_costusu.id_cuser = :usr
                                                        AND tb_costusu.nflgactivo = 1 
                                                        AND lg_ordencab.ntipmov = 37 
                                                        AND lg_ordencab.nEstadoDoc BETWEEN 60 
                                                        AND 62 
                                                    ORDER BY
                                                        lg_ordencab.id_regmov DESC
                                                    LIMIT 20");
                $sql->execute(["usr"=>$_SESSION['iduser']]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()) {

                        if ($tipoMov == 2){
                            //if ( $rs['ingresos'] != $rs['despachos'] &&  $rs['ingresos'] > 0 ) {
                                $salida.='<tr data-orden="'.$rs['id_regmov'].'" data-idcosto="'.$rs['nidreg'].'" data-ingresos="'.$rs['ingresos'].'">
                                        <td class="textoCentro">'.$rs['cnumero'].'</td>
                                        <td class="textoCentro">'.$rs['ffechadoc'].'</td>
                                        <td class="pl20px">'.$rs['area'].'</td>
                                        <td class="textoDerecha pr5px">'.$rs['ccodproy'].'</td>
                                        <td class="pl20px">'.$rs['crazonsoc'].'</td>
                                    </tr>';
                            //}
                        }else {
                            if ( $rs['ingresos'] == NULL ||  $rs['ingresos'] !=  $rs['cantidad_orden'] ) {
                                $salida.='<tr data-orden="'.$rs['id_regmov'].'" data-idcosto="'.$rs['nidreg'].'" data-ingresos="'.$rs['ingresos'].'">
                                    <td class="textoCentro">'.$rs['cnumero'].'</td>
                                    <td class="textoCentro">'.$rs['ffechadoc'].'</td>
                                    <td class="pl20px">'.$rs['area'].'</td>
                                    <td class="textoDerecha pr5px">'.$rs['ccodproy'].'</td>
                                    <td class="pl20px">'.$rs['crazonsoc'].'</td>
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

        public function calcularIngresosOrden($id){
            try {
                $sql = $this->db->connect()->prepare("SELECT SUM(lg_ordendet.ncanti) AS cantidad_orden FROM lg_ordendet WHERE id_orden =:id");
                $sql->execute(["id"=>$id]);
                $result = $sql->fetchAll();

                return $result[0]['cantidad_orden'];
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function calcularCantidadIngresa($id) {
            //aca me equivoque esta pedido con orden
            try {
                $sql = $this->db->connect()->prepare("SELECT SUM(alm_recepdet.ncantidad) AS recepcionado_orden FROM alm_recepdet WHERE pedido =:id");
                $sql->execute(["id"=>$id]);
                $result = $sql->fetchAll();

                return $result[0]['recepcionado_orden'];
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function calcularCantidadDespacha($id){
            try {
                $sql = $this->db->connect()->prepare("SELECT SUM(alm_despachodet.ndespacho) AS cantidad_despacho FROM alm_despachodet WHERE nropedido =:id");
                $sql->execute(["id"=>$id]);
                $result = $sql->fetchAll();

                return $result[0]['cantidad_despacho'];
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
                return false;
            }
        }

        public function norepite() {
            $rand = range(8, 1000000);
            shuffle($rand);
            $numero = 0;
            
            foreach ($rand as $val) {
                $val.=$val;
            }
            
            return $val;
        }

        public function cantidadItems($d,$c) {
            try {
                $sql = $this->db->connect()->prepare("SELECT
                                                        COUNT( idreg ) AS nroitems
                                                    FROM
                                                        alm_consumo 
                                                    WHERE
                                                        nrodoc = :documento 
                                                        AND ncostos = :cc
                                                        AND alm_consumo.flgactivo = 1");
                $sql->execute(["documento"=>$d,"cc"=>$c]);
                $result = $sql->fetchAll();

                return $result[0]['nroitems'];
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function tipoArchivo($archivo) {
            $extension = pathinfo($archivo, PATHINFO_EXTENSION);

            switch ($extension) {
                case 'pdf':
                    $icono = '<i class="fas fa-file-pdf"></i>';
                    $color_icono = '#FC4136';
                    break;
                case 'xlsx':
                    $icono = '<i class="fas fa-file-excel"></i>';
                    break;
                case 'xls':
                    $icono = '<i class="fas fa-file-excel"></i>';
                    break;
                case 'xlsm':
                        $icono = '<i class="fas fa-file-excel"></i>';
                        break;
                case 'docx':
                    $icono = '<i class="fas fa-file-word"></i>';
                    break;
                case 'doc':
                    $icono = '<i class="fas fa-file-word"></i>';
                    break;
                case 'jpg':
                    $icono = '<i class="fas fa-file-image"></i>';
                    break;
                case 'JPG':
                        $icono = '<i class="fas fa-file-image"></i>';
                        break;
                case 'png':
                    $icono = '<i class="fas fa-file-image"></i>';
                    break;
                case 'msg':
                    $icono = '<i class="fas fa-envelope-open-text"></i>';
                    break;
                case 'zip':
                        $icono = '<i class="fas fa-file-archive"></i>';
                        break;
                default:
                    $icono = '<i class="far fa-file"></i>';
                    break;
            }

            return $icono;
        }

        public function borraAdjuntos($codigo){
            try {
                $respuesta = false;
                $sql = $this->db->connect()->prepare("UPDATE lg_regdocumento 
                                                        SET lg_regdocumento.nflgactivo = 0
                                                        WHERE lg_regdocumento.id_regmov = :codigo");
                $sql->execute(["codigo" => $codigo]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0){
                    $respuesta = true;
                }

                return array("respuesta"=>$respuesta,
                             "archivos"=>$this->verAdjuntosPedido($codigo));
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function verAdjuntosPedido($id){
            try {
                $salida = "";
                $sql = $this->db->connect()->prepare("SELECT creferencia,
                                                             cdocumento,
                                                             id_regmov 
                                                        FROM lg_regdocumento 
                                                        WHERE nidrefer=:id
                                                            AND nflgactivo = 1
                                                            AND cmodulo='PED'");
                $sql->execute(['id'=>$id]);
                $rowCount = $sql->rowCount();

                if ($rowCount > 0) {
                    while ($rs = $sql->fetch()) {

                        $icono = $this->tipoArchivo($rs['creferencia']);

                        $salida .= '<li>
                                        <a href="'.$rs['creferencia'].'" data-archivo="'.$rs['creferencia'].'" class="icono_archivo">'.$icono.'<p>'.$rs['cdocumento'].'</p></a>
                                        <a href="'.$rs['id_regmov'].'" class="file_delete"><i class="fas fa-ban"></i></a>
                                    </li>';
                    }
                }
                
                $ret = array("adjuntos"=>$salida,
                            "archivos"=>$rowCount);

                return $ret;
            } catch (PDOException $th) {
                echo $th->getMessage();
                return false;
            }
        }

        public function numeroGuia(){
            try {
                $guiaInicial = 137401;

                $sql = $this->db->connect()->query("SELECT
                                                        COUNT( lg_guias.cnumguia ) AS nroguia 
                                                    FROM
                                                        lg_guias 
                                                    WHERE
                                                        lg_guias.cserie = 'F001'");
                $sql->execute();
                $result = $sql->fetchAll();

                return str_pad($result[0]['nroguia']+$guiaInicial,7,0,STR_PAD_LEFT);

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function numeroGuiaSunat($nroGuia,$peso){
            try {
                $sql = $this->db->connect()->query("SELECT
	                                                    MAX( lg_guias.guiasunat ) AS nroguiasunat 
                                                    FROM
                                                        lg_guias ");
                $sql->execute();
                $result = $sql->fetchAll();

                $this->actualizaNroSunat($result[0]['nroguiasunat'] + 1,$nroGuia,$peso);

                return $result[0]['nroguiasunat'] + 1;

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        private function actualizaNroSunat($numero,$guia,$peso){
            try {
                $sql = $this->db->connect()->prepare("UPDATE lg_guias 
                                                            SET lg_guias.guiasunat=:numero,
                                                                lg_guias.nPeso=:peso
                                                            WHERE lg_guias.cnumguia =:guia");

                $sql->execute(['numero'=>$numero,'guia'=>$guia,'peso'=>$peso]);

            } catch (PDOException $th) {
                echo "Error: ".$th->getMessage();
                return false;
            }
        }

        public function listaEquiposMmtto(){
            try {
                $salida = '<option value="-1" class="oculto">Elija una opción</option>';
                $sql = $this->db->connect()->query("SELECT
                                                        tb_equipmtto.cdescripcion,
                                                        tb_equipmtto.cregistro,
                                                        tb_equipmtto.idreg
                                                    FROM
                                                        tb_equipmtto 
                                                    WHERE
                                                        tb_equipmtto.nflgactivo = 1 
                                                    ORDER BY
                                                        tb_equipmtto.cdescripcion");
                $sql->execute();
                $rowCount = $sql->rowCount();

                if ($rowCount > 0){
                    while ($rs = $sql->fetch()){
                        $salida .= '<option value="'.$rs['idreg'].'">'.$rs['cregistro']."  ".$rs['cdescripcion'].'</option>';
                    }

                    return $salida;
                } 
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
    }
?>