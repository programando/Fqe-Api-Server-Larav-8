# Contexto del Proyecto Fqe-Api-Server-Larav-8

## Descripción General
Proyecto Laravel 8 que maneja una API para ventas online de productos, incluyendo gestión de productos, facturación, pagos y eventos.

## Estructura del Proyecto
- **Framework**: Laravel 8
- **Arquitectura**: API REST con eventos y listeners
- **Base de datos**: MySQL con migraciones y seeders
- **Autenticación**: Laravel Sanctum
- **Colas**: Sistema de jobs para procesamiento asíncrono

## Componentes Principales

### Modelos
- **ProductosVentaOnline**: Gestión de productos para venta online
- **User**: Usuarios del sistema
- **Invoice**: Facturas y documentos
- **Terceros**: Clientes y proveedores
- **Pedidos**: Órdenes de venta

### Controladores
- API REST para productos, usuarios, facturas, terceros y pedidos
- Manejo de pagos con PayU
- Gestión de catálogos

### Eventos y Listeners
- **Invoice**: Creación, envío de emails, generación de PDFs
- **User**: Reset de contraseñas, códigos de acceso
- **Pedidos**: Confirmación de pagos
- **Terceros**: Contactos y nóminas

### Helpers
- **DatesHelper**: Manejo de fechas
- **FilesHelper**: Gestión de archivos
- **GeneralHelper**: Funciones generales
- **NumbersHelper**: Operaciones numéricas
- **StringsHelper**: Manipulación de strings
- **UsersHelper**: Funciones relacionadas con usuarios

### Middleware
- Autenticación API
- CORS
- Validación de requests

## Características Técnicas
- **API REST**: Endpoints para todas las entidades principales
- **Eventos**: Sistema de eventos para operaciones asíncronas
- **Jobs**: Procesamiento en cola para tareas pesadas
- **Mails**: Sistema de envío de emails
- **Storage**: Gestión de archivos y imágenes
- **Validación**: Requests personalizados para validación de datos

## Rutas
- **API**: `/api/*` - Endpoints principales
- **Catálogos**: Gestión de productos y categorías
- **Clientes**: Operaciones relacionadas con clientes
- **Terceros**: Administración de terceros
- **Ventas Online**: Procesamiento de ventas online
- **Pagos**: Integración con PayU

## Configuración
- **Company**: Configuración específica de la empresa
- **Database**: Configuración de base de datos
- **Mail**: Configuración de correo electrónico
- **Queue**: Configuración de colas
- **CORS**: Configuración de acceso cross-origin

## Dependencias Principales
- **Laravel**: Framework base
- **Guzzle**: Cliente HTTP para APIs externas
- **DOMPDF**: Generación de PDFs
- **SwiftMailer**: Envío de emails
- **Sanctum**: Autenticación API

## Patrones de Desarrollo
- **MVC**: Modelo-Vista-Controlador
- **Repository**: Acceso a datos a través de modelos
- **Events/Listeners**: Patrón de eventos para operaciones asíncronas
- **Jobs**: Procesamiento en cola para tareas pesadas
- **Resources**: Transformación de datos para API
- **Middleware**: Filtros de request/response

## Convenciones de Código
- **Nombres**: PascalCase para métodos y funciones
- **Archivos**: PascalCase para nombres de archivos
- **Variables**: PascalCase para variables
- **Helpers**: Sin sufijo "Helper" en nombres
- **Modales**: Uso de IsOpen/SetIsOpen para estado de modales
