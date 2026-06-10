const http = require("http")
const fs = require("fs")
const path = require("path")
const { spawn } = require("child_process")

const puerto = 3000
const carpeta = __dirname

const rutas = {
  "/": "pages/index.html",
  "/libros": "pages/libros.html",
  "/lista-libros": "pages/lista-libros.html",
  "/autores": "pages/autores.html",
  "/lista-autores": "pages/lista-autores.html",
  "/usuarios": "pages/usuarios.html",
  "/lista-usuarios": "pages/lista-usuarios.html",
  "/prestamos": "pages/prestamos.html",
  "/lista-prestamos": "pages/lista-prestamos.html",
  "/manual": "pages/manual.html"
}

function tipoArchivo(archivo) {
  if (archivo.endsWith(".html")) return "text/html"
  if (archivo.endsWith(".css")) return "text/css"
  if (archivo.endsWith(".js")) return "text/javascript"
  if (archivo.endsWith(".jpg")) return "image/jpeg"
  if (archivo.endsWith(".png")) return "image/png"
  if (archivo.endsWith(".woff")) return "font/woff"
  if (archivo.endsWith(".woff2")) return "font/woff2"
  return "text/plain"
}

function enviarArchivo(res, archivo) {
  fs.readFile(archivo, function (error, datos) {
    if (error) {
      res.writeHead(404, { "Content-Type": "text/plain" })
      res.end("Archivo no encontrado")
    } else {
      res.writeHead(200, { "Content-Type": tipoArchivo(archivo) })
      res.end(datos)
    }
  })
}

function ejecutarPhp(req, res, archivoPhp, cuerpo) {
  const php = spawn("php", [archivoPhp], {
    env: {
      ...process.env,
      REQUEST_METHOD: req.method,
      QUERY_STRING: new URL(req.url, "http://localhost").searchParams.toString()
    }
  })

  let salida = ""
  let error = ""

  php.stdout.on("data", function (datos) {
    salida += datos.toString()
  })

  php.stderr.on("data", function (datos) {
    error += datos.toString()
  })

  php.on("close", function () {
    if (error) {
      res.writeHead(500, { "Content-Type": "application/json" })
      res.end(JSON.stringify({ ok: false, mensaje: "Error en PHP", error: error }))
    } else {
      res.writeHead(200, { "Content-Type": "application/json" })
      res.end(salida)
    }
  })

  php.stdin.write(cuerpo)
  php.stdin.end()
}

const servidor = http.createServer(function (req, res) {
  const url = new URL(req.url, "http://localhost")
  const ruta = url.pathname

  if (ruta.startsWith("/php/") && ruta.endsWith(".php")) {
    const archivoPhp = path.join(carpeta, ruta)
    let cuerpo = ""
    req.on("data", function (parte) {
      cuerpo += parte.toString()
    })
    req.on("end", function () {
      ejecutarPhp(req, res, archivoPhp, cuerpo)
    })
    return
  }

  if (rutas[ruta]) {
    enviarArchivo(res, path.join(carpeta, rutas[ruta]))
    return
  }

  enviarArchivo(res, path.join(carpeta, ruta))
})

servidor.listen(puerto, function () {
  console.log("Biblioteca funcionando en http://localhost:" + puerto)
})
