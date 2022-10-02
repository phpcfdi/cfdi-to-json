# phpcfdi/cfdi-to-json

[![Source Code][badge-source]][source]
[![Packagist PHP Version Support][badge-php-version]][php-version]
[![Discord][badge-discord]][discord]
[![Latest Version][badge-release]][release]
[![Software License][badge-license]][license]
[![Build Status][badge-build]][build]
[![Reliability][badge-reliability]][reliability]
[![Maintainability][badge-maintainability]][maintainability]
[![Code Coverage][badge-coverage]][coverage]
[![Violations][badge-violations]][violations]
[![Total Downloads][badge-downloads]][downloads]

> Herramienta para convertir archivos CFDI a JSON

## Acerca de `phpcfdi/cfdi-to-json`

Esta es una herramienta que sigue sus propias convenciones para convertir los archivos de CFDI (XML de SAT)
a formato JSON.

Algunas de las convenciones que se siguen son:

- Los elementos son objetos que contienen su valor, los atributos y sus elementos hijos.
- Los elementos que pueden aparecer más de una vez, son manejados como arreglos.
- La librería guarda un registro interno de los elementos que pueden aparecer más de una vez.

## Instalación

Usa [composer](https://getcomposer.org/)

```shell
composer require phpcfdi/cfdi-to-json
```

## Uso básico

### Convirtiendo de CFDI (string) a JSON (string)

```php
<?php
declare(strict_types=1);

use PhpCfdi\CfdiToJson\JsonConverter;

$contents = file_get_contents('mi-archivo-xfdi.xml');
$json = JsonConverter::convertToJson($contents);
echo $json;
```

### Convirtiendo de `DOMDocument` a `array`

```php
<?php
declare(strict_types=1);

use PhpCfdi\CfdiToJson\Factory;

/** @var DOMDocument $document */

$factory = new Factory();
$dataConverter = $factory->createConverter();
$rootNode = $dataConverter->convertXmlDocument($document);
$array = $rootNode->toArray();

var_export($array);
```

### Ejemplo de salida

Note que: 
- `Emisor` parece una propiedad más del objeto principal, pero el contenido es un objeto y no una cadena de caracteres.
- `Concepto` contiene un arreglo de objetos, cada uno es una representación de un nodo concepto.
- `Traslado` contiene un arreglo a pesar de que solo contenga un objeto, se conoce que es múltiple.
- `Complemento` es un arreglo a pesar de lo definido en el Anexo 20 porque el XSD dice que puede tener múltiples apariciones.

```json
{
    "Certificado": "MIIGH...imAyX",
    "CondicionesDePago": "CONTADO",
    "Fecha": "2018-01-12T08:15:01",
    "Folio": "11541",
    "FormaPago": "04",
    "LugarExpedicion": "76802",
    "MetodoPago": "PUE",
    "Moneda": "MXN",
    "NoCertificado": "00001000000401220451",
    "Sello": "Xt7tK...gdg==",
    "Serie": "H",
    "SubTotal": "1709.12",
    "TipoDeComprobante": "I",
    "Total": "2010.01",
    "Version": "3.3",
    "xsi:schemaLocation": "http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http://www.sat.gob.mx/implocal http://www.sat.gob.mx/sitio_internet/cfd/implocal/implocal.xsd",
    "Emisor": {
        "Nombre": "PROMOTORA OTIR SA DE CV",
        "RegimenFiscal": "601",
        "Rfc": "POT9207213D6"
    },
    "Receptor": {
        "Nombre": "DAY INTERNATIONAL DE MEXICO SA DE CV",
        "Rfc": "DIM8701081LA",
        "UsoCFDI": "G03"
    },
    "Conceptos": {
        "Concepto": [
            {
                "Cantidad": "2.00",
                "ClaveProdServ": "90111501",
                "ClaveUnidad": "E48",
                "Descripcion": "Paquete",
                "Importe": "1355.67",
                "Unidad": "UNIDAD DE SERVICIO",
                "ValorUnitario": "677.83",
                "Impuestos": {
                    "Traslados": {
                        "Traslado": [
                            {
                                "Base": "1355.67",
                                "Importe": "216.91",
                                "Impuesto": "002",
                                "TasaOCuota": "0.160000",
                                "TipoFactor": "Tasa"
                            }
                        ]
                    }
                }
            },
            {
                "Cantidad": "1.00",
                "ClaveProdServ": "90101501",
                "ClaveUnidad": "E48",
                "Descripcion": "Restaurante",
                "Importe": "353.45",
                "Unidad": "UNIDAD DE SERVICIO",
                "ValorUnitario": "353.45",
                "Impuestos": {
                    "Traslados": {
                        "Traslado": [
                            {
                                "Base": "353.45",
                                "Importe": "56.55",
                                "Impuesto": "002",
                                "TasaOCuota": "0.160000",
                                "TipoFactor": "Tasa"
                            }
                        ]
                    }
                }
            }
        ]
    },
    "Impuestos": {
        "TotalImpuestosTrasladados": "273.46",
        "Traslados": {
            "Traslado": [
                {
                    "Importe": "273.46",
                    "Impuesto": "002",
                    "TasaOCuota": "0.160000",
                    "TipoFactor": "Tasa"
                }
            ]
        }
    },
    "Complemento": [
        {
            "ImpuestosLocales": {
                "TotaldeRetenciones": "0.00",
                "TotaldeTraslados": "27.43",
                "version": "1.0",
                "TrasladosLocales": [
                    {
                        "ImpLocTrasladado": "IH",
                        "Importe": "27.43",
                        "TasadeTraslado": "2.50"
                    }
                ]
            },
            "TimbreFiscalDigital": {
                "FechaTimbrado": "2018-01-12T08:17:54",
                "NoCertificadoSAT": "00001000000406258094",
                "RfcProvCertif": "DCD090706E42",
                "SelloCFD": "Xt7tK...gdg==",
                "SelloSAT": "IRy7w...6Zg==",
                "UUID": "CEE4BE01-ADFA-4DEB-8421-ADD60F0BEDAC",
                "Version": "1.1",
                "xsi:schemaLocation": "http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd"
            }
        }
    ]
}
```

## Funcionamiento interno

La conversión parte de un objeto `DOMDocument` que es recorrido nodo a nodo y en cada transformación genera
un objeto de tipo `Nodes\Node` que contiene sus propiedades básicas de nombre, ruta, valor de texto, atributos e hijos.
Los hijos (`Nodes\Children`) son una colección de nodos `Nodes\Node`.

Al momento de exportar a un arreglo `Nodes\Node::toArray()` es cuando se resuelve si los nodos deben agregarse como
llaves directas a objetos, o bien, como arreglos de objetos. 

### Elementos con múltiples apariciones

Para detectar los elementos con múltiples apariciones esta librería contiene un archivo `src/UnboundedOccursPaths.json`
con el listado de rutas de elementos que pueden aparecer más de una vez.

Este listado se puede generar utilizando el archivo `bin/max-occurs-paths.php`, que descargará el registro de espacios
de nombres del SAT de PhpCfdi [`phpcfdi/sat-ns-registry`](https://github.com/phpcfdi/sat-ns-registry) así como todos
los archivos XSD para interpretar las rutas que contienen `maxOccurs="unbounded"`.

Desde 2021-03-22 se ha agregado un evento desde `phpcfdi/sat-ns-registry` para que notifique a este mismo repositorio
que el registro de espacios de nombres cambió.

### Nodos con texto

El texto o valor que contenga algún nodo XML es exportado a una llave de cadena vacía en el JSON resultante.
Por ejemplo, el siguiente XML:

```xml
<detallista:orderIdentification>
    <detallista:referenceIdentification type="ON">3</detallista:referenceIdentification>
</detallista:orderIdentification>
```

Genera el siguiente JSON:

```json
{
  "orderIdentification": {
    "referenceIdentification": {
      "": "3",
      "type": "ON"
    }
  }
}
```

## Soporte

Puedes obtener soporte abriendo un ticket en Github.

Adicionalmente, esta librería pertenece a la comunidad [PhpCfdi](https://www.phpcfdi.com), así que puedes usar los
mismos canales de comunicación para obtener ayuda de algún miembro de la comunidad.

## Compatibilidad

Esta librería se mantendrá compatible con al menos la versión con
[soporte activo de PHP](https://www.php.net/supported-versions.php) más reciente.

También utilizamos [Versionado Semántico 2.0.0](docs/SEMVER.md) por lo que puedes usar esta librería
sin temor a romper tu aplicación.

## Contribuciones

Las contribuciones con bienvenidas. Por favor, revisa [CONTRIBUTING][] para más detalles
y recuerda revisar el archivo de tareas pendientes [TODO][] y el archivo [CHANGELOG][].

## Copyright and License

The `phpcfdi/cfdi-to-json` library is copyright © [PhpCfdi](https://www.phpcfdi.com/)
and licensed for use under the MIT License (MIT). Please see [LICENSE][] for more information.

[contributing]: https://github.com/phpcfdi/cfdi-to-json/blob/main/CONTRIBUTING.md
[changelog]: https://github.com/phpcfdi/cfdi-to-json/blob/main/docs/CHANGELOG.md
[todo]: https://github.com/phpcfdi/cfdi-to-json/blob/main/docs/TODO.md

[source]: https://github.com/phpcfdi/cfdi-to-json
[php-version]: https://packagist.org/packages/phpcfdi/cfdi-to-json
[discord]: https://discord.gg/aFGYXvX
[release]: https://github.com/phpcfdi/cfdi-to-json/releases
[license]: https://github.com/phpcfdi/cfdi-to-json/blob/main/LICENSE
[build]: https://github.com/phpcfdi/cfdi-to-json/actions/workflows/build.yml?query=branch:main
[reliability]:https://sonarcloud.io/component_measures?id=phpcfdi_cfdi-to-json&metric=Reliability
[maintainability]: https://sonarcloud.io/component_measures?id=phpcfdi_cfdi-to-json&metric=Maintainability
[coverage]: https://sonarcloud.io/component_measures?id=phpcfdi_cfdi-to-json&metric=Coverage
[violations]: https://sonarcloud.io/project/issues?id=phpcfdi_cfdi-to-json&resolved=false
[downloads]: https://packagist.org/packages/phpcfdi/cfdi-to-json

[badge-source]: https://img.shields.io/badge/source-phpcfdi/cfdi--to--json-blue?logo=github
[badge-discord]: https://img.shields.io/discord/459860554090283019?logo=discord
[badge-php-version]: https://img.shields.io/packagist/php-v/phpcfdi/cfdi-to-json?logo=php
[badge-release]: https://img.shields.io/github/release/phpcfdi/cfdi-to-json?logo=git
[badge-license]: https://img.shields.io/github/license/phpcfdi/cfdi-to-json?logo=open-source-initiative
[badge-build]: https://img.shields.io/github/workflow/status/phpcfdi/cfdi-to-json/build/main?logo=github-actions
[badge-reliability]: https://sonarcloud.io/api/project_badges/measure?project=phpcfdi_cfdi-to-json&metric=reliability_rating
[badge-maintainability]: https://sonarcloud.io/api/project_badges/measure?project=phpcfdi_cfdi-to-json&metric=sqale_rating
[badge-coverage]: https://img.shields.io/sonar/coverage/phpcfdi_cfdi-to-json/main?logo=sonarcloud&server=https%3A%2F%2Fsonarcloud.io
[badge-violations]: https://img.shields.io/sonar/violations/phpcfdi_cfdi-to-json/main?format=long&logo=sonarcloud&server=https%3A%2F%2Fsonarcloud.io
[badge-downloads]: https://img.shields.io/packagist/dt/phpcfdi/cfdi-to-json?logo=packagist
