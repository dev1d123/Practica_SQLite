<?php
$title = $_POST["title"];
$year = $_POST["year"];
$score = $_POST["score"];
$votes = $_POST["votes"];

try {
    $pdo = new PDO('sqlite:../database/imdb.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO Movie (title, year, score, votes) VALUES (:title, :year, :score, :votes)";
    
    $statement = $pdo->prepare($sql);
    
    $statement->bindParam(':title', $title);
    $statement->bindParam(':year', $year);
    $statement->bindParam(':score', $score);
    $statement->bindParam(':votes', $votes);
    
    $statement->execute();
    
    echo json_encode(array("success" => true));
} catch (PDOException $e) {
    echo json_encode(array("success" => false, "error" => $e->getMessage()));
}
?>
