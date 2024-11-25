<?php
require 'functions.php';

// Fetch all sports and venues from the database to populate the dropdowns
$sports = getAllSports($pdo);
$venues = getAllVenues($pdo);

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sport_id = $_POST['sport_id'];
    $description = $_POST['description'];
    $venue_id = $_POST['venue_id'];
    $date_time = $_POST['date_time'];

    // Add the event to the database 
    addEvent($pdo, $sport_id, $description, $venue_id, $date_time);

    // Redirect back to the main page with a success message 
    header('Location: index.php?success=1');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        a {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            padding: 5px;
            font-size: 12px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #0056b3;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        input,
        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input:hover {
            background-color: #f0f8ff;
        }

        input:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            input {
                font-size: 14px;
            }

            button {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>

<body>

    <h1>Add New Event</h1>

    <a href="index.php">⇦ Back to All Events</a>

    <form method="POST" action="">
        <fieldset>
            <legend>Event Details</legend>
            <label for="sport_id">Select Sport:</label>
            <select id="sport_id" name="sport_id" required>
                <option value="" disabled selected>-- Choose a Sport --</option>
                <?php foreach ($sports as $sport): ?>
                    <option value="<?= htmlspecialchars($sport['id']) ?>"><?= htmlspecialchars($sport['name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="description">Description: </label>
            <input type="text" name="description" id="description" placeholder="Enter event description" required>
        </fieldset>

        <fieldset style="margin: 20px 0">
            <legend>Location and Time</legend>
            <label for="venue_id">Select Venue: </label>
            <select id="venue_id" name="venue_id" required>
                <option value="" disabled selected>-- Choose a Venue --</option>
                <?php foreach ($venues as $venue): ?>
                    <option value="<?= htmlspecialchars($venue['id']) ?>"><?= htmlspecialchars($venue['name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="date_time">Date & Time: </label>
            <input type="datetime-local" name="date_time" id="date_time" required>
        </fieldset>

        <button type="submit">Add New Event</button>
    </form>

</body>


</html>