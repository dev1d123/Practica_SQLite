<?php
/*Prueba para imprimir los parametros ingresados! */
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

$jsonResponse = json_encode($response);
header('Content-Type: application/json');
echo $jsonResponse;
?>
