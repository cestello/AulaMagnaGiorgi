/**
 * Aggiorna gli anni disponibili per la prenotazione
 * 
 * @param anno corrente
*/
function sceltaAnni(anno) {
    const ANNI = 2;
    let opzioni = "";

    let i;
    for (i = 0; i < ANNI; i++) {
        opzioni += `<option value=\"${anno + i}\">${anno + i}</option>\n`;
    }

    document.getElementById("year").innerHTML = opzioni;
}

/**
 * Genera i mesi e imposta l'attributo selected al mese corrente
 * 
 * @param indiceMeseCorrente intervallo [0-12)
*/
function sceltaMesi(indiceMeseCorrente) {
    const MESI = [
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

    let opzioni = "";
    let i;
    for (i = 0; i < MESI.length; i++) {
        opzioni += `<option value=\"${i}\"`;
        if (i === indiceMeseCorrente) {
            opzioni += ` selected`;
        }
        opzioni += `>${MESI[i]}</option>`
    }

    document.getElementById("month").innerHTML = opzioni;
}

/**
 * Input per selezionare un giorno del dato mese
 * 
 * @param anno scelto
 * @param mese scelto
 * @param oggi giorno corrente
 */
function sceltaGiorni(anno, mese, oggi) {
    const numeroDiGiorni = new Date(anno, mese + 1, 0).getDate();
    oggi = Math.min(oggi, numeroDiGiorni);

    let opzioni = "";
    let i;
    for (i = 1; i <= numeroDiGiorni; i++) {
        opzioni += `<option value="${i}"`;
        if (i === oggi) {
            opzioni += ` selected`;
        }
        opzioni += `>${i}</option>`;
    }

    document.getElementById("day").innerHTML = opzioni;
}

/**
 * Visualizza gli orari considerati validi a partire
 * dall'orario selezionato.
*/
function visualizzaOrariValidi() {
    let orarioInizio = parseInt(document.getElementById("from").value);
    const ORARI = [
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

    let nuoviOrari = "";
    let i;
    for (i = orarioInizio + 1; i < ORARI.length; ++i) {
        nuoviOrari += `<option value=\"${i}\"`;
        nuoviOrari += `>${ORARI[i]}</option>`;
    }
    document.getElementById("to").innerHTML = nuoviOrari;
}

/**
 * Richiesta asincrona per aggiornare il calendario
*/
function aggiornaTabella() {
    const ANNO = document.getElementById("year").value;
    const MESE = document.getElementById("month").value;
    const URL = `http://138.41.20.100/~rizzello2400/src/gestione_calendario.php?year=${encodeURIComponent(ANNO)}&month=${encodeURIComponent(MESE)}`;

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
                console.error('Errore di rete: ', error.message);
            } else {
                console.error('Si è verificato un errore imprevisto: ', error.message);
            }
        });
}

/**
 * Aggiorna la tabella e i giorni
 */
function aggiorna() {
    aggiornaTabella();

    const ANNO = Number(document.getElementById("year").value);
    const MESE = Number(document.getElementById("month").value);
    const GIORNO = Number(document.getElementById("day").value);
    sceltaGiorni(ANNO, MESE, GIORNO);
}
