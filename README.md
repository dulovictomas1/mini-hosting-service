# Mini Hosting Service

## Overview

Mini Hosting Service is a Laravel-based self-hosted hosting panel built for learning and experimentation with web hosting automation, Linux server administration, and Laravel architecture.

The project automates common hosting tasks such as:

- Database provisioning
- Webspace provisioning
- Nginx virtual host management
- Laravel application deployment
- Composer dependency installation
- Environment configuration
- Application key generation
- Database migrations
- Node.js package installation
- Frontend asset building

The system is currently developed and tested on a self-hosted Ubuntu Server environment.

---

## Infrastructure Stack

### Operating System

- Ubuntu Server LTS

### Web Server

- Nginx

### Runtime

- PHP 8.5
- PHP-FPM

### Database

- MariaDB

### Frontend Tooling

- Node.js
- NPM
- Vite

### Framework

- Laravel 12

---

# Features

## User Authentication

- Laravel Breeze authentication
- User registration
- User login/logout
- User dashboard

---

## Hosting Plans

- Create hosting plans
- Resource limits
- User plan assignment

---

## Database Provisioning

Automatically creates:

- Database
- Database user
- Secure password
- Privileges

Features:

- Automatic naming conventions
- Privilege assignment
- Metadata storage
- One-time password display

---

## Webspace Provisioning

Automatically creates:

- Client directory structure
- Web root
- Ownership and permissions
- Metadata records

Example:

```text
/var/www/html/clients/user_2/myproject
```

---

## Nginx Virtual Host Provisioning

Automatically:

- Generates virtual host configuration
- Creates sites-available configuration
- Creates sites-enabled symlink
- Validates configuration
- Reloads Nginx

Example domain:

```text
myproject.test
```

---

# Laravel Deployment Automation

The panel can automatically deploy Laravel applications into a provisioned webspace.

## Git Repository Clone

Supported:

```bash
git clone
```

---

## Composer Install

Automatically executes:

```bash
composer install --no-interaction --prefer-dist
```

---

## Environment Configuration

Automatically:

- Creates `.env`
- Injects database credentials
- Injects application URL
- Stores deployment configuration

---

## Application Key Generation

Automatically executes:

```bash
php artisan key:generate
```

---

## Database Migrations

Automatically executes:

```bash
php artisan migrate --force
```

Migration execution is performed under the web server user to ensure proper permissions and configuration loading.

---

## Node.js Dependency Installation

Automatically executes:

```bash
npm install
```

Includes handling of:

- npm cache ownership
- dependency installation
- build preparation

---

## Frontend Build

Automatically executes:

```bash
npm run build
```

for Vite-based applications.

---

# Queue System

Long-running deployment tasks are executed asynchronously using Laravel Queues.

Current queue jobs include:

- Git clone
- Composer install
- Laravel setup
- NPM install
- Frontend build

Benefits:

- Non-blocking UI
- Deployment status tracking
- Better scalability

---

# Architecture

The project follows a service-oriented architecture.

## Controllers

Responsibilities:

- Request validation
- Authorization
- Redirects
- Flash messages

Controllers remain intentionally thin.

---

## Services

### DatabaseService

Business rules and database management.

### DatabaseProvisioningService

Infrastructure-level database provisioning.

### WebspaceService

Webspace orchestration and metadata.

### WebspaceProvisioningService

Filesystem provisioning.

### NginxProvisioningService

Virtual host generation and Nginx management.

### DeployGitCloneService

Repository cloning.

### DeployComposerInstallService

Composer dependency installation.

### DeployLaravelSetupService

Laravel environment setup and migration handling.

### DeployNpmInstallService

Node dependency installation.

### DeployBuildService

Frontend build execution.

---

# Security Concepts

The project emphasizes:

- Input validation
- Controlled filesystem access
- Controlled database naming
- Least privilege principles
- Infrastructure isolation
- Secure credential generation
- Ownership management
- Execution under web server user

---

# REST API

The project exposes a REST API secured by Laravel Sanctum.

## Public Endpoints

### Plans

```http
GET /api/plans
```

Returns available hosting plans.

---

## Authentication

### Login

```http
POST /api/login
```

Returns Sanctum access token.

---

## Protected Endpoints

Protected by:

```php
auth:sanctum
```

Examples:

```http
GET /api/databases
GET /api/webspaces
```

---

# Current Status

Implemented:

- Authentication
- Hosting plans
- Database provisioning
- Webspace provisioning
- Nginx provisioning
- Git deployment
- Composer install
- Environment generation
- APP_KEY generation
- Database migrations
- NPM install
- Vite build
- Queue jobs
- REST API

---

# Planned Features

- SSL provisioning (Let's Encrypt)
- Automatic renewal handling
- Deployment logs viewer
- File manager
- Cron management
- Queue worker management
- Webspace suspension
- Webspace deletion
- Backup management
- Multi-user administration

---

# Purpose

Mini Hosting Service is primarily an educational project focused on:

- Laravel architecture
- Service layer patterns
- Linux administration
- Infrastructure automation
- Hosting platform concepts
- Deployment pipelines
- Security practices
- DevOps fundamentals

The goal is to understand how commercial hosting panels work internally by building one from scratch.