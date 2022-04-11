<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos Bienes/Servicios</title>
</head>
<body>
    <div class="mensaje">
        <p></p>
    </div>
    <div class="modal" id="esperar">
    </div>
    <div class="modal" id="pregunta">
    </div>
    <div class="modal" id="proceso">
        <div class="ventanaProceso tamanioProceso">
            <div class="cabezaProceso">
                <form action="#" id="formProceso" autocomplete="off">
                    <input type="hidden" name="codigo_costos" id="codigo_costos"> 
                    <input type="hidden" name="codigo_area" id="codigo_area">
                    <input type="hidden" name="codigo_transporte" id="codigo_transporte">
                    <input type="hidden" name="codigo_solicitante" id="codigo_solicitante">
                    <input type="hidden" name="codigo_tipo" id="codigo_tipo">
                    <input type="hidden" name="codigo_pedido" id="codigo_pedido">
                    <input type="hidden" name="codigo_estado" id="codigo_estado" value="0">
                    <input type="hidden" name="dias_atencion" id="dias_atencion" value="0">
                    <input type="hidden" name="codigo_atencion" id="codigo_atencion" value="0">

                    <div class="barraOpciones primeraBarra">
                        <span>Datos Generales</span>
                        <div>
                            <button type="button" id="saveItem" title="Grabar Pedido" class="boton1">
                                <span><i class="far fa-save"></i> Grabar Pedido</span> 
                            </button>
                            <button type="button" id="upAttach" title="Importar Adjuntos" class="boton1">
                                <i class="fas fa-upload"></i> Adjuntar Archivos
                            </button>
                            <button type="button" id="preview" title="Vista Previa" class="boton1">
                                <i class="fab fa-wpexplorer"></i> Vista Previa
                            </button>
                            <button type="button" id="sendItem" title="Enviar Pedido" class="boton1 desactivado">
                                <i class="far fa-paper-plane"></i> Enviar Almacen
                            </button>
                            <button type="button" id="requestAprob" title="Solicitar Aprobacion" class="boton1 desactivado">
                                <i class="fas fa-award"></i> Solicitar Aprobacion
                            </button>
                            <button type="button" id="closeProcess" title="Cerrar">
                                <i class="fas fa-window-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="dataProceso_2">
                        <div class="seccion_izquierda">
                            <div class="column4_55">
                                <div class="column2_3957">
                                    <label for="numero">Número:</label>
                                    <input type="text" name="numero" id="numero" class="cerrarLista" readonly>
                                </div>
                                <div class="column2_46">
                                    <label for="emision">Emisión:</label>
                                    <input type="date" name="emision" id="emision" class="cerrarLista" value="<?php echo date("Y-m-d");?>">
                                </div>
                            </div>
                            <div class="column2">
                                <label for="costos">CCostos:</label>
                                <input type="text" name="costos" id="costos" class="mostrarLista busqueda" placeholder="Elija una opcion">
                                <div class="lista" id="listaCostos">
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
                                <label for="transporte">Transporte:</label>
                                <input type="text" name="transporte" id="transporte" class="mostrarLista" placeholder="Elija una opcion">
                                <div class="lista" id="listaTransportes">
                                   <ul>
                                       <?php echo $this->listaTransportes?>
                                   </ul>
                                </div>
                            </div>
                            <div class="column2">
                                <label for="concepto">Concepto:</label>
                                <input type="text" name="concepto" id="concepto" class="cerrarLista">
                            </div>
                            <div class="column2">
                                <label for="solicitante">Solicitante:</label>
                                <input type="text" name="solicitante" id="solicitante" class="mostrarLista busqueda" placeholder="Elija una opcion">
                                <div class="lista" id="listaSolicitantes">
                                   <ul>
                                       <?php echo $this->listaAquarius?>
                                   </ul>
                                </div>
                            </div>
                        </div>
                        <div class="seccion_derecha">
                            <div class="column4_55">
                                <div class="column2_3957">
                                    <label for="tipo">Tipo :</label>
                                    <input type="text" name="tipo" id="tipo" class="mostrarLista" placeholder="Elija una opcion">
                                    <div class="lista" id="listaTipo">
                                        <ul>
                                            <?php echo $this->listaTipos?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="column2_46">
                                    <label for="vence">Vence :</label>
                                    <input type="date" name="vence" id="vence" class="cerrarLista" value="<?php echo date("Y-m-d");?>">
                                </div>
                            </div>
                            <div class="column2">
                                <label for="estado">Estado:</label>
                                <input type="text" name="estado" id="estado" class="textoCentro w35por estado procesando" readonly value="EN PROCESO">
                            </div>
                        </div>
                    </div>
                    <div class="barraOpciones">
                        <span>Especificaciones Técnicas o Descripción del Pedido</span>
                    </div>
                    <div class="textAreaEnter">
                        <textarea name="espec_items" id="espec_items" rows="2" class="w100p"></textarea>
                    </div>
                    <div class="barraOpciones">
                        <span>Detalles</span>
                        <button type="button" id="addItem" title="Añadir Item" class="cerrarLista">
                            <i class="far fa-plus-square"></i> Agregar
                        </button>
                    </div>
                    <div class="tablaInterna mininoTablaInterna">
                        <table class="tabla" id="tablaDetalles">
                            <thead>
                                <tr>
                                    <th>...</th>
                                    <th>Item</th>
                                    <th>Codigo</th>
                                    <th>Descripcion</th>
                                    <th>Und.</th>
                                    <th>Cant.</th>
                                    <th>Nro.</br>Parte</th>
                                    <th>Ver.</br>QA/QC</th>
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
        <div class="ventanaBusqueda">
            <div class="tituloVentana">
                <span id="tituloBusqueda">Catálogo Bienes/Servicios</span>
                <div>
                    <a href="#"><i class="fas fa-window-close"></i></a>
                </div>
            </div>
            <div class="textoBusqueda">
                <input type="text" name="txtBuscar" id="txtBuscar" placeholder="Buscar">
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
    <div class="cabezaModulo">
        <h1>Catálogo Bienes/Servicios</h1>
        <div>
            <a href="#" id="nuevoRegistro"><i class="far fa-file"></i></a>
            <a href="#" id="irInicio"><i class="fas fa-home"></i></a>
        </div>
    </div>
    <div class="barraTrabajo">
        <form action="#" id="formConsulta">
            <div class="variasConsultas">
                    <div>
                        <label for="tipo">Tipo : </label>
                        <select name="tipo" id="tipo">
                            <option value="37">Bienes</option>
                            <option value="38">Servicios</option>
                        </select>
                    </div>
                    <div>
                        <label for="costos">Centro de Costos</label>
                        <input type="text" name="costos" id="costos">
                    </div>
                    <div>
                        <label for="mes">Mes</label>
                        <input type="number" name="mes" id="mes" value="<?php echo date("m")?>" class="textoCentro">
                    </div>
                    <div>
                        <label for="anio">Año :</label>
                        <input type="number" name="anio" id="anio" value="<?php echo date("Y")?>" class="textoCentro">
                    </div>
                    <button type="button">Procesar</button> 
            </div>
        </form>
    </div>
    <div class="itemsTabla">
        <table id="tablaPrincipal">
            <thead>
                <tr>
                    <th>Num.</th>
                    <th>Emision</th>
                    <th>Vencimiento</th>
                    <th>Descripción</th>
                    <th>Area</th>
                    <th>Centro de Costos</th>
                    <th>Resposable</th>
                    <th>Estado Pedido</th>
                    <th>Atencion</th>
                    <th>...</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $this->listaPedidos;?>
            </tbody>
        </table>
    </div>
    <script src="<?php echo constant('URL');?>public/js/jquery.js"></script>
    <script src="<?php echo constant('URL');?>public/js/funciones.js?<?php echo constant('VERSION')?>"></script>
    <script src="<?php echo constant('URL');?>public/js/pedidos.js?<?php echo constant('VERSION')?>"></script>
</body>
</html>