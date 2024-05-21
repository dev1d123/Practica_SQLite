function closeAlertExito(){
    const alert = document.querySelector(".alertaExito");
    alert.style.display = block;
}
function closeAlertError(){
    const alert = document.querySelector(".alertaError");
    alert.style.display = block;
}

document.getElementById('myForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const currentUrl = window.location.href;
    const url = new URL(currentUrl);

    // Usar URLSearchParams para obtener los parámetros de consulta
    const urlParams = new URLSearchParams(url.search);

    const title = urlParams.get('title'); 
    const year = urlParams.get('year'); 
    const score = urlParams.get('score'); 
    const votes = urlParams.get('votes'); 

    console.log(`Title: ${title}`);
    console.log(`Year: ${year}`);
    console.log(`Score: ${score}`);
    console.log(`Votes: ${votes}`);
});



function getData(){

}

