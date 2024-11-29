## Laravel Task Scheduling and Caching Application

This Laravel application demonstrates how to implement task scheduling and caching using Redis. The main objective is to periodically fetch data from an external API, cache the results, and provide endpoints to access the cached data.

## Features

- **Task Scheduling: Automates periodic tasks using Laravel’s scheduler.**
- **Redis Integration: Uses Redis for caching API responses for faster data retrieval.**
- **Background Jobs: Implements Laravel Jobs to fetch and cache data asynchronously.**
- **Database Logging: Logs API request metadata for auditing purposes.**
- **Cache Expiry: Automatically invalidates cached data every hour.**
- **User Interface: A simple web interface to refresh cache manually and view logs.**
- **API Endpoint: Fetch cached data via an API route.**

## Installation Prerequisites

Ensure you have the following installed:

- **PHP 8.0+**
- **Composer**
- **Redis server**
- **MySQL (or any other supported database)**

### Steps in Setting-up

- **Clone the repository**
- git clone https://github.com/infotrix1/taskscheduling.git
- **Install dependencies**
- composer install
- **Configure environment variables**
- Update the .env file with your database and Redis credentials:
- **Generate the application key**
- php artisan key:generate
- **Run migrations to set up the database**
- php artisan migrate
- **Start the Redis server**
- **Run the application**
- php artisan serve

### Architecture
### Key Components

- **Controller**
- LogController handles web routes and allows manual cache refresh.
- **Services**
- LogService contains business logic for fetching and caching API data.
- **Repository**
- LogRepository manages database interactions for storing API logs.
- **Job**
- CacheApiDataJob asynchronously fetches and caches API data.
- **Scheduler**
- CacheApiDataJob asynchronously fetches and caches API data.

### Artisan Commands

- **Start the Scheduler**
- php artisan schedule:work
- **Queue Worker**
- php artisan queue:work
- **Clear Cache**
- php artisan cache:clear


  


