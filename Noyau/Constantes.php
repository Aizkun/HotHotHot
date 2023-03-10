<?php

// Rappel : nous sommes dans le répertoire Core, voilà pourquoi dans realpath je "remonte d'un cran" pour faire référence
// à la VRAIE racine de mon application

final class Constantes
{
    // Les constantes relatives aux chemins

    const REPERTOIRE_VUES        = '/Vues/';

    const REPERTOIRE_MODELE      = '/Modele/';

    const REPERTOIRE_NOYAU       = '/Noyau/';

    const REPERTOIRE_EXCEPTIONS  = '/Noyau/Exceptions/';

    const REPERTOIRE_CONTROLEURS = '/Controleurs/';

    const REPERTOIRE_STYLE = '/CSS/';

    const REPERTOIRE_JS = '/js/';

    const REPERTOIRE_IMG = '/img/';

    const REPERTOIRE_CONFIG = '/Config/';

    public static function repertoireRacine() {
        return realpath(__DIR__ . '/../');
    }
    public static function repertoireCSS() {
        return self::REPERTOIRE_STYLE;
    }
    public static function repertoireJS() {
        return self::REPERTOIRE_JS;
    }
    public static function repertoireIMG() {
        return self::REPERTOIRE_IMG;
    }
    public static function repertoireConfig() {
        return self::REPERTOIRE_CONFIG;
    }
    public static function repertoireNoyau() {
        return self::repertoireRacine() . self::REPERTOIRE_NOYAU;
    }

    public static function repertoireExceptions() {
        return self::repertoireRacine() . self::REPERTOIRE_EXCEPTIONS;
    }

    public static function repertoireVues() {
        return self::repertoireRacine() . self::REPERTOIRE_VUES;
    }

    public static function repertoireModele() {
        return self::repertoireRacine() . self::REPERTOIRE_MODELE;
    }

    public static function repertoireControleurs() {
        return self::repertoireRacine() . self::REPERTOIRE_CONTROLEURS;
    }


}