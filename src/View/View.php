<?php

namespace App\View;

use App\Exception\ApplicationException;

class View implements Renderable
{
    private string $view;
    private array $data;

    public function __construct($view, $data)
    {
        $this->view = $view;
        $this->data = $data;
    }

    public function render()
    {
        extract($this->data, EXTR_PREFIX_SAME, "view");

        require $this->getIncludeTemplate($this->view);
    }

    public function getIncludeTemplate($view)
    {
        $fileName = str_replace('.', DIRECTORY_SEPARATOR, $view);
        $file = $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . $fileName . '.php';
        
        if (file_exists($file)) {
            return $file;
        } else {
            throw new ApplicationException("$fileName шаблон не найден.");
        }        
    }
}
