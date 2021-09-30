<?php

// REDIRECT IF LOGIN
if(is_user_logged_in()) {
    wp_redirect('/profile');
}

$msg = false;
if(isset($_POST['login_submit'])) {
    if(isset($_POST['remember'])){
        setcookie('user_identify', $_POST['user_login'], -1, "/", $_SERVER['SERVER_NAME']);
    }else {
        setcookie('user_identify', '', time()-3600, "/", $_SERVER['SERVER_NAME']);
    }
    $msg = ['success' => false, 'msg' => 'yes'];
    $user = wp_signon([
        'user_login' => $_POST['user_login'],
        'user_password' => $_POST['user_password']
    ]);
    if(is_wp_error($user)) {
        $msg = ['success' => false, 'msg' => $user->get_error_message()];
    }else {
        wp_redirect('/profile');
    }
}else if(isset($_POST['register_submit'])) {
    $p = $_POST;
    $password = $p['user_password'];
    if($password !== $p['user_password_confirm']) {
        $msg = ['success' => false, 'msg' => 'Les mots de passes ne correspondent pas'];
    }else if(strlen($password) < 5) {
        $msg = ['success' => false, 'msg' => 'Le mot de passe est trop court (5 caractères minimum)'];
    }else if(!preg_match("#[A-Z ]#",$password)) {
        $msg = ['success' => false, 'msg' => 'Le mot de passe doit contenir au moins 1 majuscule'];
    }else if(!preg_match("#[a-z ]#",$password)) {
        $msg = ['success' => false, 'msg' => 'Le mot de passe doit contenir au moins 1 minuscule'];
    }else if(!preg_match("#[0-9 ]#",$password)) {
        $msg = ['success' => false, 'msg' => 'Le mot de passe doit contenir au moins 1 chiffre'];
    }else {

        $user = wp_insert_user([
            'user_login' => $p['user_login'],
            'user_pass' => $password,
            'user_email' => $p['user_email'],
            'user_registered' => date('Y-m-d H:i:s'),
            'user_url' => $p['user_url']
        ]);
        if (is_wp_error($user)) {
            $msg = ['success' => false, 'msg' => $user->get_error_message()];
        }else {
            $register_fields = ['login', 'email', 'password', 'password_confirm', 'register_submit'];
            foreach ($p as $key => $value) {
                $key = str_replace('user_', '', $key);
                if (in_array($key, $register_fields, true)) {
                    continue;
                }
                add_user_meta($user, $key, $value);
            }

            //MAIL TO USER
            $msg = 'Vous êtes maintenant inscrit';
            $headers = 'From : ' . get_option('admin_email') . "\r\n";
            wp_mail($p['user_email'], 'Inscription réussie', $msg, $headers);

            //MAIL TO ADMIN
            $msg = 'L\'utilisateur '.$p['user_login'].' est en attente d\'inscription sur votre panel admin.';
            $headers = 'From : ' . get_option('admin_email') . "\r\n";
            wp_mail(get_option('admin_email'), 'Inscription d\'utilisateur', $msg, $headers);

            wp_signon($p);
            $p = [];
            wp_redirect('/profile');
        }
    }

}else if(isset($_POST['forget_submit'])) {
    $email = $_POST['forget_email'];
    if(!empty($email) && isset($email)) {
        $mail = retrieve_password($email);
        if(is_wp_error($mail)) {
            $msg = ['success' => false, 'msg' => $mail->get_error_message()];
        }else {
            $msg = ['success' => true, 'msg' => 'Un mail a été envoyé à l\'adresse: .$email'];
        }
    }
}

