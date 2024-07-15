<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Implementacion-Funciones-Rol-Orientador
09/07/2024

Se implementan las funciones necesarias para el rol de orientador, ahora los hobbies, ideas,criterios y sueños personalizados que ingrese el emprendedor, tendran que ser aceptados por el orientador asociado en un plazo de 12 horas. Se implementan algunas tareas programadas en laravel, las cuales se encargaran de borrar la informacion que no sea regulada por los orientadores despues de las 12 horas. Para que estas tareas se ejecuten automaticamente, al momento de cargar los cambios en produccion se tendra que configurar los cron jobs, por lo general, los pasos para esta configuracion son: 

1. Abrir el archivo cron jobs: comando —> crontab -e
2. Agregar la siguiente linea al final del archivo: —> * * * * * php /ruta-proyecto/artisan schedule:run >> /dev/null 2>&1

con estos pasos, las tareas programadas en el archivo Kernel.php, deberian quedar funcionando. 

NOTA: "Por el momento, las tareas programadas estan configuradas para ejecutarse cada minuto, el tiempo de intervalo de ejecucion se puede ajustar en el archivo app/console/Kernel.php".

Se implementa tambien el envio de correos, para informar a los orientadores cuando haya informacion pendiente por aceptar.

## Implementacion-Tabla-Departamento

27/05/2024

Se implementa una nueva migracion para el "departamento", ademas se crea la relacion de uno a muchos con la tabla "ciudad", permitiendo asi un mejor filtrado de ciudades. Se cambia el Json de la seeder, el cual ahora contiene los departamentos, y la lista de ciudades asociadas.

¡Importante! Se tendra que migrar nuevamente la BD para el correcto funcionamiento del sistema.

## Implementacion_Cambio_y_Recuperacion_Contraseña

17/05/2024

Se implementa el cambio y la recuperacion de contraseña para los usuarios del sistema. Ahora, los usuarios podran cambiar la contraseña despues de loguearse, o en caso de olvidarla, restablecerla. para restablecer la contraseña, el usuario dara clic al boton "¿olvido su contraseña?", alli ingresara su email, y recibira un correo con las instrucciones para el restablecimiento. 

¡IMPORTANTE! Al momento de implementar esto a producción, se debe editar la redireccion definida en el archivo /config/app.php, la cual de manera local se encuentra asi:

'redirect_url' => env('REDIRECT_URL', 'http://localhost:4200/#/home'),

Al subirlo a produccion ese link debe ser el de el frontend del sistema, es decir "https://formaliza.hacem.com.co/".

En esta implementacion se ha añadido una tabla a la BD, por tanto se debe migrar para que funcione correctamente.

## Implementacion_verificacion_Correo

03/05/2024

Se implementa la verificacion de correo de los nuevos usuarios que sean registrados. Ahora se envia un email con un pin, que el usuario tendra que proporcionar al ingresar por primera vez al sistema. Esta medida de seguridad garantiza que el correo electronico proporcionado durante el registro realmente pertenece al usuario.

¡Importante! Para el correcto envio de email, se debe modificar el archivo .env, agregando la configuracion del servidor de correo saliente (SMTP). En entorno local, se puede usar MailTrap, el cual brinda un servico de pruebas para correos electronicos. 
El entorno SMTP en el archivo .env se ve algo asi:

MAIL_MAILER=smtp 
MAIL_HOST=smtp.example.com 
MAIL_PORT=587 
MAIL_USERNAME=your_smtp_username 
MAIL_PASSWORD=your_smtp_password 
MAIL_ENCRYPTION=tls 
MAIL_FROM_ADDRESS=your_email@example.com 
MAIL_FROM_NAME="${APP_NAME}"

MAIL_MAILER: Indica el transportador de correo que utiliza, de preferencia SMTP
MAIL_HOST: La dirección del servidor SMTP que se usará para enviar correos electrónicos.
MAIL_PORT: El puerto del servidor SMTP. Por lo general, el puerto 587.
MAIL_USERNAME y MAIL_PASSWORD: Las credenciales de autenticación de tu cuenta SMTP. Aquí deberás proporcionar tu nombre de usuario y contraseña del servidor SMTP.
MAIL_ENCRYPTION: El tipo de cifrado que se utilizará al enviar correos electrónicos. Puede ser tls o ssl.Aunque depende de la configuración del servidor SMTP.
MAIL_FROM_ADDRESS: La dirección de correo electrónico desde la cual se enviarán los correos electrónicos.
MAIL_FROM_NAME: El nombre que se mostrará como remitente en los correos electrónicos. 

Se ha configurado el siguiente entorno SMTP, el cual funciona actualmente. Se recomienda copiar y pegar en el archivo .env: 

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
#MAIL_PORT=1025
MAIL_USERNAME=hacem@miproyecto.xyz
MAIL_PASSWORD=Hacem_2024
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=hacem@miproyecto.xyz
MAIL_FROM_NAME="D.A.F.N.E."

## Modificacion_archivo_readme
02/05/2024
Se realiza primer acercamiento a la nueva estructura de manejo de cambios.

## About Laravel
3
Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)
- [Hyper Host](https://hyper.host)
- [Appoly](https://www.appoly.co.uk)
- [OP.GG](https://op.gg)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
