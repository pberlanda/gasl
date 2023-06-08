/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
function verificaDisponibilitaUsername() {
    var username = document.getElementById("username").value;
    var errorSpan = document.getElementById("username-error");

    // debug: test
    //window.alert("ciao" + " " + username);

    // Effettua una richiesta AJAX al server per verificare l'username
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "checkUsername.php?username=" + encodeURIComponent(username), true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);

            // Controlla la risposta del server
            if (response.available) {
                errorSpan.textContent = ""; // Lo username è disponibile, nessun messaggio di errore
            } else {
                errorSpan.textContent = "Lo username '" + username + "' è già stato utilizzato.";
            }
        }
    };
    xhr.send();
}

function verificaDisponibilitaEmail() {
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var errorSpan = document.getElementById("email-error");

    // Effettua una richiesta AJAX al server per verificare che l'email non sia stata registrata per un altro utente
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "checkEmail.php?username=" + encodeURIComponent(username) + "&email=" + encodeURIComponent(email), true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);

            // Controlla la risposta del server
            if (response.available) {
                errorSpan.textContent = ""; // Lo username è disponibile, nessun messaggio di errore
            } else {
                errorSpan.textContent = email + "' è già stata utilizzata.";
            }
        }
    };
    xhr.send();
}



