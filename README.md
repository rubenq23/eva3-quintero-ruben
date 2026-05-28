# eva3_quintero_ruben

Flujo para testear Modulo Personas en Swagger UI

1.	Registrar un nuevo talento
 POST /v1/personas, requiere un request body:
{
  "email": "rubenquintero@ejemplo.cl",
  "nombre": "Ruben",
  "apellido": "Quintero",
  "nivel_educacional": "universitaria"
}
El sistema generará automáticamente un id (UUID) y un codigo_talento único.

2.	Consultar listado de talentos 
GET /v1/personas, permite visualizar todos los talentos registrados y confirma que el perfil creado en el paso anterior aparece en la lista.

3.	Obtener detalle de un talento 
GET /v1/personas/{id}, consulta los datos específicos de un talento utilizando el UUID obtenido en el paso 1.

4.	Actualizar información del talento 
PATCH /v1/personas/{id}, requiere id generado en el paso 1 al registrar a la persona (talento) y requiere un request body donde se actualizarán los datos, ejemplo de datos a modificar:

{
  "email": "talento@ejemplo.cl",
  "nombre": "Juan",
  "apellido": "Pérez",
  "nivel_educacional": "universitaria"
}
5.	Gestión de estado (Validación)
PATCH /v1/personas/{id}/Validar, este endpoint es crítico para la lógica de negocio ya que solo los talentos validados son considerados en los procesos de contacto. Requiere id de la persona y de estar correcto cambia su estado “validado” : true.

6.	Eliminar un talento
DELETE /v1/personas/{id}, Elimina un perfil del sistema si es necesario.

Flujo para testear Modulo Empresa en Swagger UI

1. Registrar una nueva empresa
POST /v1/empresas Crea el perfil de la empresa en el sistema, requiere request body:
{
  "nombre_empresa": "string",
  "rut_empresa": "string",
  "email": "user@example.com",
  "tipo_empresa": "contratacion-directa",
  "contacto_nombre": "string",
  "contacto_email": "user@example.com",
  "contacto_telefono": "string",
  "rubro": "string",
  "presentacion": "string"
}
Valores aceptados en el campo tipo_empresa (contratacion-directa,est,outsourcing), el sistema registrará la empresa con estado activo: true y validado: false por defecto.

2. Consultar listado de empresas
GET /v1/empresas Obtén la lista completa de empresas registradas. Verifica que la empresa creada en el paso anterior aparezca en el listado.

3. Consultar detalle de empresa
GET /v1/empresas/{id} Consulta los datos específicos de una empresa utilizando su UUID.

4. Actualizar información corporativa
PATCH /v1/empresas/{id} Permite editar campos como la presentación o los beneficios ofrecidos. Requiere el id de la empresa y en el request body se escriben los cambios (actualización), ejemplo: 
{
  "presentacion": "Empresa enfocada en innovación y soluciones cloud.",
  "beneficios": ["Seguro dental", "Work from home"]
}

5. Gestión de estado (Validación)
PATCH /v1/empresas/{id}/validar Este es un paso crítico. Solo las empresas validadas deben ser visibles o aptas para solicitar contacto con talentos. Tras ejecutar este método, el campo validado debe cambiar a true

6. Eliminar una empresa
DELETE /v1/empresas/{id} Elimina el registro de la empresa de la plataforma si ya no es necesaria.


Flujo para testear Modulo Administracion en Swagger UI

1.	Pre-requisito tener una persona y una empresa creada, a través de /v1/personas y /v1/empresas respectivamente.

2.	Crear la solicitud de contacto 
POST /v1/admin/contactos
Esta lleva Request body:
{
  "empresa_id": "string",
  "persona_id": "string",
  "notas_admin": "string"
}
3.	Verificar lista de contactos realizados entre persona y empresa 
GET /v1/admin/contactos

4.	Actualizar el estado de la solicitud de contacto 
PATCH /v1/admin/contactos/{id}/estado
Este requiere el id del contacto y un request body:
{
  "estado": "seleccionado",
  "notas_admin": "string"
}
Valores aceptados
'pendiente', 'contactado', 'entrevista', 'seleccionado', 'no-seleccionado', 'proceso-cerrado'
5.	Consultar las estadísticas 
GET /v1/admin/estadisticas para reflejar la actividad de las solicitudes de contacto
