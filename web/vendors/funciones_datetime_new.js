var fecha = $('#buseta_informestock_autobus_fecha').pickadate({
    format: 'dd/mm/yyyy',
    formatSubmit: 'dd/mm/yyyy'
});

var fechaCostos = $('#data_busqueda_informe_costos_type_fecha').pickadate({
    format: 'dd/mm/yyyy',
    formatSubmit: 'dd/mm/yyyy'
});

var fechaInformeStock = $('#data_busqueda_informe_stock_type_fecha').pickadate({
    format: 'dd/mm/yyyy',
    formatSubmit: 'dd/mm/yyyy'
});

var fechaMovimiento = $('#bodega_albaran_type_fechaMovimiento').pickadate({
    format: 'dd/mm/yyyy',
    formatSubmit: 'dd/mm/yyyy'
});

var fechaContable = $('#bodega_albaran_type_fechaContable').pickadate({
    format: 'dd/mm/yyyy',
    formatSubmit: 'dd/mm/yyyy'
});

var fecha_pedido = $('#bodega_pedido_compra_fecha_pedido').pickadate({
    format: 'dd/mm/yyyy',
    formatSubmit: 'dd/mm/yyyy'
});
var autobus_fecha_ingreso = $('#buseta_databundle_autobus_fecha_ingreso').pickadate({
    format: 'dd/mm/yyyy',
    formatSubmit: 'dd/mm/yyyy'
});
var autobus_valido_hasta = $('#buseta_databundle_autobus_valido_hasta').pickadate({
    format: 'dd/mm/yyyy',
    formatSubmit: 'dd/mm/yyyy'
});
var recorrido_inicio = $('#buseta_tallerbundle_tareamantenimiento_recorrido_inicio').pickadate({
    format: 'dd/mm/yyyy',
    formatSubmit: 'dd/mm/yyyy'
});
var ultimo_cumplio = $('#buseta_tallerbundle_tareamantenimiento_ultimo_cumplio').pickadate({
    format: 'dd/mm/yyyy',
    formatSubmit: 'dd/mm/yyyy'
});

var picker = autobus_fecha_ingreso.pickadate('picker');
var $fechaIngreso;

if (picker != null) {
    picker.on('close', function () {
        $fechaIngreso = this.get('select', 'dd/mm/yyyy');
        var splt = $fechaIngreso.split('/');
        var entero = parseInt(splt[2]);
        entero += 15;
        splt[2] = entero.toString();

        $fechaIngreso = splt.join('/');

        var picker2 = autobus_valido_hasta.pickadate('picker');
        picker2.set('select', $fechaIngreso, {format: 'dd/mm/yyyy'});
    });
}

var fecha = $('#buseta_informestock_autobus_fecha').val();
$('input:hidden[name^="buseta_informestock_autobus[fecha]_submit"]').val(fecha);

var fechaCostos = $('#data_busqueda_informe_costos_type_fecha').val();
$('input:hidden[name^="data_busqueda_informe_costos_type[fecha]_submit"]').val(fechaCostos);

var fechaInformeStock = $('#data_busqueda_informe_stock_type_fecha').val();
$('input:hidden[name^="data_busqueda_informe_stock_type[fecha]_submit"]').val(fechaInformeStock);

var valido = $('#buseta_databundle_autobus_valido_hasta').val();
$('input:hidden[name^="buseta_databundle_autobus[valido_hasta]_submit"]').val(valido);

var fechaingreso = $('#buseta_databundle_autobus_fecha_ingreso').val();
$('input:hidden[name^="buseta_databundle_autobus[fecha_ingreso]_submit"]').val(fechaingreso);

var fechamovimiento = $('#bodega_albaran_type_fechaMovimiento').val();
$('input:hidden[name^="bodega_albaran_type[fechaMovimiento]_submit"]').val(fechamovimiento);

var fechacontable = $('#bodega_albaran_type_fechaContable').val();
$('input:hidden[name^="bodega_albaran_type[fechaContable]_submit"]').val(fechacontable);

var fechapedido = $('#bodega_pedido_compra_fecha_pedido').val();
$('input:hidden[name^="bodega_pedido_compra[fecha_pedido]_submit"]').val(fechapedido);

