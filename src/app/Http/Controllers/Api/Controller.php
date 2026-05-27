<?php

namespace App\Http\Controllers\Api;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "API ProviEmplea",
    version: "1.0.0",
    description: "API REST para la gestión de talentos en ProviEmplea"
)]
#[OA\Server(
    url: "http://localhost:8080/api",
    description: "Servidor de desarrollo"
)]
abstract class Controller
{
    // Clase base necesaria para las anotaciones globales
}
