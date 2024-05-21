<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="UFT-8">
        <meta name="viewport" content="device-width, initial-scale=1.0">
        <title>ForoVideoJuegos</title>
        <link rel = "stylesheet" type = "text/css" href = "foroVideoJuegos.css" />
        <link rel="icon" href="principal.png">
    </head>
    <body>
        <header>
            <div class="header_content">
                <div class="imagen_principal">
                    <img src="principal.png" alt="">
                </div>
                <div class="logo">
                    <h1>Foro<b>VideoJuegos</b></h1>
                </div>
            </div>
        </header>
        <main>
            <div class="container">
                <form action="buscar.php" method="post" class="barra-busqueda">
                    <input type="text" placeholder="¿Que videojuego estas buscando?" name="nombreJuego">
                    <button type="submit"><img src="search-icon.png"></button>
                </form>
            </div>
        </main>
    </body>
</html>
