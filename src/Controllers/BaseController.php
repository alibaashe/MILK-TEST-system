<?php

namespace App\Controllers;

abstract class BaseController
{
    protected array $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods.
     */
    public function __call(string $name, array $args): void
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     */
    protected function before(): bool
    {
        return true;
    }

    /**
     * After filter - called after an action method.
     */
    protected function after(): void
    {
    }

    /**
     * Render a view file.
     *
     * @param string $view  The view file to render
     * @param array  $args  Associative array of data to display in the view
     */
    protected function render(string $view, array $args = []): void
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/templates/$view";

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * Redirect to a different page.
     *
     * @param string $url  The relative URL
     */
    protected function redirect(string $url): void
    {
        header('Location: /' . ltrim($url, '/'), true, 303);
        exit;
    }
}
