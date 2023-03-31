// Funkcija

const myModal = document.getElementById('myModal')
const myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', () => {
    myInput.focus()
})

// Sveramais ievades rediģēšana.

function changeStep(stepValue) {
    document.getElementById("sveramais").step = stepValue;
}
function preventDecimal(event) {
    var sveramaistype = document.querySelector('input[name="sveramaistype"]:checked').value;
    if (sveramaistype === "Skaits") {
        event.target.value = event.target.value.replace(".", "");
    }
}

// Meklēšanas Funkcija


