<?php

// REDIRECT IF LOGIN
if(!is_user_logged_in()) {
    wp_redirect('/');
}

$user = get_currentuserinfo();

function getEventsById($id) {
    global $wpdb;
    $table = $wpdb->prefix."posts";
    $QUERY = "SELECT * FROM $table WHERE post_type = %s AND post_author = %s";
    $p = $wpdb->prepare($QUERY, ['event_listing', $id]);
    return $wpdb->get_results($p);
}

$events = getEventsById($user->ID);

function getTransformedDate($string_date) {
    $timed_date = strtotime($string_date);
    $date = getdate($timed_date);
    $months = ['janvier', 'février', 'mars', 'avril', 'mail', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
    return $date['mday'].' '.$months[$date['wday']].' '.$date['year'];
}

function changeLogin($id, $value) {
    global $wpdb;
    $table = $wpdb->prefix."users";
    $QUERY = "UPDATE $table SET user_login = %s WHERE id = %s";
    $p = $wpdb->prepare($QUERY, [$value, $id]);
    $wpdb->get_row($p);
    wp_redirect('/auth');
}

$msg = false;
if(!empty($_POST)) {
    $p = $_POST;
    if(isset($p['user_password'], $p['user_password_confirm']) && $p['user_password'] !== $p['user_password_confirm']) {
        $msg = ['success' => false, 'msg' => "Les mots de passes ne correspondent pas"];
    }else {
        $fields = [
            'ID' => $user->ID,
            'user_email' => $p['user_email'],
            'user_url' => $p['user_url']
        ];
        if(isset($p['user_password'])) {
            $fields['user_pass'] = $p['user_password'];
        }
        wp_update_user($fields);

        $non_meta = ['login', 'email', 'password', 'password_confirm', 'register_submit'];
        foreach ($p as $key=>$value){
            $key=str_replace('user_','', $key);
            if(in_array($key, $non_meta, true)) {
                continue;
            }
            update_user_meta($user->ID, $key, $value);
        }

        if($p['user_login'] !== $user->user_login) {
            changeLogin($user->ID, $p['user_login']);
        }

        $msg = ['success' => true, 'msg' => "Informations modifiées"];
        $user = get_user_by('ID', $user->ID);
    }
}

get_header();
?>

	<main id="primary" class="site-main">

        <div id="overlay"></div>
        <section id="profile-editor">
            <h3>Modifier les informations</h3>
            <i id="profile-editor-close" class="fas fa-times"></i>

            <form method="post">
                <h4>Contact</h4>
                <p>Email: <input type="text" name="user_email" placeholder="Email" value="<?= $user->user_email ?>"></p>

                <h4>Entreprise</h4>
                <p>Nom: <input type="text" name="user_company" placeholder="Nom" value="<?= get_user_meta($user->ID, 'company', true) ?>"></p>
                <p>Produits: <input type="text" name="user_products" placeholder="Produits" value="<?= get_user_meta($user->ID, 'products', true) ?>"></p>
                <p>Site: <input type="text" name="user_url" placeholder="Site" value="<?= $user->user_url ?>"></p>

                <h4>Localisation</h4>
                <p>Pays: <input type="text" name="user_country" placeholder="Pays" value="<?= get_user_meta($user->ID, 'country', true) ?>"></p>
                <p>Ville: <input type="text" name="user_city" placeholder="Ville" value="<?= get_user_meta($user->ID, 'city', true) ?>"></p>

                <h4>Compte</h4>
                <p>Prénom et nom: <input type="text" name="user_name" placeholder="Prénom et nom" value="<?= get_user_meta($user->ID, 'name', true) ?>"></p>
                <p>Identifiant: <input type="text" name="user_login" placeholder="Identifiant" value="<?= $user->user_login ?>"></p>
                <p>Mot de passe: <input type="password" name="user_password" placeholder="Mot de passe"></p>
                <p>Confirmer mot de passe: <input type="password" name="user_password_confirm" placeholder="Confirmer mot de passe"></p>
                <button type="submit">Confirmer</button>
            </form>
        </section>

        <section id="profile-top">
            <h2><?= $user->user_login ?></h2>
            <div id="profile-top-counts">
                <div class="profile-top-count">
                    <p class="profile-top-count-value">
                        <?= date('d/m/Y', strtotime($user->user_registered)) ?>
                    </p>
                    <p class="profile-top-count-label">
                        Date de création
                    </p>
                </div>
                <div class="profile-top-count">
                    <p class="profile-top-count-value">
                        <?= count($events) ?>
                    </p>
                    <p class="profile-top-count-label">
                        Événements
                    </p>
                </div>
            </div>

            <?php echo get_avatar( $user->user_email, 200 ); ?>
        </section>

        <section id="profile-content">

            <?php if($msg): ?>
                <div id="<?= $msg['success'] === true ? 'success' : 'error' ?>-block" class="msg-block">
                    <i class="fas fa-<?= $msg['success'] === true ? 'check-circle' : 'exclamation-triangle' ?>"></i> <?= $msg['msg'] ?>
                </div>
            <?php endif ?>

            <ul id="profile-content-nav">
                <li data-action="informations" class="active profile-content-nav-btn">
                    <i class="fas fa-info"></i>
                    Informations
                </li>
                <li data-action="events" class="profile-content-nav-btn">
                    <i class="fas fa-newspaper"></i>
                    Événements
                </li>
            </ul>

            <div data-active="true" data-type="informations" class="profile-content-menu">
                <h3>Informations de votre compte</h3>

                <h4>Contact</h4>
                <p>Email: <span><?= $user->user_email ?></span></p>

                <h4>Entreprise</h4>
                <p>Nom: <span><?= get_user_meta($user->ID, 'company', true) ?></span></p>
                <p>Produits: <span><?= get_user_meta($user->ID, 'products', true) ?></span></p>
                <p>Site: <span><?= $user->user_url ?></span></p>

                <h4>Localisation</h4>
                <p>Pays: <span><?= get_user_meta($user->ID, 'country', true) ?></span></p>
                <p>Ville: <span><?= get_user_meta($user->ID, 'city', true) ?></span></p>

                <h4>Compte</h4>
                <p>Prénom et nom: <span><?= get_user_meta($user->ID, 'name', true) ?></span></p>
                <p>Identifiant: <span><?= $user->user_login ?></span></p>
                <p>Mot de passe: <span>********</span></p>
                <button id="profile-editor-open">Modifier</button>
                <?php if(in_array('administrator', $user->roles)) : ?>
                    <a id="admin-btn" href="<?= admin_url() ?>">Panel Admin</a>
                <?php endif; ?>
                <a id="logout-btn" href="<?= wp_logout_url(get_permalink()) ?>">Déconnexion</a>
            </div>

            <div data-active="false" data-type="events" class="profile-content-menu">
                <h3>Liste de vos événements</h3>


                <?php

                foreach ($events as $event) {

                    $banner = get_post_meta($event->ID, '_event_banner', true);
                    $start_date = getTransformedDate(get_post_meta($event->ID, '_event_start_date', true));
                    $description = get_post_meta($event->ID, '_event_description', true);

                    if(empty($banner)) {
                        continue;
                    }

                    ?>

                <div class="event-block">
                    <img class="profile-top-img" src="<?= $banner ?>" alt="#"/>
                    <div class="event-infos">
                        <h4 class="event-infos-title"><?= $event->post_title ?></h4>
                        <p class="event-infos-date">
                            <i class="fas fa-calendar-alt"></i>
                            <?= $start_date ?>
                        </p>
                        <p class="event-infos-text">
                            <?= $description ?>
                        </p>
                    </div>

                    <!--<button>Modifier</button>-->
                </div>

                <?php } ?>

            </div>
        </section>

	</main><!-- #main -->

    <script src="<?php echo get_template_directory_uri(); ?>/js/pages/profile.js"></script>

<?php
/*get_sidebar();*/
get_footer();
