$(document).ready(function () {

    var handleCheckboxes = function (html, rowIndex, colIndex, cellNode) {
        var $cellNode = $(cellNode);
        var $check = $cellNode.find(':checked');
        return ($check.length) ? ($check.val() == 1 ? 'Yes' : 'No') : $cellNode.text();
    };

    var activeSub = $(document).find('.active-sub');
    if (activeSub.length > 0) {
        activeSub.parent().show();
        activeSub.parent().parent().find('.arrow').addClass('open');
        activeSub.parent().parent().addClass('open');
    }
    window.dtDefaultOptions = {
        retrieve: true,
		destroy: true,
        dom: 'lBfrtip<"actions">',
        columnDefs: [],
        "iDisplayLength": 10,
        "aaSorting": [],
        buttons: [
            {
                extend: 'copy',
                exportOptions: {
                    columns: ':visible',
                    format: {
                        body: handleCheckboxes
                    }
                }
            },
            'colvis'
        ]
    };
    $('.datatable').each(function () {
        if ($(this).hasClass('dt-select')) {
            window.dtDefaultOptions.select = {
                style: 'os',
                selector: 'td:first-child'
            };

            window.dtDefaultOptions.columnDefs.push({
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            });
        }
        $(this).dataTable(window.dtDefaultOptions);
    });
    if (typeof window.route_mass_crud_entries_destroy != 'undefined') {
        $('.datatable, .ajaxTable').siblings('.actions').html('<a href="' + window.route_mass_crud_entries_destroy + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
    }
    if (typeof window.route_selected_row != 'undefined') {
        $('.datatable, .ajaxTable').siblings('.actions').html('<a href="' + window.route_selected_row + '" class="btn btn-primary js-row-selected" style="margin-top:0.755em;margin-left: 20px;" id="obraselected">Seleccionar</a>');
    }

    if (typeof window.route_selectedobra_row != 'undefined') {
        $('.datatable, .ajaxTable').siblings('.actions').html('<a href="' + window.route_selectedobra_row + '" class="btn btn-primary js-row-selectedobra" style="margin-top:0.755em;margin-left: 20px;" id="obraselected">Seleccionar</a>');
	}
	
    $(document).on('click', '.js-delete-selected', function () {
        if (confirm('Are you sure')) {
            var ids = [];

            $(this).closest('.actions').siblings('.datatable, .ajaxTable').find('tbody tr.selected').each(function () {
                console.log("selected", $(this).data('entry-id'));
                ids.push($(this).data('entry-id'));
            });

            $.ajax({
                method: 'POST',
                url: $(this).attr('href'),
                data: {
                    _token: _token,
                    ids: ids
                }
            }).done(function () {
                location.reload();
            });
        }

        return false;
    });
	
    $(document).on('click', '.js-row-selected', function () {
  
            var ids = [];
            $(this).closest('.actions').siblings('.datatable, .ajaxTable').find('tbody tr.selected').each(function () {
                console.log("selected", $(this).data('entry-id'));
                ids.push($(this).data('entry-id'));
            });
            $.ajax({
                method: 'POST',
                url: $(this).attr('href'),
                data: {
                    _token: _token,
                    ids: ids
                }
				
            }).done(function () {
//                location.reload();
				$("#company").val( ids);
				$("#buscarcompania").modal("hide");
            });
        

        return false;
    });	

    $(document).on('click', '.js-row-selectedobra', function () {
  
            var ids = [];
		
            $(this).closest('.actions').siblings('.datatable, .ajaxTable').find('tbody tr.selected').each(function () {
                
				
				console.log("selected", $(this).data('entry-id'));

                ids.push($(this).data('entry-id'));
    			
            });
            $.ajax({
                method: 'POST',
                url: $(this).attr('href'),
                data: {
                    _token: _token,
                    ids: ids,
                }
				
            }).done(function () {
				switch(udc) {
					case "ciudad":
						description = $("#DataTables_Table_0").find('tbody tr.selected td:nth-child(3)').text();
						$("#ciudad").val(ids);
						$("#ciudaddesc").val(description);
						$("#buscarciudad").modal("hide");	
						break;							
					case "obra":
						description = $("#DataTables_Table_1").find('tbody tr.selected td:nth-child(3)').text();
						$("#tipo").val(ids);
						$("#tipodesc").val(description);
						$("#buscarobra").modal("hide");					
						break;
					case "estructura":
					    description = $("#DataTables_Table_2").find('tbody tr.selected td:nth-child(3)').text();
						$("#estructura").val(ids);
						$("#estructuradesc").val(description);
						$("#buscarestructura").modal("hide");	
						break;
					case "mamposteria":
						description = $("#DataTables_Table_3").find('tbody tr.selected td:nth-child(3)').text();
						$("#mamposteria").val(ids);
						$("#mamposteriadesc").val(description);
						$("#buscarmamposteria").modal("hide");	
						break;
					case "documento":
						description = $("#DataTables_Table_0").find('tbody tr.selected td:nth-child(3)').text();
						$("#code").val(ids);
						$("#description").val(description);
						$("#buscardocumento").modal("hide");	
						break;
					case "estados":
						description = $("#DataTables_Table_0").find('tbody tr.selected td:nth-child(3)').text();
						$("#code").val(ids);
						$("#description").val(description);
						$("#buscardocumento").modal("hide");	
						break;					
				}
            });
        

        return false;
    });	
	

    $(document).on('click', '#select-all', function () {
        var selected = $(this).is(':checked');

        $(this).closest('table.datatable, table.ajaxTable').find('td:first-child').each(function () {
            if (selected != $(this).closest('tr').hasClass('selected')) {
                $(this).click();
            }
        });
    });

    $('.mass').click(function () {
        if ($(this).is(":checked")) {
            $('.single').each(function () {
                if ($(this).is(":checked") == false) {
                    $(this).click();
                }
            });
        } else {
            $('.single').each(function () {
                if ($(this).is(":checked") == true) {
                    $(this).click();
                }
            });
        }
    });

    $('.page-sidebar').on('click', 'li > a', function (e) {

        if ($('body').hasClass('page-sidebar-closed') && $(this).parent('li').parent('.page-sidebar-menu').size() === 1) {
            return;
        }

        var hasSubMenu = $(this).next().hasClass('sub-menu');

        if ($(this).next().hasClass('sub-menu always-open')) {
            return;
        }

        var parent = $(this).parent().parent();
        var the = $(this);
        var menu = $('.page-sidebar-menu');
        var sub = $(this).next();

        var autoScroll = menu.data("auto-scroll");
        var slideSpeed = parseInt(menu.data("slide-speed"));
        var keepExpand = menu.data("keep-expanded");

        if (keepExpand !== true) {
            parent.children('li.open').children('a').children('.arrow').removeClass('open');
            parent.children('li.open').children('.sub-menu:not(.always-open)').slideUp(slideSpeed);
            parent.children('li.open').removeClass('open');
        }

        var slideOffeset = -200;

        if (sub.is(":visible")) {
            $('.arrow', $(this)).removeClass("open");
            $(this).parent().removeClass("open");
            sub.slideUp(slideSpeed, function () {
                if (autoScroll === true && $('body').hasClass('page-sidebar-closed') === false) {
                    if ($('body').hasClass('page-sidebar-fixed')) {
                        menu.slimScroll({
                            'scrollTo': (the.position()).top
                        });
                    }
                }
            });
        } else if (hasSubMenu) {
            $('.arrow', $(this)).addClass("open");
            $(this).parent().addClass("open");
            sub.slideDown(slideSpeed, function () {
                if (autoScroll === true && $('body').hasClass('page-sidebar-closed') === false) {
                    if ($('body').hasClass('page-sidebar-fixed')) {
                        menu.slimScroll({
                            'scrollTo': (the.position()).top
                        });
                    }
                }
            });
        }
        if (hasSubMenu == true || $(this).attr('href') == '#') {
            e.preventDefault();
        }
    });

    $('.select2').select2();

});

function processAjaxTables() {
    $('.ajaxTable').each(function () {
        window.dtDefaultOptions.processing = true;
        window.dtDefaultOptions.serverSide = true;
        if ($(this).hasClass('dt-select')) {
            window.dtDefaultOptions.select = {
                style: 'os',
                selector: 'td:first-child',
				destroy: true,
				iDisplayLength: 10
				
            };

            window.dtDefaultOptions.columnDefs.push({
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            });
        }
        $(this).DataTable(window.dtDefaultOptions);
        if (typeof window.route_mass_crud_entries_destroy != 'undefined') {
            $(this).siblings('.actions').html('<a href="' + window.route_mass_crud_entries_destroy + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
        }
    });

}
