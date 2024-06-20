
# IntelliGate: Sistema de Gestión Residencial

![IntelliGate Logo](https://github.com/19Juliette92/intelligate_vitereact.github.io/blob/main/src/assets/img/Intelligate_logo.jpg)

## Descripción del Proyecto

IntelliGate es un sistema avanzado de gestión residencial diseñado para controlar y administrar el acceso de vehículos y conductores en conjuntos residenciales. El sistema incluye módulos para la administración de usuarios, gestión de vehículos y conductores, control de acceso, e integración con sistemas de seguridad como cámaras de reconocimiento de placas.

## Características Principales

- **Administración de Usuarios**: Registro, consulta, edición y recuperación de contraseñas para usuarios del sistema.
- **Gestión de Vehículos y Conductores**: Registro, consulta, actualización y eliminación de vehículos y conductores.
- **Control de Acceso**: Verificación de permisos de acceso, registro de eventos de acceso, y gestión manual de excepciones.
- **Integración con Sistemas de Seguridad**: Captura y verificación de placas de vehículos mediante cámaras de reconocimiento.

## Requisitos Previos

- [Node.js](https://nodejs.org/) (versión 14 o superior)
- [npm](https://www.npmjs.com/) o [yarn](https://yarnpkg.com/)
- Servidor con [PHP](https://www.php.net/) (versión 7.4 o superior)
- Base de datos [MySQL](https://www.mysql.com/)

## Instalación

### Frontend

1. Clona el repositorio:
    ```bash
    git clone https://github.com/tu-usuario/intelligate.git
    cd intelligate
    ```

2. Instala las dependencias:
    ```bash
    npm install
    # o si usas yarn
    yarn install
    ```

### Backend

1. Configura tu servidor PHP y MySQL.
2. Crea una base de datos MySQL y configura las credenciales en el archivo de conexión PHP.
3. Sube los archivos PHP al servidor.

## Uso

### Frontend

1. Inicia el servidor de desarrollo:
    ```bash
    npm run dev
    # o con yarn
    yarn dev
    ```

2. Abre tu navegador y navega a `http://localhost:3000` para ver la aplicación en acción.

### Backend

1. Asegúrate de que el servidor PHP esté corriendo y la base de datos MySQL esté configurada correctamente.
2. Accede a los endpoints de la API según sea necesario para interactuar con la base de datos.

## Estructura del Proyecto

```plaintext
intelligate/
├── public/
│   └── index.html
├── src/
│   ├── assets/
│   ├── components/
│   ├── pages/
│   ├── App.jsx
│   ├── main.jsx
│   └── ...
├── backend/
│   ├── api/
│   ├── config/
│   ├── controllers/
│   ├── models/
│   └── index.php
├── .eslintrc.js
├── .gitignore
├── index.html
├── package.json
├── README.md
└── vite.config.js
```

## Scripts Disponibles

- `npm run dev` / `yarn dev`: Inicia el servidor de desarrollo.
- `npm run build` / `yarn build`: Compila la aplicación para producción.
- `npm run lint` / `yarn lint`: Ejecuta linter para encontrar problemas en el código.

## Tecnologías Utilizadas

### Frontend

- **React**: Librería de JavaScript para construir interfaces de usuario.
- **Vite**: Herramienta de construcción rápida para proyectos web modernos.
- **ESLint**: Herramienta de análisis estático para identificar problemas en el código JavaScript.
- **Babel**: Compilador de JavaScript.

### Backend

- **PHP**: Lenguaje de programación para desarrollo del backend.
- **MySQL**: Sistema de gestión de bases de datos relacional.
- **MVC**: Modelo Vista Controlador para estructurar la API y conectar con la base de datos.

## Contribuyendo

¡Contribuciones son bienvenidas! Si deseas contribuir, por favor sigue los siguientes pasos:

1. Haz un fork del proyecto.
2. Crea una rama para tu nueva funcionalidad (`git checkout -b feature/nueva-funcionalidad`).
3. Haz commit de tus cambios (`git commit -am 'Agrega nueva funcionalidad'`).
4. Empuja tu rama (`git push origin feature/nueva-funcionalidad`).
5. Abre un Pull Request.

## Licencia

Este proyecto está bajo la licencia MIT.

## Contacto

Para más información, por favor contacta a Fabian Hernandez en fhernandez26@soy.sena.edu.co
