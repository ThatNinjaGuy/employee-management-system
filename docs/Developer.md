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

3. **Database Setup**: Ensure the MySQL server is running and import the database dump. This is a required step as the database is not created automatically on application startup, atleast on local. On production, the understanding is not clear as of now.

   ```bash
   mysql -u root -p client_payroll < client_payroll_dump.sql
   ```

4. **Configure Database Connection**: The application currently uses hardcoded database credentials in `includes/dbconn.php`. You'll need to update these to match your local MySQL configuration:

   - Open `includes/dbconn.php`
   - Update the following values:

     ```php
     define('DB_USER', 'your_mysql_username'); // Default is 'root'
     define('DB_PASS', 'your_mysql_password'); // Set to your MySQL password
     ```

   Note: In the future, these credentials will be moved to a proper `.env` configuration file for better security and flexibility.

5. **Start the PHP Server**: Use PHP's built-in server to run the application locally.

   ```bash
   php -S localhost:8000
   ```

6. **Access the Application**: Open your web browser and navigate to `http://localhost:8000` to access the EMS App.

7. **Login**: There are 2 users in the system - `admin` and `user`.

   - **Admin**: Use the following credentials to login to the admin panel of the application:

     - Username: `admin`
     - Password: `Password@123`
   - **User**: Use the following credentials to login to the user panel of the application:
     - Username: `user`
     - Password: `Password@123`

## Additional Resources

- For more information on the database structure, refer to the [Database Details](database_details.md).
- For any issues or contributions, please refer to the project's issue tracker or contact the maintainers.
