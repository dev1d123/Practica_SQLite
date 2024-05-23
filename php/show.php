<?php
    /* Prueba para imprimir los parametros ingresados */
    $actor1 = isset($_POST["actor1"]) ? $_POST["actor1"] : null;
    $actor2 = isset($_POST["actor2"]) ? $_POST["actor2"] : null;
    $actor3 = isset($_POST["actor3"]) ? $_POST["actor3"] : null;

    $title = isset($_POST["title"]) ? $_POST["title"] : null;

    $minYear = isset($_POST["minYear"]) ? $_POST["minYear"] : null;
    $maxYear = isset($_POST["maxYear"]) ? $_POST["maxYear"] : null;

    $minScore = isset($_POST["minScore"]) ? $_POST["minScore"] : null;
    $maxScore = isset($_POST["maxScore"]) ? $_POST["maxScore"] : null;

    $minVotes = isset($_POST["minVotes"]) ? $_POST["minVotes"] : null;
    $maxVotes = isset($_POST["maxVotes"]) ? $_POST["maxVotes"] : null;

    $response = [
        "actor1" => $actor1,
        "actor2" => $actor2,
        "actor3" => $actor3,
        "title" => $title,
        "minYear" => $minYear,
        "maxYear" => $maxYear,
        "minScore" => $minScore,
        "maxScore" => $maxScore,
        "minVotes" => $minVotes,
        "maxVotes" => $maxVotes
    ];

    try {
        // Creación de objeto PHP Data Objects
        $pdo = new PDO('sqlite:../database/imdb.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Primera consulta: buscar por título
        $sql = "SELECT Movie.* FROM Movie WHERE 1=1";
        $params = [];

        if ($title) {
            $sql .= " AND Title = :title";
            $params[':title'] = $title;
        }

        $query = $pdo->prepare($sql);
        $query->execute($params);

        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        // Si no hay resultados, realizar la búsqueda con otros parámetros
        if (empty($results)) {
            $sql = "SELECT Movie.* FROM Movie 
                    LEFT JOIN Casting ON Movie.MovieID = Casting.MovieID
                    LEFT JOIN Actor ON Casting.ActorID = Actor.ActorID
                    WHERE 1=1";
            $params = [];

            if ($minYear) {
                $sql .= " AND Year >= :minYear";
                $params[':minYear'] = $minYear;
            }
            if ($maxYear) {
                $sql .= " AND Year <= :maxYear";
                $params[':maxYear'] = $maxYear;
            }
            if ($minScore) {
                $sql .= " AND Score >= :minScore";
                $params[':minScore'] = $minScore;
            }
            if ($maxScore) {
                $sql .= " AND Score <= :maxScore";
                $params[':maxScore'] = $maxScore;
            }
            if ($minVotes) {
                $sql .= " AND Votes >= :minVotes";
                $params[':minVotes'] = $minVotes;
            }
            if ($maxVotes) {
                $sql .= " AND Votes <= :maxVotes";
                $params[':maxVotes'] = $maxVotes;
            }

            if ($actor1 || $actor2 || $actor3) {
                $actorConditions = [];
                if ($actor1) {
                    $actorConditions[] = "Actor.Name = :actor1";
                    $params[':actor1'] = $actor1;
                }
                if ($actor2) {
                    $actorConditions[] = "Actor.Name = :actor2";
                    $params[':actor2'] = $actor2;
                }
                if ($actor3) {
                    $actorConditions[] = "Actor.Name = :actor3";
                    $params[':actor3'] = $actor3;
                }
                if ($actorConditions) {
                    $sql .= " AND (" . implode(" OR ", $actorConditions) . ")";
                }
            }

            $query = $pdo->prepare($sql);
            $query->execute($params);
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
        }

        $json = json_encode($results);

        header('Content-Type: application/json');
        echo $json;
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
?>
