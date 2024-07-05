<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h2>User Management System Backend</h2>
</head>
<body>
   <h1>User Management System Backend</h1>

<p>This repository contains the backend implementation for a User Management System using Laravel 11.</p>

## Table of Contents
- [Prerequisites](#prerequisites)
- [Installation](#installation)
  - [Clone the repository](#clone-the-repository)
  - [Install dependencies](#install-dependencies)
- [Configuration](#configuration)
  - [Environment Setup](#environment-setup)
  - [Database Configuration](#database-configuration)
- [Running Tests](#running-tests)
- [Endpoints](#endpoints)
- [License](#license)

## Prerequisites
Before you begin, ensure you have the following installed:
- PHP >= 8.2
- Composer
- MySQL (or any supported database)
- PHPUnit

## Installation
1. **Clone the repository:**
   ```bash
   git clone https://github.com/VictoriaReyes1803/UserSystemBackend.git
   cd UserSystemBackend
   ```
    2. **Install dependencies:**
       ```bash
        composer install
        ```
    </ol>

    <h2 id="configuration">Configuration</h2>

    <h3 id="environment-setup">Environment Setup</h3>
    <ol>
        <li>Copy the <code>.env.example</code> file to <code>.env</code>:</li>
        <code>cp .env.example .env</code>
        <li>Generate application key:</li>
        <code>php artisan key:generate</code>
        <li>Update <code>.env</code> with your environment-specific settings (database credentials, etc.).</li>
    </ol>

    <h3 id="database-configuration">Database Configuration</h3>
    <ol>
        <li>Create a new MySQL database for the application.</li>
        <li>Update <code>.env</code> with your database credentials:</li>
        <pre><code>DB_CONNECTION=mysql
        DB_HOST=localhost
        DB_PORT=3306
        DB_DATABASE=UserSystem
        DB_USERNAME=your_database_user
        DB_PASSWORD=your_database_password
                </code></pre>
        <li>Migrate the database:</li>
        <code>php artisan migrate</code>
            </ol>
    <h2>Running the Api</h2>
        <ol>
            <li><strong>Start Laravel Server:</strong>
                <pre><code>php artisan serve</code></pre>
            </li>
        </ol>
    <h2 id="running-tests">Running Tests</h2>
    <p>To run PHPUnit tests:</p>
    <code>./vendor/bin/phpunit tests</code>

</body>
</html>
