<?php
if(!empty($_GET['id']) && !empty($_GET['email'])){
?>
    <h3>Réinitialiser votre mot de passe</h3>
    <div>
        <form type="POST" action="http://localhost/dev/a3/tp-securite/rest?reset-pwd">
            <input type="text" style="display: none" name="id" value="<?php $_GET['id'] ?>">
            <input type="text" style="display: none" name="email" value="<?php $_GET['email'] ?>">
            <input type="text" name="newpwd">
        </form>
    </div>
<?php
}else{
?>
    <h1>No id or email found sorry</h1>
<?php
}