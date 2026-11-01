# Website Builder

Website Builder is a Laravel application built for student association Het Koppel between February and April 2025. It provides a public website and an administration area for assembling pages from reusable templates and managing association content. It was a project for the association; the current repository history is an import and does not by itself establish individual authorship of every feature.

## Features

- Assemble and preview pages from reusable templates, reorder components and select a homepage.
- Manage events, posts, sponsors, albums and media; public visitors can view content and submit posts.
- Configure navigation, footer, social links, colors and branding.
- Manage users and permissions, review a logbook, and restore or permanently delete items from the trash.

The admin routes are protected by authentication and permissions. See [routes/web.php](routes/web.php) for the available actions.

## Stack

PHP 8.1+, Laravel 10, Blade, Livewire 3, Tailwind CSS, Vite and MySQL. The Composer and npm manifests list the dependencies; Livewire supplies Alpine.js for interactive components.

## Local setup

Install PHP with Composer's required extensions, Composer, Node.js, npm and MySQL. From the repository root:

```sh
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Create a local database and configure its connection in `.env`. Then run:

```sh
php artisan migrate
php artisan db:seed
php artisan storage:link
npm run dev
```

The seeders initialize templates, settings, permissions and the footer; see [DatabaseSeeder.php](database/seeders/DatabaseSeeder.php). In another terminal run `php artisan serve`, or configure a virtual host. `npm run build` builds frontend assets. Keep `.env` private and use your own local credentials.

Create an administrator after seeding permissions:

```sh
php artisan app:create-admin-user <username> <email>
```

The command prompts for a password. Use a unique local password.

## Tests

PHPUnit example unit and feature tests and Laravel Dusk browser tests are present. The browser tests cover areas including media, navigation, users, posts, events and trash.

```sh
php artisan test
```

For Dusk, copy `.env.example.dusk.local` to `.env.dusk.local`, configure an isolated test database, `APP_URL` and the application key, and create that database. Install a compatible ChromeDriver, then run:

```sh
php artisan dusk:chrome-driver
php artisan dusk
# Or select a test:
php artisan dusk --filter TestName
```

Dusk can modify its configured database; do not use a database containing data you need. Test results are not implied by these instructions.

## Creating a page template

The custom generator creates admin and page components and inserts a template record into the current database. Use a PascalCase name and choose input names:

```sh
php artisan make:template TextLeftTextRight first_input second_input
```

Choose a name that does not already exist. The admin component in `app/View/Components/Templates/<Name>/Admin.php` exposes `public $input_names`; edit that array to add inputs. Define the admin fields and public output in the corresponding views under `resources/views/components/templates/`. Template data is available in the page view as `{{ $template->pivot->data->first_input }}`. Add the template to [TemplateSeeder.php](database/seeders/TemplateSeeder.php) if it should also be available in newly seeded databases.

Alternatively, create both components manually with `php artisan make:component Templates/<Name>/Admin` and `php artisan make:component Templates/<Name>/Page`, define the input names in the admin class, create the views, and add the template to the database and seeder.

## Original team conventions

The original project documentation described `master` for production, `development` for ongoing work, and branches such as `feature/`, `fix/`, `refactor/`, `wip/` and `build/`. It called for semantic commits, pull requests reviewed by another developer, and issues for bugs and features. These are historical conventions, not a claim about the current branch structure. The team also referenced the [Spatie Laravel and PHP guidelines](https://spatie.be/guidelines/laravel-php).
