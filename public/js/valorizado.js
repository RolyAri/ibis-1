$(function(){
    $("#esperar").fadeOut();

    $("#btnConsulta").on('click', function(e) {
        e.preventDefault();

        $("#esperar").fadeIn();

        let str = $("#formConsulta").serialize();

        $.post(RUTA+"valorizado/consulta", str,
            function (data, text, requestXHR) {
                $("#esperar").fadeOut();
                $("#tableValorizado tbody")
                    .empty()
                    .append(data);
            },
            "text"
        );
        
        return false
    });

    $("#btnExporta").click(function(e){
        e.preventDefault();

        var array = [];
        /* Obtenemos todos los tr del Body*/
        var rowsBody= $("#tableValorizado").find('tbody > tr');
        /* Obtenemos todos los th del Thead */
        var rowsHead= $("#tableValorizado").find('thead > tr > th');
        
        /* Iteramos sobre as filas del tbody*/
        for (var i = 0; i < rowsBody.length; i++) {
            var obj={};/* auxiliar*/
            for (var j = 0;j < rowsHead.length;j++) /*  Iteramos sobre los th de THead*/
                /*Asignamos como clave el text del th del thead*/
                /*Asignamos como Valor el text del tr del tbody*/
                obj[rowsHead[j].dataset.titulo] =  rowsBody[i].getElementsByTagName('td')[j].innerText;
            
            array.push(obj);/* Añadimos al Array Principal*/
        }

        $.post(RUTA+"valorizado/exportar", {detalles:JSON.stringify(array)},
            function (data, textStatus, jqXHR) {
                window.location.href = data.documento;
            },
            "json"
        );

        return false;
    });
})

/*detalles = () =>{
    DATA = [];

    let TABLA = $("#tableValorizado tbody >tr");

    TABLA.each(function(){
        let ITEM                = $(this).find('td').eq(0).text(),
            ESTADO              = $(this).find('td').eq(1).text(),
            PROYECTO            = $(this).find('td').eq(2).text(),
            AREA                = $(this).find('td').eq(3).text(),
            PARTIDA             = $(this).find('td').eq(4).text(),
            ATENCION            = $(this).find('td').eq(5).text(),
            TIPO                = $(this).find('td').eq(6).text(),
            ANIO_PEDIDO         = $(this).find('td').eq(7).text(),
            NUM_PEDIDO          = $(this).find('td').eq(8).text(),
            CREA_PEDIDO         = $(this).find('td').eq(9).text(),
            APRO_PEDIDO         = $(this).find('td').eq(10).text(),
            CANTIDAD            = $(this).find('td').eq(11).text(),
            CODIGO              = $(this).find('td').eq(12).text(),
            UNIDAD              = $(this).find('td').eq(13).text(),
            DESCRIPCION         = $(this).find('td').eq(14).text(),
            TIPO_ORDEN          = $(this).find('td').eq(15).text(),
            ANIO_ORDEN          = $(this).find('td').eq(16).text(),
            NRO_ORDEN           = $(this).find('td').eq(17).text(),
            FECHA_ORDEN         = $(this).find('td').eq(18).text(),
            CANTIDAD_ORDEN      = $(this).find('td').eq(19).text(),
            PROVEEDOR           = $(this).find('td').eq(20).text(),
            FECHA_ENTREGA       = $(this).find('td').eq(21).text(),
            CANTIDAD_RECIBIDA   = $(this).find('td').eq(22).text(),
            SALDO_RECIBIR       = $(this).find('td').eq(23).text(),
            DIAS_ENTREGA        = $(this).find('td').eq(24).text(),
            DIAS_ATRASO         = $(this).find('td').eq(25).text(),
            SEMAFORO            = $(this).find('td').eq(26).text(),
            NOTA_INGRESO        = $(this).find('td').eq(27).text(),
            GUIA_INGRESO        = $(this).find('td').eq(28).text(),
            FECHA_INGRESO       = $(this).find('td').eq(29).text(),
            NOTA_SALIDA         = $(this).find('td').eq(30).text(),
            GUIA_REMISION       = $(this).find('td').eq(31).text(),
            FECHA_GUIAREMISION  = $(this).find('td').eq(32).text(),
            CANTIDA_OBRA        = $(this).find('td').eq(33).text(),
            NOTA_INGRESOOBRA    = $(this).find('td').eq(34).text(),
            FECHA_RECEPOBRA     = $(this).find('td').eq(35).text(),
            ESTADO_PEDIDO       = $(this).find('td').eq(36).text(),
            ESTADO_ITEM         = $(this).find('td').eq(37).text(),
            NUMERO_PARTE        = $(this).find('td').eq(38).text(),
            CODIGO_ACTIVO       = $(this).find('td').eq(39).text(),
            OPERADOR            = $(this).find('td').eq(40).text(),
            TRANSPORTE          = $(this).find('td').eq(41).text(),
            OBSERVACIONES       = $(this).find('td').eq(42).text();
          

        item = {};

        item['item']                = ITEM;
        item['estado']              = ESTADO;
        item['proyecto']            = PROYECTO;
        item['area']                = AREA;
        item['partida']             = PARTIDA;
        item['atencion']            = ATENCION;
        item['tipo']                = TIPO;
        item['anio_pedido']         = ANIO_PEDIDO;
        item['num_pedido']          = NUM_PEDIDO;
        item['crea_pedido']         = CREA_PEDIDO;
        item['apro_pedido']         = APRO_PEDIDO;
        item['codigo']              = CODIGO;
        item['unidad']              = UNIDAD;
        item['descripcion']         = DESCRIPCION;
        item['cantidad']            = CANTIDAD;
        item['tipo_orden']          = TIPO_ORDEN;
        item['anio_orden']          = ANIO_ORDEN;
        item['nro_orden']           = NRO_ORDEN;
        item['fecha_orden']         = FECHA_ORDEN;
        item['proveedor']           = PROVEEDOR;
        item['fecha_entrega']       = FECHA_ENTREGA;
        item['cantidad_recibida']   = CANTIDAD_RECIBIDA;
        item['saldo_recibir']       = SALDO_RECIBIR;
        item['dias_entrega']        = DIAS_ENTREGA;
        item['dias_atraso']         = DIAS_ATRASO;
        item['semaforo']            = SEMAFORO;
        item['nota_ingreso']        = NOTA_INGRESO;
        item['guia_ingreso']        = GUIA_INGRESO;
        item['fecha_ingreso']       = FECHA_INGRESO;
        item['nota_salida']         = NOTA_SALIDA;
        item['guia_remision']       = GUIA_REMISION;
        item['fecha_guiaremision']  = FECHA_GUIAREMISION;
        item['cantidad_obra']       = CANTIDA_OBRA;
        item['nota_ingresoobra']    = NOTA_INGRESOOBRA;
        item['fecha_recepobra']     = FECHA_RECEPOBRA;
        item['estado_pedido']       = ESTADO_PEDIDO;
        item['estado_item']         = ESTADO_ITEM;
        item['numero_parte']        = NUMERO_PARTE;
        item['codigo_activo']       = CODIGO_ACTIVO;
        item['operador']            = OPERADOR;
        item['transporte']          = TRANSPORTE;
        item['observaciones']       = OBSERVACIONES;
        item['cantidad_orden']      = CANTIDAD_ORDEN;
        
        DATA.push(item);
    })

    return DATA;
}*/