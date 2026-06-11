const express = require("express")
const path = require("path")
const { MongoClient, ObjectId } = require("mongodb")

const app = express()
const puerto = 3000
const cliente = new MongoClient("mongodb://127.0.0.1:27017")
let db

function textoIgual(texto) {
  const limpio = String(texto).replace(/[.*+?^${}()|[\]\\]/g, "\\$&")
  return new RegExp("^" + limpio + "$", "i")
}

async function existeDuplicado(coleccion, filtro, id) {
  if (id) {
    filtro._id = { $ne: new ObjectId(id) }
  }
  const encontrado = await db.collection(coleccion).findOne(filtro)
  return encontrado != null
}

app.use(express.urlencoded({ extended: true }))
app.use(express.json())
app.use("/public", express.static(path.join(__dirname, "public")))

app.get("/", function (req, res) {
  res.sendFile(path.join(__dirname, "pages/index.html"))
})

app.get("/libros", function (req, res) {
  res.sendFile(path.join(__dirname, "pages/libros.html"))
})

app.get("/lista-libros", function (req, res) {
  res.sendFile(path.join(__dirname, "pages/lista-libros.html"))
})

app.get("/autores", function (req, res) {
  res.sendFile(path.join(__dirname, "pages/autores.html"))
})

app.get("/lista-autores", function (req, res) {
  res.sendFile(path.join(__dirname, "pages/lista-autores.html"))
})

app.get("/usuarios", function (req, res) {
  res.sendFile(path.join(__dirname, "pages/usuarios.html"))
})

app.get("/lista-usuarios", function (req, res) {
  res.sendFile(path.join(__dirname, "pages/lista-usuarios.html"))
})

app.get("/prestamos", function (req, res) {
  res.sendFile(path.join(__dirname, "pages/prestamos.html"))
})

app.get("/lista-prestamos", function (req, res) {
  res.sendFile(path.join(__dirname, "pages/lista-prestamos.html"))
})

app.get("/manual", function (req, res) {
  res.sendFile(path.join(__dirname, "pages/manual.html"))
})

app.get("/api/autores/listar", async function (req, res) {
  try {
    const datos = await db.collection("autores").find().toArray()
    res.json({ ok: true, datos: datos })
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudieron cargar los autores" })
  }
})

app.get("/api/autores/obtener/:id", async function (req, res) {
  try {
    const dato = await db.collection("autores").findOne({ _id: new ObjectId(req.params.id) })
    res.json({ ok: true, dato: dato })
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudo cargar el autor" })
  }
})

app.post("/api/autores/guardar", async function (req, res) {
  try {
    const datos = {
      nombre: req.body.nombre,
      nacionalidad: req.body.nacionalidad,
      correo: req.body.correo
    }
    const duplicado = await existeDuplicado("autores", {
      $or: [
        { nombre: textoIgual(req.body.nombre) },
        { correo: textoIgual(req.body.correo) }
      ]
    }, req.body.id)
    if (duplicado) {
      res.json({ ok: false, tipo: "warning", mensaje: "Ya existe un autor con ese nombre o correo" })
      return
    }
    if (req.body.id) {
      await db.collection("autores").updateOne({ _id: new ObjectId(req.body.id) }, { $set: datos })
      res.json({ ok: true, mensaje: "Autor actualizado correctamente" })
    } else {
      await db.collection("autores").insertOne(datos)
      res.json({ ok: true, mensaje: "Autor guardado correctamente" })
    }
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudo guardar el autor" })
  }
})

app.post("/api/autores/eliminar", async function (req, res) {
  try {
    const resultado = await db.collection("autores").deleteOne({ _id: new ObjectId(req.body.id) })
    if (resultado.deletedCount == 0) {
      res.json({ ok: false, tipo: "warning", mensaje: "El autor ya no existe o ya fue eliminado" })
    } else {
      res.json({ ok: true, mensaje: "Autor eliminado correctamente" })
    }
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudo eliminar el autor" })
  }
})

app.get("/api/libros/listar", async function (req, res) {
  try {
    const datos = await db.collection("libros").aggregate([
      { $lookup: { from: "autores", localField: "autorId", foreignField: "_id", as: "autor" } },
      { $unwind: { path: "$autor", preserveNullAndEmptyArrays: true } },
      { $project: { titulo: 1, genero: 1, anio: 1, autorId: 1, autorNombre: "$autor.nombre" } }
    ]).toArray()
    res.json({ ok: true, datos: datos })
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudieron cargar los libros" })
  }
})

app.get("/api/libros/obtener/:id", async function (req, res) {
  try {
    const dato = await db.collection("libros").findOne({ _id: new ObjectId(req.params.id) })
    res.json({ ok: true, dato: dato })
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudo cargar el libro" })
  }
})

app.post("/api/libros/guardar", async function (req, res) {
  try {
    const datos = {
      titulo: req.body.titulo,
      genero: req.body.genero,
      anio: Number(req.body.anio),
      autorId: new ObjectId(req.body.autorId)
    }
    const duplicado = await existeDuplicado("libros", {
      titulo: textoIgual(req.body.titulo)
    }, req.body.id)
    if (duplicado) {
      res.json({ ok: false, tipo: "warning", mensaje: "Ya existe un libro con ese titulo" })
      return
    }
    if (req.body.id) {
      await db.collection("libros").updateOne({ _id: new ObjectId(req.body.id) }, { $set: datos })
      res.json({ ok: true, mensaje: "Libro actualizado correctamente" })
    } else {
      await db.collection("libros").insertOne(datos)
      res.json({ ok: true, mensaje: "Libro guardado correctamente" })
    }
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudo guardar el libro" })
  }
})

