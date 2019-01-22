<php $title = "Formulaire d\'inscription"; ?>

<php ob_start(); ?>

<form>
    <div class="col-md-4 mb-3">
        <label for="validationCustom01">First name</label>
        <input type="text" class="form-control" id="validationCustom01" name="Prenom" placeholder="First name" value="" required>
        <div class="valid-feedback">
        Looks good!
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <label for="validationCustom02">Last name</label>
        <input type="text" class="form-control" id="validationCustom02" name="Nom" placeholder="Last name" value="" required>
        <div class="valid-feedback">
        Looks good!
        </div>
    </div>
    <div class="form-group row">
        <label for="exampleInputEmail1">Email address</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Mot de passe</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Retapez votre mot de passe</label>
        <div class="col-sm-10">
        <input type="password" class="form-control" id="inputPassword" name="repeatpassword" placeholder="Password">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-auto my-1">
            <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Profil</label>
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="profil">
                <option selected>Sélectionner</option>
                <option value="1">Employé</option>
                <option value="2">Employeur</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-auto my-1">
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </div>
    </div>
</form>

<php $content = ob_get_clean(); ?>

<php require('view/template.php'); ?>