get_header();
?>

	<main id="primary" class="auth-main site-main">

        <section id="auth-img" style="background: url(<?= get_field('img_back') ?>) no-repeat; background-size: cover;"></section>

        <!--LOGIN BLOCK-->
        <section data-active="true" class="auth-block">
            <?php the_custom_logo(); ?>
            <h2 id="auth-block-title"><?php bloginfo( 'name' ); ?></h2>

            <?php if($msg): ?>
                <div id="<?= $msg['success'] === true ? 'success' : 'error' ?>-block" class="msg-block">
                    <i class="fas fa-<?= $msg['success'] === true ? 'check-circle' : 'exclamation-triangle' ?>"></i> <?= $msg['msg'] ?>
                </div>
            <?php endif ?>

            <form class="auth-block-form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

                <div class="auth-block-form-input">
                    <i class="fas fa-user"></i>
                    <input type="text" name="user_login" placeholder="Identifiant ou Email" value="<?= isset($_COOKIE['user_identify']) ? $_COOKIE['user_identify'] : '' ?>">
                </div>

                <div class="auth-block-form-input">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="user_password" placeholder="Mot de passe">
                </div>

                <div class="auth-block-form-remember">
                    <input type="checkbox" name="remember" id="remember" value="1" <?= isset($_COOKIE['user_identify']) ? 'checked' : '' ?>>
                    Se souvenir de moi
                </div>

                <!--FORGET PASSWORD-->
                <p id="auth-block-forget">mot de passe oublié ? <span id="forget-pass">Cliquez-ici</span></p>
                <div id="forget-content">

                    <div id="forget-content-msg">
                        <i class="fas fa-info"></i> Merci de saisir votre email afin de vous envoyer un mail pour modifier votre mot de passe.
                    </div>

                    <div class="auth-block-form-input">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="forget_email" placeholder="Email">
                    </div>

                    <button type="submit" name="forget_submit">Envoyer</button>

                </div>

                <button type="submit" name="login_submit">Connexion</button>

            </form>

            <p id="auth-block-type">Pas encore membre ? <span class="auth-toggle">Créer un compte</span></p>

        </section>

        <!--REGISTER BLOCK-->
        <section data-active="false" class="auth-block">
            <?php the_custom_logo(); ?>
            <h2 id="auth-block-title"><?php bloginfo( 'name' ); ?></h2>

            <?php if($msg): ?>
                <div id="<?= $msg['success'] === true ? 'success' : 'error' ?>-block" class="msg-block">
                    <i class="fas fa-<?= $msg['success'] === true ? 'check-circle' : 'exclamation-triangle' ?>"></i> <?= $msg['msg'] ?>
                </div>
            <?php endif ?>

            <form class="auth-block-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">

                <div class="auth-block-form-input">
                    <i class="fas fa-user"></i>
                    <input type="text" name="user_login" placeholder="Identifiant" value="<?= isset($_POST['user_login']) ? $_POST['user_login'] : '' ?>" required>
                </div>

                <div class="auth-block-form-input">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="user_email" placeholder="Adresse email" value="<?= isset($_POST['user_email']) ? $_POST['user_email'] : '' ?>" required>
                </div>

                <div class="auth-block-form-input">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="user_password" placeholder="Mot de passe" required>
                </div>

                <div class="auth-block-form-input">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="user_password_confirm" placeholder="Confirmer le mot de passe" required>
                </div>

                <div class="auth-block-form-input">
                    <i class="fas fa-user"></i>
                    <input type="text" name="user_name" placeholder="Prénom et nom du contact" value="<?= isset($_POST['user_name']) ? $_POST['user_name'] : '' ?>" required>
                </div>

                <div class="auth-block-form-input">
                    <i class="fas fa-building"></i>
                    <input type="text" name="user_company" placeholder="Nom d'entreprise" value="<?= isset($_POST['user_company']) ? $_POST['user_company'] : '' ?>" required>
                </div>

                <div class="auth-block-form-input">
                    <i class="fas fa-globe-europe"></i>
                    <input type="text" name="user_country" placeholder="Pays" value="<?= isset($_POST['user_country']) ? $_POST['user_country'] : '' ?>" required>
                </div>

                <div class="auth-block-form-input">
                    <i class="fas fa-city"></i>
                    <input type="text" name="user_city" placeholder="Ville" value="<?= isset($_POST['user_city']) ? $_POST['user_city'] : '' ?>" required>
                </div>

                <div class="auth-block-form-input">
                    <i class="fab fa-chrome"></i>
                    <input type="text" name="user_url" placeholder="Lien du site" value="<?= isset($_POST['user_url']) ? $_POST['user_url'] : '' ?>">
                </div>

                <div class="auth-block-form-input">
                    <i class="fas fa-list-alt"></i>
                    <input type="text" name="user_products" placeholder="Produits et services vendus" value="<?= isset($_POST['user_products']) ? $_POST['user_products'] : '' ?>" required>
                </div>

                <div class="auth-block-form-input">
                    <textarea name="user_motivation" placeholder="Pourquoi voulez vous devenir créateur d'événements ?" required><?= isset($_POST['user_motivation']) ? $_POST['user_motivation'] : '' ?></textarea>
                </div>

                <button type="submit" name="register_submit">S'inscrire</button>

            </form>

            <p id="auth-block-type">Déjà membre ? <span class="auth-toggle">Se connecter</span></p>

        </section>

	</main><!-- #main -->

    <script src="<?php echo get_template_directory_uri(); ?>/js/pages/auth.js"></script>

<?php
/*get_sidebar();*/

