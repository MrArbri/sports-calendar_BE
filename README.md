# Sports Calendar Web Application

## Overview

The Sports Calendar Web Application is a platform that allows users to manage sports events. It enables users to add events, view a list of upcoming events, and select teams, sports, and venues. The application provides a simple interface for users to interact with the data, and all changes are stored in a MySQL database.

Key features of the application:

- Add and manage sports events
- View upcoming events with details such as sport, teams, venue, and date/time
- Create teams automatically if they don't exist when adding an event
- Responsive design for both large and small screens

## Setup and Running the Application

### Prerequisites

1. PHP (7.0 or higher)
2. MySQL (or MariaDB)
3. Apache or any other web server
4. Composer (for managing PHP dependencies)
5. A local development environment like XAMPP, MAMP, or LAMP

### 1. Clone the Repository

To get started, clone the repository to your local machine:

```bash
git clone https://github.com/MrArbri/sports-calendar_BE
```

### 2. Import the Database

You can import the database schema by using the SQL file included in the repository.

1. Navigate to `sports_event_calendar.sql`.
2. Import this file into your MySQL database through phpMyAdmin or the MySQL CLI.

### 3. Configure the Database Connection

In the `db.php` file, update the database connection details:

```php
$host = 'localhost';  // Database host
$dbname = 'sports_event_calendar'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password (default is empty for local development)
```

### 4. Install Dependencies (Optional)

If you use Composer for managing PHP dependencies, run the following command to install any necessary libraries:

```bash
composer install
```

### 5. Run the Application

After setting up the database and configuring the `db.php` file, you can start the application by navigating to the folder where your project is located and running it on your local server. The project should be accessible at:

```
http://localhost/sports-calendar_BE
```

### 6. Access the Admin Panel

You can now access the admin interface to add new events. The page for adding events is located at:

```
http://localhost/sports-calendar_BE/add_event.php
```

### 7. Viewing Events

The list of events will be available on the homepage:

```
http://localhost/sports-calendar_BE/index.php
```

## Assumptions & Design Decisions

- **Database Structure**: The database consists of tables for `Events`, `Sports`, `Venues`, `Teams`, and a pivot table `Event_Teams` to manage many-to-many relationships between events and teams.
- **Automatic Team Creation**: If a team does not exist when adding an event, it will be automatically created.
- **Responsive UI**: The form layout is designed to be responsive, adjusting for larger screens with teams displayed side by side and stacking them vertically on smaller screens.
- **Error Handling**: Basic error handling is implemented for database operations, but additional validation can be added for production environments.
