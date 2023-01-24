<h1>Changer mot de passe</h1>
<style>
#nomPage{
    display: none;
}
</style>    
<form class="form-text" action="/Users/modifierMDP" method="POST" onsubmit="return Valide(this)">
    <label class="form-label" for="oldMdp">Token ou ancien mot de passe :</label>
    <input type="text" name="oldMdp" id="oldMdp" size="50"  class="input-group-text">
    <label class="form-label" for="mdp">Choisissez votre nouveau mot de passe :</label>
    <input type="password" name="mdp" id="mdp" placeholder="**************" class="input-group-text">
    <label class="form-label" for="mdp2">Confirmez votre nouveau mot de passe :</label>
    <input type="password" name="mdp2" id="mdp2" placeholder="**************" class="input-group-text">
    <input type="submit" name="submit" value="Valider" class="btn btn-lg btn-primary btn-block">
</form>
