# Mini Hosting Service

Learning project focused on backend architecture, provisioning logic and hosting automation built with Laravel.

---

## Features

- User registration & authentication (Laravel Breeze)
- Hosting plans (Mini, Standard, Top)
- Database limits per plan
- MySQL database provisioning
- MySQL user provisioning
- Privilege assignment
- Webspace provisioning
- Apache VirtualHost routing
- Domain → webspace mapping

---

# Tech Stack

- Laravel
- PHP 8
- MySQL
- Apache
- Laravel Breeze
- Blade
- Eloquent ORM

---

# Architecture

The project separates responsibilities into multiple layers.

## Controllers

Responsible for:
- request validation
- request/response flow
- redirects
- flash messages

Controllers stay intentionally thin.

---

## Service Layer

### DatabaseService

Responsible for:
- business rules
- plan limits
- naming generation
- orchestration

### DatabaseProvisioningService

Responsible for:
- CREATE DATABASE
- CREATE USER
- GRANT PRIVILEGES
- MySQL infrastructure provisioning

### WebspaceService

Responsible for:
- domain handling
- path generation
- metadata persistence

### WebspaceProvisioningService

Responsible for:
- directory creation
- filesystem provisioning
- initial index.php generation

---

# Provisioning Flow

## Database provisioning

User request:

```text
Create database
```

Backend flow:

```text
Request
→ Validation
→ Business rules
→ Generate DB/user names
→ Generate password
→ CREATE DATABASE
→ CREATE USER
→ GRANT PRIVILEGES
→ Save metadata
→ Show password once
```

---

## Webspace provisioning

User request:

```text
Create webspace
```

Backend flow:

```text
Request
→ Validation
→ Generate safe path
→ Create directory
→ Create index.php
→ Save metadata
```

---

# Security Concepts

Project focuses on:
- whitelist validation
- regex validation
- controlled path generation
- controlled database naming
- separation of infrastructure layer
- no database password persistence
- one-time password display

---

# Local Apache VirtualHosts

Example VirtualHost:

```apache
<VirtualHost *:80>
    ServerName example.test

    DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/clients/user_1/example_test"

    <Directory "/Applications/XAMPP/xamppfiles/htdocs/clients/user_1/example_test">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

---

# Current Status

Implemented:
- authentication
- plans
- DB provisioning
- filesystem provisioning
- Apache routing

Planned:
- automatic VirtualHost generation
- provisioning rollback
- async queue provisioning
- SSL provisioning
- delete/suspend flows
- admin management panel

---

# Purpose

This project is intentionally built as a learning-oriented mini hosting panel focused mainly on:

- backend architecture
- provisioning systems
- service layer patterns
- infrastructure automation
- security mindset
- Laravel OOP practices