app.post("/api/libros/eliminar", async function (req, res) {
  try {
    const resultado = await db.collection("libros").deleteOne({ _id: new ObjectId(req.body.id) })
    if (resultado.deletedCount == 0) {
      res.json({ ok: false, tipo: "warning", mensaje: "El libro ya no existe o ya fue eliminado" })
    } else {
      res.json({ ok: true, mensaje: "Libro eliminado correctamente" })
    }
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudo eliminar el libro" })
  }
})

app.get("/api/usuarios/listar", async function (req, res) {
  try {
    const datos = await db.collection("usuarios").find().toArray()
    res.json({ ok: true, datos: datos })
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudieron cargar los usuarios" })
  }
})

app.get("/api/usuarios/obtener/:id", async function (req, res) {
  try {
    const dato = await db.collection("usuarios").findOne({ _id: new ObjectId(req.params.id) })
    res.json({ ok: true, dato: dato })
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudo cargar el usuario" })
  }
})

app.post("/api/usuarios/guardar", async function (req, res) {
  try {
    const datos = {
      nombre: req.body.nombre,
      telefono: req.body.telefono,
      correo: req.body.correo,
      grupo: req.body.grupo
    }
    const duplicado = await existeDuplicado("usuarios", {
      $or: [
        { correo: textoIgual(req.body.correo) },
        { telefono: req.body.telefono }
      ]
    }, req.body.id)
    if (duplicado) {
      res.json({ ok: false, tipo: "warning", mensaje: "Ya existe un usuario con ese correo o telefono" })
      return
    }
    if (req.body.id) {
      await db.collection("usuarios").updateOne({ _id: new ObjectId(req.body.id) }, { $set: datos })
      res.json({ ok: true, mensaje: "Usuario actualizado correctamente" })
    } else {
      await db.collection("usuarios").insertOne(datos)
      res.json({ ok: true, mensaje: "Usuario guardado correctamente" })
    }
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudo guardar el usuario" })
  }
})

app.post("/api/usuarios/eliminar", async function (req, res) {
  try {
    const resultado = await db.collection("usuarios").deleteOne({ _id: new ObjectId(req.body.id) })
    if (resultado.deletedCount == 0) {
      res.json({ ok: false, tipo: "warning", mensaje: "El usuario ya no existe o ya fue eliminado" })
    } else {
      res.json({ ok: true, mensaje: "Usuario eliminado correctamente" })
    }
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudo eliminar el usuario" })
  }
})

app.get("/api/prestamos/listar", async function (req, res) {
  try {
    const datos = await db.collection("prestamos").aggregate([
      { $lookup: { from: "libros", localField: "libroId", foreignField: "_id", as: "libro" } },
      { $lookup: { from: "usuarios", localField: "usuarioId", foreignField: "_id", as: "usuario" } },
      { $unwind: "$libro" },
      { $unwind: "$usuario" },
      {
        $project: {
          libroId: 1,
          usuarioId: 1,
          nombreUsuario: "$usuario.nombre",
          tituloLibro: "$libro.titulo",
          fechaPrestamo: 1,
          fechaEntrega: 1,
          estado: 1
        }
      }
    ]).toArray()
    res.json({ ok: true, datos: datos })
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudieron cargar los prestamos" })
  }
})

app.get("/api/prestamos/obtener/:id", async function (req, res) {
  try {
    const dato = await db.collection("prestamos").findOne({ _id: new ObjectId(req.params.id) })
    res.json({ ok: true, dato: dato })
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudo cargar el prestamo" })
  }
})

app.post("/api/prestamos/guardar", async function (req, res) {
  try {
    const datos = {
      libroId: new ObjectId(req.body.libroId),
      usuarioId: new ObjectId(req.body.usuarioId),
      fechaPrestamo: req.body.fechaPrestamo,
      fechaEntrega: req.body.fechaEntrega,
      estado: req.body.estado
    }
    const duplicado = await existeDuplicado("prestamos", {
      libroId: datos.libroId,
      usuarioId: datos.usuarioId,
      fechaPrestamo: req.body.fechaPrestamo
    }, req.body.id)
    if (duplicado) {
      res.json({ ok: false, tipo: "warning", mensaje: "Ya existe un prestamo igual para ese libro, usuario y fecha" })
      return
    }
    if (req.body.id) {
      await db.collection("prestamos").updateOne({ _id: new ObjectId(req.body.id) }, { $set: datos })
      res.json({ ok: true, mensaje: "Prestamo actualizado correctamente" })
    } else {
      await db.collection("prestamos").insertOne(datos)
      res.json({ ok: true, mensaje: "Prestamo guardado correctamente" })
    }
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudo guardar el prestamo" })
  }
})

app.post("/api/prestamos/eliminar", async function (req, res) {
  try {
    const resultado = await db.collection("prestamos").deleteOne({ _id: new ObjectId(req.body.id) })
    if (resultado.deletedCount == 0) {
      res.json({ ok: false, tipo: "warning", mensaje: "El prestamo ya no existe o ya fue eliminado" })
    } else {
      res.json({ ok: true, mensaje: "Prestamo eliminado correctamente" })
    }
  } catch (error) {
    res.json({ ok: false, mensaje: "No se pudo eliminar el prestamo" })
  }
})

async function iniciar() {
  await cliente.connect()
  db = cliente.db("biblioteca_juvenil")
  app.listen(puerto, function () {
    console.log("Biblioteca funcionando en http://localhost:" + puerto)
  })
}

iniciar()
