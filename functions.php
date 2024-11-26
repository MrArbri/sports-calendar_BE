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

function addEvent($pdo, $sport_id, $description = null, $venue_id, $date_time)
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

// Check if a team exists or create it if it does not.
function getOrCreateTeam($pdo, $team_name)
{
    // Check if the team exists
    $stmt = $pdo->prepare('SELECT id FROM teams WHERE name = ?');
    $stmt->execute([$team_name]);
    $team = $stmt->fetch();

    if ($team) {
        // Return existing team ID
        return $team['id'];
    } else {
        // Insert new team and return the new ID
        $stmt = $pdo->prepare('INSERT INTO teams (name) VALUES (?)');
        $stmt->execute([$team_name]);
        return $pdo->lastInsertId();
    }
}

// Link a team to an event in the Event_Teams table.
function linkTeamToEvent($pdo, $event_id, $team_id)
{
    $stmt = $pdo->prepare('INSERT INTO event_teams (event_id, team_id) VALUES (?, ?)');
    $stmt->execute([$event_id, $team_id]);
}
