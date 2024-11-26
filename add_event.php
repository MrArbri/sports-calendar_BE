<?php
require 'functions.php';

// Fetch all sports and venues from the database to populate the dropdowns
$sports = getAllSports($pdo);
$venues = getAllVenues($pdo);

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sport_id = $_POST['sport_id'];
    $team1_name = trim($_POST['team1']);
    $team2_name = trim($_POST['team2']);
    $venue_id = $_POST['venue_id'];
    $date_time = $_POST['date_time'];

    // Check or create Team 1
    $team1_id = getOrCreateTeam($pdo, $team1_name);

    // Check or create Team 2
    $team2_id = getOrCreateTeam($pdo, $team2_name);

    // Create a description for the event
    $description = $team1_name . ' - vs - ' . $team2_name;

    // Add the event to the database 
    $event_id = addEvent($pdo, $sport_id, $description, $venue_id, $date_time);

    // Link the teams to the event
    linkTeamToEvent($pdo, $event_id, $team1_id);
    linkTeamToEvent($pdo, $event_id, $team2_id);

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
            background-color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        nav {
            text-align: start;
            padding: 10px;
            background-color: green;
            color: #fff;
            font-size: 14px;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            text-decoration: none;
            padding: 10px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #0056b3;
        }

        .main-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }



        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Wrapper for team fields */
        .team-fields {
            display: flex;
            gap: 20px;
            /* Space between the fields */
            flex-wrap: wrap;
            /* Allows wrapping on smaller screens */
        }

        .team-field {
            flex: 1;
            /* Ensures both fields take up equal width */
            min-width: 200px;
            /* Ensures a minimum width for each field */
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

        footer {
            width: auto;
            text-align: center;
            padding: 10px;
            background-color: #212121;
            color: #fff;
            border-top: 1px solid #ddd;
            font-size: 14px;
            margin-top: 20px;
        }

        @media (max-width: 600px) {

            .team-fields {
                flex-direction: column;
                /* Stack the fields */
                gap: 10px;
                /* Reduce space between fields */
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

    <nav>
        <a href="index.php">⇦ Back to All Events</a>
    </nav>

    <div class="main-content">
        <h1>Add New Event</h1>

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

                <div class="team-fields">
                    <div class="team-field">
                        <label for="team1">Team 1: </label>
                        <input type="text" name="team1" id="team1" placeholder="Enter Team 1 Name" required>
                    </div>
                    <div class="team-field">
                        <label for="team2">Team 2: </label>
                        <input type="text" name="team2" id="team2" placeholder="Enter Team 2 Name" required>
                    </div>
                </div>
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
    </div> <!-- End of .main-content -->

    <footer>
        <p>&copy; <?= date('Y'); ?> Arbër Islamaj. All rights reserved.</p>
    </footer>

</body>


</html>