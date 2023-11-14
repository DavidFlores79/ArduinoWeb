$(function() {
    $('[data-toggle="tooltip"]').tooltip();

    $(".datepicker").datepicker({
        dateFormat: 'yy-mm-dd',
        dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ], // Column headings for days starting at Sunday
        monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
        monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ], // Names of months for drop-down and formatting
    });
    $(".datepicker").datepicker('setDate', new Date());

    $('.selectpicker').selectpicker({deselectAllText: 'Quitar todos', selectAllText: 'Elegir todos'});

    $("#navbar-toggler").on("click", function() {
        $("#menuModal").modal("show");
    })

    $(window).on('resize', function() {
        $("#menuModal").modal("hide");
    });

    $('#buscar-loading').addClass('d-none');
    
    if ("{{ $errors->first('permisos') }}") {
        $('#permisos').show();

        setTimeout(function() {
            $('#permisos').fadeOut('slow');
        }, 3000);
    }

    // Ocultar tooltips al hacer clic en cualquier lugar de la página
    $(document).on("click", function () {
        $('[data-toggle="tooltip"]').tooltip("hide");
    });

});

//Loading pantalla completa
function activarLoading() {
    $('#loading').removeClass('d-none');
    $('#loading').addClass('d-flex');
}

function desactivarLoading() {
    $('#loading').removeClass('d-flex');
    $('#loading').addClass('d-none');
}

//Loading en boton
function activarValidandoLoading() {
    $('.validando').addClass('d-none');
    $('.validando-loading').removeClass('d-none');
}
  
function desactivarValidandoLoading() {
    $('.validando-loading').addClass('d-none');
    $('.validando').removeClass('d-none');
}
