<?php
require 'functions.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sport_id = $_POST['sport_id'];
    $description = $_POST['description'];
    $venue_id = $_POST['venue_id'];
    $date_time = $_POST['date_time'];

    // Add the event to the database 
    addEvent($pdo, $sport_id, $description, $venue_id, $date_time);

    // Redirect back to the main page
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
</head>

<body>

    <h1>Add New Event</h1>

    <form method="POST" action="">

        <label for="sport_id">Sport ID: </label>
        <input type="number" id="sport_id" name="sport_id" required> <br><br>

        <label for="description">Description: </label>
        <input type="text" name="description" id="description" required><br><br>

        <label for="venue_id">Venue ID: </label>
        <input type="number" name="venue_id" id="venue_id" required><br><br>

        <label for="date_time">Date & Time: </label>
        <input type="datetime-local" name="date_time" id="date_time" required><br><br>

        <button type="submit">Add Neu Event</button>

    </form>

</body>

</html>