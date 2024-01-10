<h1>
 <img src="https://github.com/connellr023/gratis/blob/main/public/images/logo_large.png?raw=true" width="450px" />
</h1>

> A lightweight framework for developing *REST-like* APIs in **PHP**.

<div align="left">
 <img src="https://img.shields.io/badge/developer-Connell Reffo-de2349">
 <img src="https://img.shields.io/badge/license-MIT-3643d1">
 <img src="https://img.shields.io/badge/language-PHP-937dbd">
 <img src="https://github.com/connellr023/gratis/actions/workflows/unit.yml/badge.svg">
<img src="https://github.com/connellr023/gratis/actions/workflows/integration.yml/badge.svg">
</div>

<br />

### Table Of Contents
- [Overview](#overview)
- [Composer](#composer)
- [Intended Structure](#intended-structure)
    - [Middlewares](#middlewares)
    - [Controllers](#controllers)
    - [Models](#models)
    - [View](#view)
- [Documentation](public/doc/INDEX.md)
  - Structure
    - [Middlewares](public/doc/MIDDLEWARES.md)
    - [Controllers](public/doc/CONTROLLERS.md)
    - [Models](public/doc/MODELS.md)
    - [View](public/doc/VIEW.md)
  - Services
      - [Router Class](public/doc/ROUTER.md)
      - [Database Class](public/doc/DATABASE.md)
- [Development](#development)
    - [Requirements](#requirements)
    - [Installing Dependencies](#installing-dependencies)
    - [Continuous Integration](#running-the-phpunit-test-suite)
- [License](#license)

<br />

### Overview
**Gratis** is a versatile framework designed to promote the separation of concerns,
fostering scalable code practices by encapsulating logic within handlers.
Primarily tailored for creating robust and scalable APIs that follow the **CRUD** lifecycle, the framework follows a *REST-like* architectural style.
It allows form seamless interactions with **SQL** databases, providing a structured and efficient foundation for building web applications.

<br />

### Composer
The **Gratis** framework can be used in a composer **PHP** project by running the following command,
```bash
composer require connell/gratis
```

<br />

### Intended Structure
```text
│
└── src/
    ├── Models/
    │ └── ...
    │
    ├── Controllers/
    │ └── ...
    │
    ├── Middlewares/
    │ └── ...
    │
    ├── View/
    │ └── ...
    │
    └── ...
```
The code structure is meticulously crafted to adhere to a well-defined separation of concerns, delineating distinct roles for *model*, *controller*, *middleware*, and *view* components.

- ### Middlewares
  Positioned at the forefront of the process, middlewares gain initial access to client *request* and *response* objects before the controller takes charge. This makes them adept at tasks like client verification and handling cross-origin resource sharing.

- ### Controllers
  Tasked with managing HTTP requests, controllers within the API play a pivotal role in orchestrating communication with the backend logic, ensuring a seamless exchange of information with the front end.

- ### Models
  Endowed with the capability to execute database I/O operations, models uphold a rigorously typed database schema. This commitment ensures robust data integrity and reliability throughout the system.

- ### View
  Housed within a dedicated directory, the *View* encapsulates static webpage code tailored for a single-page web application. This setup streamlines the development process, fostering a modular and scalable architectural design.

This framework is specifically designed to integrate with static files generated by contemporary front-end frameworks, such as **Vue.js** or **React**.


<br />

### Development
Below details information about the development environment.

<br />

### Requirements
The required dependencies for this framework are as follows from `composer.json`,

```json
"require": {
  "php": "^8.3",
  "ext-pdo": "*"
},
"require-dev": {
  "phpunit/phpunit": "^10.5",
  "guzzlehttp/guzzle": "^7.8"
}
```

<br />

### Installing Dependencies
The only dependency used in this framework is **PHPUnit** for development testing. In order to install **PHPUnit**
as well as generate autoload files, run the following command,
```bash
composer install
```

<br />

### Running The PHPUnit Test Suite
If you want to run the integration tests, the local **PHP** development server must
be running on `http://localhost:8000`. There is a script to do this in `composer.json`,
```bash
composer dev
```
In order to the run the entire automated test suite for this framework, execute,
```bash
composer test
```
For just integration,
```bash
composer test:integration
```
For just unit tests,
```bash
composer test:unit
```
or see the **GitHub Actions** tab.

<br />

### License
This software is distributed under the **MIT** license. See `LICENSE` for more information.

<br />
<br />

<div align="center">
 <img src="https://github.com/connellr023/gratis/blob/main/public/images/logo_small.png?raw=true" width="150px" />
 <br />
 <br />
 <div>Developed and tested by <b>Connell Reffo</b> in 2024.</div>
</div>
