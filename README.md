# 🧠 SkillSwap – Plataforma de Intercambio de Habilidades

SkillSwap es una aplicación web que permite a jóvenes compartir y aprender nuevas habilidades mediante un sistema de match. Los usuarios pueden registrarse, indicar qué habilidades quieren aprender y cuáles pueden enseñar, y conectarse con otros para hacer un intercambio de conocimientos.

---

## 📌 Tabla de Contenidos
- [Descripción del Proyecto](#descripción-del-proyecto)
- [Tecnologías Utilizadas](#tecnologías-utilizadas)
- [Requisitos Funcionales](#requisitos-funcionales)
- [Requisitos No Funcionales](#requisitos-no-funcionales)
- [Mockup](#mockup)
- [Modelo Entidad-Relación (ER)](#modelo-entidad-relación-er)
- [Diagramas UML](#diagramas-uml)
- [Estructura de Carpetas](#estructura-de-carpetas)
- [Instalación y Despliegue](#instalación-y-despliegue)
- [Autores](#autores)

---

## 📝 Descripción del Proyecto

SkillSwap permite a los usuarios:
- Registrarse y autenticarse de forma segura.
- Establecer su rol como estudiante o mentor.
- Publicar habilidades que desean enseñar.
- Buscar habilidades que desean aprender.
- Hacer match con otros usuarios según intereses comunes.
- Recuperar contraseña por correo.
- Interactuar a través de una interfaz limpia y sencilla.

---

## 🛠️ Tecnologías Utilizadas

- PHP (programación backend)
- MySQL (gestión de base de datos)
- HTML + Bootstrap 5 (interfaz frontend)
- SweetAlert (alertas elegantes)
- Composer (gestión de dependencias)
- PHPMailer (envío de correos)
- MVC (Modelo-Vista-Controlador)
- InfinityFree + FileZilla (despliegue gratuito)
- Postman (pruebas API REST)
- JWT (para autenticación en API REST) ✅ *en fase futura*

---

## ✅ Requisitos Funcionales

- Registro y login de usuarios.
- Gestión de usuarios (CRUD).
- Recuperación de contraseña por email.
- Definición de habilidades.
- Sistema de match entre habilidades.
- Panel de administración (para usuarios con rol admin).

---

## 🚫 Requisitos No Funcionales

- Interfaz limpia y clara (UX amigable).
- Seguridad básica con hash de contraseñas y tokens.
- Validaciones en formularios.
- Código organizado bajo patrón MVC.
- Compatibilidad con navegadores modernos.

---

## 🎨 Mockup

_(Agrega aquí una captura de tu diseño Figma o wireframe del sitio web)_

---

## 🧩 Modelo Entidad-Relación (ER)

Base de datos: `skillswap`  
Tablas:
- `users` (id, name, email, password, role, reset_token, token_expiry)
- `skills` (id, user_id, name, description)
- `matches` (id, user1_id, user2_id, skill_id, status)

_(Agrega aquí imagen del diagrama ER)_

---

## 📊 Diagramas UML

- Diagrama de Casos de Uso
- Diagrama de Clases
- Diagrama de Secuencia (opcional)

_(Puedes hacerlos en draw.io, Lucidchart o Figma)_

---

## 📁 Estructura de Carpetas

App_SkillSwap/
│
├── app/
│ ├── controllers/
│ ├── models/
│
├── config/
│ └── database.php
│
├── public/
│ └── index.php
│
├── src/
│ └── Services/
│ └── MailService.php
│
├── views/
│ ├── auth/
│ ├── users/
│ └── shared/
│
├── vendor/
├── composer.json
├── README.md

## 🚀 Instalación y Despliegue

1. Clona el repositorio:
   ```bash
   git clone https://github.com/tuusuario/SkillSwap.git

   
   
👩‍💻 Autor
Victoria – Desarrollo completo del backend, interfaz y despliegue.

