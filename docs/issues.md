# Pending Issues

1. Password Hashing
   - **Current Implementation**: Passwords are stored using MD5 hashes in the database
   - **Problem**: MD5 is cryptographically broken and unsuitable for password hashing
   - **Recommendation**: Replace with a secure hashing algorithm like:
     - bcrypt
     - Argon2
     - PBKDF2
     - scrypt
   - **Priority**: High - This is a critical security vulnerability

2. Seeding Configs for the application
   - **Current Implementation**: No config seeding is done. SQL dump file has been provided for the database @client_payroll_dump.sql
   - **Problem**: The application is not able to check and ensure DB readiness on application load and requires manual condiguration.
   - **Recommendation**: Seeding the config for the application
   - **Priority**: Medium - This is a critical maintenance issue. Schema visibility is lost and creates issues on fresh development efforts.

3. The file includes/dbconn.php is not secure. It contains the database credentials in plain text.
   - **Current Implementation**: The file dbconn.php contains the database credentials in plain text. This also has the issue that the database credentials are hardcoded and need to be tuned for every user.
   - **Problem**: The file dbconn.php contains the database credentials in plain text.
   - **Recommendation**: The file dbconn.php should be removed and the database credentials should be stored in the .env file.
   - **Priority**: High - This is a critical security vulnerability.

4. Remove the following files from the project:
   - admin/view-employees.php
