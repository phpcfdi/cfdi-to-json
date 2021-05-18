# CHANGELOG

## Acerca de SemVer

Usamos [Versionado Semántico 2.0.0](SEMVER.md) por lo que puedes usar esta librería sin temor a romper tu aplicación.

Pueden aparecer cambios no liberados que se integran a la rama principal pero no ameritan una nueva liberación de
versión aunque sí su incorporación en la rama principal de trabajo, generalmente se tratan de cambios en el desarrollo.

## Cambios no liberados en una versión

No hay cambios no liberados. 

## Listado de cambios

### Versión 0.2.1 2021-05-17

- Se actualiza el archivo `UnboundedOccursPaths.json` porque se incluyó el nuevo complemento `CartaPorte`.

Cambios en desarrollo

- Se actualizó la herramienta `php-cs-fixer` a `^3.0`.
- Se actualizó el archivo de configuración de PHPUnit a uno más apegado al recomendado.
- Se agrega a GitHub Actions un flujo de trabajo de construcción del proyecto.
- Se agrega a GitHub Actions un flujo de trabajo de actualización y PR desde `phpcfdi/sat-ns-registry`.
- Se elimina la integración con Travis-CI. Gracias.

### Versión 0.2.0 2021-03-22

- Se extrae la lógica del conteo de hijos de `Nodes\Children` a `Nodes\KeysCounter`.
- Se corrigen los test y las llamadas de `file_get_contents`.
- Conseguir el 100% de testeo.
- Agregar a Travis-CI la comprobación de que el archivo `src/UnboundedOccursPaths.json` no ha cambiado.
- Usar `phive` para las herramientas de desarrollo.
- Se agrega `infection` para correr pruebas de mutación. No es mandatorio por el momento.

### Versión 0.1.0 2021-02-02 ¡Feliz cumpleaños Dany!

- Primera liberación para su uso público.
