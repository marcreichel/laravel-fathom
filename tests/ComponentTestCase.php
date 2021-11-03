<?php

namespace MarcReichel\LaravelFathom\Tests;

use Gajus\Dindent\Exception\RuntimeException;
use Gajus\Dindent\Indenter;
use MarcReichel\LaravelFathom\LaravelFathomServiceProvider;
use Orchestra\Testbench\TestCase;

class ComponentTestCase extends TestCase
{
    use InteractsWithViews;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('view:clear');
    }

    protected function getPackageProviders($app): array
    {
        return [LaravelFathomServiceProvider::class];
    }

    /**
     * @throws RuntimeException
     */
    public function assertComponentRenders(string $expected, string $template, array $data = []): void
    {
        $indenter = new Indenter();
        $blade = (string) $this->blade($template, $data);
        $indented = $indenter->indent($blade);
        $cleaned = str_replace(
            [' >', "\n/>", ' </div>', '> ', "\n>"],
            ['>', '/>', "\n</div>", ">\n    ", '>'],
            $indented,
        );

        $this->assertSame($expected, $cleaned);
    }
}
