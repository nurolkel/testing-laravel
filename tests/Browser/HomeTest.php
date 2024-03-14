<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        // 1. Visit the Home Page
        // 2. Press a "Click Me"
        // 3. See "You've been clicked,punked"
        // 4. Assert that the current url is /feedback
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertPathIs('/')
                    ->assertSee('Click Me')
                    ->click('@click-me')
                    ->assertPathIs('/feedback')
                    ->assertSee("You've been clicked,punk");
        });
    }
}
