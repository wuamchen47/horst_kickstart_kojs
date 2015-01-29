 function regformhash(form, password, conf) {
     // Überprüfe, ob jedes Feld einen Wert hat
    if (password.value == ''  || 
          conf.value == '') {
 
        alert('Alles ausfüllen, Meister!');
        return false;
    }
 
    // Überprüfe, dass Passwort lang genug ist (min 6 Zeichen)
    // Die Überprüfung wird unten noch einmal wiederholt, aber so kann man dem 
    // Benutzer mehr Anleitung geben
    if (password.value.length < 6) {
        alert('Check nochmal die Passwortregeln, kleiner Tipp: zu kurz...');
        form.password.focus();
        return false;
    }
 
    // Mindestens eine Ziffer, ein Kleinbuchstabe und ein Großbuchstabe
    // Mindestens sechs Zeichen 
 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Check nochmal die Passwortregeln...');
        return false;
    }
 
    // Überprüfe die Passwörter und bestätige, dass sie gleich sind
    if (password.value != conf.value) {
        alert('Die Passwörter stimmen nicht überein');
        form.password.focus();
        return false;
    }
 
    // Erstelle ein neues Feld für das gehashte Passwort.
    var p = document.createElement("input");
 
    // Füge es dem Formular hinzu. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Sorge dafür, dass kein Text-Passwort geschickt wird. 
    password.value = "";
    conf.value = "";
 
    // Reiche das Formular ein. 
    form.submit();
    return true;
}