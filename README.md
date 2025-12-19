# Ferretería "El Tornillo" - Módulo de Pedidos Especiales

## Descripción
Este módulo permite registrar pedidos especiales indicando material, cantidad, datos del cliente, teléfono, estado del pedido y fechas.  
Según el pedido de Don Ramón
"Los clientes piden materiales que no tenemos en stock: tubos especiales,
pinturas específicas, herramientas raras. Anoto en papeles que después pierdo.
Necesito registrar pedidos especiales: qué material, cantidad, nombre del
cliente, teléfono, y estado: pedido a proveedor, en camino, llegó, entregado.
La fecha del pedido que se ponga sola. Si me equivoco, poder corregir. Los
entregados, ¿los borro? Mi hijo dice que guardemos para saber qué piden más.
Ustedes opinen.
A veces estoy en bodega y solo tengo el celular. Que pueda revisar desde ahí."

## Justificación de no eliminación
Los pedidos entregados no se borran, se quedan en otra lista completa, es decir se marcan como entregados, desaparece de la lista principal y si quiero volver a verlos debe presionamos lista completa para editar su pedido al igaul que si edita el pedido entregado este no  


## Tabla: pedidos

### Estructura de campos
| Campo           | Tipo de dato (Laravel) | Tipo en BD (referencial) | Nulo | Default                  | Descripción |
|----------------|-------------------------|---------------------------|------|--------------------------|-------------|
| id             | id()                    | BIGINT UNSIGNED           | No   | Auto increment           | Identificador único del pedido |
| cli_nombre     | string                  | VARCHAR(255)              | No   | -                        | Nombre del cliente |
| cli_apellido   | string                  | VARCHAR(255)              | No   | -                        | Apellido del cliente |
| telefono       | string                  | VARCHAR(255)              | No   | -                        | Teléfono del cliente (se valida que contenga solo números) |
| material       | string                  | VARCHAR(255)              | No   | -                        | Material solicitado |
| cantidad       | integer                 | INT                       | No   | -                        | Cantidad solicitada (mínimo 1) |
| estado         | enum                    | ENUM                      | No   | pedido_a_proveedor       | Estado del pedido |
| fecha_pedido   | timestamp               | TIMESTAMP                 | No   | CURRENT_TIMESTAMP        | Fecha/hora de creación del pedido |
| fecha_entrega  | timestamp()->nullable() | TIMESTAMP                 | Sí   | NULL                     | Se asigna cuando el pedido pasa a entregado |
| created_at     | timestamps()            | TIMESTAMP                 | Sí   | NULL                     | Registro automático de Laravel |
| updated_at     | timestamps()            | TIMESTAMP                 | Sí   | NULL                     | Actualización automática de Laravel |

### Valores permitidos para estado
- pedido_a_proveedor
- en_camino
- llego
- entregado

## Decisiones de diseño

### Estado como ENUM
Se usa ENUM para evitar valores inválidos en el estado y mantener consistencia.  
Además, se define un default de `pedido_a_proveedor` para que al crear un pedido no sea obligatorio enviar el estado.

### fecha_pedido automática
`fecha_pedido` se define con `useCurrent()` para que se registre automáticamente al crear el pedido, sin depender del usuario.

### fecha_entrega nullable y controlada por lógica
`fecha_entrega` es NULL por defecto y solo se llena cuando el estado cambia a `entregado`.  
Si un pedido se marca como entregado por error y luego se corrige a otro estado, la fecha de entrega se borra (vuelve a NULL).  
Esto permite mantener un historial simple y coherente de entregas.

### Teléfono como string
Se guarda como string para conservar ceros iniciales y evitar problemas de formato.  
La validación del formulario controla que solo se ingresen números.

## Migración
La tabla se crea con la migración `create_pedidos_table` usando el siguiente esquema:

- Se crea `pedidos`
- Se definen campos de cliente, pedido, estado y fechas
- Se agregan `created_at` y `updated_at`
- En `down()`, se elimina la tabla con `dropIfExists('pedidos')`
