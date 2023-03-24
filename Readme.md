# Sobre el proyecto

## Descripción

Tenfe es una aplicación web creada con PHP que permite visualizar horarios de las distintas líneas de Rodalies de Catalunya, tanto líneas dentro de la provincia Barcelona como regionales. Además, se pueden visualizar las distintas estaciones de tren y todos sus horarios, así como las distintas formas de llegar a cualquier destino desde cualquier origen en la red de estaciones, junto a los horarios y líneas a usar.

También permite administrar las distintas rutas y recorridos, como crear, borrar y modificar horarios asi como crear usuarios con permiso de edición solo en algunas lineas.

## Motivación

Tenfe surge de un sentimiento de insatisfacción al usar las aplicaciones reales de Renfe y Adif, con una propuesta de mejora para estas en la que es más fácil visualizar y modificar los datos.

Además, la aplicación de Tenfe incluye mejoras sustanciales de accesibilidad, así como el cumplimiento de la normativa de accesibilidad EN-301549V2.1.2:2018 considerando las excepciones del real decreto 1112/2018.

## Parte técnica

La aplicación de Tenfe se desarrolló con:

- PHP sin frameworks tanto para el lado del cliente como el lado del servidor.
- TailwindCSS  (un framework de CSS) que permite su implementación CDN sin paquetes
- MySQL como sistema gestor de bases de datos
- Python y excel para pasar los datos de los PDFs actuales de la Generalitat a la base de datos