var
    pedidocompra = {
        form_id: $('div#basicos').find('form').attr('id'),
        form_name: $('div#basicos').find('form').attr('name'),
        id: '',
        _start_evens: function () {
            $('#bodega_pedido_compra_fecha_pedido').datetimepicker({
                'format': 'DD/MM/YYYY'
            });
            $('#bodega_pedido_compra_tercero').chosen();
            $('#bodega_pedido_compra_almacen').chosen();

            proveedor.findMoneda();
            proveedor.getElement().on('change', proveedor.findMoneda);

            $('a#btn_pedidocompra_save').on('click', pedidocompra._save);
        },
        _load: function () {
            pedidocompra.id = $('input[id="' + pedidocompra.form_id + '_id"]').val();
            if (pedidocompra.id === '' || pedidocompra.id === undefined) {
                // hide all tabs on page load
                $('a[data-toggle="tab"]').each(function(key, item) {
                    if($(item).attr('href') != '#basicos') {
                        $(item).parent().hide();
                    }
                });
            }

            // on show tab events
            $('a[data-toggle="tab"]').unbind('show.bs.tab');
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                var href = $(e.target).attr('href');
                var relhref = $(e.relatedTarget).attr('href');

                if (href === '#lineas') {
                    lineas._load();
                }
            });

            pedidocompra._start_evens();
        },
        _save: function (event) {
            if (event != undefined) {
                event.preventDefault();
            }

            // disable btn
            button._disable('a#btn_pedidocompra_save');

            // add spinning to show loading process
            tabs._add_loadding('basicos');

            // PedidoCompra Id
            pedidocompra.id = $('input[id="' + pedidocompra.form_id + '_id"]').val();

            var pedidocomprasForm    = $('form#' + pedidocompra.form_id),
                url             = Routing.generate('pedidocompra_create',{});
            if(pedidocompra.id !== '' && pedidocompra.id !== undefined) {
                url = Routing.generate('pedidocompra_update', {'id': pedidocompra.id});
            }

            pedidocomprasForm.ajaxSubmit({
                success: pedidocompra._done,
                error: utils._fail,
                complete: pedidocompra._always,
                uploadProgress: pedidocompra._upload,
                url: url,
                dataType: 'json'
            });
        },
        _done: function (response, textStatus, jqXHR) {
            $('form#' + pedidocompra.form_id).replaceWith(response.view);

            if(jqXHR.status == 201) {
                $btalerts.addSuccess(response.message);
                // PedidoCompra Id
                pedidocompra.id = $('input[id="' + pedidocompra.form_id + '_id"]').val();
                // activate all tabs
                tabs._show_all_tabs();
            } else if(jqXHR.status == 202) {
                $btalerts.addSuccess(response.message);
            }
            pedidocompra._start_evens();
        },
        _always: function() {
            // remove spinning
            tabs._remove_loadding('basicos');
            // remove progress bar
            progressBar._remove_progressBar($('input[id="' + pedidocompra.form_id + '_foto_file"]').attr('id'));

            button._enable('a#btn_pedidocompra_save');
        },
        _upload: function (event, position, total, percentComplete) {
            var progressBarr = $('div#basicos').find('.progress-bar')[0];
            if (progressBarr !== undefined) {
                $(progressBarr).css('width', percentComplete + '%');
                $(progressBarr).find('span').html(percentComplete + '% Completado');
            }
        }
    },

    moneda = {
        element: 'select#bodega_pedido_compra_moneda',

        restore: function () {
            $(moneda.element).removeAttr('readonly');
            $(moneda.element).find('option').removeAttr('disabled').removeAttr('selected');
            $(moneda.element).find('option[value=""]').first().attr('selected','selected');
        },

        select: function (id) {
            $(moneda.element).find('option[value="' + id + '"]').first()
                .attr('selected', 'selected')
                .removeAttr('disabled');
            // Disabled because we want to select any other if needed
            //$(moneda.element).find('option[value!="' + id + '"]')
            //    .removeAttr('selected')
            //    .attr('disabled', 'disabled');

            //if ($(moneda.element).find('option[value="' + id + '"]').size() > 0) {
            //    moneda.readonly();
            //}
        },

        readonly: function () {
            $(moneda.element).attr('readonly', 'readonly');
        }
    },

    proveedor = {
        element: 'select#bodega_pedido_compra_tercero',

        findMoneda: function () {
            var idproveedor = $(proveedor.element).val();

            if (idproveedor.length === 0 || isNaN(idproveedor)) {
                moneda.restore();
                return ;
            }

            $.ajax({
                url: Routing.generate('pedidocompra_get_moneda_by_proveedor', {id: idproveedor}),
                dataType: 'JSON',
                method: 'GET'
            }).done(function (response, textStatus, jqXHR) {
                moneda.select(response.id);
            }).fail(function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 404) {
                    $btalerts.addWarning(jqXHR.responseJSON.error);
                } else if (jqXHR.status === 500) {
                    $btalerts.addWarning('Ha ocurrido un error inesperado.');
                }
            });
        },
        getElement: function() {
            return $(proveedor.element);
        }
    };
