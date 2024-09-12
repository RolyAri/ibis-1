$(function(){
    let accion = "";
    let grabado = false;

    $("#esperar").fadeOut();

    $("#tablaPrincipal tbody").on("click","a", function (e) {
        e.preventDefault();

        let id = $(this).attr("href");

        if($(this).data("accion") == 'status'){
            let formData = new FormData();
            
            formData.append("id",id);

            fetch(RUTA+'autorizacion/status',{
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data =>{
                if (data[0].frecepcion !== null) {
                    $("#fecha1").text(data[0].frecepcion);
                    $("#circle1")
                        .removeClass('etapa_falta')
                        .addClass('etapa_completa');

                    $("#circle1 p")
                        .removeClass('faltante')
                        .addClass('completado');

                    $("#circle1 p i")
                        .removeClass('fa-times')
                        .addClass('fa-check');
                }else{
                    $("#circle1")
                        .removeClass('etapa_completa')
                        .addClass('etapa_falta');

                    $("#circle1 p")
                        .removeClass('completado')
                        .addClass('faltante');

                    $("#circle1 p i")
                        .removeClass('fa-check')
                        .addClass('fa-times');
                };

                if (data[0].fentrelog !== null) {
                    $("#fecha2").text(data[0].fentrelog);

                    $("#circle2")
                        .removeClass('etapa_falta')
                        .addClass('etapa_completa');

                    $("#circle2 p")
                        .removeClass('faltante')
                        .addClass('completado');

                    $("#circle2 p i")
                        .removeClass('fa-times')
                        .addClass('fa-check');
                }else{
                    $("#circle2")
                        .removeClass('etapa_completa')
                        .addClass('etapa_falta');

                    $("#circle2 p")
                        .removeClass('completado')
                        .addClass('faltante');

                    $("#circle2 p i")
                        .removeClass('fa-check')
                        .addClass('fa-times');
                };

                if (data[0].freceplog !== null) {
                    $("#fecha3").text(data[0].freceplog);
                };

                if (data[0].fentreuser !== null) {
                    $("#fecha4").text(data[0].fentreuser);
                };

                $("#status").fadeIn();
             })

        }else{
            console.log(id); 
        };

        return false;
    });

    $("#tablaPrincipal tbody").on("click","tr", function (e) {
        e.preventDefault();

        accion = "";

        let indice  = $(this).data("indice"),
            formData = new FormData();
            formData.append('indice', indice);

        fetch(RUTA+'autorizacion/documentoId',{
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            $("#codigo_costos").val(data.datos[0].ncostos);
            $("#codigo_area").val(data.datos[0].narea);
            $("#codigo_tipo").val(data.datos[0].ctransferencia);
            $("#codigo_solicitante").val(data.datos[0].ncostos);
            $("#codigo_origen").val(data.datos[0].norigen);
            $("#codigo_destino").val(data.datos[0].ndestino);
            $("#codigo_estado").val(data.datos[0].nestado);
            $("#codigo_usuario").val(data.datos[0].celabora);
            $("#codigo_autoriza").val(data.datos[0].cautoriza);
            $("#numero").val(data.datos[0].idreg);
            $("#emision").val(data.datos[0].emision);
            $("#costos").val(data.datos[0].cdesproy);
            $("#area").val(data.datos[0].area);
            $("#solicitante").val(data.datos[0].solicita);
            $("#origen").val(data.datos[0].almacenorigen);
            $("#destino").val(data.datos[0].almacendestino);
            $("#tipo").val(data.datos[0].transferencia);
            $("#autoriza").val(data.datos[0].autoriza);
            $("#observaciones").val(data.datos[0].observac);
            $("#codigo_traslado").val(data.datos[0].indice);

            let fila = 1;

            data.detalles.forEach(element => {
                let row = `<tr>
                                <td></td>
                                <td class="textoCentro">${fila++}</td>
                                <td class="textoCentro">${element.ccodprod}</td>
                                <td class="pl20px">${element.cdesprod}</td>
                                <td class="textoCentro">${element.cabrevia}</td>
                                <td class="textoDerecha">${element.ncantidad}</td>
                                <td class="pl20px">${element.cserie}</td>
                                <td class="pl20px">${element.cdestino}</td>
                                <td class="pl20px">${element.nparte}</td>
                                <td class="pl20px">${element.cobserva}</td>
                            </tr>`;
                
                $("#tablaDetalles tbody").append(row);
            });

            $("#proceso").fadeIn();
        })

        return false;
    });

    $("#nuevoRegistro").click(function (e) { 
        e.preventDefault();

        try {
            if ( $("#id_user").val() == "" ) throw new Error("General -- reinicie el sistema");

                $("#estado")
                    .removeClass()
                    .addClass("textoCentro w35por estado procesando");
                $("#proceso").fadeIn();
                
                accion = 'n';
                grabado = false;

                $("#codigo_usuario,#codigo_solicitante").val($("#id_user").val());
                $("#solicitante").val($("#name_user").val());
                $("#correo_usuario").val($("#mail_user").val());
                $("#codigo_estado").val(49);

                $(".primeraBarra").css("background","#0078D4");
                $(".primeraBarra span").text('Datos Generales');

        } catch (error) {
            mostrarMensaje(error,"mensaje_error");
        }
       
        return false;
    });

    $("#closeProcess").click(function (e) { 
        e.preventDefault();

        $.post(RUTA+"autorizacion/actualizaListado",
            function (data, textStatus, jqXHR) {
                $(".itemsTabla table tbody")
                    .empty()
                    .append(data);

                $("#proceso").fadeOut(function(){
                    grabado = false;
                    $("form")[1].reset();
                    $("#tablaDetalles tbody").empty();
                    $(".lista").fadeOut();
                });
            },
            "text"
        );
        return false;
    });

    $(".mostrarLista").focus(function (e) { 
        e.preventDefault();

        if (accion !="n") {
            return false;
        }
        
        $(this).next().slideDown();

        return false;
    });

    $(".cerrarLista").focus(function (e) { 
        e.preventDefault();
        
        $(".lista").fadeOut();

        return false;
    });

    $(".btnCallMenu").click(function (e) { 
        e.preventDefault();
        
        let callButtom = e.target.id;

        $(this).next().fadeToggle();

        return false
    });

    $(".lista").on("click",'a', function (e) {
        e.preventDefault();

        let control = $(this).parent().parent().parent();
        let destino = $(this).parent().parent().parent().prev();
        let contenedor_padre = $(this).parent().parent().parent().attr("id");
        let id = "";
        let codigo = $(this).attr("href");
        let catalogo = $(this).data("catalogo");
        
        control.slideUp()
        destino.val($(this).text());
        id = destino.attr("id");

        if(contenedor_padre == "listaCostosOrigen"){
            $("#codigo_costos_origen").val(codigo);
        }else if(contenedor_padre == "listaCostosDestino") {
            $("#codigo_costos_destino").val(codigo);
        }else if(contenedor_padre == "listaAreas"){
            $("#codigo_area").val(codigo);
        }else if(contenedor_padre == "listaSolicitantes"){
            $("#codigo_solicitante").val(codigo);
        }else if(contenedor_padre == "listaTiposTransferencia"){
            $("#codigo_tipo_transferencia").val(codigo);
        }else if(contenedor_padre == "listaOrigen"){
            $("#codigo_origen").val(codigo);
        }else if(contenedor_padre == "listaDestino"){
            $("#codigo_destino").val(codigo);
        }else if(contenedor_padre == "listaTipos"){
            $("#codigo_tipo").val(codigo);
        }else if(contenedor_padre == "listaAutoriza"){
            $("#codigo_autoriza").val(codigo);
        }else if(contenedor_padre == "listaMovimiento"){
            $("#codigo_movimiento").val(codigo);
        }else if(contenedor_padre == "listaAprueba"){
            $("#codigo_aprueba").val(codigo);
            $("#autoriza").val($(this).text());
        }else if(contenedor_padre == "listaOrigenGuia"){
            $("#codigo_origen").val(codigo);
            $("#almacen_origen").val($(this).text());
            $("#almacen_origen_direccion").val($(this).data('direccion'));
            $("#codigo_origen_sunat").val($(this).data('sunat'));
            $("#ruc_entidad_origen").val($(this).data('ruc'));
            $("#nombre_entidad_origen").val($(this).data('razon'));
            $("#ubigeo_origen_guia,#ubig_origen").val($(this).data('ubigeo'));
            $("#cso").val($(this).data('sunat'));
        }else if(contenedor_padre == "listaDestinoGuia"){
            $("#almacen_destino").val($(this).text());
            $("#almacen_destino_direccion").val($(this).data('direccion'));
            $("#codigo_destino_sunat").val($(this).data('sunat'));
            $("#ubigeo_destino_guia,#ubig_destino").val($(this).data('ubigeo'));
            $("#ruc_entidad_destino").val($(this).data('ruc'));
            $("#nombre_entidad_destino").val($(this).data('razon'));
            $("#csd").val($(this).data('sunat'));
        }else if(contenedor_padre == "listaAutorizaGuia"){
            $("#autorizaguia").val($(this).text());
            $("#codigo_autoriza").val(codigo);
        }else if(contenedor_padre == "listaDespacha"){
            $("#codigo_despacha").val(codigo);
        }else if(contenedor_padre == "listaDestinatario"){
            $("#destinatario").val($(this).text());
            $("#codigo_destinatario").val(codigo);
        }else if(contenedor_padre == "listaModalidad"){
            $("#modalidad_traslado").val($(this).text());
            $("#codigo_modalidad").val(codigo);
        }else if(contenedor_padre == "listaEnvio"){
            $("#tipo_envio").val($(this).text());
            $("#codigo_tipo").val(codigo);
        }else if(contenedor_padre == "listaEntidad"){
            $("#codigo_entidad_transporte").val(codigo);
            $("#empresa_transporte_razon").val($(this).text());
            $("#ruc_proveedor").val($(this).data("ruc"));
            $("#direccion_proveedor").val($(this).data("direccion"));
            $("#registro_mtc").val($(this).data("mtc"));
        }else if(contenedor_padre == "listaTransporte"){
            $("#codigo_transporte").val(codigo);
            $("#tipo_transporte").val($(this).text());
        }else if(contenedor_padre == "listaConductores"){
            $("#nombre_conductor").val($(this).text());
            $("#licencia_conducir").val($(this).data('licencia'));
            $("#conductor_dni").val($(this).data('dni'));
        }else if(contenedor_padre == "listaPlacas"){
            $("#placa").val($(this).text());
        }else if(contenedor_padre == "listaOrigenCabecera"){
            $("#codigo_almacen_origen").val(codigo);
        }else if(contenedor_padre == "listaDestinoCabecera"){
            $("#codigo_almacen_destino").val(codigo);
        }

        return false;
    });

    //filtrado en la lista de solicitante
    $(".busqueda").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(this).next().attr("id");

        //aignar a una variable el contenido
        let l = "#"+ $(this).next().attr("id")+ " li a"

        $(l).filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    //filtrar Item del pedido
    $("#txtBuscarCodigo, #txtBuscarDescrip").on("keypress", function (e) {
        if(e.which == 13) {
            $("#esperar").fadeIn();
            
            if ( $("#codigo_tipo").val() === "277" ){
                $.post(RUTA+"pedidos/filtraItems", {codigo:$("#txtBuscarCodigo").val(),
                                            descripcion:$("#txtBuscarDescrip").val(),
                                            tipo:37},
                    function (data, textStatus, jqXHR) {
                        $("#tablaModulos tbody")
                            .empty()
                            .append(data);
                        $("#esperar").fadeOut();
                    },
                    "text"
                );
            }
            else {
                $.post(RUTA+"autorizacion/equipos", {codigo:$("#txtBuscarCodigo").val(),
                                                    descripcion:$("#txtBuscarDescrip").val()},
                    function (data, textStatus, jqXHR) {
                        $("#tablaModulos tbody")
                            .empty()
                            .append(data);
                        $("#esperar").fadeOut();
                    },
                    "text"
                );
            }
            
        }
    });

    //cuando cambia algo en la tabla de detalles
    $("#tablaDetalles tbody ").on("change","input", function (e) {
        //e.preventDefault();

        if (accion == 'u') {
            $(this).parent().parent().attr("data-grabado",0);
        }
        
       return false;
    });

    $("#tablaDetalles tbody ").on("change","textarea", function (e) {
        //e.preventDefault();

        if (accion == 'u') {
            $(this).parent().parent().attr("data-grabado",0);
        }
        
       return false;
    });

    $("#tablaDetalles tbody").on('keypress','input', function (e) {
        if (e.which == 13) {
            //para cambiar el foco con el enter

            cb = parseInt($(this).attr('tabindex'));

            if ($(':input[tabindex=\'' + (cb + 1) + '\']') != null) {
                $(':input[tabindex=\'' + (cb + 1) + '\']').focus();
                $(':input[tabindex=\'' + (cb + 1) + '\']').select();
            }
        }
    });

    $("#addItem").click(function (e) { 
        e.preventDefault();

        grabado = false;
        
        if ( $("#codigo_tipo").val() === ""){
            mostrarMensaje("Selecione el tipo de movimiento","mensaje_error");
        }else{
            if ( $("#codigo_tipo").val() === "277")
                $.post(RUTA+"pedidos/llamaProductos", {tipo:37},
                    function (data, textStatus, jqXHR) {
                        $("#tablaModulos tbody")
                            .empty()
                            .append(data);

                        $("#busqueda").fadeIn();
                    },
                    "text"
                );
            else {
                $.post(RUTA+"autorizacion/equipos", {codigo:"-1",descripcion:"-1"},
                    function (data, textStatus, jqXHR) {
                        $("#tablaModulos tbody")
                            .empty()
                            .append(data);

                        $("#busqueda").fadeIn();
                    },
                    "text"
                );
            }
        }

        return false;
    });

    $(".tituloVentana").on("click","a", function (e) {
        e.preventDefault();

        $(this).parent().parent().parent().parent().fadeOut();

        return false;
    });

    $("#tablaModulos tbody").on("click","tr", function (e) {
        e.preventDefault();

        let nFilas = $.strPad($("#tablaDetalles tr").length,3);
        let idprod = $(this).data("idprod");
        let nunid = $(this).data("ncomed");
        let codigo = $(this).children('td:eq(0)').text();
        let descrip = $(this).children('td:eq(1)').text();
        let unidad = $(this).children('td:eq(2)').text();
        let grabado = 0;
        let tabPos  = $("#tablaDetalles tr").length;

        let row = `<tr data-grabado="${grabado}" data-idprod="${idprod}" data-codund="${nunid}" data-idx="-">
                    <td class="textoCentro"><a href="#"><i class="fas fa-eraser"></i></a></td>
                    <td class="textoCentro">${nFilas}</td>
                    <td class="textoCentro">${codigo}</td>
                    <td class="pl20px">${descrip}</td>
                    <td class="textoCentro">${unidad}</td>
                    <td><input type="number" 
                                step="any" 
                                placeholder="0.00" 
                                onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"
                                tabIndex="${tabPos}">
                    </td>
                    <td class="textoCentro"><input type="text"></td>
                    <td class="textoCentro"><input type="text"></td>
                    <td class="textoCentro"><input type="text"></td>
                    <td><textarea></textarea></td>
                </tr>`;

        $("#tablaDetalles tbody").append(row);

        return false;
    });
    
    $("#tablaDetalles").on('click','a', function(e) {
        e.preventDefault();

        let fila = $(this).parent().parent();

        if ($(this).attr("href") == "#") {
                $(this).parent().parent().remove();
                fillTables($("#tablaDetalles tbody > tr"),1);
        }else {
            $.post(RUTA+"pedidos/quitarItem", {query:"UPDATE alm_autorizadet SET alm_autorizadet.nflgactivo =:estado WHERE alm_autorizadet.iditem =:id",
                                                        id:$(this).attr("href")},
                function (data, text, requestXHR) {
                    fila.remove();
                    fillTables($("#tablaDetalles tbody > tr"),1);
                },
                "text"
            );
        };

        return false;
    });

    $("#saveItem").click(function (e) { 
        e.preventDefault();
        
        let result = {};

        $.each($("#formProceso").serializeArray(),function(){
            result[this.name] = this.value;
        });

        try {
            if (result['codigo_costos'] == '') throw "Elija Centro de Costos";
            if (result['codigo_area'] == '') throw "Elija Area";
            if (result['codigo_tipo'] == '') throw "Elija Tipo de Autorizacion";
            if (result['codigo_solicitante'] == '') throw "Elija el asignado";
            if (result['codigo_origen'] == '') throw "Elija el almacén origen";
            if (result['codigo_destino'] == '') throw "Elija el almacén destino";
            if ($("#tablaDetalles tbody tr").length <= 0) throw "El pedido no tienes items";
            if (checkCantTables($("#tablaDetalles tbody > tr"),5)) throw "No ingreso cantidad en un item";
            
            if ( accion == 'n' ){

                $("#esperar").css("opacity","1").fadeIn();

                $.post(RUTA+"autorizacion/nuevoDocumento", {cabecera:result,detalles:JSON.stringify(itemsSave())},
                    function (data, textStatus, jqXHR) {
                        grabado = true;
                        accion = "u";
                        
                        $(".primeraBarra").css("background","#819830");
                        $(".primeraBarra span").text('Datos Generales ... Grabado');

                        $("#numero").val(data.numero);
                        $("#esperar").css("opacity","0").fadeOut();

                        mostrarMensaje("Registro grabado","mensaje_correcto");

                    },
                    "json"
                );
            }else if(accion == 'u'){

                $("#esperar").css("opacity","1").fadeIn();

                $.post(RUTA+"autorizacion/modificaDocumento", {cabecera:result,detalles:JSON.stringify(itemsSave())},
                    function (data, textStatus, jqXHR) {
                        mostrarMensaje(data.mensaje,data.clase);
                        accion = "u";
                        grabado = true;
                        $("#tablaDetalles tbody")
                            .empty()
                            .append(data.items.detalles);
                        $("#esperar").css("opacity","0").fadeOut();
                    },
                    "json");
            }

        } catch (error) {
            mostrarMensaje(error,'mensaje_error');
        }

        return false;
    });

    $("#preview").click(function (e) { 
        e.preventDefault();
        
        try {
            if ( accion == "n" ) throw new Error('Debe grabar el documento');

            let result = {};

            $.each($("#formProceso").serializeArray(),function(){
                result[this.name] = this.value;
            });

            let formData = new FormData();
            formData.append("cabecera",result);
            formData.append("detalles",JSON.stringify(itemsSave()));

            $.post(RUTA+'autorizacion/vistaPrevia',{"cabecera":result,"detalles":JSON.stringify(itemsPreview())},
                function (data, text, requestXHR) {
                    $(".ventanaVistaPrevia iframe")
                    .attr("src","")
                    .attr("src","public/documentos/autorizaciones/"+data.archivo);

                    $("#vista_previa").val(data);

                    $("#vistaprevia").fadeIn();
                },
                "json"
            );

        } catch (error) {
            mostrarMensaje(error.message,"mensaje_error");
        }

        return false;
    });

    $("#closePreview").click(function (e) { 
        e.preventDefault();

        $(".ventanaVistaPrevia iframe").attr("src","");
        $("#vistaprevia").fadeOut();

        return false;
    });

    $("#guiaRemision").click(function(e){
        e.preventDefault();

        try {
            if ( $("#rol_user").val() == 2 && $("#rol_user").val() == 4 ) throw new Error("No esta habilitado para generar guias");
            if ( accion == "n" ) throw new Error('Debe grabar el documento');

            $("#vistadocumento").fadeIn();
        } catch (error) {
            mostrarMensaje(error.message,"mensaje_error")
        }
        
        return false;
    });

    $("#recepcionCarga").click(function(e){
        e.preventDefault();

        try {
            if ( $("#rol_user").val() == 2 && $("#rol_user").val() == 4 ) throw new Error("No esta habilitado para este proceso");
            if ( $("#codigo_estado").val() != 49 ) throw new Error("El formato ya ha sido recepcionado");

            $("#recepcionAlmacenModal").fadeIn();
        } catch (error) {
            mostrarMensaje(error.message,"mensaje_error")
        }

        return false;
    });

    $("#entregaLogistica").click(function(e){
        e.preventDefault();

        try {
            if ( $("#rol_user").val() == 2 && $("#rol_user").val() == 4 ) throw new Error("No esta habilitado para este proceso");
            if ( $("#codigo_estado").val() != 60 ) throw new Error("No se permite la accion");

            $("#entregaLogisticaModal").fadeIn();
        } catch (error) {
            mostrarMensaje(error.message,"mensaje_error")
        }

        return false;
    });

    $("#recepcionLogistica").click(function(e){
        e.preventDefault();

        try {
            if ( $("#rol_user").val() == 2 && $("#rol_user").val() == 4 ) throw new Error("No esta habilitado para este proceso");
            if ( $("#codigo_estado").val() != 62 ) throw new Error("No se puede recepcionar el documento");

            $("#recepcionLogisticaModal").fadeIn();
        } catch (error) {
            mostrarMensaje(error.message,"mensaje_error")
        }

        return false;
    });

    $("#entregaUsuario").click(function(e){
        e.preventDefault();

        try {
            if ( $("#rol_user").val() == 2 && $("#rol_user").val() == 4 ) throw new Error("No esta habilitado para este proceso");
            if ( $("#codigo_estado").val() != 63 ) throw new Error("No se recepcionó de logística");

            $("#entregaDestinoModal").fadeIn();
        } catch (error) {
            mostrarMensaje(error.message,"mensaje_error")
        }

        return false;
    });

    $("#btnAceptarRecepcion").click(function (e) { 
        e.preventDefault();

        try {
            let formData = new FormData();
            formData.append("id", $("#codigo_traslado").val());
            formData.append("estado",60);

            fetch(RUTA+"autorizacion/recepcionAlmacen",{
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                mostrarMensaje("Registrado Correctamente","mensaje_correcto");
            })
            .catch(error => {
                if (error instanceof TypeError && error.message.includes('API key')) {
                  console.error('Invalid API key:', error);
                } else {
                  console.error('There was a problem with the Fetch operation:', error);
                }
            });
        } catch (error) {
            mostrarMensaje(error.message,"mensaje_error");
        }

        return false;
    });

    $("#btnAceptarEntregaLogistica").click(function (e) { 
        e.preventDefault();

        try {
            let formData = new FormData();
            formData.append("id", $("#codigo_traslado").val());
            formData.append("estado",62);

            fetch(RUTA+"autorizacion/entregaLogistica",{
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                mostrarMensaje("Traslado actualizado","mensaje_correcto");
            })
        } catch (error) {
            mostrarMensaje(error.message,"mensaje_error");
        }

        return false;
    });

    $("#btnAceptarRecepcionLogistica").click(function (e) { 
        e.preventDefault();

        try {
            let formData = new FormData();
            formData.append("id", $("#codigo_traslado").val());
            formData.append("estado",63);

            fetch(RUTA+"autorizacion/recepcionLogistica",{
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                mostrarMensaje("Recepcionado en almacen","mensaje_correcto");
            })
        } catch (error) {
            mostrarMensaje(error.message,"mensaje_error");
        }

        return false;
    });

    $("#btnAceptarEntregaDestino").click(function (e) { 
        e.preventDefault();

        try {
            let formData = new FormData();
            formData.append("id", $("#codigo_traslado").val());
            formData.append("estado",140);

            fetch(RUTA+"autorizacion/entregaFinal",{
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                mostrarMensaje("Traslado Culminado","mensaje_correcto");
            })
        } catch (error) {
            mostrarMensaje(error.message,"mensaje_error");
        }

        return false;
    });

    $("#btnCancelarRecepcion,#btnCancelarEntregaLogistica,#btnCancelarRecepcionLogistica,#btnCancelarEntregaDestino,#closeInform").click(function (e) { 
        e.preventDefault();
        
        $(this).closest(".modal").fadeOut();

        return false;
    });

    $(".tituloDocumento").on("click","#closeDocument", function (e) {
        e.preventDefault();

        $(this).parent().parent().parent().parent().parent().fadeOut();

        return false;
    });
})

itemsSave = () =>{
    DATA = [];
    let TABLA = $("#tablaDetalles tbody >tr");

    TABLA.each(function(){
        let IDPROD      = $(this).data('idprod'),
            CODIGO      = $(this).find('td').eq(2).text(),
            DESCRIPCION = $(this).find('td').eq(3).text(),
            UNIDAD      = $(this).find('td').eq(4).text(),
            CANTIDAD    = $(this).find('td').eq(5).children().val(),
            SERIE       = $(this).find('td').eq(6).children().val(),
            DESTINO     = $(this).find('td').eq(7).children().val(),
            PARTE       = $(this).find('td').eq(8).children().val(),
            OBSERVAC    = $(this).find('td').eq(9).children().val(),
            ESTADO      = $(this).attr('data-grabado'),
            ITEM        = $(this).find('td').eq(1).text();

        item= {};
        
        if ( ESTADO == 0 ) {
            item['idprod']      = IDPROD;
            item['codigo']      = CODIGO;
            item['descripcion'] = DESCRIPCION;
            item['unidad']      = UNIDAD;
            item['cantidad']    = CANTIDAD;
            item['serie']       = SERIE;
            item['destino']     = DESTINO;
            item['parte']       = PARTE;
            item['observac']    = OBSERVAC;
            item['estado']      = ESTADO;
            item['item']        = ITEM;

            $(this).attr('data-grabado',1);

            DATA.push(item);
        } 
    })

    return DATA;
}

itemsPreview = () =>{
    DATA = [];
    let TABLA = $("#tablaDetalles tbody >tr");

    TABLA.each(function(){
        let IDPROD      = $(this).data('idprod'),
            ITEM        = $(this).find('td').eq(1).text(),
            CODIGO      = $(this).find('td').eq(2).text(),
            DESCRIPCION = $(this).find('td').eq(3).text(),
            UNIDAD      = $(this).find('td').eq(4).text(),
            CANTIDAD    = $(this).find('td').eq(5).text(),
            SERIE       = $(this).find('td').eq(6).text(),
            DESTINO     = $(this).find('td').eq(7).text(),
            PARTE       = $(this).find('td').eq(8).text(),
            OBSERVAC    = $(this).find('td').eq(9).text(),

        item= {};
        
            item['idprod']      = IDPROD;
            item['item']        = ITEM;
            item['codigo']      = CODIGO;
            item['descripcion'] = DESCRIPCION;
            item['unidad']      = UNIDAD;
            item['cantidad']    = CANTIDAD;
            item['serie']       = SERIE;
            item['destino']     = DESTINO;
            item['parte']       = PARTE;
            item['observac']    = OBSERVAC;

            $(this).attr('data-grabado',1);

            DATA.push(item);
    })

    return DATA;
}