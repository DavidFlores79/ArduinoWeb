//Archivo para constantes utilizadas dentro de HOPE --David Flores
const titulos = {
    mensaje_sistema: 'Mensaje del Sistema',
}

const mensajes = {
    datosError: 'Los datos no se muestran correctamente',
    datosNoEncontrados: 'No se encontró ningun resultado',
    datosErrorConexion: 'Error de Conexion',
    ingresaBusqueda: 'Ingresa el documento de pedido para poder ejecutar la busqueda',
    seleccionPosicion: 'Selecciona al menos una posicion antes de utilizar esta opcion',
    accionNoRealizada: 'Hubo un problema, inténtelo más tarde',
    PdfNoCargado: 'No se ha cargado el PDF',
    Autenticacion: 'Su sesión ha vencido. Será redirigido a Home.',
}

const tiposDeMensaje = {
    exito: 'success',
    error: 'error',
    informacion: 'info',
    advertencia: 'warning',
}

const configuraciones = {
    titulo: 'Configuracion del Sistema',
}

const logs = {
    titulo: 'Bitácora',
}

function mostrarSwal(response) {
    console.log({response});
    if (response.status === 422) {
        let mensaje = "";
        for (let i in response.data.errors) {
            mensaje += response.data.errors[i] + "\n";
        }
        swal(mensaje, {
            title: titulos.mensaje_sistema,
            icon: tiposDeMensaje.advertencia,
        });
    } else if (response.status === 419 || response.status === 401) {
        swal({
            title: titulos.mensaje_sistema,
            text: "Serás redirigido a Home.",
            icon: tiposDeMensaje.advertencia,
            confirmButtonText: 'Ir a Home!',
        }).then(() => window.location.href = "home");
    } else {
        swal(
            titulos.mensaje_sistema,
            response.data.message ?? 'Error al obtener los datos.',
            tiposDeMensaje.error
        );
    }
}