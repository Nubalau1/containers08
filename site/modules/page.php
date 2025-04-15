<?php

class Page {
    private $template;

    public function __construct($template) {
        $this->template = file_get_contents($template);
    }

    public function Render($data) {
        $page = $this->template;
        foreach ($data as $key => $value) {
            $page = str_replace("{{ $key }}", $value, $page);
        }
        return $page;
    }
}
