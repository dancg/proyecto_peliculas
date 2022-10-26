<?php

namespace App\Service;

use App\Modelos\Pelicula;

//ponemos la barra delante de Dotenv ya que no es un documento que pertenezca a mi namespacegit init
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__."/../../");
$dotenv->load();

//require __DIR__."/../../vendor/autoload.php";

//define('URL', 'https://api.themoviedb.org/3/movie/popular?api_key=58de7b9ec74ed6ce297ecc21b3d2fbb2&language=en-US&page=1');
//define("IMG", "https://image.tmdb.org/t/p/w500");
define("URL", $_ENV['URL_BASE'].$_ENV['KEY']);
//die(URL);
define("IMG", $_ENV['URL_IMG']);
//die(IMG);
class ApiService
{
    public function getPeliculas()
    {
        $peliculas = [];
        $datos = file_get_contents(URL);
        //Transformar en Json
        $datosJson = json_decode($datos);
        $datosPelis = $datosJson->results;
        foreach ($datosPelis as $objPelicula) {
            $peliculas[] = (new Pelicula)->setTitulo($objPelicula->title)
                ->setResumen($objPelicula->overview)
                ->setPoster(IMG . $objPelicula->poster_path)
                ->setFecha($objPelicula->release_date)
                ->setCaratula(IMG . $objPelicula->backdrop_path);
        }
        // echo "<pre>";
        // var_dump($peliculas);
        // echo "</pre>";
        return $peliculas;
    }
}
//Esto sirve para ver lo que metemos sin crear main ni nada
(new ApiService())->getPeliculas();
