/**
 * Visualizza gli orari considerati validi a partire
 * dall'orario selezionato.
*/
function validTime() {
    let initialTime = parseInt(document.getElementById("from").value);
    let times = [
        "8:00",
        "8:30",
        "9:00",
        "9:30",
        "10:00",
        "10:30",
        "11:00",
        "11:30",
        "12:00",
        "12:30",
        "13:00",
        "13:30",
        "14:00"
    ];

    let new_times = "";
    let i;
    for (i = initialTime + 1; i < times.length; ++i) {
        new_times += `<option value=\"${i}\">${times[i]}</option>`
    }
    document.getElementById("to").innerHTML = new_times;
}

/**
 * Genera i mesi e imposta l'attributo selected al mese corrente
*/
function updateMonths(currentMonthIndex) {
    let months = [
        "Gennaio",
        "Febbraio",
        "Marzo",
        "Aprile",
        "Maggio",
        "Giugno",
        "Luglio",
        "Agosto",
        "Settembre",
        "Ottobre",
        "Novembre",
        "Dicembre"
    ];

    let options = "";
    let i;
    for (i = 0; i < months.length; i++) {
        options += `<option value=\"${i}\"`;
        if (i === currentMonthIndex) {
            options += ` selected`;
        }
        options += `>${months[i]}</option>`
    }

    document.getElementById("month").innerHTML = options;
}

/**
 * Aggiorna gli anni disponibili per la prenotazione
 * 
 * @param year anno corrente
 */
function updateYears(year) {
    const YEARS = 2;
    let years = "";
    let i;
    for (i = 0; i < YEARS; i++) {
        years += `<option value=\"${year + i}\">${year + i}</option>\n`;
    }
    document.getElementById("year").innerHTML = years;
}

/**
 * Richiesta asincrona per aggiornare il calendario
*/
function updateTable() {
    const year = document.getElementById("year").value;
    const month = parseInt(document.getElementById("month").value);
    const URL = `http://138.41.20.100/~rizzello2400/src/gestione_calendario.php?year=${encodeURIComponent(year)}&month=${encodeURIComponent(month)}`;

    fetch(URL)
        .then(response => {
            if (!response.ok) {
                throw new Error('Errore nella richiesta HTTP: ' + response.statusText);
            }
            return response.text();
        })
        .then(data => {
            document.getElementById("calendar").innerHTML = data;
        })
        .catch(error => {
            if (error.name === 'TypeError') {
                console.error('Errore di rete:', error.message);
            } else {
                console.error('Si è verificato un errore imprevisto: ', error.message);
            }
        });
}
