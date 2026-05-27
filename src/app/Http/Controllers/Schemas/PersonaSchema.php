<?php

namespace App\Http\Controllers\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="Persona",
 * title="Persona",
 * description="Modelo completo de persona/talento",
 * required={"email", "codigo_talento"}
 * )
 */
class PersonaSchema
{
    /** @OA\Property(property="id",                  type="integer", example=1) */
    public int $id;
    /** @OA\Property(property="email",               type="string",  format="email",  example="juan@example.com") */
    public string $email;
    /** @OA\Property(property="telefono",            type="string",  example="+56912345678", nullable=true) */
    public ?string $telefono;
    /** @OA\Property(property="codigo_talento",      type="string",  example="PROV-2026-A1B2") */
    public string $codigo_talento;
    /** @OA\Property(property="resumen",             type="string",  nullable=true) */
    public ?string $resumen;
    /** @OA\Property(property="nivel_educacional",   type="string",  enum={"basica","media","tecnica","universitaria","postgrado"}, nullable=true) */
    public ?string $nivel_educacional;
    /** @OA\Property(property="titulo_carrera",      type="string",  example="Ingeniero en Informática", nullable=true) */
    public ?string $titulo_carrera;
    /** @OA\Property(property="año_egreso",          type="integer", example=2019, nullable=true) */
    public ?int $año_egreso;
    /** @OA\Property(property="años_experiencia",    type="integer", example=5) */
    public int $años_experiencia;
    /**
     * @OA\Property(property="areas_experiencia", type="array",
     * @OA\Items(type="string"), example={"Desarrollo Web", "APIs REST"}, nullable=true)
     */
    public ?array $areas_experiencia;
    /**
     * @OA\Property(property="competencias", type="array",
     * @OA\Items(type="string"), example={"PHP", "Laravel", "MySQL"}, nullable=true)
     */
    public ?array $competencias;
    /** @OA\Property(property="rango_renta",  type="string", example="800k-1.2M", nullable=true) */
    public ?string $rango_renta;
    /** @OA\Property(property="tipo_jornada", type="string", enum={"completa","part-time","por-horas"}, nullable=true) */
    public ?string $tipo_jornada;
    /** @OA\Property(property="modalidad",    type="string", enum={"presencial","remoto","hibrido"}, nullable=true) */
    public ?string $modalidad;
    /**
     * @OA\Property(property="cursos", type="array", nullable=true,
     * @OA\Items(type="object",
     * @OA\Property(property="nombre",      type="string"),
     * @OA\Property(property="institucion", type="string"),
     * @OA\Property(property="año",         type="integer")
     * )
     * )
     */
    public ?array $cursos;
    /**
     * @OA\Property(property="idiomas", type="array", nullable=true,
     * @OA\Items(type="object",
     * @OA\Property(property="idioma", type="string"),
     * @OA\Property(property="nivel",  type="string", enum={"basico","intermedio","avanzado","nativo"})
     * )
     * )
     */
    public ?array $idiomas;
    /** @OA\Property(property="portafolio_url",       type="string",  format="url",   nullable=true) */
    public ?string $portafolio_url;
    /** @OA\Property(property="persona_discapacidad", type="boolean", example=false) */
    public bool $persona_discapacidad;
    /** @OA\Property(property="validado",             type="boolean", example=false) */
    public bool $validado;
    /** @OA\Property(property="activo",               type="boolean", example=true) */
    public bool $activo;
    /** @OA\Property(property="porcentaje_completitud", type="integer", example=85) */
    public int $porcentaje_completitud;
    /** @OA\Property(property="created_at", type="string", format="date-time") */
    public string $created_at;
    /** @OA\Property(property="updated_at", type="string", format="date-time") */
    public string $updated_at;
}

