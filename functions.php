<?php
require 'db.php';

function getAllEvents($pdo)
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
    ORDER BY e.date_time ASC";

    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllSports($pdo)
{
    $query = "SELECT id, name FROM Sports ORDER BY name ASC";
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllVenues($pdo)
{
    $query = "SELECT id, name FROM Venues ORDER BY name ASC";
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addEvent($pdo, $sport_id, $description, $venue_id, $date_time)
{
    $query = "
    INSERT INTO Events (sport_id, description, venue_id, date_time)
    VALUES (:sport_id, :description, :venue_id, :date_time)";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':sport_id' => $sport_id,
        ':description' => $description,
        ':venue_id' => $venue_id,
        ':date_time' => $date_time
    ]);
    return $pdo->lastInsertId();
}
