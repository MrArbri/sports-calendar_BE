<?php
require 'functions.php';

// Get the sport from the URL query parameter 
$sport_name = isset($_GET['sport']) ? $_GET['sport'] : 'Football'; // Default sport: Football

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
</head>

<body>

    <h1>Events for <?= htmlspecialchars($sport_name) ?>:</h1>

    <a href="index.php"> Back to All Events</a>

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
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= htmlspecialchars($event['description']) ?></td>
                    <td><?= htmlspecialchars($event['sport_name']) ?></td>
                    <td><?= htmlspecialchars($event['venue_name']) ?></td>
                    <td><?= htmlspecialchars($event['date_time']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>