var recorrido_inicio = $('#buseta_tallerbundle_tareamantenimiento_recorrido_inicio').val();
$('input:hidden[name^="buseta_tallerbundle_tareamantenimiento[recorrido_inicio]_submit"]').val(recorrido_inicio);

var ultimo_cumplio = $('#buseta_tallerbundle_tareamantenimiento_ultimo_cumplio').val();
$('input:hidden[name^="buseta_tallerbundle_tareamantenimiento[ultimo_cumplio]_submit"]').val(ultimo_cumplio);

/*var fecha_inicio = $('#buseta_tallerbundle_ordentrabajo_fecha_inicio').val();
 $('input:hidden[name^="buseta_tallerbundle_ordentrabajo_fecha_inicio]_submit"]').val(fecha_inicio);*/

/*var fecha_final = $('#buseta_tallerbundle_ordentrabajo_fecha_final').val();
 $('input:hidden[name^="buseta_tallerbundle_ordentrabajo_fecha_final]_submit"]').val(fecha_final);*/

localChange()
$("input#barras").click(localChange);
$("input#rampas").click(localChange);
$("input#camaras").click(localChange);
$("input#lector").click(localChange);
$("input#publicidad").click(localChange);
$("input#gps").click(localChange);
$("input#wifi").click(localChange);

function localChange() {
    barras = $("input#barras:checked").is(":empty");
    rampas = $("input#rampas:checked").is(":empty");
    camaras = $("input#camaras:checked").is(":empty");
    publicidad = $("input#publicidad:checked").is(":empty");
    gps = $("input#gps:checked").is(":empty");
    wifi = $("input#wifi:checked").is(":empty");
    lector = $("input#lector:checked").is(":empty");

    if (!barras) {
        $('textarea#buseta_databundle_autobus_barras').val("");
        $('textarea#buseta_databundle_autobus_barras').fadeOut();
        $('label#barras').fadeOut();
    } else {
        $('textarea#buseta_databundle_autobus_barras').fadeIn();
        $('label#barras').fadeIn();
    }

    if (!rampas) {
        $('textarea#buseta_databundle_autobus_rampas').val("");
        $('textarea#buseta_databundle_autobus_rampas').fadeOut();
        $('label#rampas').fadeOut();
    } else {
        $('textarea#buseta_databundle_autobus_rampas').fadeIn();
        $('label#rampas').fadeIn();
    }

    if (!camaras) {
        $('textarea#buseta_databundle_autobus_camaras').val("");
        $('textarea#buseta_databundle_autobus_camaras').fadeOut();
        $('label#camaras').fadeOut();
    } else {
        $('textarea#buseta_databundle_autobus_camaras').fadeIn();
        $('label#camaras').fadeIn();
    }

    if (!publicidad) {
        $('textarea#buseta_databundle_autobus_publicidad').val("");
        $('textarea#buseta_databundle_autobus_publicidad').fadeOut();
        $('label#publicidad').fadeOut();
    } else {
        $('textarea#buseta_databundle_autobus_publicidad').fadeIn();
        $('label#publicidad').fadeIn();
    }

    if (!gps) {
        $('textarea#buseta_databundle_autobus_gps').val("");
        $('textarea#buseta_databundle_autobus_gps').fadeOut();
        $('label#gps').fadeOut();
    } else {
        $('textarea#buseta_databundle_autobus_gps').fadeIn();
        $('label#gps').fadeIn();
    }

    if (!wifi) {
        $('textarea#buseta_databundle_autobus_wifi').val("");
        $('textarea#buseta_databundle_autobus_wifi').fadeOut();
        $('label#wifi').fadeOut();
    } else {
        $('textarea#buseta_databundle_autobus_wifi').fadeIn();
        $('label#wifi').fadeIn();
    }

    if (!lector) {
        $('textarea#buseta_databundle_autobus_lector_cedulas').val("");
        $('textarea#buseta_databundle_autobus_lector_cedulas').fadeOut();
        $('label#lector').fadeOut();
    } else {
        $('textarea#buseta_databundle_autobus_lector_cedulas').fadeIn();
        $('label#lector').fadeIn();
    }

}







