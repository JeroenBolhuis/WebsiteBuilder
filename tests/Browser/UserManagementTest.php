<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Permission;
use Tests\DuskTestCase;

class UserManagementTest extends DuskTestCase
{
    /**
     * test, admin heeft alle permissies.
     */
    public function testAdminHasAllPermissions()
    {
        $this->browse(function (Browser $browser) {
            $tmp_user = User::factory()->create([
                'email' => 'admin@hetkoppel.com',
            ]);

            $tmp_user->syncPermissions(Permission::all());
            
            $browser->loginAs($tmp_user)
                ->visit(route('admin.index'))
                ->assertSee("Pagina's")
                ->assertSee("Evenementen")
                ->assertSee("Sponsoren")
                ->assertSee("Posts")
                ->assertSee("Navigatiebalk")
                ->assertSee("Mediabibliotheek")
                ->assertSee("Gebruikers")
                ->assertSee("Footer")
                ->assertSee("Instellingen");
        });
    }

    /**
     * test, default user heeft geen permissies.
     */
    public function testDefaultUserHasNoPermissions()
    {
        $this->browse(function (Browser $browser) {
            $tmp_user = User::factory()->create([
                'email' => 'admin@hetkoppel.com',
            ]);
            
            $tmp_user->syncPermissions(Permission::where('name', 'edit page')->get()); // Needed to open admin page (maybe add a admin homepage to fully test.)
            
            $browser->loginAs($tmp_user)
                ->visit(route('admin.index'))
                ->AssertSee("Pagina's")
                ->assertDontSee("Evenementen")
                ->assertDontSee("Sponsoren")
                ->assertDontSee("Posts")
                ->assertDontSee("Navigatiebalk")
                ->assertDontSee("Mediabibliotheek")
                ->assertDontSee("Gebruikers")
                ->assertDontSee("Footer")
                ->assertDontSee("Instellingen");
        });
    }

    /**
     * test, enkele permissie voor gebruiker.
     */
    public function testVerifySingleRole()
    {
        $this->browse(function (Browser $browser) {
            $tmp_user = User::factory()->create([
                'email' => 'admin@hetkoppel.com',
            ]);
            
            $tmp_user->syncPermissions(Permission::where('name', 'edit post')->get());
            
            $browser->loginAs($tmp_user)
                ->visit(route('post.index'))
                ->assertSee("Posts")
                ->clickLink("Nieuwe post")
                ->type("title", "Mijn nieuwe post")
                ->type("slug", 'mijn-nieuwe-post')
                ->click("input[type=\"submit\"]")
                ->assertSee("Mijn nieuwe post");
        });
    }

    /**
     * test, aanmaken van een gebruiker.
     */
    public function testCreateUser(): void
    {
        $this->browse(function (Browser $browser) {
            $tmp_user = User::factory()->create([
                'email' => 'admin@hetkoppel.com',
            ]);

            $tmp_user->syncPermissions(Permission::all());

            $browser->loginAs($tmp_user)
                ->visit(route('user.index'))
                ->clickLink("Nieuwe gebruiker")

                ->type('name', 'testuser1')
                ->type('email', 'testuser1@test.com')
                ->type('password', 'testuser1')
                ->type('password_confirmation', 'testuser1')
                ->click('#create')

                ->assertSee('testuser1');
        });
    }

    /**
     * test, aanmaken van een gebruiker met een bestaand email adres.
     */
    public function testCreateUserWithExistingEmail(): void
    {
        $this->browse(function (Browser $browser) {
            $tmp_user = User::factory()->create([
                'email' => 'admin@hetkoppel.com',
            ]);

            $tmp_user->syncPermissions(Permission::all());

            $browser->loginAs($tmp_user)
                ->visit(route('user.index'))
                ->clickLink("Nieuwe gebruiker")

                ->type('name', 'testuser1')
                ->type('email', 'admin@hetkoppel.com')
                ->type('password', 'testuser1')
                ->type('password_confirmation', 'testuser1')
                ->click('#create')

                ->assertSee('Email is al in gebruik.');
        });
    }

