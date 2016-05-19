<section>
    <div class = "jumbotron nomargin">
        <div class="container">
            <?= Message::show() ?>
            <div class="row">
                <div class="col-sm-offset-4 col-sm-4">      
                    <div class="presenterbox">
                        <form method="post" action="<?= DIR ?>users/register">
                            <label>Persönliche Daten:</label>
                            <div class="form-group">
                                <label hidden for="i_mail">Mail eingeben:</label>
                                <input type="email" class="form-control" id="i_mail" name="i_mail" placeholder="E-Mail Adresse eingeben">
                            </div>
                            <div class="form-group">
                                <label hidden for="i_username">Nutzername:</label>
                                <input type="text" class="form-control" id="i_username" name="i_username" placeholder="Nutzernamen eingeben">
                            </div>
                            <div class="form-group">
                                <label for="i_pass">Passwort:</label>
                                <input type="password" class="form-control" id="i_pass" name="i_pass" placeholder="Passwort eingeben">
                            </div>
                            <div class="form-group">
                                <label hidden for="i_pass_conf">Passwort bestätigen:</label>
                                <input type="password" class="form-control" id="i_pass_conf" name="i_pass_conf" placeholder="Passwort bestätigen">
                            </div>
                            <button type="submit" class="btn btn-primary">Registrieren</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

