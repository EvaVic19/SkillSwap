function mostrarAlertaExito(mensaje) {
  Swal.fire({
    icon: 'success',
    title: 'Éxito',
    text: mensaje,
    confirmButtonColor: '#198754'
  });
}

function mostrarAlertaError(mensaje) {
  Swal.fire({
    icon: 'error',
    title: 'Atención',
    text: mensaje,
    confirmButtonColor: '#dc3545'
  });
}
