<?php
    @session_start();
    //@session_start();
    error_reporting(E_ALL | E_STRICT);

    // define constants
    define('PROJECT_DIR', realpath('./'));
    define('LOCALE_DIR', PROJECT_DIR .'/locale');
    define('DEFAULT_LOCALE', 'fr_FR');

    require_once('../public/libs/gettext/gettext.inc');
    $supported_locales = array('en_US', 'fr_FR');
    $encoding = 'UTF-8';

    //$locale = (isset($_GET['lang']))? $_GET['lang'] : DEFAULT_LOCALE;
    $locale = (isset($_SESSION['userLang']))? $_SESSION['userLang'] : DEFAULT_LOCALE;

    // gettext setup
    T_setlocale(LC_MESSAGES, $locale);
    $domain = 'messages';
    bindtextdomain($domain, LOCALE_DIR);
    if (function_exists('bind_textdomain_codeset'))
        bind_textdomain_codeset($domain, $encoding);
    textdomain($domain);
    header("Content-type: text/html; charset=$encoding")
?>
