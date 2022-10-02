# CHANGELOG

## Acerca de SemVer

Usamos [Versionado Semántico 2.0.0](SEMVER.md) por lo que puedes usar esta librería sin temor a romper tu aplicación.

Pueden aparecer cambios no liberados que se integran a la rama principal, pero no ameritan una nueva liberación de
versión aunque sí su incorporación en la rama principal de trabajo, generalmente se tratan de cambios en el desarrollo.

## Cambios no liberados en una versión

## Listado de cambios

### Versión 0.3.2 2022-10-01

Permite la lectura del contenido de texto de los nodos, esto es porque el "Complemento Detallista"
usa este tipo de estructura. Estos contenidos se consideran como espacios en blanco colapsados.

Gracias `@gam04` por tu contribución.

#### Cambios al entorno de desarrollo

- Se actualizan las herramientas de desarrollo.
- Se actualiza el flujo de trabajo de integración contínua:
  - Se utilizan las GitHub Actions versión 3.
  - Se corren los procesos en PHP 8.1.
  - Se elimina la dependencia de `composer` donde no se usa.
- Se actualiza el archivo de configuración de `php-cs-fixer`.
- Se agrega la configuración en Git para que los finales de línea solo sean `LF`.
- Se integra el proyecto a [SonarCloud](https://sonarcloud.io/code?id=phpcfdi_cfdi-to-json).
- Se elimina la integración con Scrutinizer CI a favor de SonarCloud. ¡Gracias Scrutinizer CI!.

### Versión 0.3.1 2022-04-04

La herramienta PHPStan detectó un posible error de mal uso de la propiedad `DOMElement::localName` donde
puede ser de los tipos `string` o `null`, pero solo se consideraba `string`.

La herramienta PHPStan detectó un posible error de mal uso de la propiedad `DOMElement::parentNode` donde
se verifica que la propiedad ahora sea de tipo `DOMElement`.

### Versión 0.3.0 2022-03-16

Se ha descubierto un error en donde dos especificaciones de esquemas del SAT pueden chocar
y en una definición tener nodos que no son múltiples y en otra versión que sí lo son.
Por ejemplo, en CFDI 3.3 el nodo `CfdiRelacionados` solo puede aparecer 1 vez,
mientras que en CFDI 4.0 su número de apariciones es ilimitado.

Se corrige esta situación cambiando la forma de generar las rutas del archivo leído
y cambiando las rutas extraídas de los archivos XSD. En ambos casos ahora se antepone
el espacio de nombres XML, por ejemplo: `{http://www.sat.gob.mx/cfd/4}/Comprobante/CfdiRelacionados`.

De igual forma, ahora el archivo `UnboundedOccursPaths.json` solo contiene entradas únicas y ordenadas.
De esta forma la búsqueda de una coincidencia es mucho más rápida al usar las llaves de un arreglo,
y será más fácil entender los cambios que ocurran en el archivo.

Además, se le ha dado mantenimiento al proyecto actualizando los archivos de desarrollo,
dependencias de las herramientas de desarrollo, flujo de trabajo de integración continua,
licencia (feliz 2022) y probando la compatibilidad con PHP 8.1.

### Versión 0.2.2 2021-11-18

- Se actualiza el archivo `UnboundedOccursPaths.json` porque se incluyó el nuevo complemento `CartaPorte 2.0`.

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
