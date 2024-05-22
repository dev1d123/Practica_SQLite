//obtener todos los parametros!
var actor1 = document.getElementById("actor1");
var actor2 = document.getElementById("actor2");
var actor3 = document.getElementById("actor3");

var minYear = document.getElementById("minYear");
var maxYear = document.getElementById("maxYear");

var minScore = document.getElementById("minScore");
var maxScore = document.getElementById("maxScore");

var minVotes = document.getElementById("minVotes");
var maxVotes = document.getElementById("maxVotes");

document.getElementById("filter").addEventListener("submit", function(event){
    event.preventDefault(); // Evitar el envío del formulario por defecto

    console.log("El maximo puntaje es: ", maxScore.value);
});