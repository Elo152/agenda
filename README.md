# Agenda de Contactos Multiusuario

## **Descripción**
Esta aplicación de agenda de contactos multiusuario está desarrollada en PHP y MySQL. Permite a los usuarios gestionar sus contactos, enviar mensajes y filtrar la lista de contactos. Cada usuario puede iniciar sesión, registrarse y tener una lista personalizada de contactos y mensajes.

---

## **Características**
1. **Inicio de Sesión:** Los usuarios inician sesión con su número de teléfono y contraseña. Si el teléfono o la contraseña no existen se muestra un mensaje de error. Es obligatorio introducir ambos campos.
2. **Registro de Usuarios:** Incluye número de teléfono, contraseña y avatar. Muestra un mensaje de error si el número de teléfono ya está en uso y la contraseña se guarda hasheada. Es obligatorio introducir todos los campos.
3. **Gestión de Contactos:**
    - Lista todos los contactos del usuario.
    - Filtra contactos por nombre.
    - Crea nuevos contactos utilizando un formulario en un diálogo.
4. **Detalles del Contacto:**
    - Muestra información del contacto (foto, nombre y apellidos).
    - Envía mensajes al contacto, que se guardan en la base de datos y se muestran bajo la información del contacto.
5. **Control de Navegación:**
    - Redirige a los usuarios no autenticados a la página de inicio de sesión.
    - Redirige a los usuarios registrados a la página de inicio de sesión.
    - Redirige a los usuarios autenticados desde la página de inicio de sesión a la página principal (index.php) dónde aparece la lista de contactos.
6. **Avatar en Cabecera:** Muestra el avatar del usuario en todas las páginas.

---

## **Pantallas**
1. **Inicio de Sesión:** Entrada de número de teléfono y contraseña.
2. **Registro:** Formulario con número de teléfono, contraseña y carga de avatar.
3. **Lista de Contactos:**
    - Muestra los contactos del usuario.
    - Filtra contactos por nombre.
    - Formulario en un diálogo para crear nuevos contactos.
4. **Detalles del Contacto:**
    - Muestra foto, nombre y apellidos del contacto.
    - Formulario para enviar mensajes.
    - Muestra los mensajes enviados a ese usuario ordenados por fecha.

---

## **Estructura de la Base de Datos**

### Tablas
1. **Usuarios**
    - `id` (Clave Primaria)
    - `telefono` (Único, String, Obligatorio)
    - `password` (Hashed, String, Obligatorio)
    - `avatar` (String, Opcional)

2. **Contactos**
    - `id` (Clave Primaria)
    - `nombre` (String, Obligatorio)
    - `apellidos` (String, Opcional)
    - `telefono` (String, Obligatorio)
    - `foto` (String, Opcional)
    - `id_usuario` (Clave Foránea a Usuarios, Obligatorio)

3. **Mensajes**
    - `id` (Clave Primaria)
    - `texto` (Texto, Obligatorio)
    - `fecha_envio` (Datetime, por defecto `CURRENT_TIMESTAMP`, Obligatorio)
    - `id_contacto` (Clave Foránea a Contactos, Obligatorio)


---

## **Estructura de la Aplicación**

### **Clases**
1. **Usuario**
    - Atributos: `id`, `telefono`, `password`, `avatar`
2. **Contacto**
    - Atributos: `id`, `nombre`, `apellidos`, `telefono`, `foto`, `idUsuario`
3. **Mensaje**
    - Atributos: `id`, `texto`, `fechaEnvio`, `idContacto`

### **Organización de Archivos**
```
/agenda
  |-- /controllers
  |    |-- contactService.php
  |    |-- messageService.php
  |    |-- usuarioService.php
  |
  |-- /database
  |    |-- config.php
  |    |-- dataBase.sql
  |
  |-- /models
  |    |-- Contacto.php
  |    |-- Mensaje.php
  |    |-- Usuario.php
  |
  |-- /public
  |    |-- /css
  |    |    |-- style.css
  |    |
  |    |-- /images
  |    |    |-- avatar-elo.png
  |    |    |-- carmen.png
  |    |    |-- jose.png
  |    |    |-- laura.png
  |    |
  |    |-- index.php
  |
  |-- /views
  |    |-- contacto.php
  |    |-- login.php
  |    |-- logout.php
  |    |-- registro.php
  |    |-- /partials
  |         |-- header.php
  |
  |-- README.md
```

---

## **Instalación y Configuración**

### **Requisitos Previos**
- PHP 8.0+
- MySQL 8.0+
- Servidor web (por ejemplo, Apache o Nginx)

### **Pasos de Instalación**
1. Configura la base de datos:
    - Importa el archivo SQL proporcionado en la carpeta `/database` a tu servidor MySQL.
    - Actualiza los detalles de conexión a la base de datos en `config.php`.
3. Inicia el servidor web, navega a la carpeta del proyecto y abre el archivo index.php que se encuentra en la carpeta public.


### **Uso**
1. Inicia sesión con el usuario 611223344 y contraseña 123456 o registra un nuevo usuario.
2. Inicia sesión con las credenciales registradas.
3. Crea, visualiza y filtra contactos.
4. Envía mensajes desde la página de detalles del contacto.

---

## **Autora**
Eloísa Martínez Martín
