<h1>
 <img src="https://github.com/connellr023/gratis/blob/main/public/logo_large.png?raw=true" width="450px" />
</h1>

> A lightweight framework for developing *REST-like* APIs in **PHP**.

![Developer](https://img.shields.io/badge/Connell%20Reffo-143?style=for-the-badge&logoColor=black&color=lightblue)
![License](https://img.shields.io/badge/MIT-143?style=for-the-badge&logoColor=black&color=lightgreen)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![PhpStorm](https://img.shields.io/badge/phpstorm-143?style=for-the-badge&logo=phpstorm&logoColor=black&color=black&labelColor=darkorchid)
<br />

### Table Of Contents
 - [Overview](#overview)
 - [Intended Structure](#intended-structure)

<br />

### Overview
Gratis is a versatile framework designed to promote the separation of concerns, fostering scalable code practices by encapsulating logic within handlers. Primarily tailored for creating robust and scalable APIs, the framework follows a *REST-like* architectural style. It seamlessly interacts with SQL databases, providing a structured and efficient foundation for building web applications.

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
    └── ...
```
The code structure is designed to follow a clear separation of concerns, distinguishing between *model* and *controller* components.

- **Controllers:** Responsible for handling HTTP requests, controllers in the API interact with the backend logic, facilitating seamless communication with the front end.

- **Models:** Empowered to perform database I/O, models enforce a strictly typed database schema. This ensures robust data integrity and reliability.

This framework is tailored to collaborate seamlessly with static files generated by modern front-end frameworks, such as **Vue.js**. Due to this focus, there is no need for explicit *views*, streamlining the development process and fostering a modular and scalable architecture.

<br />

### Running **PHPUnit** Test Suite
In order to the run the automated test suite for this framework, execute,
```bash
./vendor/bin/phpunit
```

<br />
<br />

<div align="center">
 <img src="https://github.com/connellr023/gratis/blob/main/public/logo_small.png?raw=true" width="150px" />
 <br />
 <br />
 <div>Developed and tested by <b>Connell Reffo</b> in 2024.</div>
</div>
