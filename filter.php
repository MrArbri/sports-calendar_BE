<?php
require 'functions.php';

// Get the sport from the URL query parameter 
$sport_name = isset($_GET['sport']) ? $_GET['sport'] : '';

// Validate the sport name or redirect to index.php 
if (empty($sport_name)) {
    header('Location: index.php');
    exit;
}

// Get the events for the selected sport 
$events = getEventsBySport($pdo, $sport_name);

function getEventsBySport($pdo, $sport_name)
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
    WHERE s.name = :sport_name
    ORDER BY e.date_time ASC";

    $stmt = $pdo->prepare($query);
    $stmt->execute([':sport_name' => $sport_name]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Events by Sport</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
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

        a {
            text-decoration: none;
            margin: 0 10px;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
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

    <h1>Events for <?= htmlspecialchars($sport_name) ?></h1>

    <nav>
        <a href="add_event.php">Add Event</a> |
        <a href="filter.php?sport=Football">Filter by Football</a>|
        <a href="filter.php?sport=Basketball">Filter by Basketball</a> |
        <a href="filter.php?sport=Ice Hockey">Filter by Ice Hockey</a>
    </nav>

    <a href="index.php"> Back to All Events</a><br><br>

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
                            <td><?= htmlspecialchars((new Datetime($event['date_time']))->format('d-m-Y H:i')) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">
                            No events available for <?= htmlspecialchars($sport_name) ?>.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>