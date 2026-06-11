<?php

namespace MarcReichel\LaravelFathom\Tests;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ConsoleTest extends TestCase
{
    protected string $configPath;

    public function setUp(): void
    {
        parent::setUp();

        $this->configPath = config_path('fathom.php');
    }

    #[Test]
    public function the_install_command_copies_the_configuration(): void
    {
        if (File::exists($this->configPath)) {
            unlink($this->configPath);
        }

        $this->assertFalse(File::exists($this->configPath));

        Artisan::call('fathom:install');

        $this->assertTrue(File::exists($this->configPath));
    }
}
