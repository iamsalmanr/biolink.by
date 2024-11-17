jQuery(function ($) {
    "use strict";

    /* Datatable Basic */
    var $datatable = $('#basic_datatable'),
        order_by = $datatable.data('order-col') || 0,
        order = $datatable.data('order-dir') || 'asc';

    if($datatable.length) {
        var dtbasic = $datatable.DataTable({
            rowReorder: {
                selector: 'tr .quick-reorder-icon',
                update: false
            },
            order: [[order_by, order]],
            processing: true,
            responsive: true,
            columnDefs: [
                {orderable: false, targets: 'no-sort'}
            ],
            pageLength: 25
        });
        $('div.dataTables_filter input').addClass('form-control');
        $('div.dataTables_length select').addClass('form-control');
    }

    /* Datatable ajax */
    var $datatable = $('#ajax_datatable'),
        order_by = $datatable.data('order-col') || 0,
        order = $datatable.data('order-dir') || 'desc',
        datatable_ajax_url = $datatable.data('jsonfile');

    if($datatable.length) {
        var dt = $datatable.DataTable({
            rowReorder: {
                selector: 'tr .quick-reorder-icon',
                update: false
            },
            order: [[order_by, order]],
            processing: true,
            serverSide: true,
            responsive: true,
            columnDefs: [
                {orderable: false, targets: 'no-sort'}
            ],
            pageLength: 25,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: datatable_ajax_url,
                error: function () {
                    $("#ajax_datatable_processing").css("display", "none");
                }
            }
        });
        $('div.dataTables_filter input').addClass('form-control');
        $('div.dataTables_length select').addClass('form-control');

        // custom filters for datatable
        $('.quick-datatable-filter').on('change', function () {
            if (datatable_ajax_url.indexOf('?') !== -1) {
                datatable_ajax_url = datatable_ajax_url + "&" + $(this).attr('name') + '=' + $(this).val();
            } else {
                datatable_ajax_url = datatable_ajax_url + "?" + $(this).attr('name') + '=' + $(this).val();
            }
            dt.ajax.url(datatable_ajax_url);
            dt.ajax.reload();
        });

        dt.on('row-reorder', function (e, diff, edit) {
            var data = [];
            $datatable.find('tbody').children('tr').each(function () {
                var $this = $(this);
                var position = $this.attr('id');
                data.push(position);
            });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $datatable.data('reorder-route'),
                type: 'POST',
                data: {action: $datatable.data('reorder-action'), position: data},
                success: function (response) {
                    if (response.success) {
                        quick_alert(response.message);
                    } else {
                        quick_alert(response.message, 'error');
                    }
                }
            });
        });
    }

    // Child Datatable - Add event listener for opening and closing details
    $('#ajax_datatable tbody').on('click', 'td .details-row-button', function () {
        var table = $('#ajax_datatable').DataTable();
        var tr = $(this).closest('tr');
        var btn = $(this);
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            $(this).removeClass('icon-feather-minus-circle').addClass('icon-feather-plus-circle');
            $('div.table_row_slider', row.child()).slideUp( function () {
                row.child.hide();
                tr.removeClass('shown');
            } );
        }
        else {
            // Open this row
            $(this).removeClass('icon-feather-plus-circle').addClass('icon-feather-minus-circle');
            // Get the details with ajax
            var $jsonfile = $( '#ajax_datatable').data('jsonfile');
            var id = btn.data('entry-id');
            var action = btn.data('entry-action');
            var data = {action: action, id: id};

            $.ajax({
                type: "POST",
                url :"datatable-json/"+$jsonfile,
                data: data
            })
                .done(function(data) {
                    row.child("<div class='table_row_slider'>" + data + "</div>", 'no-padding').show();
                    tr.addClass('shown');
                    $('div.table_row_slider', row.child()).slideDown();
                })
                .fail(function(data) {
                    row.child("<div class='table_row_slider'>There was an error loading the details. Please retry.</div>").show();
                    tr.addClass('shown');
                    $('div.table_row_slider', row.child()).slideDown();
                })
                .always(function(data) {

                });
        }
    } );

    /* Post ajax form */
    $(document).on("submit", "#ajax_submit_form, .ajax_submit_form", function (e) {
        e.preventDefault();
        var $form = $(this),
            action = $form.attr('action'),
            loader = $form.find('[type="submit"]'),
            sidepanel_ajax = $form.data('ajax-sidepanel') || false,
            options = {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:  action,
                dataType:  'json',
                success:   function(response){
                    if (response.success) {
                        quick_alert(response.message);
                        $('#post_id').val(response.id);
                        if ($('#quick-dynamic-modal').length) {
                            $('#quick-dynamic-modal').modal('hide');
                        }
                    } else {
                        quick_alert(response.message, 'error');
                    }
                    loader.removeClass('quick-loader').prop('disabled',false);
                }
            };
        loader.addClass('quick-loader').prop('disabled',true);
        $form.ajaxSubmit(options);
    });

    /* Sidepanel ajax */
    $(document).on("click", "#post_sidePanel_data", function (e) {
        var $button = $(this),
            $form = $('#sidePanel_form'),
            action = $form.attr('action'),
            formData = $form.serializeArray();

        $button.addClass('quick-loader').prop('disabled',true);
        $form.ajaxSubmit({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: action,
            dataType:  'json',
            success:   function (response) {
                $button.removeClass('quick-loader').prop('disabled',false);
                if (response.success) {
                    quick_alert(response.message);

                    if(typeof dt !== 'undefined')
                        dt.ajax.reload();
                    else
                        location.reload();

                    $.slidePanel.hide();
                } else {
                    quick_alert(response.message, 'error');
                }
            }
        });
    });
    $(document).on("submit", "#sidePanel_form", function (e) {
        // prevent form submit on enter
        e.preventDefault();
        return false;
    });

    /* Position reorder */
    var $reorder_body = $('.quick-reorder-body');
    if($reorder_body.length) {
        $reorder_body.sortable({
            helper: function (e, ui) {
                ui.children().each(function () {
                    $(this).width($(this).width());
                });
                return ui;
            },
            axis: 'y',
            handle: '.quick-reorder-icon',
            update: function (event, ui) {
                var data = [];

                $reorder_body.children('.quick-reorder-element').each(function () {
                    var $this = $(this);
                    var position = $this.data('id');
                    data.push(position);
                });
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: $reorder_body.data('action'),
                    data: {position: data},
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            quick_alert(response.message);
                        } else {
                            quick_alert(response.message, 'error');
                        }
                    }
                });
            }
        });
    }

    /* Site action delete */
    var $delete_button = $('#quick-delete-button');
    $delete_button.on('click', function () {
        if (confirm("Are you sure?")) {
            var $this = $(this),
                action = $this.data('action'),
                data = [],
                $row = [],
                $checkboxes = $('tbody input:checked');


            if ($($checkboxes).length ) {
                $checkboxes.each(function () {
                    var row = $(this).parents('tr');
                    $row.push(row);
                    data.push(this.value);
                });
            }else{
                $checkboxes = $('.quick-accordion input:checked');
                $checkboxes.each(function () {
                    var row = $(this).parents('.quick-accordion-card');
                    $row.push(row);
                    data.push(this.value);
                });
            }

            $this.addClass('quick-loader').prop('disabled',true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: action,
                type: 'POST',
                data: {
                    ids: data
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        quick_alert(response.message);
                        if(typeof dt !== 'undefined'){
                            dt.rows($checkboxes.closest('td')).remove().draw();
                        }else{
                            $.each($row.reverse(), function (index) {
                                $(this).delay(500 * index).fadeOut(200, function () {
                                    $(this).remove();
                                });
                            });
                        }
                    } else {
                        quick_alert(response.message,'error');
                    }
                    $this.removeClass('quick-loader').prop('disabled',false);
                    // hide action button
                    $(".site-action").removeClass('active');
                }
            });
        }
    });

    $(document).on('click','.item-ajax-button', function (e) {
        e.preventDefault();
        var $this = $(this),
            action = $this.data('ajax-action'),
            $item = $this.closest('tr'),
            alert_mesg = $(this).data('alert-message'),
            data = {action: action, id: $item.attr('id')};

        if (confirm(alert_mesg)) {
            $this.addClass('quick-loader').prop('disabled', true);
            $.ajax({
                url: action,
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        if(typeof dt !== 'undefined')
                            dt.ajax.reload();
                        else
                            location.reload();
                        quick_alert(response.message);
                    } else {
                        quick_alert(response.message, 'error');
                    }
                    $this.removeClass('quick-loader').prop('disabled',false);
                }
            });
        }
    });

    /* delete single row */
    $(document).on('click','.item-js-delete', function (e) {
        e.preventDefault();
        var $this = $(this),
            action = $this.data('ajax-action'),
            $item = $this.closest('tr'),
            data = { action: action, id: $item.attr('id') };

        swal({
            title: "Are you sure?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#6b76ff",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        }, function(){
            $('.confirm').addClass('quick-loader').prop('disabled',true);
            $.ajax({
                url: ajaxurl + '?action=' + action,
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $item.remove();
                        quick_alert(response.message);
                    } else {
                        quick_alert(response.message,'error');
                    }
                    swal.close();
                    $('.confirm').removeClass('quick-loader').prop('disabled',false);
                }
            });
        });
    });

    $(document).on('click','.login-as-user',function (e) {
        e.stopPropagation();
        e.preventDefault();

        //Parameter
        if ($(this).data('redirect-url')) {
            var url = $(this).data('redirect-url');
        }else{
            var url = '';
        }
        var $id = $(this).data('user-id');
        var data = { action: 'loginAsUser', id: $id };
        var $btn = $(this);
        $btn.addClass('quick-loader').prop('disabled',true);
        $.ajax({
            type: 'POST',
            data: data,
            url: ajaxurl,
            success: function (response) {
                $btn.removeClass('quick-loader').prop('disabled',false);
                if(url!=''){
                    var win = window.open(url, '_blank');
                    win.focus();
                }else{
                    if(response != 0) {
                        var win = window.open(response, '_blank');
                        win.focus();
                    }
                }
            }
        });
    });
});
