import{verificationCapteur} from "./verificationTemperature.js";

let requeteAlertes = new XMLHttpRequest();
requeteAlertes.open('GET', '../../temperature.json')
requeteAlertes.onload = function () {
    let data = JSON.parse(requeteAlertes.responseText);
    historique(data, 24);
    console.log(data);
}
requeteAlertes.send();

function historique(data, element) {
    let history = document.getElementById('historique');
    let content = document.createElement("section");
    for (let i = 0; i < data.length; i++) {
        let details = document.createElement("details");
        let summary = document.createElement("summary");
        let donnees = document.createElement("p");
        summary.append("Alertes du " + data[i].date);
        verificationCapteur(data,i,donnees);
        details.appendChild(summary);
        details.appendChild(donnees);
        content.appendChild(details);
    }
    history.appendChild(content);

}
