<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System Backend</title>
</head>
<body>
    <h1>User Management System Backend</h1>

    <p>This repository contains the backend implementation for a User Management System using Laravel 11.</p>

    <h2>Table of Contents</h2>
    <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
        <li><a href="#configuration">Configuration</a></li>
        <ul>
            <li><a href="#environment-setup">Environment Setup</a></li>
            <li><a href="#database-configuration">Database Configuration</a></li>
        </ul>
        <li><a href="#running-tests">Running Tests</a></li>
        <li><a href="#endpoints">Endpoints</a></li>
        <li><a href="#license">License</a></li>
    </ul>

    <h2 id="prerequisites">Prerequisites</h2>
    <p>Before you begin, ensure you have the following installed:</p>
    <ul>
        <li>PHP >= 8.2</li>
        <li>Composer</li>
        <li>MySQL (or any supported database)</li>
        <li>PHPUnit</li>
    </ul>

    <h2 id="installation">Installation</h2>
    <ol>
        <li>Clone the repository:</li>
        <code>git clone https://github.com/VictoriaReyes1803/UserSystemBackend.git</code>
        <code>cd UserSystemBackend</code>
        <code>cd UserManagementSystem</code>
        
        <li>Install dependencies:</li>
        <code>composer install</code>
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
