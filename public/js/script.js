function confirmarEliminar(formulario) {
  Swal.fire({
    title: "Confirmar eliminacion",
    text: "Este registro se eliminara de la base de datos",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, eliminar",
    cancelButtonText: "Cancelar",
    confirmButtonColor: "#b83232",
    cancelButtonColor: "#16324f"
  }).then(function (resultado) {
    if (resultado.isConfirmed) {
      formulario.submit()
    }
  })
  return false
}

function imprimirPagina() {
  window.print()
}

function buscarTabla() {
  const texto = document.getElementById("buscar").value.toLowerCase()
  const filas = document.querySelectorAll("tbody tr")
  filas.forEach(function (fila) {
    const contenido = fila.innerText.toLowerCase()
    if (contenido.includes(texto)) {
      fila.style.display = ""
    } else {
      fila.style.display = "none"
    }
  })
}

document.addEventListener("DOMContentLoaded", function () {
  const mensaje = document.body.getAttribute("data-mensaje")
  const error = document.body.getAttribute("data-error")
  if (mensaje) {
    Swal.fire("Listo", mensaje, "success")
  }
  if (error) {
    Swal.fire("Error", error, "error")
  }
})
