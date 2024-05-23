document.getElementById("filter").addEventListener("submit", function(event){
    event.preventDefault(); 
    //obtener los parametros cuando se llame a la funcion
    var actor1 = document.getElementById("actor1").value;
    var actor2 = document.getElementById("actor2").value;
    var actor3 = document.getElementById("actor3").value;
    var title = document.getElementById("title").value;
    var minYear = document.getElementById("minYear").value;
    var maxYear = document.getElementById("maxYear").value;
    var minScore = document.getElementById("minScore").value;
    var maxScore = document.getElementById("maxScore").value;
    var minVotes = document.getElementById("minVotes").value;
    var maxVotes = document.getElementById("maxVotes").value;


    var params = "actor1=" + encodeURIComponent(actor1) +
    "&actor2=" + encodeURIComponent(actor2) +
    "&actor3=" + encodeURIComponent(actor3) +
    "&title=" + encodeURIComponent(title) +
    "&minYear=" + encodeURIComponent(minYear) +
    "&maxYear=" + encodeURIComponent(maxYear) +
    "&minScore=" + encodeURIComponent(minScore) +
    "&maxScore=" + encodeURIComponent(maxScore) +
    "&minVotes=" + encodeURIComponent(minVotes) +
    "&maxVotes=" + encodeURIComponent(maxVotes);

    //efectuando la consulta mediante ajax
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/show.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        if(xhr.status === 200){
            console.log("Conexion exitosa");
            console.log(xhr.responseText);
        }else{
            console.log("Error");
        }
    };
    xhr.send(params);
});


//funcion para cargar a los actores

console.log("Cargando a los actores!!!");
//solicitud fetch en toda la tabla actores!
var xhr2 = new XMLHttpRequest();
xhr2.open("POST", "../php/showActors.php", true);
xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

xhr2.onload = function(){
    if(xhr2.status === 200){
        console.log("Conexion exitosa, actores recibidos!");
        //convertir los valores a json
        const data = JSON.parse(xhr2.responseText);

        console.log(xhr2.responseText);
        printSelect(data);
    }else{
        console.log("Error");
    }
};
xhr2.send();

function printSelect(data){
    var select = document.querySelectorAll(".actorSelect");
    select.forEach(function(selectElement){
        data.forEach((actor)=>{
            console.log(actor.Name)
            var newOpt = document.createElement('option');
            newOpt.textContent = actor.Name;
            newOpt.value = actor.Name;
            selectElement.appendChild(newOpt);
        });
    });
    
}