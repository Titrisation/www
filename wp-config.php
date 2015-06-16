<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur 
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'crowd');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'crowd');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', '');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Gcmk._8jS|aWVpJ }--i;,76q&o+}yZ[S$!.3(lXF:;eroxF!=AbYW9a5R,8 v)u');
define('SECURE_AUTH_KEY',  '$-UMKn}aYFr[gHv%pa?5kdrhRAF;#|6:if_d IWGL4j>QDtoUnPdGL]F&dX|tHiR');
define('LOGGED_IN_KEY',    ' %-X/<(xnP.o,Lc=;&@7Pz8)+rVyie59#jJ`6Z,y`v+2pruNKl`b-:qjRv3|4G_1');
define('NONCE_KEY',        '8nDWjN&=V8lE/V1=BOT0qar}?qT7iL++<>ivylR xgX;+DR%qFb>4 |&RnITQdT{');
define('AUTH_SALT',        'X(rDgL3!XsS#0k5T,x|;4N)H356l1M+Tf%2GP;o+-W/3exK9ROCOY|>k#Quv-+O}');
define('SECURE_AUTH_SALT', 'g;|D@CXnm+(? #O~_A!+7]Vqc[0Cs`:-s3=eDZ8DY<3tOxV^b+/K1,U^Q24,2!JU');
define('LOGGED_IN_SALT',   ' E%oK5T#I)p8+UF~?[gzWmV$+R+8(vk{^n4G}]_[&@i$SN>b9cbimph^~xWK9r#-');
define('NONCE_SALT',       'A+x;-><IY9d]B;9}1`-/,yVM5:hnNL(W Ar`Sp[loI,8n+6cI$/Q#2lXF-OrSM3a');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wp_';

/** 
 * Pour les développeurs : le mode deboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 */ 
 // Enable WP_DEBUG mode
define('WP_DEBUG', true);

// Enable Debug logging to the /wp-content/debug.log file
define('WP_DEBUG_LOG', true);

// Disable display of errors and warnings 
define('WP_DEBUG_DISPLAY', true);
//@ini_set('display_errors',0);

error_log('TEST');

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');