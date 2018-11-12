<html>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="../css/login.css" rel="stylesheet">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="../js/login.js"></script>
<!------ Include the above in your HEAD tag ---------->
<div class="animate-title">
    <h1>FIGHT FOR ENSIIE</h1>
</div>
<div class="container">

    <div class="row">

        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <?php if(isset($_SESSION['errors']) && !empty($_SESSION['errors'])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Erreur!</strong> <?php echo $_SESSION['errors']; ?>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="#" class="active" id="login-form-link">Login</a>
                        </div>
                        <div class="col-xs-6">
                            <a href="#" id="register-form-link">Register</a>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="login-form" action="../login.php" method="post" role="form" style="display: block;">
                                <div class="form-group">
                                    <input type="text" name="loginUsername" id="loginUsername" tabindex="1" class="form-control" placeholder="Pseudo" value="" pattern=".{3,}" title="3 caractères minimum" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="loginPassword" id="loginPassword" tabindex="2" class="form-control" placeholder="Mot de passe" pattern=".{4,}" title="4 caractères minimum"required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="OH OUI, LOG MOI!">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form id="register-form" action="../login.php" method="post" role="form" style="display: none;">
                                <div class="form-group">
                                    <input type="text" name="registerUsername" id="registerUsername" tabindex="1" class="form-control" placeholder="Pseudo" value="" pattern=".{3,}" title="3 caractères minimum" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="registerEmail" id="registerEmail" tabindex="1" class="form-control" placeholder="Adresse e-mail" value="" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="registerPassword" id="registerPassword" tabindex="2" class="form-control" placeholder="Mot de passe" pattern=".{4,}" title="4 caractères minimum" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="registerConfirmPassword" id="registerConfirmPassword" tabindex="2" class="form-control" placeholder="Confirmation du mot de passe" pattern=".{4,}" title="4 caractères minimum" required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Inscris-moi !">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</html>