<?php
    /* Prueba para imprimir los parametros ingresados */
    $actor = isset($_POST["actor"]) ? $_POST["actor"] : null;

    $title = isset($_POST["title"]) ? $_POST["title"] : null;

    $minYear = isset($_POST["minYear"]) ? $_POST["minYear"] : null;
    $maxYear = isset($_POST["maxYear"]) ? $_POST["maxYear"] : null;

    $minScore = isset($_POST["minScore"]) ? $_POST["minScore"] : null;
    $maxScore = isset($_POST["maxScore"]) ? $_POST["maxScore"] : null;

    $minVotes = isset($_POST["minVotes"]) ? $_POST["minVotes"] : null;
    $maxVotes = isset($_POST["maxVotes"]) ? $_POST["maxVotes"] : null;

    $response = [
        "actor" => $actor,
        "title" => $title,
        "minYear" => $minYear,
        "maxYear" => $maxYear,
        "minScore" => $minScore,
        "maxScore" => $maxScore,
        "minVotes" => $minVotes,
        "maxVotes" => $maxVotes
    ];

    try {
        $pdo = new PDO('sqlite:../database/imdb.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT Movie.* FROM Movie WHERE 1=1";
        $params = [];
        $sql .= ($minYear !== null ? " AND Year >= :minYear" : "") .
                ($maxYear !== null ? " AND Year <= :maxYear" : "") .
                ($minScore !== null ? " AND Score >= :minScore" : "") .
                ($maxScore !== null ? " AND Score <= :maxScore" : "") .
                ($minVotes !== null ? " AND Votes >= :minVotes" : "") .
                ($maxVotes !== null ? " AND Votes <= :maxVotes" : "");

        if ($minYear !== null) $params[':minYear'] = $minYear;
        if ($maxYear !== null) $params[':maxYear'] = $maxYear;
        if ($minScore !== null) $params[':minScore'] = $minScore;
        if ($maxScore !== null) $params[':maxScore'] = $maxScore;
        if ($minVotes !== null) $params[':minVotes'] = $minVotes;
        if ($maxVotes !== null) $params[':maxVotes'] = $maxVotes;

        if ($title) {
            $sql .= " AND Title = :title";
            $params[':title'] = $title;
            
            $query = $pdo->prepare($sql);
            $query->execute($params);
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $json = json_encode($results);
            header('Content-Type: application/json');
            echo $json;
            exit;


        }

        if ($actor) {
            $actorSql = "SELECT ActorID FROM Actor WHERE Name = :actor";
            $actorQuery = $pdo->prepare($actorSql);
            $actorQuery->execute([':actor' => $actor]);
            $actorResult = $actorQuery->fetch(PDO::FETCH_ASSOC);


            
            if ($actorResult) {

                $actorId = $actorResult['ActorId'];
                $castingSql = "SELECT MovieID FROM Casting WHERE ActorId = :actorId";
                $castingQuery = $pdo->prepare($castingSql);
                $castingQuery->execute([':actorId' => $actorId]);
                $castingResults = $castingQuery->fetchAll(PDO::FETCH_ASSOC);


                if ($castingResults) {
                    $sql .= " AND (";
                    $dor = 0;
                    foreach ($castingResults as $row) {
                        if ($dor > 0) {
                            $sql .= " OR ";
                        }
                        $sql .= "MovieID = " . $row['MovieID'];
                        $dor++;
                    }
                    $sql .= ")";
                    

                } else {
                    $results = [];
                    echo json_encode($results);
                    exit;
                }
            } else {
                $results = [];
                echo json_encode($results);
                exit;
            }
        }


        // Ejecutar la consulta final
        $query = $pdo->prepare($sql);
        $query->execute($params);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        // Devolver los resultados en formato JSON
        $json = json_encode($results);
        header('Content-Type: application/json');
        echo $json;
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
?>
