<?php
require 'functions.php';
$events = getAllEvents($pdo);
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

    <nav>
        <a href="add_event.php">Add Event</a> |
        <a href="filter.php?sport=Football">Filter by Football</a>|
        <a href="filter.php?sport=Basketball">Filter by Basketball</a> |
        <a href="filter.php?sport=Ice Hockey">Filter by Ice Hockey</a>
    </nav>

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