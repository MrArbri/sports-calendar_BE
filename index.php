<?php
require 'functions.php';

// Get available sports and venues
$sports = getAllSports($pdo);
$venues = getAllVenues($pdo);

// Get the sport and venue from the URL query parameter 
$sport_name = isset($_GET['sport']) ? $_GET['sport'] : '';
$venue_id = isset($_GET['venue']) ? $_GET['venue'] : '';

// Get filtered events or all events if no filter is applied
$events = getFilteredEvents($pdo, $sport_name, $venue_id);

function getFilteredEvents($pdo, $sport_name, $venue_id)
{
    $query = "
    SELECT
        e.id AS event_id,
        e.description,
        e.date_time,
        s.name AS sport_name,
        v.name AS venue_name
    FROM Events e
    JOIN Sports s ON e.sport_id = s.id
    LEFT JOIN Venues v ON e.venue_id = v.id
    WHERE (:sport_name = '' OR s.name = :sport_name)
    AND (:venue_id = '' OR v.id = :venue_id)
    ORDER BY e.date_time ASC";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':sport_name' => $sport_name,
        ':venue_id' => $venue_id,
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Event Calendar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 10px;
        }

        h1 {
            text-align: center;
        }

        form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
            gap: 10px;
            padding: 10px;
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
        }

        select {
            padding: 5px 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 5px 15px;
            font-size: 14px;
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

        #table {
            display: flex;
            justify-content: center;
        }

        table {
            width: 95%;
            border-collapse: collapse;
            margin-top: 5%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        nav {
            text-align: center;
            margin-bottom: 20px;
        }

        nav a {
            text-decoration: none;
            margin: 0 10px;
            color: #007bff;
        }

        nav a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <h1>Sports Event Calendar</h1>

    <form method="GET" action="index.php">
        <label for="sport">Filter by Sport:</label>
        <select id="sport" name="sport">
            <option value="">-- All Sports --</option>
            <?php foreach ($sports as $sport): ?>
                <option value="<?= htmlspecialchars($sport['name']) ?>">
                    <?= htmlspecialchars($sport['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="venue">Filter by Venue:</label>
        <select id="venue" name="venue">
            <option value="">-- All Venues --</option>
            <?php foreach ($venues as $venue): ?>
                <option value="<?= htmlspecialchars($venue['id']) ?>">
                    <?= htmlspecialchars($venue['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Filter</button>
    </form>

    <div id="table">
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Sport</th>
                    <th>Venue</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?= htmlspecialchars($event['description']) ?></td>
                            <td><?= htmlspecialchars($event['sport_name']) ?></td>
                            <td><?= htmlspecialchars($event['venue_name']) ?></td>
                            <td><?= htmlspecialchars((new DateTime($event['date_time']))->format('d-m-Y H:i')) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">No events available at the moment.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>