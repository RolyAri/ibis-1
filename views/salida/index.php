<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="mensaje">
        <p></p>
    </div>
    <div class="modal" id="pregunta">
        <div class="ventanaPregunta">
            <h3>Desea eliminar el registro?</h3>
            <div>
                <button type="button" id="btnAceptarPregunta">Aceptar</button>
                <button type="button" id="btnCancelarPregunta">Cancelar</button>
            </div>
        </div>
    </div>
    <div class="modal" id="proceso">
        <div class="ventanaProceso tamanioProceso">
            <div class="cabezaProceso">
                <form action="#" id="formProceso" autocomplete="off">
                    <input type="hidden" name="codigo_costos" id="codigo_costos"> 
                    <input type="hidden" name="codigo_area" id="codigo_area">
                    <input type="hidden" name="codigo_movimiento" id="codigo_movimiento">
                    <input type="hidden" name="codigo_aprueba" id="codigo_aprueba">
                    <input type="hidden" name="codigo_almacen" id="codigo_almacen">
                    <input type="hidden" name="codigo_almacen_destino" id="codigo_almacen_destino">
                    <input type="hidden" name="codigo_pedido" id="codigo_pedido">
                    <input type="hidden" name="codigo_orden" id="codigo_orden">
                    <input type="hidden" name="codigo_estado" id="codigo_estado">
                    <input type="hidden" name="codigo_moneda" id="codigo_moneda">
                    <input type="hidden" name="codigo_ingreso" id="codigo_ingreso">
                    <input type="hidden" name="codigo_salida" id="codigo_salida">
                    <input type="hidden" name="id_centi" id="id_centi">

                    <div class="barraOpciones primeraBarra">
                        <span>Datos Generales</span>
                        <div>
                            <button type="button" id="saveDoc" title="Grabar Nota" class="boton3">
                                <p><i class="far fa-save"></i> Grabar </p> 
                            </button>
                            <button type="button" id="importData" title="Importar Ingresos" class="boton3">
                                <i class="fab fa-wpexplorer"></i> Importar Ordenes
                            </button>
                            <button type="button" id="preview" title="Vista Previa" class="boton3">
                                <i class="far fa-file-pdf"></i> Vista Previa
                            </button>
                            <button type="button" id="closeProcess" title="Cerrar" class="boton3">
                                <i class="fas fa-window-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="dataProceso_2">
                        <div class="seccion_izquierda">
                            <div class="column4_55">
                                <div class="column2_3957">
                                    <label for="Fecha Emite">Fecha :</label>
                                    <input type="date" name="fecha" id="fecha" class="cerrarLista" value="<?php echo date("Y-m-d");?>" readonly>
                                </div>
                                <div class="column2_46">
                                    <label for="numero">Numero :</label>
                                    <input type="text" name="numero" id="numero" class="cerrarLista textoDerecha pr20px" readonly>
                                </div>
                            </div>
                            <div class="column2">
                                <label for="costos">CCostos:</label>
                                <input type="text" name="costos" id="costos" class="mostrarLista busqueda">
                            </div>
                            <div class="column2">
                                <label for="aprueba">Aprueba:</label>
                                <input type="text" name="aprueba" id="aprueba" class="mostrarLista busqueda" placeholder="Elija opción"
                                        readonly>
                                <div class="lista" id="listaAprueba">
                                    <ul>
                                        <?php echo $this->listaAprueba?>
                                    </ul> 
                                </div>
                            </div>
                        </div>
                        <div class="seccion_medio">
                            <div class="column2">
                                <label for="almacen_origen_despacho">Almacen Origen:</label>
                                <input type="text" name="almacen_origen_despacho" id="almacen_origen_despacho" class="mostrarLista busqueda" readonly>
                                <div class="lista" id="listaAlmacenDestino">
                                   <ul>
                                       <?php echo $this->listaAlmacen?>
                                   </ul> 
                                </div>
                            </div>
                            <div class="column2">
                                <label for="almacen_destino_despacho">Almacen Destino:</label>
                                <input type="text" name="almacen_destino_despacho" id="almacen_destino_despacho" class="mostrarLista busqueda" readonly>
                                <div class="lista" id="listaAlmacenDestino">
                                   <ul>
                                       <?php echo $this->listaAlmacen?>
                                   </ul> 
                                </div>
                            </div>
                            <div class="column4_55">
                                <div class="column2">
                                    <label for="movimiento">Mov Almacen:</label>
                                    <input type="text" name="movimiento" id="movimiento" class="w100por" readonly>
                                </div>
                                <div class="column2_46">
                                    <input type="hidden" name="guia" id="guia" class="cerrarLista">
                                </div>
                            </div>
                        </div>
                        <div class="seccion_derecha">
                            <div class="column2">
                                <label for="tipo">Tipo Mov.:</label>
                                <input type="text" name="tipo" id="tipo" class="mostrarLista busqueda" placeholder="Elija opción"
                                    readonly>
                                <div class="lista" id="listaMovimiento">
                                   <ul>
                                       <?php echo $this->listaMovimiento?>
                                   </ul> 
                                </div>
                            </div>
                            <div class="column4_55">
                                <div class="column2">
                                    <label for="estado">Estado:</label>
                                    <input type="text" name="estado" id="estado" class="textoCentro estado w100por procesando" readonly value="EN PROCESO">
                                </div>
                                
                            </div>
                           
                        </div>
                    </div>
                    <div class="barraOpciones">
                        <span>Detalles</span>
                        <div>
                            <button type="button" id="atachDocs" title="Documentos Adjuntos" class="cerrarLista boton3">
                                <i class="fas fa-paperclip"></i> Documentos Adjuntos
                            </button>
                            <button type="button" id="asocOrd" title="Orden de Compra Asociada" class="cerrarLista boton3">
                                <i class="far fa-file-pdf"></i> Orden Asociada
                            </button>
                            <button type="button" id="guiaRemision" title="Guia de Remision" class="cerrarLista boton3">
                                <i class="fas fa-upload"></i> Guia de Remision
                            </button>
                        </div>
                    </div>
                    <div class="tablaInterna mininoTablaInterna">
                        <table class="tabla" id="tablaDetalles">
                            <thead>
                                <tr class="stickytop">
                                        <th class="">...</th>
                                        <th class="">Item</th>
                                        <th class="">Codigo</th>
                                        <th class="">Descripcion</th>
                                        <th class="">Unidad</th>
                                        <th width="7%">Cantidad</br>Orden</th>
                                        <th width="7%">Cantidad</br>Despacho</th>
                                        <th class="">Observaciones</th>
                                        <th width="4%">Pedido</th>
                                        <th width="4%">Orden</th>
                                        <th width="4%">Ingreso</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="busqueda">
        <div class="ventanaBusqueda w75por">
            <div class="tituloVentana">
                <span id="tituloBusqueda">Ordenes</span>
                <div>
                    <a href="#" id="closeSearch"><i class="fas fa-window-close"></i></a>
                </div>
            </div>
            <div class="textoBusquedaGrid">
                <input type="text" name="ordenSearch" id="ordenSearch" placeholder="Orden">
                <select name="itemCostos" id="itemCostos">
                    <?php echo $this->listaCostosSelect ?>
                </select>
                <button type="button" class="boton3" id="btnAceptItems">Aceptar</button>
            </div>
            <div class="tablaBusqueda">
                <table class="tablaWrap" id="ordenes">
                    <thead>
                        <tr class="stickytop" >
                            <th>Orden</th>
                            <th>Emisión</th>
                            <th>Area</th>
                            <th>Centro de Costos</th>
                            <th>Proveedor</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal" id="vistadocumento">
        <div class="ventanaDocumento">
            <form method="post" id="guiaremision">
                <input type="hidden" name="codigo_origen" id="codigo_origen">
                <input type="hidden" name="codigo_destino" id="codigo_destino">
                <input type="hidden" name="codigo_autoriza" id="codigo_autoriza">
                <input type="hidden" name="codigo_despacha" id="codigo_despacha">
                <input type="hidden" name="codigo_destinatario" id="codigo_destinatario">
                <input type="hidden" name="codigo_entidad_transporte" id="codigo_entidad_transporte">
                <input type="hidden" name="direccion_entidad_transporte" id="direccion_entidad_transporte">
                <input type="hidden" name="ruc_entidad_transporte" id="ruc_entidad_transporte">
                <input type="hidden" name="codigo_modalidad" id="codigo_modalidad">
                <input type="hidden" name="codigo_tipo" id="codigo_tipo">
                <input type="hidden" name="motivo_traslado" id="motivo_traslado">
                <iframe id="iFramePdf" src="" class="oculto"></iframe>

                <div class="tituloDocumento">
                    <div>
                        <p class="titulo_seccion"><strong> Guia de Remision y despacho : </strong></p>
                        <input type="text" name="serie_guia" id="serie_guia" class="w10por" value="0001" readonly>
                        <input type="text" name="numero_guia" id="numero_guia">    
                    </div>
                    <div>
                        <a href="#" id="printDocument" title="Imprimir Guia"><i class="fas fa-print"></i></a>
                        <a href="#" id="previewDocument" title="Vista previa"><i class="fas fa-eye"></i></a>
                        <a href="#" id="closeDocument" title="Cerrar Ventana"><i class="fas fa-window-close"></i></a>
                    </div>
                </div>
                <hr>
                <div class="dos_columnas">
                    <div class="columna_izquierda">
                        <div >
                            <label for="fgemision">Fecha Emisión:</label>
                            <input type="date" name="fgemision" id="fgemision" value="<?php echo date("Y-m-d")?>">
                        </div>
                        <div>
                            <p class="titulo_seccion"><strong>Datos del destinatario</strong></p>
                            <div class="dos_columnas_interna">
                                <label>R.U.C.</label>
                                <input type="text" name="destinatario_ruc" id="destinatario_ruc" value="20504898173" readonly>
                                <label>Razón Social :</label>
                                <input type="text" name="destinatario_razon" id="destinatario_razon" value="SERVICIOS PETROLEROS Y CONSTRUCCIONES SEPCON S.A.C" readonly>
                                <label>Dirección:</label>
                                <input type="text" name="destinatario_direccion" id="destinatario_direccion" value="AV. SAN BORJA NORTE N° 445 - SAN BORJA-LIMA-PERU." readonly>
                            </div>
                            <p><strong>Domicilio de partida</strong></p>
                            <div class="dos_columnas_interna">
                                <label for="almacen_origen">Almacen Origen: </label>
                                <input type="text" name="almacen_origen" id="almacen_origen" class="mostrarLista busqueda" >
                                <div class="lista" id="listaOrigen">
                                   <ul>
                                       <?php echo $this->listaAlmacen?>
                                   </ul> 
                                </div>
                                <label for="almacen_origen_direccion ">Dirección:</label>
                                <input type="text" name="almacen_origen_direccion" id="almacen_origen_direccion">
                            </div>
                            <p><strong>Domicilio de Llegada</strong></p>
                            <div class="dos_columnas_interna">
                                <label for="almacen_destino">Almacen Destino: </label>
                                <input type="text" name="almacen_destino" id="almacen_destino" class="mostrarLista busqueda">
                                <div class="lista" id="listaDestino">
                                   <ul>
                                       <?php echo $this->listaAlmacen?>
                                   </ul> 
                                </div>
                                <label for="almacen_destino_direccion ">Dirección:</label>
                                <input type="text" name="almacen_destino_direccion" id="almacen_destino_direccion">
                            </div>
                            <p><strong>Empresa de Transporte</strong></p>
                            <div class="dos_columnas_interna">
                                <label for="empresa_transporte_razon">Razón Social</label>
                                <input type="text" name="empresa_transporte_razon" id="empresa_transporte_razon" class="mostrarListaInterna busqueda" 
                                    placeholder="Elija opción">
                                <div class="lista" id="listaEntidad">
                                   <ul>
                                       <?php echo $this->listaEntidad?>
                                   </ul> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columna_derecha">
                        <p><strong>Motivo</strong></p>
                        <div class="cuatro_columnas_interna">
                            <label for="modalidad_traslado" class="uno">Modalidad Traslado :</label>
                            <input type="text" name="modalidad_traslado" id="modalidad_traslado" class="dos mostrarListaInterna busqueda" placeholder="Elija opción" readonly>
                            <div class="lista rowOne uno" id="listaModalidad">
                                <ul>
                                    <?php echo $this->listaModalidad?>
                                </ul> 
                            </div>
                            <label for="tipo_envio">Tipo Envio</label>
                            <input type="text" name="tipo_envio" id="tipo_envio" class="dos mostrarListaInterna busqueda" placeholder="Elija opción" readonly>
                            <div class="lista uno rowTwo" id="listaEnvio">
                                <ul>
                                    <?php echo $this->listaEnvio?>
                                </ul> 
                            </div>
                            <label for="autoriza">Autoriza:</label>
                            <input type="text" name="autoriza" id="autoriza" class="dos mostrarListaInterna busqueda" placeholder="Elija opción" readonly>
                            <div class="lista uno rowThree" id="listaAutoriza">
                                <ul>
                                    <?php echo $this->listaPersonal?>
                                </ul> 
                            </div>
                            <label for="destinatario">Destinatario:</label>
                            <input type="text" name="destinatario" id="destinatario" class="dos mostrarListaInterna busqueda" placeholder="Elija opción" readonly>
                            <div class="lista uno rowFour" id="listaDestinatario">
                                <ul>
                                    <?php echo $this->listaPersonal?>
                                </ul> 
                            </div>
                            <label for="observaciones_guia">Observaciones:</label>
                            <textarea name="observaciones" id="observaciones" placeholder="Observaciones" class="dos"></textarea>    
                        </div>
                        <p><strong>Datos del Conductor</strong></p>
                        <div class="dos_columnas_interna">
                            <label for="nombre_conductor">Nombre :</label>
                            <input type="text" name="nombre_conductor" id="nombre_conductor">
                            <label for="licencia_conducir">N° Licencia :</label>
                            <input type="text" name="licencia_conducir" id="licencia_conducir">
                        </div>
                        <p><strong>Datos del Vehiculo</strong></p>
                        <div class="dos_columnas_interna">
                            <label for="marca">Marca :</label>
                            <input type="text" name="marca" id="marca">
                            <label for="placa">Nro. Placa :</label>
                            <input type="text" name="placa" id="placa">
                            <label for="configuracion">Conf. Vehicular :</label>
                            <input type="text" name="configuracion" id="configuracion">
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
    <div class="modal" id="vistaprevia">
        <div class="ventanaVistaPrevia">
            <div class="tituloVista">
                <h3>Vista Previa</h3>
                <a href="#" id="closePreview" title="Cerrar Ventana"><i class="fas fa-window-close"></i></a>
            </div>
            <iframe src=""></iframe>
        </div>
    </div>
    <div class="modal" id="imprimir">
        <div class="ventanaVistaPrevia">
            <div class="tituloVista">
                <h3>Vista Previa</h3>
                <a href="#" id="closePreview" title="Cerrar Ventana"><i class="fas fa-window-close"></i></a>
            </div>
            <iframe src="" id="iFramePdf"></iframe>
        </div>
    </div>
    <div class="cabezaModulo">
        <h1>Notas de Salida</h1>
        <div>
            <a href="#" id="nuevoRegistro"><i class="far fa-file"></i><p>Nuevo</p></a>
            <a href="#" id="irInicio"><i class="fas fa-home"></i><p>Inicio</p></a>
        </div>
    </div>
    <div class="barraTrabajo">
        <form action="#" id="formConsulta">
            <div class="variasConsultas">
                    <div>
                        <label for="tipo">Guia N°. </label>
                        <input type="text" id="guiaSearch" name="guiaSearch">
                    </div>
                    <div>
                        <label for="costosSearch">Centro de Costos: </label>
                        <select name="costosSearch" id="costosSearch" class="item4">
                            <?php echo $this->listaCostosSelect ?>
                        </select>
                    </div>
                    <div>
                        <label for="mes">Mes</label>
                        <select name="mesSearch" id="mesSearch">
                            <option value="-1">Mes</option>
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Setiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>
                    <div>
                        <label for="anio">Año :</label>
                        <input type="number" name="anioSearch" id="anioSearch" value="<?php echo date("Y")?>" class="textoCentro">
                    </div>
                    <button type="button" class="boton3" id="btnConsulta">Consultar</button> 
            </div>
        </form>
    </div>
    <div class="itemsTabla">
        <table id="tablaPrincipal">
            <thead>
                <tr>
                    <th>Num. Nota</th>
                    <th>F.Emisión</th>
                    <th>Almacen Origen</th>
                    <th>Almacen Destino</th>
                    <th>Centro de Costos</th>
                    <th>Año</th>
                    <th>Guia</br>Remision</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $this->listaNotasSalidas;?>
            </tbody>
        </table>
    </div>
    <script src="<?php echo constant('URL');?>public/js/jquery.js"></script>
    <script src="<?php echo constant('URL');?>public/js/funciones.js?<?php echo constant('VERSION')?>"></script>
    <script src="<?php echo constant('URL');?>public/js/salida.js?<?php echo constant('VERSION')?>"></script>
</body>
</html>