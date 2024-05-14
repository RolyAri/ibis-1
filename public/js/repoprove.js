$(function() {
    let campo = "",
        ffemision = [],
        cCostos = [],
        cEntidad = [];
    
    $("#espera").fadeOut();

    $(".contenedorfiltro *").click(function(e){
        e.preventDefault();

        let control = $(this);
        
        campo = $(this).parent().parent().data("campo");
        
        $(".filter_options").fadeOut();

        llamarFiltro(control,campo);

        return false;
    });

    $(".btn_sendfilter").click(function (e) { 
        e.preventDefault();
    
        let indice = 0,
            formdata = new FormData();
    
        $('.filterList input[type=checkbox]:checked').each(function() {
            if (campo == 'ffemision')
                ffemision[indice++] = $(this).attr("id");
            else if (campo == 'cCostos')
                cCostos[indice++] = $(this).attr("id");
            else if (campo == 'cEntidad')
                cEntidad[indice++] = $(this).attr("id");
        });

        formdata.append("filtro_emision",JSON.stringify(ffemision));
        formdata.append("filtro_costos",JSON.stringify(cCostos));
        formdata.append("filtro_entidad",JSON.stringify(cEntidad));

        fetch(RUTA+'repoprove/filtros',{
            method: 'POST',
            body:formdata
        })
        .then(response => response.json())
        .then(data => {
            $("#tablaPrincipalProveedor tbody").empty();
            
            let row = "",
                montoDolares = "",
                montoSoles = "",
                estado = "",
                ope="",
                fin="",
                log="";
            
            data.filas.forEach(fila => {
                if ( fila['ncodmon'] == 20) {
                    montoSoles = "S/. " + fila['ntotal'];
                    montoDolares = "";
                }else{
                    montoSoles = "";
                    montoDolares =  "$ " + fila['ntotal'],2;
                }

                if ( fila['nEstadoDoc'] == 49) {
                    estado = "procesando";
                }else if ( fila['nEstadoDoc'] == 59 ) {
                    estado = "firmas";
                }else if ( fila['nEstadoDoc'] == 60 ) {
                    estado = "recepcion";
                }else if ( fila['nEstadoDoc'] == 62 ) {
                    estado = "despacho";
                }else if ( fila['nEstadoDoc'] == 105 ) {
                    estado = "anulado";
                    montoDolares = "";
                    montoSoles = "";
                }

                log = fila['nfirmaLog'] == null ? '<i class="far fa-square"></i>' : '<i class="far fa-check-square"></i>';
                ope = fila['nfirmaOpe'] == null ? '<i class="far fa-square"></i>' : '<i class="far fa-check-square"></i>';
                fin = fila['nfirmaFin'] == null ? '<i class="far fa-square"></i>' : '<i class="far fa-check-square"></i>';

                row += `<tr>
                            <td class="textoCentro">${fila['cnumero']}</td>
                            <td class="textoCentro">${fila['ffechadoc']}</td>
                            <td class="pl20px">${fila['concepto']}</td>
                            <td class="pl20px">${fila['ccodproy']}</td>
                            <td class="pl20px">${fila['area']}</td>
                            <td class="pl20px">${fila['proveedor']}</td>
                            <td class="textoDerecha">${montoSoles}</td>
                            <td class="textoDerecha">${montoDolares}</td>
                            <td class="textoCentro ${estado}">${estado.toUpperCase()}</td>
                            <td class="textoCentro">${log}</td>
                            <td class="textoCentro">${fin}</td>
                            <td class="textoCentro">${ope}</td>
                        </tr>`;
            });

            $("#tablaPrincipalProveedor tbody").append(row);
        })
    
        $(this).parent().fadeOut();
    
        return false;
    });
    
})


llamarFiltro = (control,campo) => {
    $(".filter_options").children('ul').empty();

    let formdata = new FormData();
    formdata.append("campo",campo);

    fetch(RUTA+"repoprove/consultarValoresLista",{
        method: "POST",
        body: formdata
    })
    .then(reponse => reponse.json())
    .then(data => {
        data.valores.forEach(valor => {
            let item = ` <li><input type="checkbox" id="${valor['id']}"> ${valor['onumero']} </li>`;
            $(".filter_options").children('ul').append(item);
        });

        control.parent().parent().children(".filter_options").fadeToggle();
    });
}

