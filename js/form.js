function Valide(Form) {
    if(Form.elements['mdp'].value != Form.elements['mdp2'].value) {
        alert("Les mots de passes indiqué doivent être identiques");
        return false;
    }
    else {
        return true;
    }
}
function Delete(element){
    $("#suppr" + element).click(function() {
        document.getElementById(element).removeAttribute('hidden');
    })
}