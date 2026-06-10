function ponerMenu() {
  const menu = document.getElementById("menu")
  if (!menu) return
  menu.innerHTML = `
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="/"><i class="bi bi-book-half"></i> Biblioteca</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="menuNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="/"><i class="bi bi-house"></i> Inicio</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-journal-bookmark"></i> Libros</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/libros">Registrar</a></li>
              <li><a class="dropdown-item" href="/lista-libros">Lista</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-person-lines-fill"></i> Autores</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/autores">Registrar</a></li>
              <li><a class="dropdown-item" href="/lista-autores">Lista</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-people"></i> Usuarios</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/usuarios">Registrar</a></li>
              <li><a class="dropdown-item" href="/lista-usuarios">Lista</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-arrow-left-right"></i> Prestamos</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/prestamos">Registrar</a></li>
              <li><a class="dropdown-item" href="/lista-prestamos">Lista</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="/manual"><i class="bi bi-file-earmark-text"></i> Manual</a></li>
        </ul>
      </div>
    </div>
  </nav>`
}

function ponerFooter() {
  const footer = document.getElementById("pie")
  if (!footer) return
  footer.innerHTML = "<footer><div>Biblioteca Juvenil - Node server.js, HTML separado y consultas PHP</div></footer>"
}

function datosFormulario(formulario) {
  return new URLSearchParams(new FormData(formulario)).toString()
}

async function pedir(url, metodo, datos) {
  const opciones = { method: metodo }
  if (metodo === "POST") {
    opciones.headers = { "Content-Type": "application/x-www-form-urlencoded" }
    opciones.body = datos
  }
  const respuesta = await fetch(url, opciones)
  return await respuesta.json()
}

function mensaje(resultado, despues) {
  if (resultado.ok) {
    Swal.fire("Listo", resultado.mensaje || "Operacion realizada", "success").then(function () {
      if (despues) despues()
    })
  } else {
    Swal.fire("Error", resultado.mensaje || "Ocurrio un error", "error")
  }
}

function confirmarEliminar(id, url, despues) {
  Swal.fire({
    title: "Confirmar eliminacion",
    text: "Este registro se eliminara de la base de datos",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, eliminar",
    cancelButtonText: "Cancelar",
    confirmButtonColor: "#b83232",
    cancelButtonColor: "#16324f"
  }).then(async function (resultado) {
    if (resultado.isConfirmed) {
      const r = await pedir(url, "POST", "id=" + encodeURIComponent(id))
      mensaje(r, despues)
    }
  })
}

function buscarTabla() {
  const texto = document.getElementById("buscar").value.toLowerCase()
  const filas = document.querySelectorAll("tbody tr")
  filas.forEach(function (fila) {
    const contenido = fila.innerText.toLowerCase()
    fila.style.display = contenido.includes(texto) ? "" : "none"
  })
}

function imprimirPagina() {
  window.print()
}

function tomarId() {
  return new URLSearchParams(location.search).get("id") || ""
}

function llenarFormulario(formulario, datos) {
  Object.keys(datos).forEach(function (campo) {
    if (formulario[campo]) formulario[campo].value = datos[campo]
  })
}

document.addEventListener("DOMContentLoaded", function () {
  ponerMenu()
  ponerFooter()
})
