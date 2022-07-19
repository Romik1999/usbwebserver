<?php

class Router
{
    private $pages = array();

    public function addRoute($url, $path)
    {
        $this->pages[$url] = $path;
    }

    public function route($url)
    {
        $path = $this->pages[$url];
        $file_dir = 'app/' . $path;
        if ($path == "") {
            require "404.php";
            die();
        }
        if (file_exists($file_dir)) {
            require $file_dir;
        } else {
            require "404.php";
            die();
        }
    }
}