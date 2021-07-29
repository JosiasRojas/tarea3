# tarea3
Tarea3 Base de Datos FLASK + PHP
Grupo 35
Integrantes:
  Josias Rojas
  Kevin Becker
  Ricardo Herrera

# Supuestos

- Se asume que todos los usuarios tienen acceso a la pestaña de simulación
- No existira mas de un cambio del precio de la moneda dentro de 5 segundos
- No se creara la misma moneda con otro precio dentro de 5 segundos a partir de la ultima insercion de esta moneda
- Para **cambiar la fecha** del precio de una moneda se hace un *POST*
- Para cambiar el valor **sin alterar la fecha** el precio de una moneda se hace un *PUT*
- No se borraran paises que tengan usuario
- La contraseña de los usuarios no se cambiara una vez creado
- La consulta 2 el monto es extrictamente superior

# Consideraciones

Para cada tabla en la API existe la posibilidad de obtener todas las filas de la tabla y la de obtener un solo elemento mediante el metodo GET pasando un "id" en el body.

Para las peticiones de la api/consultas se deben entregar siempre los codigos/id en el caso de:
- pais
- usuario_tiene_moneda
- moneda