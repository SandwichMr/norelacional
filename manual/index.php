<?php
$titulo = "Manual de Usuario";
$nivel = "../";
include "../includes/header.php";
?>

<section class="manual-bloque text-center">
  <img src="../public/img/img9.jpg" class="manual-img mb-3" alt="Portada">
  <h1 class="titulo-seccion">Manual de Usuario</h1>
  <h3>Proyecto Biblioteca Juvenil</h3>
  <p><strong>Alumno:</strong> Nombre del alumno</p>
  <p><strong>Modulo:</strong> Desarrollo de aplicaciones web</p>
  <p><strong>Semestre:</strong> Sexto semestre</p>
  <p><strong>Fecha:</strong> 9 de junio de 2026</p>
</section>

<section class="manual-bloque">
  <h2 class="titulo-seccion">Indice</h2>
  <ol>
    <li>Proposito del sistema</li>
    <li>Tecnologias utilizadas</li>
    <li>Como ejecutar el sistema</li>
    <li>Configuracion necesaria</li>
    <li>Colecciones de MongoDB</li>
    <li>Referencias con ObjectId</li>
    <li>Relaciones con aggregate y lookup</li>
    <li>Uso paso a paso</li>
    <li>CRUD paso a paso</li>
    <li>Validaciones y errores</li>
  </ol>
</section>

<section class="manual-bloque">
  <h2 class="titulo-seccion">Proposito del sistema</h2>
  <p>Biblioteca Juvenil es un sistema web basico para una biblioteca escolar pequena. Sirve para registrar autores, libros, usuarios y prestamos. Tambien permite consultar datos en tablas, editar registros, actualizar informacion, eliminar registros e imprimir listas.</p>
  <img src="../public/img/img10.jpg" class="manual-img" alt="Sistema">
</section>

<section class="manual-bloque">
  <h2 class="titulo-seccion">Tecnologias utilizadas</h2>
  <p>El sistema utiliza HTML, CSS, Bootstrap local, Bootstrap Icons local, JavaScript basico, SweetAlert local, PHP, Apache, MongoDB y el driver MongoDB de PHP. No usa npm, Node, Express, login, sesiones, tokens, contrasenas ni seguridad avanzada.</p>
  <div class="row g-3">
    <div class="col-md-4"><img src="../public/img/img11.jpg" class="manual-img" alt="Tecnologia"></div>
    <div class="col-md-4"><img src="../public/img/img12.jpg" class="manual-img" alt="Tecnologia"></div>
    <div class="col-md-4"><img src="../public/img/img13.jpg" class="manual-img" alt="Tecnologia"></div>
  </div>
</section>

<section class="manual-bloque">
  <h2 class="titulo-seccion">Como ejecutar el sistema</h2>
  <p>Primero se debe tener Apache, PHP, la extension mongodb de PHP y MongoDB encendido. Despues se coloca la carpeta biblioteca_juvenil dentro de la carpeta publica de Apache y se abre en el navegador.</p>
  <pre class="bg-light p-3 rounded">http://localhost/biblioteca_juvenil/</pre>
</section>

<section class="manual-bloque">
  <h2 class="titulo-seccion">Configuracion necesaria</h2>
  <p>La base de datos se llama biblioteca_juvenil. La conexion esta en includes/db.php y usa mongodb://127.0.0.1:27017. Las paginas estan separadas por carpetas. Los archivos publicos estan en public.</p>
</section>

<section class="manual-bloque">
  <h2 class="titulo-seccion">Colecciones de MongoDB</h2>
  <ul>
    <li><strong>autores:</strong> _id, nombre, nacionalidad, correo.</li>
    <li><strong>libros:</strong> _id, titulo, genero, anio, autorId.</li>
    <li><strong>usuarios:</strong> _id, nombre, telefono, correo, grupo.</li>
    <li><strong>prestamos:</strong> _id, libroId, usuarioId, fechaPrestamo, fechaEntrega, estado.</li>
  </ul>
  <img src="../public/img/img14.jpg" class="manual-img" alt="Colecciones">
