# Localhost Setup Guide for AdminHub

## Prerequisites
- XAMPP installed and running
- Apache and MySQL services started

## Setup Steps

### 1. Start XAMPP Services
1. Open XAMPP Control Panel
2. Start Apache and MySQL services
3. Make sure both services show green status

### 2. Create Database
1. Open your browser and go to: `http://localhost/phpmyadmin`
2. Click on "SQL" tab
3. Copy and paste the contents of `database.sql` file
4. Click "Go" to execute the SQL

### 3. Test the Application
1. Open your browser and go to: `http://localhost/AdminHub/signup.html`
2. Create a new account
3. Go to: `http://localhost/AdminHub/login.html`
4. Login with your credentials

## Test Credentials
- Email: `test@example.com`
- Password: `password`

## Files Created/Modified
- `config.php` - Database connection configuration
- `auth.php` - Authentication handler for login/signup
- `database.sql` - Database setup script
- `signup.html` - Updated to work with localhost backend
- `login.html` - Updated to work with localhost backend

## Features
- User registration with validation
- User login with authentication
- Password hashing for security
- Session management
- Basic form validation

## Troubleshooting
- Make sure Apache and MySQL are running in XAMPP
- Check that the database `adminhub` exists
- Verify file permissions are correct
- Check browser console for any JavaScript errors 