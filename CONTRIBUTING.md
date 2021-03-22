# Contribuciones

Las contribuciones son bienvenidas. Aceptamos *Pull Requests* en [repositorio GitHub][homepage].

Este proyecto se apega al siguiente [Código de Conducta][coc].
Al participar en este proyecto y en su comunidad, deberás seguir este código.

## Miembros del equipo

* [phpCfdi][] - Organización que mantiene el proyecto.
* [Contribuidores][contributors].

## Canales de comunicación

Puedes encontrar ayuda y comentar asuntos relacionados con este proyecto en estos lugares:

* Comunidad Discord: <https://discord.gg/aFGYXvX>
* GitHub Issues: <https://github.com/phpcfdi/cfdi-to-json/issues>

## Reportar Bugs

Publica los *Bugs* en la sección [GitHub Issues][issues] del proyecto.

Sigue las recomendaciones generales de [phpCfdi][] para reportar problemas
<https://www.phpcfdi.com/general/reportar-problemas/>.

Cuando se reporte un *Bug*, por favor incluye la mayor información posible para reproducir el problema, preferentemente
con ejemplos de código o cualquier otra información técnica que nos pueda ayudar a identificar el caso.

**Recuerda no incluir contraseñas, información personal o confidencial.**

## Corrección de Bugs

Apreciamos mucho los *Pull Request* para corregir Bugs.

Si encuentras un reporte de Bug y te gustaría solucionarlo siéntete libre de hacerlo.
Sigue las directrices de "Agregar nuevas funcionalidades" a continuación.

## Agregar nuevas funcionalidades

Si tienes una idea para una nueva funcionalidad revisa primero que existan discusiones o *Pull Requests*
en donde ya se esté trabajando en la funcionalidad.

Antes de trabajar en la nueva característica, utiliza los "Canales de comunicación" mencionados
anteriormente para platicar acerca de tu idea. Si dialogas tus ideas con la comunidad y los
mantenedores del proyecto, podrás ahorrar mucho esfuerzo de desarrollo y prevenir que tu
*Pull Request* sea rechazado. No nos gusta rechazar contribuciones, pero algunas características
o la forma de desarrollarlas puede que no estén alineadas con el proyecto.

Considera las siguientes directrices:

* Usa una rama única que se desprenda de la rama principal.
  No mezcles dos diferentes funcionalidades en una misma rama o *Pull Request*.
* Describe claramente y en detalle los cambios que hiciste.
* **Escribe pruebas** para la funcionalidad que deseas agregar.
* **Asegúrate que las pruebas pasan** antes de enviar tu contribución.
  Usamos integración contínua donde se hace esta verificación, pero es mucho mejor si lo pruebas localmente.
* Intenta enviar una historia coherente, entenderemos cómo cambia el código si los *commits* tienen significado.
* La documentación es parte del proyecto.
  Realiza los cambios en los archivos de ayuda para que reflejen los cambios en el código.

## Proceso de construcción

```shell
# Instala phive, sigue las indicaciones seguras de https://phar.io/#Install o la forma insegura:
wget https://phar.io/releases/phive.phar -O ~/.local/bin/phive

## Si no se han instalado las herramientas previamente
phive install --force-accept-unsigned --trust-gpg-keys 0x4AA394086372C20A,0x31C7E470E2138192,0xE82B2FB314E9906E,0xCF1A108D0E7AE720,0xC5095986493B4AA0

# Actualiza tus dependencias
composer update
phive update

# Verificación de estilo de código
composer dev:check-style

# Corrección de estilo de código
composer dev:fix-style

# Ejecución de pruebas
composer dev:test

# Ejecución todo en uno, corregir estilo, verificar estilo y correr pruebas
composer dev:build

# Opcional: correr las pruebas de mutación
composer dev:infection
```

[phpCfdi]:      https://github.com/phpcfdi/
[project]:      https://github.com/phpcfdi/cfdi-to-json
[contributors]: https://github.com/phpcfdi/cfdi-to-json/graphs/contributors
[coc]:          https://github.com/phpcfdi/cfdi-to-json/blob/main/CODE_OF_CONDUCT.md
[issues]:       https://github.com/phpcfdi/cfdi-to-json/issues
