function habilita() {

    var select = document.getElementById('tipoSolicitante');

    var value = select.options[select.selectedIndex].value;

    if (value === '1') {
       document.getElementById("rm").disabled = false; // para ativar campo

    } else {
        document.getElementById("rm").value = '';
        document.getElementById("rm").disabled = true; // para desativar campo
    } 
}


