

# Laravel Project Setup with PostgreSQL

This guide walks you through setting up your Laravel project with a PostgreSQL database.

## 🚀 Setup Instructions

1. **Clone the repository**

   ```bash
   git clone https://github.com/Sun-vatanak/moblieapp-api-nu.git
   cd moblieapp-api-nu
   ```

2. **Copy the example environment file**

   ```bash
   cp .env.example .env
   ```

3. **Configure your `.env` file**

   Update the database settings in `.env`:

   ```
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Install dependencies**

   ```bash
   composer install
   ```

5. **Generate application key**

   ```bash
   php artisan key:generate
   ```

6. **Run migrations and seed the database**

   ```bash
   php artisan migrate --seed
   ```
   6. **Run Project**

      ```
      php artisan serve
     ```

---


