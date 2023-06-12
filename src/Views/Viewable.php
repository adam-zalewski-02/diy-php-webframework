<?php

namespace Howest\Diy\Views;

class Viewable
{
    protected $view;
    protected $data;

    public function __construct(string $view = "", array $data = [])
    {
        $this->view = $view;
        $this->data = $data;
    }

    /**
     * @throws Exception
     */
    public function render(): string
    {
        extract($this->data);
        ob_start();
        include $this->view;
        return ob_get_clean();
    }
}
