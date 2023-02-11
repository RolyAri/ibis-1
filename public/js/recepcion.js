$(function(){
    let accion = "",
        co = 1;
    
    var tipoVista = null;
       
    $("#esperar").fadeOut();

    $("#tablaPrincipal tbody").on("click","tr", function (e) {
        e.preventDefault();

        $.post(RUTA+"recepcion/consultaId", {id:$(this).data("indice")},
            function (data, textStatus, jqXHR) {
                
                let estado = "textoCentro w100por estado " + data.cabecera[0].estado;
                
                $("#codigo_costos").val(data.cabecera[0].ncodpry);
                $("#codigo_area").val(data.cabecera[0].ncodarea);
                $("#codigo_movimiento").val(data.cabecera[0].ncodmov);
                $("#codigo_aprueba").val(data.cabecera[0].id_userAprob);
                $("#codigo_almacen").val(data.cabecera[0].ncodalm1);
                $("#codigo_pedido").val(data.cabecera[0].idref_pedi);
                $("#codigo_orden").val(data.cabecera[0].idref_abas);
                $("#codigo_estado").val(data.cabecera[0].nEstadoDoc);
                $("#codigo_entidad").val(data.cabecera[0].id_centi);
                $("#codigo_ingreso").val(data.cabecera[0].id_regalm);
                $("#almacen").val(data.cabecera[0].almacen);
                $("#fecha").val(data.cabecera[0].ffecdoc);
                $("#numero").val(data.cabecera[0].nnronota);
                $("#proyecto").val(data.cabecera[0].proyecto);
                $("#area").val(data.cabecera[0].area);
                $("#solicita").val(data.cabecera[0].nombres);
                $("#orden").val(data.cabecera[0].orden);
                $("#pedido").val(data.cabecera[0].pedido);
                $("#ruc").val(data.cabecera[0].cnumdoc);
                $("#guia").val(data.cabecera[0].cnumguia);
                $("#razon").val(data.cabecera[0].crazonsoc);
                $("#concepto").val(data.cabecera[0].concepto);
                $("#detalle").val(data.cabecera[0].detalle);
                $("#aprueba").val(data.cabecera[0].cnombres);
                $("#tipo").val(data.cabecera[0].cdescripcion);
                $("#estado").val(data.cabecera[0].estado);
                $("#movimiento").val(1);
                
                let swqaqc = data.cabecera[0].nflgCalidad == 1 ? true: false;
                tipoVista = true;
                accion = "u";
                
                $("#qaqc").prop("checked",swqaqc);
                
                $("#estado")
                    .removeClass()
                    .addClass(estado);
                
                
                $("#tablaDetalles tbody")
                    .empty()
                    .append(data.detalles);
                
                $("#tablaSeries tbody")
                    .empty()
                    .append(data.series);

                $(".listaArchivos")
                    .empty()
                    .append(data.adjuntos);

                $("#items").val($("#tablaDetalles tbody tr").length);

                accion = "u";
                grabado = true;
                $("#proceso").fadeIn();

                console.log(accion);
            },
            "json"
        );

        return false;
    });

    $("#nuevoRegistro").click(function (e) { 
        e.preventDefault();

        $("#estado")
            .removeClass()
            .addClass("textoCentro estado w100por procesando");
        $("#proceso").fadeIn();
        
        accion = 'n';
        tipoVista = null;

        return false;
    });

    $("#closeProcess").click(function (e) { 
        e.preventDefault();

        $("#proceso").fadeOut();

        $.post(RUTA+"recepcion/actualizaNotas",
            function (data, textStatus, jqXHR) {
                $(".itemsTabla table tbody")
                    .empty()
                    .append(data);

                $("#proceso").fadeOut(function(){
                    grabado = false;
                    $("form")[0].reset();
                    $("form")[1].reset();
                    $("#tablaDetalles tbody,.listaArchivos").empty();
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

    $(".lista").on("click",'a', function (e) {
        e.preventDefault();

        let control = $(this).parent().parent().parent();
        let destino = $(this).parent().parent().parent().prev();
        let contenedor_padre = $(this).parent().parent().parent().attr("id");
        let id = "";
        let codigo = $(this).attr("href");
        
        control.slideUp()

        destino.val($(this).text());
        id = destino.attr("id");

        if (contenedor_padre == "listaAlmacen"){
            $("#codigo_almacen").val(codigo);

            $.post(RUTA+"recepcion/numeroIngreso", {id:codigo},
                function (data, textStatus, jqXHR) {
                    $("#numero").val(data.numero);
                    $("#movimiento").val(data.movimiento);
                },
                "json"
            );
        }else if(contenedor_padre == "listaAprueba"){
            $("#codigo_aprueba").val(codigo);
        }else if(contenedor_padre == "listaMovimiento"){
            $("#codigo_movimiento").val(codigo);
        }

        return false;
    });

    $("#importData").click(function (e) { 
        e.preventDefault();
        
        try {
            if (accion == "u") throw "La nota, no puede modificarse";

            $.post(RUTA+"recepcion/ordenes",
                function (data, textStatus, jqXHR) {
                    $("#ordenes tbody")
                        .empty()
                        .append(data);
                    $("#busqueda").fadeIn();
                },
                "text"
            );
        } catch (error) {
            mostrarMensaje(error,"mensaje_error");
        }
        
        
        return false;
    });

    $(".tituloVentana").on("click","a", function (e) {
        e.preventDefault();

        $(this).parent().parent().parent().parent().fadeOut();

        return false;
    });

    $("#ordenes tbody").on("click","tr", function (e) {
        e.preventDefault();

        $("#tipo").val("ORDEN DE COMPRA");
        $("#codigo_movimiento").val(89);

        $.post(RUTA+"recepcion/ordenId",{id:$(this).data("orden")},
            function (data, textStatus, jqXHR) {
                    suma = 0;

                    $("#codigo_costos").val(data.cabecera[0].ncodcos);
                    $("#codigo_area").val(data.cabecera[0].ncodarea);
                    $("#codigo_orden").val(data.cabecera[0].id_regmov);
                    $("#codigo_pedido").val(data.cabecera[0].id_refpedi);
                    $("#codigo_estado").val(data.cabecera[0].nEstadoDoc);
                    $("#codigo_entidad").val(data.cabecera[0].id_centi);
                    $("#codigo_entidad").val(data.cabecera[0].id_centi);
                    $("#proyecto").val(data.cabecera[0].costos);
                    $("#area").val(data.cabecera[0].area);
                    $("#solicita").val(data.cabecera[0].solicita);
                    $("#orden").val(data.cabecera[0].cnumero);
                    $("#pedido").val(data.cabecera[0].pedido);
                    $("#ruc").val(data.cabecera[0].cnumdoc);
                    $("#razon").val(data.cabecera[0].crazonsoc);
                    $("#concepto").val(data.cabecera[0].concepto);
                    $("#detalle").val(data.cabecera[0].detalle);
                    $("#almacen").val(data.cabecera[0].cdesalm);
                    $("#codigo_almacen").val(data.cabecera[0].ncodalm);
                    $("#numero").val(data.numero.numero);
                    $("#movimiento").val(data.numero.movimiento);
                
                    $("#tablaDetalles tbody")
                        .empty()
                        .append(data.detalles);

                    $("#items").val($("#tablaDetalles tbody tr").length);

                $("#busqueda").fadeOut();
            },
            "json"
        );
        

        return false
    });

    $("#btnAceptItems").click(function (e) { 
        e.preventDefault();
        
        if (co != 0) {
            $.post(RUTA+"recepcion/cabeceraIngreso", {id:co},
                function (data, textStatus, jqXHR) {
                    $("#codigo_costos").val()
                    $("#codigo_area").val()
                    $("#codigo_orden").val()
                    $("#codigo_estado").val()
                    $("#codigo_entidad").val()
                    $("#proyecto").val(data.cabecera[0].costos)
                    $("#solicita").val()
                    $("#orden").val()
                    $("#pedido").val()
                    $("#ruc").val()
                    $("#razon").val()
                    $("#concepto").val()
                    $("#detalle").val()
                },
                "json"
            );
        }

        return false
    });

    $("#atachDocs").click(function (e) { 
        e.preventDefault();
        
        $("#archivos").fadeIn();

        return false;
    });

    $("#openArch").click(function (e) { 
        e.preventDefault();
 
        if (accion == "n")
            $("#uploadAtach").trigger("click");
 
        return false;
    });

    $("#uploadAtach").on("change", function (e) {
        e.preventDefault();
 
        let fp = $(this);
        let lg = fp[0].files.length;
        let items = fp[0].files;
        let fragment = "";
 
        if (lg > 0) {
             for (var i = 0; i < lg; i++) {
                 var fileName = items[i].name; // get file name
 
                 // append li to UL tag to display File info
                 fragment +=`<li><p><i class="far fa-file"></i></p>
                                 <p>${fileName}</p></li>`;
             }
 
             $(".listaArchivos").append(fragment);
         }
 
        return false;
    });
 
    $("#btnConfirmAtach").on("click", function (e) {
         e.preventDefault();
 
         $("#archivos").fadeOut();
 
         return false;
    });
 
    $("#btnCancelAtach").on("click", function (e) {
         e.preventDefault();
 
         $("#archivos").fadeOut();
         $("#fileAtachs")[0].reset();
         $(".listaArchivos").empty();
 
    });

    $("#saveOrden").click(function (e) { 
        e.preventDefault();
        
        let result = {},
            solicitada = 0,
            recibida = 0,
            cerrarOrden = false;

        $.each($("#formProceso").serializeArray(),function(){
            result[this.name] = this.value;
        });

        try {
            if (result['codigo_almacen'] == '') throw "Elija el Almacen";
            if (result['codigo_costos'] == '') throw "Elija Centro de Costos";
            if (result['codigo_aprueba'] == '') throw "Elija la persona que aprueba";
            if (result['codigo_movimiento'] == '') throw "Elija tipo de movimiento";
            if (result['guia'] == '') throw "Escriba el número de guia";

            $("#tablaDetalles tbody  > tr").each(function () {
                solicitada += parseFloat($(this).find('td').eq(5).text() || 0,10);
                recibida += parseFloat($(this).find('td').eq(6).children().val() || 0,10)
            })

            cerrarOrden = solicitada == recibida ? 62 : 60;

            if (accion == "n") {
                $.post(RUTA+"recepcion/nuevoIngreso", {cabecera:result,
                    detalles:JSON.stringify(detalles()),
                    series:JSON.stringify(series()),
                    cerrar:cerrarOrden},
                        function (data, textStatus, jqXHR) {
                            $("#codigo_ingreso").val(data.indice);
                            $("#proceso").fadeOut();
                            mostrarMensaje("Nota Grabada","mensaje_correcto");
                            $("#tablaPrincipal tbody")
                                .empty()
                                .append(data.listado);
                        },
                        "json"
                    );
            }else{
                console.log('Aca vamos a actualizar');
            }

            

        } catch (error) {
            mostrarMensaje(error,'mensaje_error');
        }

        return false;
    });

    $("#closeDocument").click(function (e) { 
        e.preventDefault();
        
        let result = {};

        $.each($("#formProceso").serializeArray(),function(){
            result[this.name] = this.value;
        });

        try {
            if (result['codigo_ingreso'] == '') throw "Debe grabar el documento";
            if (result['codigo_costos'] == '') throw "Elija Centro de Costos";
            if (result['codigo_aprueba'] == '') throw "Elija la persona que aprueba";
            if (result['codigo_movimiento'] == '') throw "Elija tipo de movimiento";
            if (result['guia'] == '') throw "Escriba el número de guia"

            $.post(RUTA+"recepcion/cierraIngreso", {cabecera:result,
                                                    detalles:JSON.stringify(detalles())},
                function (data, textStatus, jqXHR) {
                    console.log(data);
                },
                "text"
            );
        } catch (error) {
            mostrarMensaje(error,'mensaje_error');
        }

        return false;
    });

     //añadir registro de adjuntos
    $("#fileAtachs").on("submit", function (e) {
        e.preventDefault()

        let aInfo = new FormData( this );
            aInfo.append("nroIngreso",$("#codigo_ingreso").val());

        $.ajax({
            // URL to move the uploaded image file to server
            url: RUTA + 'recepcion/adjuntos',
            // Request type
            type: "POST", 
            // To send the full form data
            data: aInfo,
            contentType:false,      
            processData:false,
            dataType:"json",    
            // UI response after the file upload  
            success: function(data)
            {   
                
            }
        });
        
        return false;
    });

    $("#tablaDetalles tbody").on("click","a", function (e) {
        e.preventDefault();

        if ($(this).data("accion") == "setSerial") {
            let filas = parseInt($(this).parent().parent().find("td").eq(6).children().val()),
            orden = $(this).parent().parent().data('detorden'),
            producto = $(this).parent().parent().data('idprod'),
            almacen = $("#codigo_almacen").val(),
            nombre = $(this).parent().parent().find("td").eq(3).text();

            row = `<tr data-orden="${orden}" data-producto="${producto}" data-almacen="${almacen}">
                        <td>${nombre}</td>
                        <td><input type="text"></td>
                    </tr>`

            if (accion == 'n') {
                $("#tablaSeries tbody").empty();

                for (let index = 0; index < filas; index++) {
                    $("#tablaSeries").append(row);        
                }
            }

            $("#series").fadeIn();
        }else {
            $(this).parent().parent().remove();
        }
        

        return false;
    });

    $("#btnCancelSeries").click(function (e) { 
        e.preventDefault();

        $("#tablaSeries tbody").empty();
        $("#series").fadeOut();
        
        return false;
    });

    $("#btnConfirmSeries").click(function (e) { 
        e.preventDefault();

        $("#series").fadeOut();
        
        return false;
    });

    $("#preview").click(function (e) { 
        e.preventDefault();
        
        let result = {};

        $.each($("#formProceso").serializeArray(),function(){
            result[this.name] = this.value;
        });

        try {
            if (tipoVista == null) throw "Debe grabar el documento...";

            $.post(RUTA+"recepcion/documentopdf",{cabecera:result,
                                                    detalles:JSON.stringify(detalles(tipoVista)),
                                                    condicion:0},
                function (data, textStatus, jqXHR) {
                    $(".ventanaVistaPrevia iframe")
                    .attr("src","")
                    .attr("src",data);

                    $("#vistaprevia").fadeIn();
                },
                "text"
            );
        } catch (error) {
            mostrarMensaje(error,'mensaje_error');
        }

        return preview;
    });

    $("#closePreview").click(function (e) { 
        e.preventDefault();

        $(".ventanaVistaPrevia iframe").attr("src","");
        $("#vistaprevia").fadeOut();

        return false;
    });

    $("#sendEntOrden").click(function(e){
        e.preventDefault();

       let result = {};

        $.each($("#formProceso").serializeArray(),function(){
            result[this.name] = this.value;
        });

        try {
            if (result['codigo_almacen'] == '') throw "Elija el Almacen";
            if (result['codigo_costos'] == '') throw "Elija Centro de Costos";
            if (result['codigo_aprueba'] == '') throw "Elija la persona que aprueba";
            if (result['codigo_movimiento'] == '') throw "Elija tipo de movimiento";
            if (result['guia'] == '') throw "Escriba el número de guia"

            $.post(RUTA+"recepcion/envioProveedor",{cabecera:result,
                                                    detalles:JSON.stringify(detalles()),
                                                    condicion:1},
                function (data, textStatus, jqXHR) {
                   
                },
                "text"
            );
        } catch (error) {
            mostrarMensaje(error,'mensaje_error');
        }

        return false;
    });

    $("#btnConsulta").on('click', function(e) {
        e.preventDefault();

        let str = $("#formConsulta").serialize();

        $.post(RUTA+"recepcion/filtroRecepcion", str,
            function (data, text, requestXHR) {
                $("#tablaPrincipal tbody")
                    .empty()
                    .append(data);
            },
            "text"
        );
        
        return false
    });

    $("#itemCostos").change(function (e) { 
        e.preventDefault(e);

        $.post(RUTA+"recepcion/ordenesPorCosto", {costo:$(this).val()},
            function (data, textStatus, jqXHR) {
                $("#ordenes tbody")
                    .empty()
                    .append(data);
            },
            "text"
        );

        return false        
    });

    $("#ordenSearch").keyup(function (e) { 
        if(e.which == 13) {
            $("#esperar").fadeIn();
            
            $.post(RUTA+"recepcion/filtraOrden", {id:$(this).val()},
                function (data, textStatus, jqXHR) {
                    $("#ordenes tbody")
                        .empty()
                        .append(data);
                    $("#esperar").fadeOut();
                },
                "text"
            );
        }
    });

    $("#btnAceptarPregunta").click(function (e) { 
        e.preventDefault();

        $(this).parent().parent().remove();
        
        $("#pregunta").fadeOut();

        return false;
    });

    $("#btnCancelarPregunta").click(function (e) { 
        e.preventDefault();
        
        $("#pregunta").fadeOut();

        return false;
    });

    $("#saveOrden").click(function (e) { 
        e.preventDefault();
        
        let result = {},
            solicitada = 0,
            recibida = 0,
            cerrarOrden = false;

        $.each($("#formProceso").serializeArray(),function(){
            result[this.name] = this.value;
        });

        try {
            if (result['codigo_almacen'] == '') throw "Elija el Almacen";
            if (result['codigo_costos'] == '') throw "Elija Centro de Costos";
            if (result['codigo_aprueba'] == '') throw "Elija la persona que aprueba";
            if (result['codigo_movimiento'] == '') throw "Elija tipo de movimiento";
            if (result['guia'] == '') throw "Escriba el número de guia";

            $("#tablaDetalles tbody  > tr").each(function () {
                solicitada += parseFloat($(this).find('td').eq(5).text() || 0,10);
                recibida += parseFloat($(this).find('td').eq(6).children().val() || 0,10)
            })

            cerrarOrden = solicitada == recibida ? 62 : 60;

            if (accion == "n") {
                $.post(RUTA+"recepcion/nuevoIngreso", {cabecera:result,
                    detalles:JSON.stringify(detalles()),
                    series:JSON.stringify(series()),
                    cerrar:cerrarOrden},
                        function (data, textStatus, jqXHR) {
                            $("#codigo_ingreso").val(data.indice);
                            $("#proceso").fadeOut();
                            mostrarMensaje("Nota Grabada","mensaje_correcto");
                            $("#tablaPrincipal tbody")
                                .empty()
                                .append(data.listado);
                        },
                        "json"
                    );
            }

            

        } catch (error) {
            mostrarMensaje(error,'mensaje_error');
        }

        return false;
    });

    $("#btnPendientes, #btnTotales").click(function (e) { 
        e.preventDefault();

        tipoVista = e.target.id == "btnTotales"?true:false;

        let result = {};

        $.each($("#formProceso").serializeArray(),function(){
            result[this.name] = this.value;
        });

        try {
            //if(accion != "n") throw "Documento registrado";
            if (result['codigo_almacen'] == '') throw "Elija el Almacen";
            if (result['codigo_aprueba'] == '') throw "Elija la persona que aprueba";
            if (result['guia'] == '') throw "Escriba el número de guia";

            if (accion == "n") {
                $.post(RUTA+"recepcion/nuevoIngreso", {cabecera:result,
                    detalles:JSON.stringify(detalles(tipoVista)),
                    series:JSON.stringify(series())},
                        function (data, textStatus, jqXHR) {
                            $("#codigo_ingreso").val(data.indice);
                            mostrarMensaje("Nota Grabada","mensaje_correcto");
                            $("#tablaPrincipal tbody")
                                .empty()
                                .append(data.listado);
                            accion = "u";
                        },
                        "json"
                    );
            }else{
                console.log("Aca hay que ver para modificar");
            }

        } catch (error) {
            mostrarMensaje(error,'mensaje_error');
        }
        
        return false;
    });
})

detalles = (flag) =>{
    DETALLES = [];

    let TABLA = $("#tablaDetalles tbody >tr");
    
    TABLA.each(function(){
        let ITEM        = $(this).find('td').eq(1).text(),
            IDDETORDEN  = $(this).data("detorden"),
            IDDETPED    = $(this).data("iddetped"),
            IDPROD      = $(this).data("idprod"),
            PEDIDO      = $("#codigo_pedido").val(),
            ORDEN       = $("#codigo_orden").val(),
            ALMACEN     = $("#codigo_almacen").val(),
            CANTSOL     = parseFloat($(this).find('td').eq(6).text()),
            CANTREC     = $(this).find('td').eq(7).children().val(),// cantidad
            CANTSAL     = null,
            OBSER       = $(this).find('td').eq(8).children().val(),
            VENCE       = null,
            CODIGO      = $(this).find('td').eq(3).text(),//codigo
            DESCRIPCION = $(this).find('td').eq(4).text(),//descripcion
            UNIDAD      = $(this).find('td').eq(5).text(),//unidad
            NESTADO     = null,
            CESTADO     = null //$(this).find("select[name='estado'] option:selected").text(),
            UBICACION   = "",
            CHECKED     = $(this).find('td').eq(1).children().prop("checked");//codigo

    
        item = {};

        if ( CHECKED == flag)  {
            if (CANTREC > 0) {
                item['item']        = ITEM;
                item['iddetorden']  = IDDETORDEN;
                item['iddetped']    = IDDETPED;
                item['idprod']      = IDPROD;
                item['pedido']      = ORDEN;
                item['orden']       = PEDIDO;
                item['almacen']     = ALMACEN;
                item['cantrec']     = CANTREC;
                item['cantsol']     = CANTSOL;
                item['cantsal']     = CANTSAL;
                item['obser']       = OBSER;
                item['vence']       = VENCE;

                item['codigo']     = CODIGO;
                item['descripcion']= DESCRIPCION;
                item['unidad']     = UNIDAD;
                item['nestado']    = NESTADO;
                item['cestado']    = CESTADO;
                item['ubicacion']  = UBICACION;

                DETALLES.push(item);
            }
        }  
    })

    return DETALLES; 
}

series = () => {
    SERIES = [];

    let TABLA = $("#tablaSeries tbody >tr");

    TABLA.each(function(){

        let ORDEN   = $(this).data('orden'),
            ALMACEN = $("#codigo_almacen").val(),
            PRODUCTO = $(this).data('producto'),
            SERIE  = $(this).find('td').eq(1).children().val();
    
        item = {};

        if (SERIE != ""){
            item['orden'] = ORDEN;
            item['almacen'] = ALMACEN;
            item['producto'] = PRODUCTO;
            item['serie']= SERIE;
        }
        

        SERIES.push(item);
    })

    return SERIES;
}