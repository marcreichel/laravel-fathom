<?php

namespace MarcReichel\LaravelFathom\Tests;

use Illuminate\View\View;
use Throwable;

class TestView
{
    /**
     * The original view.
     *
     * @var View
     */
    protected View $view;

    /**
     * The rendered view contents.
     *
     * @var string
     */
    protected string $rendered;

    /**
     * Create a new test view instance.
     *
     * @param View $view
     *
     * @return void
     * @throws Throwable
     */
    public function __construct(View $view)
    {
        $this->view = $view;
        $this->rendered = $view->render();
    }

    /**
     * Get the string contents of the rendered view.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->rendered;
    }
}
