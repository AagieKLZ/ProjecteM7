🌎 [Web de Tenfe](https://3.122.188.12/)

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
- TailwindCSS (un framework de CSS) que permite su implementación CDN sin paquetes
- MySQL como sistema gestor de bases de datos
- Python y excel para pasar los datos de los PDFs actuales de la Generalitat a la base de datos

## Sobre la base de datos

Hemos realizado un trabajo, aunque algunas partes sean solo teóricas, dónde se puede consultar como funciona la base de datos de Tenfe.

Se puede consultar el pdf en el siguiente enlace:

https://drive.google.com/file/d/1_qtezNTbShS2LGGmve_G0Gqw-eTqoCys/view?usp=sharing

## Despliegue

Además, es importante destacar que el proyecto de Tenfe ha sido hosteado en una 
máquina EC2 de AWS, utilizando XAMPP como servidor web y base de datos. 
Esto nos permite tener un control total sobre el entorno de producción y 
asegurar la escalabilidad y disponibilidad del servicio. 

Se han trasladado las bases de datos a proudcción con mysqldump y se ha configurado 
el servidor web para solo permitir conexiones locales a la base de datos.

Se puede consultar el proyecto aqui: https://3.122.188.12/

## Acceso a administrador
Usuario: admin@tenfe.com

Contraseña: 123321
