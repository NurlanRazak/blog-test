<?php

declare(strict_types=1);

namespace App\Controllers;

use Smarty;

abstract class BaseController
{

    protected Smarty $smarty;

    protected array $config;

    public function __construct()
    {
        $this->config = require dirname(__DIR__) . '/Config/config.php';

        $root = dirname(__DIR__, 2);

        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir($root . '/templates');
        $this->smarty->setCompileDir($root . '/templates_c');
        $this->smarty->setCacheDir($root . '/cache');
        $this->smarty->assign('app_url', rtrim($this->config['APP_URL'], '/'));
    }

    /**
     * @param string $template
     * @param array $data
     * @return void
     */
    protected function render(string $template, array $data = []): void
    {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $this->smarty->display($template);
    }
}