<?php

namespace Core;

class View {
    public static function render($template, $context = []) {
        static $twig = null;
        if (null === $twig) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig_Environment($loader);
        }
        echo $twig->render($template, $context);
    }
}
