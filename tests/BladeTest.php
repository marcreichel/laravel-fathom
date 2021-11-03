<?php

namespace MarcReichel\LaravelFathom\Tests;

use Gajus\Dindent\Exception\RuntimeException;

class BladeTest extends ComponentTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['fathom.site_id' => 'CDBUGS']);
    }

    /** @test
     * @throws RuntimeException
     */
    public function the_component_can_be_rendered(): void
    {
        $expected = <<<'HTML'
<script src="https://cdn.usefathom.com/script.js"
        data-site="CDBUGS"
        defer
                                               ></script>
HTML;
        $this->assertComponentRenders($expected, '<x-fathom-tracking-code/>');
    }

    /** @test
     * @throws RuntimeException
     */
    public function we_can_specify_domain(): void
    {
        config(['fathom.domain' => 'lion.phpunit.com']);

        $expected = <<<'HTML'
<script src="https://lion.phpunit.com/script.js"
        data-site="CDBUGS"
        defer
                                               ></script>
HTML;
        $this->assertComponentRenders($expected, '<x-fathom-tracking-code/>');
    }

    /** @test
     * @throws RuntimeException
     */
    public function we_can_honor_dnt(): void
    {
        config(['fathom.honor_dnt' => true]);

        $expected = <<<'HTML'
<script src="https://cdn.usefathom.com/script.js"
        data-site="CDBUGS"
        defer
        data-honor-dnt="true"                                       ></script>
HTML;
        $this->assertComponentRenders($expected, '<x-fathom-tracking-code/>');
    }

    /** @test
     * @throws RuntimeException
     */
    public function we_can_disable_auto_tracking(): void
    {
        config(['fathom.disable_auto_tracking' => true]);

        $expected = <<<'HTML'
<script src="https://cdn.usefathom.com/script.js"
        data-site="CDBUGS"
        defer
                data-auto="false"                               ></script>
HTML;
        $this->assertComponentRenders($expected, '<x-fathom-tracking-code/>');
    }

    /** @test
     * @throws RuntimeException
     */
    public function we_can_disable_canonicals(): void
    {
        config(['fathom.ignore_canonicals' => true]);

        $expected = <<<'HTML'
<script src="https://cdn.usefathom.com/script.js"
        data-site="CDBUGS"
        defer
                        data-canonical="false"                       ></script>
HTML;
        $this->assertComponentRenders($expected, '<x-fathom-tracking-code/>');
    }

    /** @test
     * @throws RuntimeException
     */
    public function we_can_specify_excluded_domains(): void
    {
        config(['fathom.excluded_domains' => 'localhost']);

        $expected = <<<'HTML'
<script src="https://cdn.usefathom.com/script.js"
        data-site="CDBUGS"
        defer
                                data-excluded-domains="localhost"               ></script>
HTML;
        $this->assertComponentRenders($expected, '<x-fathom-tracking-code/>');
    }

    /** @test
     * @throws RuntimeException
     */
    public function we_can_specify_included_domains(): void
    {
        config(['fathom.included_domains' => 'localhost']);

        $expected = <<<'HTML'
<script src="https://cdn.usefathom.com/script.js"
        data-site="CDBUGS"
        defer
                                        data-included-domains="localhost"       ></script>
HTML;
        $this->assertComponentRenders($expected, '<x-fathom-tracking-code/>');
    }

    /** @test
     * @throws RuntimeException
     */
    public function we_can_set_spa_mode(): void
    {
        config(['fathom.spa_mode' => 'auto']);

        $expected = <<<'HTML'
<script src="https://cdn.usefathom.com/script.js"
        data-site="CDBUGS"
        defer
                                                data-spa="auto"></script>
HTML;
        $this->assertComponentRenders($expected, '<x-fathom-tracking-code/>');
    }
}
