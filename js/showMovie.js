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

    console.log("Los parametros son: ", params);
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