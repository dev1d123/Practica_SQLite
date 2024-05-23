<?php
    try {
        $pdo = new PDO('sqlite:../database/imdb.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM Actor";
        $query = $pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $json = json_encode($results);
        header('Content-Type: application/json');
        echo $json;
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
?>
