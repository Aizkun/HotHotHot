//Pop up alertes

let requete = new XMLHttpRequest();
requete.open('GET', '../temperature.json')
requete.onload = function () {
    let data = JSON.parse(requete.responseText);
    alerts(data, 0);
}
requete.send();

let modal = document.getElementById("modal");
let modalContent = document.getElementById("modal-content");
let captor = document.getElementById("capteur");
let footer = document.getElementById("footer");
let close = document.getElementsByClassName("close")[0];

function alerts(data,element) {
    let donnees = document.createElement("p");
    donnees.setAttribute("id", "informations-alertes");
    let link = document.createElement("a");
    link.setAttribute("id","lienHistory");
    link.setAttribute('href', "../../Pages/history");
    link.append("Pour en savoirs plus.");
    footer.setAttribute("hidden", true)
    close.onclick = function () {
        captor.removeAttribute("hidden");
        modal.setAttribute("hidden",true);
        footer.removeAttribute("hidden");
    }
    window.onclick = function (event) {
        if (event.target == modal) {
            captor.removeAttribute("hidden");
            modal.setAttribute("hidden",true);
            footer.removeAttribute("hidden");
        }
    }
    let content = document.getElementById("modal-body");
    AlertesExterieur(data,element,donnees);
    donnees.appendChild(link);
    content.appendChild(donnees);
}
function AlertesExterieur(data, element, balise) {
    let br = document.createElement("br");
    let espace = document.createElement("br");
    let averageTempEx = (data[element].tempExterieurMax + data[element].tempExterieurMin) / 2;
    if (averageTempEx > 35) {
        balise.append("🔥🔥 Extérieur: Hot Hot Hot ! Température : " + averageTempEx + ". 🔥🔥");
        balise.appendChild(br);
        balise.appendChild(espace);
        AlertesInterieur(data, element, balise,"red");
    } else if (averageTempEx < 0) {
        balise.append("⚠️⚠️❄️❄️Extérieur: Banquise en vue ! Température : " + averageTempEx + ". ❄️❄️⚠️⚠️");
        balise.appendChild(br);
        balise.appendChild(espace);
        AlertesInterieur(data, element, balise,"blue");
    } else {
        balise.append("RAS pour l'extérieur. Température : " + averageTempEx + ".");
        balise.appendChild(br);
        balise.appendChild(espace);
        AlertesInterieur(data, element, balise, "white");
    }
}
function AlertesInterieur(data, element, balise, couleur) {
    let br = document.createElement("br");
    let red ='';
    let blue = '';
    if(couleur === "white"){
        red = 'red';
        blue = 'blue';
    }else{
        red = "linear-gradient(to left, red 50%, " + couleur + " 50%)";
        blue = "linear-gradient(to left, blue 50%, " + couleur + " 50%)";
    }
    let averageTempInt = (data[element].tempInterieurMax + data[element].tempInterieurMin) / 2;
    if (averageTempInt > 50) {
        balise.append("⚠️⚠️🔥🔥Interieur: Appelez les pompiers ou arrêtez votre barbecue ! Température : " + averageTempInt + "⚠️⚠️🔥🔥");
        balise.appendChild(br);
        modalContent.style.background = red ;
    } else if (averageTempInt > 22 && averageTempInt < 50) {
        balise.append("🔥🔥Interieur: Baissez le chauffage ! Température : " + averageTempInt + "🔥🔥");
        balise.appendChild(br);
        modalContent.style.background = red ;

    } else if (averageTempInt < 12 && averageTempInt > 0) {
        balise.append("❄️❄️❄️❄️Interieur: montez le chauffage ou mettez un gros pull  ! Température : " + averageTempInt + "❄️❄️❄️❄️");
        balise.appendChild(br);
        modalContent.style.background = blue ;
    } else if (averageTempInt < 0) {
        balise.append("⚠️⚠️❄️❄️Interieur: canalisations gelées, appelez SOS plombier - et mettez un bonnet ! Température : " + averageTempInt+ "❄️❄️⚠️⚠️");
        balise.appendChild(br);
        modalContent.style.background = blue ;
    } else {
        balise.append("RAS pour l'intérieur. Température : " + averageTempInt);
    }
}


