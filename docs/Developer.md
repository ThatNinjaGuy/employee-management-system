# Developer Guide

This guide provides instructions for setting up the EMS App for development.

## Prerequisites

- PHP
- Composer for dependency management
- MySQL server running locally

## Setup Instructions

1. **Clone the Repository**: Clone the EMS App repository to your local machine.

   ```bash
   git clone <repository-url>
   cd ems-app
   ```

2. **Install Dependencies**: Use Composer to install PHP dependencies.

   ```bash
   composer install
   ```

3. **Database Setup**: Ensure the MySQL server is running and import the database dump.

   ```bash
   mysql -u root -p client_payroll < client_payroll_dump.sql
   ```

4. **Configure Environment**: Copy the `.env.example` to `.env` and configure your environment variables - As of now this is not required as all the environment variables are set in the `includes/dbconn.php` file. This should be removed in future and shifted to the `.env` file.

   ```bash
   cp .env.example .env
   ```

5. **Start the PHP Server**: Use PHP's built-in server to run the application locally.

   ```bash
   php -S localhost:8000
   ```

6. **Access the Application**: Open your web browser and navigate to `http://localhost:8000` to access the EMS App.

## Additional Resources

- For more information on the database structure, refer to the [Database Details](database_details.md).
- For any issues or contributions, please refer to the project's issue tracker or contact the maintainers.
