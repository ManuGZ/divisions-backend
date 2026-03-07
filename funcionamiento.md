# Documentación de Funcionamiento de las APIs

## Endpoints Disponibles

### 1. **Obtener Divisiones**
**URL:** `/api/divisions`  
**Método:** `GET`  
**Descripción:** Devuelve todas las divisiones registradas en la base de datos.  
**Respuesta:**
```json
[
    {
        "id": 1,
        "name": "Division Principal",
        "parent_id": null,
        "level": 1,
        "collaborators_count": 10,
        "ambassador_name": "John Doe",
        "created_at": "2026-03-06T19:18:35.000000Z",
        "updated_at": "2026-03-06T19:18:37.000000Z",
        "superior_division": "Logisticas",
        "children": [
            {
                "id": 316,
                "name": "Balistreri Group",
                "parent_id": 1,
                "level": 10,
                "collaborators_count": 23,
                "ambassador_name": "Dr. Green Hettinger",
                "created_at": "2026-03-07T02:27:35.000000Z",
                "updated_at": "2026-03-07T02:27:37.000000Z",
                "superior_division": "Logisticas"
            },
        ]
    }
]
```

### 2. **Crear División**
**URL:** `/api/divisions`  
**Método:** `POST`  
**Descripción:** Crea una nueva división en la base de datos.  
**Cuerpo de la Solicitud:**
```json
{
    "name": "Nueva División",
    "parent_id": null,
    "ambassador_name": "Jane Doe",
    "superior_division": "Recursos Humanos"
}
```
**Respuesta:**
```json
{
    "id": 101,
    "name": "Nueva División",
    "parent_id": null,
    "level": 1,
    "collaborators_count": 15,
    "ambassador_name": "Jane Doe",
    "superior_division": "Recursos Humanos",
    "created_at": "2026-03-06T19:18:35.000000Z",
    "updated_at": "2026-03-06T19:18:37.000000Z"
}
```

### 3. **Actualizar División**
**URL:** `/api/divisions/{id}`  
**Método:** `PUT`  
**Descripción:** Actualiza los datos de una división existente.  
**Parámetros:**
- `id` (requerido): ID de la división a actualizar.  
**Cuerpo de la Solicitud:**
```json
{
    "name": "División Actualizada",
    "collaborators_count": 20,
    "superior_division": "Finanzas"
}
```
**Respuesta:**
```json
{
    "id": 101,
    "name": "División Actualizada",
    "parent_id": null,
    "level": 1,
    "collaborators_count": 20,
    "ambassador_name": "Jane Doe",
    "superior_division": "Finanzas",
    "created_at": "2026-03-06T19:18:35.000000Z",
    "updated_at": "2026-03-06T19:20:00.000000Z"
}
```

### 4. **Obtener Subdivisiones de una División**
**URL:** `/api/divisions/{id}/subdivisions`  
**Método:** `GET`  
**Descripción:** Devuelve las subdivisiones asociadas a una división específica.  
**Parámetros:**
- `id` (requerido): ID de la división principal.  
**Respuesta:**
```json
[
    {
        "id": 2,
        "name": "Subdivisión 1",
        "parent_id": 1,
        "level": 2,
        "collaborators_count": 5,
        "ambassador_name": "Jane Doe",
        "created_at": "2026-03-06T19:18:35.000000Z",
        "updated_at": "2026-03-06T19:18:37.000000Z",
        "superior_division": "Seguridad"
    }
]
```

### 5. **Reiniciar y Poblar Divisiones**
**URL:** `/api/seed-divisions`  
**Método:** `POST`  
**Descripción:** Elimina los datos existentes en la tabla `divisions` y la repuebla utilizando el seeder `DivisionSeeder`.  
**Respuesta:**
- Éxito:
```json
{
    "message": "Divisions reseeded successfully"
}
```
- Error:
```json
{
    "error": "Descripción del error"
}
```

## Funcionamiento Interno

### Seeder: `DivisionSeeder`
- **Ubicación:** `database/seeders/DivisionSeeder.php`
- **Descripción:**
  - Crea 100 divisiones principales con valores aleatorios para los campos `superior_division"` y `collaborators_count`.
  - Crea 400 subdivisiones y las asigna aleatoriamente a las divisiones principales.

### Migración: `add_superior_division_to_divisions_table`
- **Ubicación:** `database/migrations/2026_03_07_002448_add_superior_division_to_divisions_table.php`
- **Descripción:**
  - Agrega la columna `superior_division` a la tabla `divisions` para almacenar el tipo de división.

### Modelo: `Division`
- **Ubicación:** `app/Models/Division.php`
- **Descripción:**
  - Define las relaciones `parent` y `children` para manejar divisiones y subdivisiones.
  - Permite la asignación masiva de los campos `name`, `parent_id`, `level`, `collaborators_count`, `ambassador_name` y `superior_division`.

### Endpoint: `/api/seed-divisions`
- **Ubicación:** `routes/api.php`
- **Descripción:**
  - Utiliza el comando la funcion `Artisan::call('db:seed', [
            '--class' => 'DivisionSeeder',
            '--force' => true
        ]);` para reiniciar y repoblar la tabla `divisions`.

## Notas Adicionales
- Asegurarse de que el contenedor Docker esté en ejecución antes de probar los endpoints.
- Verifica que las migraciones estén aplicadas correctamente ejecutando:
```bash
./vendor/bin/sail artisan migrate
```