let requete = new XMLHttpRequest();
requete.open('GET', '../temperature.json')
requete.onload = function () {
    let data = JSON.parse(requete.responseText);
    injectionBalise(data, 0);
    console.log(data[0]);
}
requete.send();

function injectionBalise(data, element) {
    let capteur1 = document.getElementById("capteurData1");
    let capteur2 = document.getElementById("capteurData2");
    let averageTempInt = (data[element].tempInterieurMax + data[element].tempInterieurMin) / 2;
    let averageTempEx = (data[element].tempExterieurMax + data[element].tempExterieurMin) / 2;
    capteur1.append(averageTempInt);
    capteur2.append(averageTempEx);
}

var conn = new WebSocket('wss://ws.hothothot.dog:9502');
conn.onopen = function(e) {
    console.log("Connection established!");
    conn.send('Hello !');
};

conn.onmessage = function(e) {
    console.log(e.data);
    let requete = new XMLHttpRequest();
    let requeteBD = new XMLHttpRequest();
    requete.open('GET', 'wss://ws.hothothot.dog:9502')
    requete.onload = function () {
        requeteBD.open('POST', '../../Pages/json' )
        let data = JSON.parse(requete.responseText);
        injectionBalise2(e.data);
        console.log(data[0]);
        requeteBD.send('température=' + e.data);
    }
    requete.send();
};
function injectionBalise2(data) {
    const dataTemperature = JSON.parse(data);
    console.log(dataTemperature);
    let captorInt = document.getElementById("capteurData1");
    let captorExt = document.getElementById("capteurData2");
    let tempInt = dataTemperature.capteurs[0].Valeur;
    let tempEx = dataTemperature.capteurs[1].Valeur;
    captorInt.append(tempInt);
    captorExt.append(tempEx);
}

