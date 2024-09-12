<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo constant('URL')?>public/css/ibis.css?<?php echo constant('VERSION')?>">
</head>
<body>
    <div class="mensaje">
        <p></p>
    </div>
    <div class="modal" id="esperar">
    </div>
    <div class="modal" id="proceso">
        <div class="ventanaProceso tamanioProceso">
            <div class="cabezaProceso">
                <form action="#" id="formProceso" autocomplete="off">
                    <input type="hidden" name="codigo_costos_origen" id="codigo_costos_origen">
                    <input type="hidden" name="codigo_costos_destino" id="codigo_costos_destino"> 
                    <input type="hidden" name="codigo_area" id="codigo_area">
                    <input type="hidden" name="codigo_tipo" id="codigo_tipo">
                    <input type="hidden" name="codigo_tipo_transferencia" id="codigo_tipo_transferencia">
                    <input type="hidden" name="codigo_solicitante" id="codigo_solicitante">
                    <input type="hidden" name="codigo_origen" id="codigo_origen">
                    <input type="hidden" name="codigo_destino" id="codigo_destino">
                    <input type="hidden" name="vista_previa" id="vista_previa">
                    <input type="hidden" name="emitido" id="emitido">
                    <input type="hidden" name="codigo_usuario" id="codigo_usuario">
                    <input type="hidden" name="codigo_autoriza" id="codigo_autoriza">
                    <input type="hidden" name="codigo_traslado" id="codigo_traslado">
                    <input type="hidden" name="correo_usuario" id="correo_usuario">
                    <input type="hidden" name="codigo_estado" id="codigo_estado">

                    <div class="barraOpciones primeraBarra">
                        <span>Datos Generales</span>
                        <div>
                            
                            <button type="button" id="saveItem" title="Grabar Proceso" class="boton3">
                                <p><i class="far fa-save"></i> Grabar Registro</p> 
                            </button>
                            <button type="button" id="preview" title="Vista Previa" class="boton3">
                                <i class="fab fa-wpexplorer"></i> Vista Previa
                            </button>
                            <button type="button" id="guiaRemision" title="Guia de remision" class="boton3 accion">
                                <i class="far fa-paper-plane"></i> Guia de Remisión
                            </button>
                            <button type="button" id="closeProcess" title="Cerrar" class="boton3">
                                <i class="fas fa-window-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="dataProceso_2">
                        <div class="seccion_izquierda">
                            <div class="column4_55">
                                <div class="column2_3457">
                                    <label for="numero">Transferencia:</label>
                                    <input type="text" name="numero" id="numero" class="cerrarLista" readonly>
                                </div>
                                <div class="column2_46">
                                    <label for="emision">Emisión:</label>
                                    <input type="date" name="emision" id="emision" class="cerrarLista" value="<?php echo date("Y-m-d");?>">
                                </div>
                            </div>
                            <div class="column2">
                                <label for="costos">CCostos Origen:</label>
                                <input type="text" name="costos" id="costos" class="mostrarLista busqueda" placeholder="Elija una opcion">
                                <div class="lista" id="listaCostosOrigen">
                                   <ul>
                                       <?php echo $this->listaCostos?>
                                   </ul> 
                                </div>
                            </div>
                            <div class="column2">
                                <label for="costos">CCostos Destino:</label>
                                <input type="text" name="costosdestino" id="costosdestino" class="mostrarLista busqueda" placeholder="Elija una opcion">
                                <div class="lista" id="listaCostosDestino">
                                   <ul>
                                       <?php echo $this->listaCostos?>
                                   </ul> 
                                </div>
                            </div>
                            <div class="column2">
                                <label for="area">Area:</label>
                                <input type="text" name="area" id="area" class="mostrarLista busqueda" placeholder="Elija una opcion">
                                <div class="lista" id="listaAreas">
                                   <ul>
                                       <?php echo $this->listaAreas?>
                                   </ul>
                                </div>
                            </div>
                        </div>
                        <div class="seccion_medio">
                           
                            <div class="column2">
                                    <label for="origen">Almacen Origen:</label>
                                    <input type="text" name="origen" id="origen" class="mostrarLista busqueda" placeholder="Elija una opcion">
                                    <div class="lista" id="listaOrigen">
                                        <ul>
                                            <?php echo $this->listaAlmacen?>
                                        </ul>
                                   </div>
                            </div>
                            <div class="column2">
                                <label for="destino">Almacen Destino:</label>
                                <input type="text" name="destino" id="destino" class="mostrarLista busqueda" placeholder="Elija una opcion">
                                <div class="lista" id="listaDestino">
                                    <ul>
                                        <?php echo $this->listaAlmacen?>
                                    </ul>
                                </div>
                            </div>
                            <div class="column2">
                                <label for="solicitante">Solicitante:</label>
                                <input type="text" name="solicitante" id="solicitante">
                            </div>
                            <div class="column2">
                                <label for="autoriza">Autoriza:</label>
                                <input type="text" name="autoriza" id="autoriza" class="mostrarLista" placeholder="Elija una opcion">
                                <div class="lista" id="listaAutoriza">
                                   <ul>
                                        <?php echo $this->listaPersonal?>
                                   </ul>
                                </div>
                            </div>
                        </div>
                        <div class="seccion_derecha">
                            <div class="column4_55">
                                <div class="column2_3457">
                                    <label for="tipo">Transferencia:</label>
                                    <input type="text" name="tipo" id="tipo" class="mostrarLista busqueda" placeholder="Elija una opcion">
                                    <div class="lista" id="listaTiposTransferencia">
                                        <ul>
                                        <?php echo $this->listaTiposTransferencia?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="column4_55">
                                <div class="column2_3457">
                                    <label for="tipo">Tipo:</label>
                                    <input type="text" name="tipo" id="tipo" class="mostrarLista busqueda" placeholder="Elija una opcion">
                                    <div class="lista" id="listaTipos">
                                        <ul>
                                        <?php echo $this->listaTipos?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="column2">
                                <label for="observaciones">Observa:</label>
                                <input type="text" name="observaciones" id="observaciones">
                            </div>
                        </div>
                    </div>
                    <div class="textAreaEnter oculto">
                        <textarea name="espec_items" id="espec_items" rows="2" class="w100p" readonly></textarea>
                    </div>
                    <div class="barraOpciones">
                        <span>Detalles</span>
                        <div>
                            <button type="button" id="recepcionCarga" title="Recepción Almacén" class="boton3 accion" data-estado="recepcionAlmacen">
                                <i class="fas fa-truck-loading"></i> Recepción Almacén
                            </button>
                            <button type="button" id="entregaLogistica" title="Entrega Logística" class="boton3 accion" data-estado="entregaLogistica">
                                <i class="fas fa-truck-moving"></i> Entrega Logistica
                            </button>
                            <button type="button" id="recepcionLogistica" title="Recepción Logística" class="boton3 accion" data-estado="recepcionLogistica">
                                <i class="fas fa-share"></i> Recepción Logística
                            </button>
                            <button type="button" id="entregaUsuario" title="Entrega Usuario" class="boton3 accion" data-estado="entregaUsuario">
                                <i class="fas fa-user-secret"></i> Entrega Usuario
                            </button>

                            <button type="button" id="addItem" title="Añadir Item" class="cerrarLista boton3">
                                <i class="far fa-plus-square"></i> Agregar
                            </button>
                            
                        </div>
                    </div>
                    <div class="tablaInterna mininoTablaInterna">
                        <table class="tabla" id="tablaDetalles">
                            <thead class="stickytop">
                                <tr>
                                    <th width="3%">...</th>
                                    <th width="5%">Item</th>
                                    <th width="8%">Codigo</th>
                                    <th>Descripcion</th>
                                    <th width="5%">Und.</th>
                                    <th width="6%">Cant.</th>
                                    <th width="6%">Serie.</th>
                                    <th width="6%">Destino</th>
                                    <th width="10%">Nro. Parte</th>
                                    <th width="30%">Observaciones</th>
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
    <div class="modal" id="recepcionAlmacenModal">
        <div class="ventanaPregunta">
            <h3>¿Recepcionar los items?</h3>
            <div>
                <button type="button" id="btnAceptarRecepcion">Aceptar</button>
                <button type="button" id="btnCancelarRecepcion">Cancelar</button>
            </div>
        </div>
    </div>
    <div class="modal" id="entregaLogisticaModal">
        <div class="ventanaPregunta">
            <h3>¿Entregar Autorización para su despacho?</h3>
            <div>
                <button type="button" id="btnAceptarEntregaLogistica">Aceptar</button>
                <button type="button" id="btnCancelarEntregaLogistica">Cancelar</button>
            </div>
        </div>
    </div>
    <div class="modal" id="recepcionLogisticaModal">
        <div class="ventanaPregunta">
            <h3>¿Recepcionar el traslado?</h3>
            <div>
                <button type="button" id="btnAceptarRecepcionLogistica">Aceptar</button>
                <button type="button" id="btnCancelarRecepcionLogistica">Cancelar</button>
            </div>
        </div>
    </div>
    <div class="modal" id="entregaDestinoModal">
        <div class="ventanaPregunta">
            <h3>¿Culminar el traslado?</h3>
            <div>
                <button type="button" id="btnAceptarEntregaDestino">Aceptar</button>
                <button type="button" id="btnCancelarEntregaDestino">Cancelar</button>
            </div>
        </div>
    </div>
    <div class="modal" id="status">
        <div class="ventanaInformes">
            <div class="title__informe">
                <h3>Estado del Traslado</h3>
                <a href="#" id="closeInform"><i class="far fa-window-close"></i></a>
            </div>
            <div class="statusTraslado">
                <div class="estados">
                    <div class="etapas" id="etapa1">
                        <div>
                            <p class="descripcionEtapa">Recepción Almacén</p>
                            <p id="fecha1"></p>
                        </div>
                        <div class="circle etapa_falta" id="circle1">
                            <p class="faltante"><i class="fas fa-times"></i></p>
                        </div>
                    </div>
                    <div class="etapas" id="etapa2">
                        <div>
                            <p class="descripcionEtapa">Entrega Logística</p>
                            <p id="fecha2"</p>
                        </div>
                        <div class="circle etapa_falta" id="circle2">
                            <p class="faltante"><i class="fas fa-times"></i></p>
                        </div>
                    </div>
                    <div class="etapas" id="etapa3">
                        <div>
                            <p class="descripcionEtapa">Recepción Logística</p>
                            <p id="fecha3"></p>
                        </div>
                        <div class="circle etapa_falta" id="circle3">
                            <p class="faltante"><i class="fas fa-times"></i></p>
                        </div>
                    </div>
                    <div class="etapas" id="etapa4">
                        <div>
                            <p class="descripcionEtapa">Entrega Usuario</p>
                            <p id="fecha4"></p>
                        </div>
                        <div class="circle etapa_falta" id="circle4">
                            <p class="faltante"><i class="fas fa-times"></i></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal" id="busqueda">
        <div class="ventanaBusqueda w50por">
            <div class="tituloVentana">
                <span id="tituloBusqueda">Catálogo Bienes/Servicios</span>
                <div>
                    <a href="#">
                        <i class="fas fa-window-close"></i>
                        <span>Cerrar</span>
                    </a>
                </div>
            </div>
            <div class="textoBusqueda">
                <input type="text" name="txtBuscarCodigo" id="txtBuscarCodigo" placeholder="Buscar Codigo">
                <input type="text" name="txtBuscarDescrip" id="txtBuscarDescrip" placeholder="Buscar Descripción">
            </div>
            <div class="tablaBusqueda">
                <table class="tabla " id="tablaModulos">
                    <thead >
                        <tr class="stickytop">
                            <th width="10%">Codigo</th>
                            <th>Descripcion</th>
                            <th>Und.</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
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
    <div class="modal" id="sendMail">
        <form action="#" method="post" id="formMails">
            <input type="hidden" name="estadoPedido" id="estadoPedido">
            <div class="ventanaCorreo">
                    <input type="file" name="mailAtach[]" id="mailAtach" multiple class="oculto">
                    <div class="tituloCorreo">
                        <h3 class="w100por">Enviar Correo</h3>
                        <a href="#" id="closeMail" title="Cerrar Ventana"><i class="fas fa-window-close"></i></a>
                        <hr>
                    </div>
                    <div class="cuerpoCorreo">
                        <div class="correoIzq">
                            <div class="asunto">
                                <label for="subject">Asunto :</label>
                                <input type="text" name="subject" id="subject">
                            </div>
                            <div class="opciones">
                                <button class="boton3 js-boton" data-type="bold" type="button"><i class="fas fa-bold"></i></button>
                                <button class="boton3 js-boton" data-type="italic" type="button"><i class="fas fa-italic"></i></button>
                                <button class="boton3" id="btnAtach"><i class="fas fa-paperclip"></i></button>
                            </div>
                            <div class="messaje">
                                <div contenteditable="true" id="mailMessage">

                                </div>
                            </div>
                            <div>
                                <span>CC: <?php echo $_SESSION['correo']?></span>
                            </div>
                            <ul class="atachs">

                            </ul>
                            <div class="commands">
                                <button class="boton3" id="btnConfirmSend">Enviar</button>
                            </div>
                        </div>
                        <div class="correoDerch">
                            <h4>Correos</h4>
                            <table id="listaCorreos" class="tabla">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>...</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </form>
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
                <input type="hidden" name="codigo_transporte" id="codigo_transporte">
                <input type="hidden" name="codigo_tipo" id="codigo_tipo">
                <input type="hidden" name="motivo_traslado" id="motivo_traslado">
                <input type="hidden" name="id_guia" id="id_guia" value=0>
                <input type="hidden" name="ubig_origen" id="ubig_origen">
                <input type="hidden" name="ubig_destino" id="ubig_destino">
                <input type="hidden" name="cso" id="cso">
                <input type="hidden" name="csd" id="csd">
                <input type="hidden" name="codigo_ubigeo" id="codigo_ubigeo">
                <input type="hidden" name="nombre_entidad_origen" id="nombre_entidad_origen">
                <input type="hidden" name="ruc_entidad_origen" id="ruc_entidad_origen">
                <input type="hidden" name="nombre_entidad_destino" id="nombre_entidad_destino">
                <input type="hidden" name="ruc_entidad_destino" id="ruc_entidad_destino">
                <input type="hidden" name="ticket_sunat" id="ticket_sunat">
                <div class="tituloDocumento">
                    <div>
                        <p class="titulo_seccion"><strong> Guia de Remision Interna : </strong></p>
                        <input type="text" name="serie_guia" id="serie_guia" class="w10por" value="T001" readonly>
                        <input type="text" name="numero_guia" id="numero_guia" readonly>
                        <br/><br/>
                        <p class="titulo_seccion"><strong> Guia de Remision Sunat : </strong></p>
                        <input type="text" name="serie_guia_sunat" id="serie_guia_sunat" class="w10por" value="T001" readonly>
                        <input type="text" name="numero_guia_sunat" id="numero_guia_sunat" readonly>
                    </div>
                    <div class="opciones_modal">
                        <a href="#" id="saveDocument" title="Grabar Guia"><i class="fas fa-save"></i><p>Grabar</p></a>
                        <a href="#" id="previewDocument" title="Vista previa"><i class="fas fa-eye"></i><p>Vista Previa</p></a>
                        <a href="#" id="guiaSunat" title="Guia Sunat" class="oculto"><i class="fas fa-shipping-fast"></i><p>Sunat</p></a>
                        <a href="#" id="closeDocument" title="Cerrar Ventana"><i class="fas fa-window-close"></i><p>Cerrar</p></a>
                    </div>
                </div>
                <hr>
                <div class="dos_columnas">
                    <div class="columna_izquierda">
                        <div class="fechas">
                            <div>
                                <label for="fgemision">Fecha Emisión:</label>
                                <input type="date" name="fgemision" id="fgemision" value="<?php echo date("Y-m-d")?>">
                            </div>
                            <div>
                                <label for="ftraslado">Fecha Traslado:</label>
                                <input type="date" name="ftraslado" id="ftraslado" value="<?php echo date("Y-m-d")?>" min="<?php echo date("Y-m-d")?>">
                            </div>
                            <div>
                                <label for="tipo_documento">Tipo Guia:</label>
                                <select name="tipo_documento" id="tipo_documento">
                                    <option value="1">DESTINATARIO</option>
                                    <option value="2" style="display:none;">REMITENTE</option>
                                    <option value="3">TRANSPORTISTA</option>
                                    <option value="4" style="display:none;">SUNAT</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <p class="titulo_seccion"><strong>Datos del Remitente</strong></p>
                            <div class="dos_columnas_interna">
                                <label>R.U.C.</label>
                                <input type="text" name="destinatario_ruc" id="destinatario_ruc" value="20504898173" readonly>
                                <label>Razón Social :</label>
                                <input type="text" name="destinatario_razon" id="destinatario_razon" value="SERVICIOS PETROLEROS Y CONSTRUCCIONES SEPCON S.A.C" readonly>
                                <label>Dirección:</label>
                                <input type="text" name="destinatario_direccion" id="destinatario_direccion" value="AV. SAN BORJA NORTE N° 445 - SAN BORJA-LIMA-PERU." readonly>
                            </div>
                            <p><strong>Domicilio de partida</strong></p>
                            <div class="tres_columnas_interna">
                                <label for="almacen_origen">Almacen Origen: </label>
                                <input type="text" name="almacen_origen" id="almacen_origen" class="cerrarLista" >
                                <button type="button" id="btnAlmacenOrigen" class="btnCallMenu boton3">+</button>
                                <div class="lista" id="listaOrigenGuia">
                                   <ul>
                                       <?php echo $this->listaAlmacen?>
                                   </ul> 
                                </div>
                                <label for="almacen_origen_direccion ">Dirección:</label>
                                <input type="text" name="almacen_origen_direccion" id="almacen_origen_direccion">
                                <br/>
                                <label for="ubigeo_origen">Ubigeo :</label>
                                <input type="text" name="ubigeo_origen_guia" id="ubigeo_origen_guia">
                                <button type="button" class="btnCallDialog boton3" id="ubigeoBtnOrigen">+</button>
                            </div>
                            <p><strong>Domicilio de Llegada</strong></p>
                            <div class="tres_columnas_interna">
                                <label for="almacen_destino">Almacen Destino: </label>
                                <input type="text" name="almacen_destino" id="almacen_destino">
                                <button type="button" class="btnCallMenu boton3">+</button>
                                <div class="lista" id="listaDestinoGuia">
                                   <ul>
                                       <?php echo $this->listaAlmacen?>
                                   </ul> 
                                </div>
                                <label for="almacen_destino_direccion ">Dirección:</label>
                                <input type="text" name="almacen_destino_direccion" id="almacen_destino_direccion">
                                <br/>
                                <label for="ubigeo_destino">Ubigeo :</label>
                                <input type="text" name="ubigeo_destino_guia" id="ubigeo_destino_guia">
                                <button type="button" class="btnCallDialog boton3" id="ubigeoBtnDestino">+</button>
                            </div>
                            <p><strong>Empresa de Transporte</strong></p>
                            <div class="tres_columnas_interna">
                                <label for="empresa_transporte_razon">Razón Social</label>
                                <input type="text" name="empresa_transporte_razon" id="empresa_transporte_razon" class="buscaGuia">
                                <button type="button" class="btnCallMenu boton3" id="ubigeoBtnDestino">+</button>
                                <div class="lista" id="listaEntidad">
                                   <ul>
                                       <?php echo $this->listaEntidad?>
                                   </ul> 
                                </div>
                                <label for="direccion_proveedor">Dirección</label>
                                <input type="text" name="direccion_proveedor" id="direccion_proveedor" class="datosEntidad">
                                <span></span>
                                <label for="ruc_proveedor">R.U.C.</label>
                                <input type="text" name="ruc_proveedor" id="ruc_proveedor" class="datosEntidad">
                                <span></span>
                                <label for="registro_mtc">Registro MTC</label>
                                <input type="text" name="registro_mtc" id="registro_mtc" class="datosEntidad">
                            </div>
                        </div>
                    </div>
                    <div class="columna_derecha">
                        <label id="mensaje_sunat" style="width: 100%;
                                    display: block;
                                    height: 1rem;
                                    text-align: right;
                                    padding: .5rem;"></label>
                        <br/>
                        <p><strong>Motivo</strong></p>
                        <div class="tres_columnas_interna">
                            <label for="tipo_transporte" class="uno">Tipo Transporte :</label>
                            <input type="text" name="tipo_transporte" id="tipo_transporte" class="dos mostrarListaInterna busqueda">
                            <button type="button" class="btnCallMenu boton3">+</button>
                            <div class="lista rowOne uno" id="listaTransporte">
                                <ul>
                                    <?php echo $this->listaTransporte?>
                                </ul> 
                            </div>
                            <label for="modalidad_traslado" class="uno">Modalidad Traslado :</label>
                            <input type="text" name="modalidad_traslado" id="modalidad_traslado" class="dos mostrarListaInterna busqueda">
                            <button type="button" class="btnCallMenu boton3">+</button>
                            <div class="lista rowOne uno" id="listaModalidad">
                                <ul>
                                    <?php echo $this->listaModalidad?>
                                </ul> 
                            </div>
                            <label for="tipo_envio">Tipo Envio</label>
                            <input type="text" name="tipo_envio" id="tipo_envio" class="dos mostrarListaInterna busqueda" placeholder="Elija opción">
                            <button type="button" class="btnCallMenu boton3">+</button>
                            <div class="lista uno rowTwo" id="listaEnvio">
                                <ul>
                                    <?php echo $this->listaEnvio?>
                                </ul> 
                            </div>
                            <label for="autoriza">Autoriza:</label>
                            <input type="text" name="autorizaguia" id="autorizaguia" class="dos mostrarListaInterna busqueda" placeholder="Elija opción">
                            <button type="button" class="btnCallMenu boton3">+</button>
                            <div class="lista uno rowThree" id="listaAutorizaGuia">
                                <ul>
                                    <?php echo $this->listaPersonal?>
                                </ul> 
                            </div>
                            <label for="destinatario">Destinatario:</label>
                            <input type="text" name="destinatario" id="destinatario" class="busqueda" placeholder="Elija opción">
                            <button type="button" class="btnCallMenu boton3">+</button>
                            <div class="lista uno rowFour" id="listaDestinatario">
                                <ul>
                                    <?php echo $this->listaPersonal?>
                                </ul> 
                            </div>
                            <label for="observaciones_guia">Observaciones:</label>
                            <textarea name="observaciones" id="observaciones" placeholder="Observaciones" class="dos"></textarea>
                        </div>
                        <p><strong>Datos del Conductor</strong></p>
                        <div class="tres_columnas_interna">
                            <label for="nombre_conductor">Nombre :</label>
                            <input type="text" name="nombre_conductor" id="nombre_conductor" class="cerrarLista">
                            <button type="button" id="btnConductor" class="btnCallMenu boton3">+</button>
                            <div class="lista" id="listaConductores">
                                <ul>
                                    <?php echo $this->listaConductores?>
                                </ul> 
                            </div>
                            <label for="licencia_conducir">N° Licencia :</label>
                            <input type="text" name="licencia_conducir" id="licencia_conducir" class="cerrarLista">
                            <span></span>
                            <label for="coductor_dni">DNI conductor :</label>
                            <input type="text" name="conductor_dni" id="conductor_dni" class="cerrarLista">
                        </div>
                        <p><strong>Datos del Vehiculo</strong></p>
                        <div class="tres_columnas_interna">
                            <label for="placa">Nro. Placa :</label>
                            <input type="text" name="placa" id="placa">
                            <button type="button" id="btnPlaca" class="btnCallMenu boton3">+</button>
                            <div class="lista" id="listaPlacas">
                                <ul>
                                    <?php echo $this->listaPlacas?>
                                </ul> 
                            </div>
                            <label for="marca" class="oculto">Marca :</label>
                            <input type="text" name="marca" id="marca" class="oculto">
                        </div>
                        <p><strong>Datos Adicionales</strong></p>
                        <div class="tres_columnas_interna">
                            <label for="marca">Peso :</label>
                            <input type="text" name="peso" id="peso">
                            <span></span>
                            <label for="bultos" class="oculto">Nro. Bultos :</label>
                            <input type="text" name="bultos" id="bultos" class="oculto">
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
    <div class="cabezaModulo">
        <h1>Autorización de traslado de equipos/materiales</h1>
        <div>
            <a href="#" id="nuevoRegistro"><i class="far fa-file"></i><p>Nuevo</p></a>
            <a href="#" id="irInicio"><i class="fas fa-home"></i><p>Inicio</p></a>
            <a href="#" id="closeSession" class="oculto">xxx<p>Inicio</p></a>
        </div>
    </div>
    <div class="barraTrabajo">
        <form action="#" id="formConsulta">
            <div class="variasConsultas">
                    <div>
                        <label for="numberSearch">Numero : </label>
                        <input type="text" name="numberSearch" id="numberSearch">
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
                    <button type="button" id="btnConsulta" class="boton3">Consultar</button> 
            </div>
        </form>
    </div>
    <div class="itemsTabla">
        <table id="tablaPrincipal">
            <thead class="stickytop">
                <tr>
                    <th>Item.</th>
                    <th>Emision</th>
                    <th>Tipo</th>
                    <th>Centro Costos</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Area</th>
                    <th>Asigna</th>
                    <th>Estado</th>
                    <th>...</th>
                    <th>...</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $this->listaTraslados;?>
            </tbody>
        </table>
    </div>
    <script src="<?php echo constant('URL');?>public/js/jquery.js"></script>
    <script src="<?php echo constant('URL');?>public/js/funciones.js?<?php echo constant('VERSION')?>"></script>
    <script src="<?php echo constant('URL');?>public/js/autorizacion.js?<?php echo constant('VERSION')?>"></script>
</body>
</html>