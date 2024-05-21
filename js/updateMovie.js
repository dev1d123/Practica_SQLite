const movieForms = document.querySelector('.form-movie');
const castingForms = document.querySelector('.form-casting');

function showFormCasting() {
    castingForms.style.display = 'block'; 
}

function showFormMovie() {
    movieForms.style.display = 'block'; 
}

function closeFormMovie() {
    movieForms.style.display = 'none'; 
}

function closeFormCasting() {
    castingForms.style.display = 'none'; 
}