</section>

<section class="manual-bloque">
  <h2 class="titulo-seccion">Referencias con ObjectId</h2>
  <p>MongoDB crea un campo _id para cada documento. En este sistema, libroId, usuarioId y autorId guardan ObjectId para relacionar registros. Un libro guarda autorId para saber quien es su autor. Un prestamo guarda libroId y usuarioId para saber que libro se presto y a que usuario.</p>
</section>

<section class="manual-bloque">
  <h2 class="titulo-seccion">Relaciones con aggregate, $lookup, $unwind y $project</h2>
  <p>En la lista de prestamos se usa aggregate(). Dentro de la consulta se usa $lookup para unir prestamos con libros y usuarios. Despues $unwind convierte los arreglos relacionados en objetos sencillos. Al final $project muestra solo los campos importantes: nombre del usuario, titulo del libro, fechas y estado.</p>
  <pre class="bg-light p-3 rounded">$lookup une colecciones
$unwind acomoda los resultados
$project selecciona los campos a mostrar</pre>
</section>

<section class="manual-bloque">
  <h2 class="titulo-seccion">Explicacion de estilos</h2>
  <p>El diseno usa azul oscuro, blanco, beige, cafe claro y dorado. Las tarjetas, formularios centrados, tablas claras e iconos ayudan a que el sistema se vea ordenado.</p>
  <div class="row g-3">
    <div class="col-md-6"><img src="../public/img/img15.jpg" class="manual-img" alt="Estilos"></div>
    <div class="col-md-6"><img src="../public/img/img16.jpg" class="manual-img" alt="Estilos"></div>
  </div>
</section>

<section class="manual-bloque">
  <h2 class="titulo-seccion">Uso del sistema paso a paso</h2>
  <ol>
    <li>Entrar a la pagina principal.</li>
    <li>Usar la barra de navegacion para elegir libros, autores, usuarios o prestamos.</li>
    <li>Entrar a Registrar para llenar un formulario.</li>
    <li>Entrar a Lista para ver la tabla de datos.</li>
    <li>Usar el boton de busqueda para encontrar registros.</li>
    <li>Usar editar, eliminar o imprimir segun se necesite.</li>
  </ol>
  <div class="row g-3">
    <div class="col-md-4"><img src="../public/img/img17.jpg" class="manual-img" alt="Captura"></div>
    <div class="col-md-4"><img src="../public/img/img18.jpg" class="manual-img" alt="Captura"></div>
    <div class="col-md-4"><img src="../public/img/img19.jpg" class="manual-img" alt="Captura"></div>
  </div>
</section>

<section class="manual-bloque">
  <h2 class="titulo-seccion">CRUD paso a paso</h2>
  <p><strong>Crear:</strong> llenar un formulario y presionar Guardar.</p>
  <p><strong>Mostrar:</strong> entrar a la pagina de lista para ver la tabla.</p>
  <p><strong>Editar:</strong> presionar el boton del lapiz, cambiar los datos y guardar.</p>
  <p><strong>Actualizar:</strong> el formulario de edicion envia los datos a PHP y MongoDB cambia el documento.</p>
  <p><strong>Eliminar:</strong> presionar el boton de basura y confirmar con SweetAlert.</p>
  <img src="../public/img/img20.jpg" class="manual-img" alt="CRUD">
</section>

<section class="manual-bloque">
  <h2 class="titulo-seccion">Validaciones y manejo de errores</h2>
  <p>Los formularios tienen campos required para evitar datos vacios. Los correos usan type="email". El telefono usa pattern y maxlength para capturar 10 numeros. SweetAlert muestra mensajes de exito, error y confirmacion antes de eliminar.</p>
</section>

<?php include "../includes/footer.php"; ?>
