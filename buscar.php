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
            <div class="salidaPHP">
                <?php
                    
                        // Reemplaza "tu_api_key_rawg" con tu clave API de RAWG y "tu_api_key_gb" con tu clave API de Giant Bomb.
                        $apiKeyRawg = "3ecf3c577ea14c87b4649044a320d926";
                        $apiKeyGiantBomb = "9a12fa5afef801ffcba02f56c2f51eff86104446";
                        $nombreJuego = $_POST['nombreJuego'];

                        // Inicializamos cURL.
                        $ch = curl_init();

                        // Configuramos la petición para la API de RAWG.
                        curl_setopt($ch, CURLOPT_URL, "https://api.rawg.io/api/games?key=$apiKeyRawg&search=$nombreJuego");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                        // Realizamos la petición a RAWG.
                        $rawg_response = curl_exec($ch);
                        $rawg_data = json_decode($rawg_response);

                        // Verificamos si se encontraron juegos.
                        if ($rawg_data && count($rawg_data->results) > 0) {
                            // Recorremos los resultados.
                            foreach ($rawg_data->results as $game) {
                                echo "Nombre del juego: ".$game->name."<br>";

                                // Configuramos la petición para la API de Giant Bomb.
                                curl_setopt($ch, CURLOPT_URL, "https://www.giantbomb.com/api/search/?api_key=$apiKeyGiantBomb&format=json&query=\"$game->name\"&resources=game");
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-Agent: MyApp (email@address.com)"));

                                // Realizamos la petición a Giant Bomb.
                                $giantbomb_response = curl_exec($ch);
                                $giantbomb_data = json_decode($giantbomb_response);

                                // Verificamos si se encontraron juegos.
                                if ($giantbomb_data && count($giantbomb_data->results) > 0) {
                                    // Mostramos las plataformas del primer juego que coincide.
                                    $platforms = array_map(function($platform) { return $platform->name; }, $giantbomb_data->results[0]->platforms);
                                    echo "Plataformas: ".implode(", ", $platforms)."<br>";
                                } else {
                                    echo "PC<br>";
                                }

                                echo "<hr>";
                            }
                        } else {
                            echo "No se encontraron juegos.";
                        }

                        curl_close($ch);

                ?>
                    <h1 style="padding: 3%;">Videos recomendados de los videojuegos mencionados arriba</h1>
                <?php

                        // Replace "tu_clave_api_youtube" with your actual YouTube API Key
                            $apiKeyYoutube = "AIzaSyCT21uskFxi-dLOOv7TGmU3qMfXGSmqQDc";

                            foreach ($rawg_data->results as $game) {
                                $query = urlencode("$game->name trailer");  // Añade "trailer" a la búsqueda
                                curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/youtube/v3/search?part=snippet&q=$query&maxResults=1&key=$apiKeyYoutube");
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            
                                $youtube_response = curl_exec($ch);
                                $youtube_data = json_decode($youtube_response);
                            
                                if ($youtube_data && isset($youtube_data->items) && count($youtube_data->items) > 0) {
                                    echo "Nombre del juego: ".$game->name."<br>";
                                    $item = $youtube_data->items[0];
                                    if (isset($item->id->videoId)) {
                                        $videoId = $item->id->videoId;
                                        echo "Trailer relacionado: <a href=\"https://www.youtube.com/watch?v=$videoId\">https://www.youtube.com/watch?v=$videoId</a><br>";
                                    }
                                }
                            }


                ?>
            </div>
        </main>
    </body>
</html>