    /**
     * test, aanmaken van een gebruiker met ongeldige input.
     */
    public function testCreateInvalidUser(): void
    {
        $this->browse(function (Browser $browser) {
            $tmp_user = User::factory()->create([
                'email' => 'admin@hetkoppel.com',
            ]);

            $tmp_user->syncPermissions(Permission::all());

            $browser->loginAs($tmp_user)
                ->visit(route('user.index'))
                ->clickLink("Nieuwe gebruiker")

                ->type('name', 'u')
                ->type('email', 'e@m')
                ->type('password', 'tu')
                ->type('password_confirmation', 'tu2')
                ->click('#create')

                ->assertSee('Gebruiker aanmaken')
                ->assertSee('Bevestiging van wachtwoord komt niet overeen.')
                ->assertSee('Naam moet minimaal 2 tekens zijn.')
                ->assertSee('Email moet minimaal 5 tekens zijn.')
                ->assertSee('Wachtwoord moet minimaal 5 tekens zijn.');
        });
    }

    /**
     * test, wijzigen van een gebruiker.
     */
    public function testModifyUser(): void
    {
        $this->browse(function (Browser $browser) {
            $tmp_user = User::factory()->create([
                'email' => 'admin@hetkoppel.com',
            ]);
            
            $tmp_user->syncPermissions(Permission::all());
            
            $tmp_target_user = User::factory()->create([
                'email' => 'subject@test.com',
            ]);

            $browser->loginAs($tmp_user)
                ->visit(route('user.edit', $tmp_target_user->id))

                ->type('name', 'Changed name')
                ->type('email', 'changed@email.com')

                ->check('input[id="role-6"]')
                ->click('#save')

                ->assertChecked('input[id="role-6"]')
                ->assertValue('input[name="name"]', 'Changed name')
                ->assertValue('input[name="email"]', 'changed@email.com');
        });
    }

    /**
     * test, wijzigen van een gebruiker met ongeldige input.
     */
    public function testModifyInvalidUser(): void
    {
        $this->browse(function (Browser $browser) {
            $tmp_user = User::factory()->create([
                'email' => 'admin@hetkoppel.com',
            ]);
            
            $tmp_user->syncPermissions(Permission::all());
            
            $tmp_target_user = User::factory()->create([
                'email' => 'subject@test.com',
            ]);

            $browser->loginAs($tmp_user)
                ->visit(route('user.edit', $tmp_target_user->id))

                ->type('name', 'c')
                ->type('email', 'c@e')
                ->type('password', 'p')
                ->type('password_confirmation', 'w')

                ->check('input[id="role-6"]')
                ->click('#save')

                ->assertSee('Bevestiging van wachtwoord komt niet overeen.')
                ->assertSee('Naam moet minimaal 2 tekens zijn.')
                ->assertSee('Email moet minimaal 5 tekens zijn.')
                ->assertSee('Wachtwoord moet minimaal 5 tekens zijn.');
        });
    }

    /**
     * test, verwijderen van een gebruiker.
     */
    public function testDeleteUser(): void
    {
        $this->browse(function (Browser $browser) {

            $tmp_user = User::factory()->create([
                'email' => 'admin@hetkoppel.com',
            ]);
            
            $tmp_user->syncPermissions(Permission::all());
            
            $tmp_target_user = User::factory()->create([
                'email' => 'subject@test.com',
            ]);

            $browser->loginAs($tmp_user)
                ->visit(route('user.edit', $tmp_target_user->id))
                ->press('Verwijderen')
                ->click('#deleteconfirm')
                ->assertDontSee('subject@test.com');
        });
    }

    /**
     * test, verwijderen van een gebruiker zonder permissie.
     */
    public function testDeleteUserWithoutPermission(): void
    {
        $this->browse(function (Browser $browser) {

            $tmp_user = User::factory()->create([
                'email' => 'admin@hetkoppel.com',
            ]);
            
            $tmp_user->syncPermissions(Permission::where('name', '!=', 'delete user')->get());
            
            $tmp_target_user = User::factory()->create([
                'email' => 'subject@test.com',
            ]);

            $browser->loginAs($tmp_user)
                ->visit(route('user.edit', $tmp_target_user->id))
                ->assertNotPresent('#delete');
        });
    }
}
