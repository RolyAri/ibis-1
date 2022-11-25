$(function(){
    let accion   = "",
        grabado  = false,
        entidad  = "",
        pedido   = 0,
        proforma = "",
        moneda   = "",
        ingresos = 0,
        swcoment = false,
        autorizado = 0,
        costos = "",
        fp = 0;
    
    $("#esperar").fadeOut();

    $("#tablaPrincipal tbody").on("click","tr", function (e) {
        e.preventDefault();

        autorizado = $(this).data('finanzas')+$(this).data('logistica')+$(this).data('operaciones');

        $.post(RUTA+"orden/ordenId", {id:$(this).data("indice")},
            function (data, textStatus, jqXHR) {

                let estado = "textoCentro " + data.cabecera[0].estado;

                $("#codigo_costos").val(data.cabecera[0].ncodcos);
                $("#codigo_area").val(data.cabecera[0].ncodarea);
                $("#codigo_transporte").val(data.cabecera[0].ctiptransp);
                $("#codigo_tipo").val(data.cabecera[0].ntipmov);
                $("#codigo_almacen").val(data.cabecera[0].ncodalm);
                $("#codigo_pedido").val(data.cabecera[0].id_refpedi);
                $("#codigo_orden").val(data.cabecera[0].id_regmov);
                $("#codigo_estado").val(data.cabecera[0].nEstadoDoc);
                $("#codigo_entidad").val(data.cabecera[0].id_centi);
                $("#codigo_moneda").val(data.cabecera[0].ncodmon);
                $("#codigo_pago").val(data.cabecera[0].ncodpago);
                $("#ruc_entidad").val(data.cabecera[0].cnumdoc);
                $("#direccion_entidad").val(data.cabecera[0].cviadireccion);
                $("#direccion_almacen").val(data.cabecera[0].direccion);
                $("#telefono_entidad").val(data.cabecera[0].ctelefono1);
                $("#correo_entidad").val(data.cabecera[0].mail_entidad);
                $("#codigo_verificacion").val(data.cabecera[0].cverificacion);
                $("#telefono_contacto").val(data.cabecera[0].ctelefono1);
                $("#correo_contacto").val(data.cabecera[0].cemail);
                $("#proforma").val(data.cabecera[0].cnumcot);
                $("#retencion").val(data.cabecera[0].nagenret);
                $("#nivel_atencion").val(data.cabecera[0].nivelAten);
                $("#numero").val(data.cabecera[0].cnumero);
                $("#emision").val(data.cabecera[0].ffechadoc);
                $("#costos").val(data.cabecera[0].costos);
                $("#area").val(data.cabecera[0].area);
                $("#concepto").val(data.cabecera[0].concepto);
                $("#detalle").val(data.cabecera[0].detalle);
                $("#moneda").val(data.cabecera[0].nombre_moneda);
                $("#total").val(data.cabecera[0].ctotal);
                $("#tipo").val(data.cabecera[0].tipo);
                $("#fentrega").val(data.cabecera[0].ffechaent);
                $("#cpago").val(data.cabecera[0].pagos);
                $("#estado").val(data.cabecera[0].descripcion_estado);
                $("#entidad").val(data.cabecera[0].crazonsoc);
                $("#atencion").val(data.cabecera[0].cnombres);
                $("#transporte").val(data.cabecera[0].transporte);
                $("#lentrega").val(data.cabecera[0].cdesalm);
                $("#total_numero").val(data.cabecera[0].ntotal);
                $("#ncotiz").val(data.cabecera[0].cnumcot);
                $("#tcambio").val(data.cabecera[0].ntcambio);
                $("#user_modifica").val(data.cabecera[0].userModifica);
                $("#nro_pedido").val(data.cabecera[0].nrodoc);

               if (data.cabecera[0].nigv != 0) {
                    $("#si").prop("checked", true);
               }else {
                    $("#no").prop("checked", true);
               };


                $("#estado")
                    .removeClass()
                    .addClass(estado);

                $("#tablaDetalles tbody")
                    .empty()
                    .append(data.detalles);

                $("#tablaComentarios tbody")
                    .empty()
                    .append(data.comentarios);

                $("#sw").val(1);

                if (data.bocadillo != 0) {
                    $(".button__comment")
                        .text(data.bocadillo)
                        .show();
                }else{
                    $(".button__comment").hide();
                }

            },
            "json"
        );
    
        accion = "u";
        grabado = true;
        $("#proceso").fadeIn();
    
        return false;
    });

    $("#nuevoRegistro").click(function (e) { 
        e.preventDefault();

        $("#estado")
            .removeClass()
            .addClass("textoCentro estado procesando");
        $("form")[0].reset();
        $("#proceso").fadeIn();
        $("#sw").val(0);
        $("#codigo_estado").val(0);
        $(".button__comment").hide();

        accion = 'n';
        grabado = false;

        return false;
    });

    $(".mostrarLista").focus(function (e) { 
        e.preventDefault();

        if ($("#codigo_estado").val() == 59)
            return false;

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
            $("#direccion_almacen").val($(this).data('direccion'));
        }else if (contenedor_padre == "listaTransporte"){
            $("#codigo_transporte").val(codigo);
        }else if (contenedor_padre == "listaMoneda"){
            $("#codigo_moneda").val(codigo);
        }else if (contenedor_padre == "listaPago"){
            $("#codigo_pago").val(codigo);
        }else if (contenedor_padre == "listaEntidad"){
            $("#codigo_entidad").val(codigo);
            $("#ruc_entidad").val($(this).data("ruc"));
            $("#direccion_entidad").val($(this).data("direccion"));

            $.post(RUTA+"orden/detallesEntidad",{"codigo": $(this).data("ruc")},
                function (data, textStatus, jqXHR) {
                    $("#atencion").val(data[0].contacto);
                    $("#direccion_entidad").val(data[0].cviadireccion);
                    $("#telefono_entidad").val(data[0].ctelefono);
                    $("#correo_entidad").val(data[0].correo_entidad);
                },
                "json"
            );
        }

        return false;
    });

    $("#closeProcess").click(function (e) { 
        e.preventDefault();

        $.post(RUTA+"orden/actualizaListado",
            function (data, textStatus, jqXHR) {
                $(".itemsTabla table tbody")
                    .empty()
                    .append(data);

                $("#proceso").fadeOut(function(){
                    grabado = false;
                    $("form")[0].reset();
                    $("form")[1].reset();
                    $("#tablaDetalles tbody").empty();
                });
            },
            "text"
        );

        return false;
    });

    $("#loadRequest").click(function (e) { 
        e.preventDefault();

        if ($("#codigo_estado").val() == 59){
            mostrarMensaje("La orden no se puede modificar","mensaje_error");
            return false;
        }
            
        $("#esperar").fadeIn();

        $.post(RUTA+"orden/pedidos",
            function (data, textStatus, jqXHR) {
                $("#esperar").fadeOut(function(e){
                    $("#busqueda").fadeIn();
                    $("#pedidos tbody")
                        .empty()
                        .append(data);
                });
            },
            "text"
        );
        
        return false;
    });

    $(".tituloVentana").on("click","a", function (e) {
        e.preventDefault();

        $(this).parent().parent().parent().parent().fadeOut();

        return false;
    });

    $("#pedidos tbody").on("click","tr", function (e) {
        e.preventDefault();

        if (costos == "" ) {
            costos = $(this).data("costos");
            pedido = $(this).data("pedido");
        }

        try {
            if ( costos  != $(this).data("costos")) throw "El item esta otro centro de costos";
            //if ( pedido  != $(this).data("pedido")) throw "El item esta en  un pedido diferente";

            let nFilas      = $.strPad($("#tablaDetalles tr").length,3),
                codigo      = $(this).children('td:eq(5)').text(),
                request     = $(this).data("pedido"),
                nroreq      = $(this).children('td:eq(0)').text(),
                descrip     = $(this).children('td:eq(6)').text(),
                cantidad    = $(this).data("cantidad"),
                unidad      = $(this).data("unidad"),
                total       = 0,
                cod_prod    = $(this).data("codprod"),
                id_item     = $(this).data("iditem"),
                grabado     = 0;

            $("#nro_pedido").val(nroreq);

            if (!checkExistTable($("#tablaDetalles tbody tr"),codigo,5)){
                let item = $(this);
                let row = `<tr data-grabado ="${grabado}" 
                                data-total  ="${total}" 
                                data-codprod="${cod_prod}" 
                                data-itPed  ="${id_item}"
                                data-cant   ="${cantidad}"
                                data-refpedi="${request}">
                            <td class="textoCentro"><a href="#"><i class="fas fa-ban"></i></a></td>
                            <td class="textoCentro">${nFilas}</td>
                            <td class="textoCentro">${codigo}</td>
                            <td class="pl20px">${descrip}</td>
                            <td class="textoCentro">${unidad}</td>
                            <td class="textoDerecha pr5px">
                                <input type="number" 
                                    step="any" 
                                    placeholder="0.00" 
                                    onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"
                                    onclick="this.select()"
                                    value=${cantidad}>
                            </td>
                            <td class="textoDerecha pr5px precio">
                                <input type="number"
                                    step="any" 
                                    placeholder="0.00" 
                                    onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"
                                    onclick="this.select()">
                            </td>
                            <<td class="textoDerecha pr5px"></td>
                            <td></td>
                            <td class="textoCentro">${nroreq}</td>
                            <td class="pl20px"><textarea></textarea></td>
                        </tr>`;

                $.post(RUTA+"orden/marcaItem", {id:$(this).data("iditem"),"estado":1},
                    function (data, text, requestXHR) {
                        item.remove();
                        $("#tablaDetalles tbody").append(row);
                    },                        
                    "text"
                );
                
            }else{
                mostrarMensaje("Item duplicado","mensaje_error");
            }
        } catch (error) {
            mostrarMensaje(error,'mensaje_error');
        }

        return false;
    });

    $("#btnAceptItems").click(function (e) { 
        e.preventDefault();

        try {
            if ($("#tablaDetalles tbody").length == 0) throw "No se selecciono ningún item";
            
            $.post(RUTA+"orden/datosPedido", {pep:pedido,prof:proforma,ent:entidad},
                function (data, textStatus, jqXHR) {

                    $("#codigo_pedido").val(data.pedido[0].idreg);
                    $("#codigo_costos").val(data.pedido[0].idcostos);
                    $("#codigo_area").val(data.pedido[0].idarea);
                    $("#codigo_transporte").val(data.pedido[0].idtrans);
                    $("#codigo_tipo").val(data.pedido[0].idtipomov);
                    $("#costos").val(data.pedido[0].proyecto);
                    $("#area").val(data.pedido[0].area);
                    $("#concepto").val(data.pedido[0].concepto);
                    $("#detalle").val(data.pedido[0].detalle);
                    $("#tipo").val(data.pedido[0].tipo);
                    $("#pedidopdf").val(data.pedido[0].docPdfAprob);
                    $("#nivel_atencion").val(data.pedido[0].nivelAten);
                    $("#tcambio").val(data.cambio);
                    
                    $("#numero").val(data.orden);
                    $("#codigo_verificacion").val(data.pedido[0].verificacion);
                    
                    $("#busqueda").fadeOut(); 
                },
                "json"
            );
        } catch (error) {
            mostrarMensaje(error,"mensaje_error");
        };

        return false;
    });

    $("#preview").click(function (e) { 
        e.preventDefault();
        
        try {
            let result = {};
    
            $.each($("#formProceso").serializeArray(),function(){
                result[this.name] = this.value;
            })
    
            if (result['numero'] == "") throw "No tiene numero de orden";
            if (result['fentrega'] == "") throw "Elija la fecha de entrega";
            if (result['codigo_transporte'] == "") throw "Elija la forma de transporte";
            if (result['codigo_almacen'] == "") throw "Indique el lugar de entrega";

            $.post(RUTA+"orden/vistaPreliminar", {cabecera:result,condicion:0,detalles:JSON.stringify(detalles())},
                function (data, textStatus, jqXHR) {
                    $(".ventanaVistaPrevia iframe")
                        .attr("src","")
                        .attr("src","public/documentos/ordenes/vistaprevia/"+data);
                    
                    $("#vista_previa").val(data);    
                    $("#vistaprevia").fadeIn();
                },
                "text"
            );
            
        } catch (error) {
            mostrarMensaje(error,'mensaje_error');
        }

        return false;
    });

    $("#closePreview").click(function (e) { 
        e.preventDefault();

        $(".ventanaVistaPrevia iframe").attr("src","");
        $("#vistaprevia").fadeOut();

        return false;
    });

    $("#addMessage").click(function (e) { 
        e.preventDefault();
        

        let date = fechaActual(),
            usuario = $("#name_user").val();
        
        let row = `<tr data-grabar="0">
                        <td >${usuario}</td>
                        <td><input type="date" value="${date}" readonly></td>
                        <td><input type="text" placeholder="Escriba su comentario"></td>
                        <td class="con_borde centro"><a href="#"><i class="far fa-trash-alt"></i></a></td>
                    </tr>`;


        if (ingresos == 0) {
            if ($("#tablaComentarios tbody tr").length <= 0)
                $("#tablaComentarios tbody").append(row);
            else{
                $('#tablaComentarios > tbody tr:eq(0)').before(row);
            }

            ingresos++;
        }
        
        $("#comentarios").fadeIn();

        return false;
    });

    $("#btnAceptarDialogo").click(function (e) { 
        e.preventDefault();
        
        $("#comentarios").fadeOut();

        if ($("#codigo_estado").val() == 59 && !swcoment) {
            $.post(RUTA+"orden/comentarios", {codigo:$("#codigo_orden").val(),comentarios:JSON.stringify(comentarios())},
                function (data, textStatus, jqXHR) {
                    swcoment = true;
                },
                "text"
            );
        }

        return false
    });

    $("#saveOrden").click(function (e) { 
        e.preventDefault();

        let result = {};
    
        $.each($("#formProceso").serializeArray(),function(){
            result[this.name] = this.value;
        })

        formData = new FormData();
        formData.append("cabecera",JSON.stringify(result));
        $.each(jQuery('#uploadAtach')[0].files, function(i, file) {
            formData.append('file-'+i, file);
        });
        formData.append("detalles",JSON.stringify(detalles()));
        formData.append("comentarios",JSON.stringify(comentarios()));

        try {
            if ($("#codigo_estado").val() == 59) throw "La orden esta en firmas.";
            if (result['numero'] == "") throw "No tiene numero de orden";
            if (result['fentrega'] == "") throw "Elija la fecha de entrega";
            if (result['codigo_moneda'] == "") throw "Elija la moneda";
            if (result['codigo_pago'] == "") throw "Elija el tipo de pago";
            if (result['correo_entidad'] == "") throw "Elija el proveedor";
            if (result['codigo_almacen'] == "") throw "Indique el lugar de entrega";
            if (result['total'] == "") throw "No se registro el total de la orden";
            if ($("#tablaDetalles tbody tr") .length <= 0) throw "No tiene items cargados"

            grabado = true;
            
            if ( accion == 'n' ){
                $.ajax({
                    // URL to move the uploaded image file to server
                    url: RUTA + 'orden/nuevoRegistro',
                    // Request type
                    type: "POST", 
                    // To send the full form data
                    data: formData,
                    contentType:false,      
                    processData:false,
                    dataType:"json",    
                    // UI response after the file upload
                    beforeSend: function () {
                        $("#esperar").fadeIn();
                    },  
                    success: function(response)
                    {   
                        mostrarMensaje(response.mensaje,response.clase);
                        $("#proceso, #sendMail,#esperar").fadeOut();
                        $("#tablaPrincipal tbody")
                            .empty()
                            .append(response.pedidos);
                    }
                });
            }else {
                $.post(RUTA+"orden/modificaRegistro", {cabecera:result,
                                                        detalles:JSON.stringify(detalles()),
                                                        comentarios:JSON.stringify(comentarios())},
                    function (data, textStatus, jqXHR) {
                        mostrarMensaje(data.mensaje,data.clase);
                    },
                    "json"
                );
            }

        } catch (error) {
            mostrarMensaje(error,'mensaje_error'); 
        }

        

        return false;
    });

    $("#requestAprob").click(function (e) { 
        e.preventDefault();

        try {
            if ($("#codigo_estado").val() == 59) throw "La orden esta en firmas.";
            if (!grabado) throw "Por favor grabar la orden";

            $.post(RUTA+"orden/buscaRol", {rol:$(this).data("rol")},
                function (data, textStatus, jqXHR) {
                    $("#listaCorreos tbody").empty().append(data);
                    $("#sendMail").fadeIn();
                },
                "text"
            );
        } catch (error) {
            mostrarMensaje(error,'mensaje_error'); 
        }
        
        return false;
    });

    $("#closeMail").click(function (e) { 
        e.preventDefault();

        $("form")[2].reset();
        $(".atachs").empty();
        $(".messaje div").empty();
        $("#sendMail").fadeOut();

        return false;
    });

    $("#btnConfirmSend").click(function (e) { 
        e.preventDefault();
        
        try {
            if ($("#subject").val() =="") throw "Escriba el asunto";
            if ($("messaje div").html() =="") throw "Escriba el asunto";

            let result = {};
    
            $.each($("#formProceso").serializeArray(),function(){
                result[this.name] = this.value;
            })

            $.post(RUTA+"orden/correo", {cabecera:result,
                                        detalles:JSON.stringify(detalles()),
                                        correos:JSON.stringify(mailsList()),
                                        asunto:$("#subject").val(),
                                        mensaje:$(".messaje div").html()},
                                                
            function (data, textStatus, jqXHR) {
                mostrarMensaje(data.mensaje,data.clase);
                $("#sendMail").fadeOut();
            },
            "json"
        );
        } catch (error) {
            mostrarMensaje(error,'mensaje_error');
        }

        return false;
    });

    $("#sendEntOrden").click(function (e) { 
        e.preventDefault();
        
        try {
            if (autorizado != 3) throw "La orden no ha sido autorizada";
            
            let result = {};
    
            $.each($("#formProceso").serializeArray(),function(){
                result[this.name] = this.value;
            })

            //$("#sendMail").fadeIn();

            $.post(RUTA+"orden/envioOrden", {cabecera:result,
                                            detalles:JSON.stringify(detalles())},
                function (data, textStatus, jqXHR) {
                    mostrarMensaje(data.mensaje,data.clase);
                    $("#tablaPrincipal tbody")
                        .empty()
                        .append(data.ordenes);
                    $("#esperar").fadeOut();
                },
                "json"
            );

        } catch (error) {
            mostrarMensaje(error,'mensaje_error');
        }

        

        return false;
    });

    $("#tablaDetalles tbody").on('keypress','input', function (e) {
        if (e.which == 13) {
            try {
                let cant = $(this).parent().parent().find("td").eq(5).children().val();
                let precio = $(this).parent().parent().find("td").eq(6).children().val();
                let suma = 0;
                
                let total = precio*cant;

                $(this).parent().parent().find("td").eq(7).text(total.toFixed(2));

                $("#tablaDetalles tbody  > tr").each(function () {
                    suma += parseFloat($(this).find('td').eq(7).text()||0,10);
                })

                if(suma > 0) {
                    $("#total").val(numberWithCommas(suma.toFixed(2)));
                    $("#total_numero").val(suma.toFixed(2));

                }

            } catch (error) {
                
            }
        }
    });

    $("#tablaDetalles tbody").on('click',"a", function(e) {
        e.preventDefault();

        if ($("#codigo_estado").val() == 59){
            mostrarMensaje("La orden no se puede modificar","mensaje_error");
            return false;
        }

        let item    = $(this).parent().parent().remove();
        let suma = 0;

        $.post(RUTA+"orden/marcaItem", {id:$(this).parent().parent().data("itped"),
                                        io:$(this).parent().parent().data("itord"),
                                        "estado":0},
            function (data, text, requestXHR) {
                item.remove();
                fillTables($("#tablaDetalles tbody > tr"),1);
            },                        
            "text"
        );

        $("#tablaDetalles tbody  > tr").each(function () {
            suma += parseFloat($(this).find('td').eq(7).text()||0,10);
        })

        if(suma > 0) {
            $("#total").val(numberWithCommas(suma.toFixed(2)));
            $("#total_numero").val(suma.toFixed(2));

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

    $("#uploadCotiz").click(function(e){
        e.preventDefault();

        $("#archivos").fadeIn();

        return false;
    });

    $("#openArch").click(function (e) { 
        e.preventDefault();
 
        $("#uploadAtach").trigger("click");
 
        return false;
    });

    $("#uploadAtach").on("change", function (e) {
        e.preventDefault();
 
        fp = $(this);
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

    $("#btnConsulta").on('click', function(e) {
        e.preventDefault();

        let str = $("#formConsulta").serialize();

        $.post(RUTA+"orden/filtroOrden", str,
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

        $.post(RUTA+"orden/ItemsPorCostos", {costo:$(this).val()},
            function (data, textStatus, jqXHR) {
                $("#pedidos tbody")
                    .empty()
                    .append(data);
            },
            "text"
        );

        return false        
    });
})


detalles = () => {
    DATA = [];
    let TABLA = $("#tablaDetalles tbody >tr");

    TABLA.each(function(){
        let ITEM        = $(this).find('td').eq(1).text(),
            CODIGO      = $(this).find('td').eq(2).text(),
            DESCRIPCION = $(this).find('td').eq(3).text(),
            UNIDAD      = $(this).find('td').eq(4).text(),
            CANTIDAD    = $(this).find('td').eq(5).children().val(),
            PRECIO      = $(this).find('td').eq(6).children().val(),
            IGV         = 0,
            TOTAL       = $(this).find('td').eq(7).text(),
            NROPARTE    = $(this).find('td').eq(8).text(),
            PEDIDO      = $(this).find('td').eq(9).text(),
            CODPROD     = $(this).data('codprod'),
            MONEDA      = $("#codigo_moneda").val(),
            ITEMPEDIDO  = $(this).data('itped'),
            GRABAR      = $(this).data('grabado'),
            CANTPED     = $(this).data('cant'),
            REFPEDI      = $(this).data('refpedi'),
            DETALLES    = $(this).find('td').eq(10).children().val();

        item= {};
        
        //if (GRABAR == 0) {
            item['item']        = ITEM;
            item['codigo']      = CODIGO;
            item['descripcion'] = DESCRIPCION;
            item['unidad']      = UNIDAD;
            item['cantidad']    = CANTIDAD;
            item['precio']      = PRECIO;
            item['igv']         = IGV;
            item['total']       = TOTAL;
            item['nroparte']    = NROPARTE;
            item['pedido']      = PEDIDO;
            item['codprod']     = CODPROD;
            item['moneda']      = MONEDA;
            item['itped']       = ITEMPEDIDO;
            item['grabado']     = GRABAR;
            item['cantped']     = CANTPED;
            item['refpedi']     = REFPEDI;
            item['detalles']    = DETALLES;

            DATA.push(item);
        //}
    });

    return DATA;
}

comentarios = () => {
    COMENTARIOS = [];

    let TABLA = $("#tablaComentarios tbody >tr");

    TABLA.each(function (){
        let USUARIO     = $("#id_user").val(),
            FECHA       = $(this).find('td').eq(1).children().val(),
            COMENTARIO  = $(this).find('td').eq(2).children().val(),
            GRABAR      = $(this).data("grabar");

        item = {};

        if ( GRABAR == "0" && COMENTARIO !=""){
            item['usuario']     = USUARIO;
            item['fecha']       = FECHA;
            item['comentario']  = COMENTARIO;
            item['grabar']      = GRABAR;

            COMENTARIOS.push(item);
        }

        
    });

    return COMENTARIOS;
}

mailsList = () => {
    CORREOS = [];

    let TABLA =  $("#listaCorreos tbody >tr");

    TABLA.each(function(){
        let CORREO      = $(this).find('td').eq(1).text(),
            NOMBRE      = $(this).find('td').eq(0).text(),
            ENVIAR      = $(this).find('td').eq(2).children().prop("checked"),

        item= {};
        
        if (ENVIAR) {
            item['nombre']= NOMBRE;
            item['correo']= CORREO;

            CORREOS.push(item);
        }
        
    })

    return CORREOS;
}

