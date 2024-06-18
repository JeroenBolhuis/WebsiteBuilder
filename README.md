# Website Builder
## Setup

Volg deze stappen om het Laravel-project op te zetten:

1. Clone de repository met `git clone <repository-url>`.
2. Navigeer naar de projectmap met `cd <project-map>`.
3. Voer `composer install` uit om de afhankelijkheden te installeren.
4. Voer `npm install` uit om de npm-pakketten te installeren.
5. Maak een kopie van het `.env.example` bestand en hernoem het naar `.env`.
6. Genereer een applicatiesleutel met `php artisan key:generate`.
7. Voer de database migraties uit met `php artisan migrate`.
8. Voer het volgende command uit `php artisan storage:link` om alle afbeeldingen te laten werken.
9. Maak een virtuele host aan of voer `php artisan serve` uit om de applicatie lokaal te draaien.
10. Geniet van je Laravel-project!

Zorg ervoor dat je de juiste configuratie instelt in het `.env` bestand, zoals de databaseverbinding en andere relevante instellingen.

Voor de Dusk tests moet de Dusk env nog opgezet worden:

1. Maak een kopie van het `.env.example.dusk.local` bestand en hernoem het naar `.env.dusk.local`.
2. Stel in de ENV de juiste `DB_DATABASE`, `APP_URL` en `APP_KEY` (uit de .env) in.
3. Maak de SQL database aan.
4. Voer het command `php artisan dusk:chrome-driver` uit.
5. Run `php artisan dusk` voor alle tests of `php artisan dusk --filter naam_test`.

## Coding Guidelines
1. https://spatie.be/guidelines/laravel-php

## Git workflow
### Branches 

De branches die gebruikt worden zijn: 

`master` - De master branch is de branch waar de code in staat die op dat moment in productie is. 

`development` - De development branch is de branch waar de code in staat die op dat moment in ontwikkeling is. 

`feature/` - De feature branches zijn branches die gebruikt worden om een feature te ontwikkelen. Deze branches worden vanaf de development branch gemaakt en worden na het afronden van de feature gemerged met de development branch. 

 
De namen van de branches geven wij volgens de semantisch standaard. 

`feature/<omschrijving>` - Nieuwe functie in het programma. 

`fix/<omschrijving>` - Bugfix in het programma. 

`refactor/<omschrijving>` - Aanpassing van huidige code in het programma. 

`wip/<omschrijving>` - Work in progress, toevoeging waar je langer mee bezig gaat zijn of experimenteren met code. 

`build/<omschrijving>` - Aanpassing aan de configuratie en werking van de applicatie. 

 
### Commits 
Commits worden gemaakt met de volgende structuur: Semantische Git Commits. 

### Pull requests 
Pull requests worden gemaakt vanaf een branch naar de development branch. Deze worden vervolgens door minimaal 1 andere developer gereviewd en gemerged.  

### Issues 
Issues worden gebruikt om bugs en features te tracken. In de issue wordt een beschrijving gegeven van de bug of feature. Vervolgens wordt er een passende label aan de issue toegevoegd. 

### Custom Commands  
#### Nieuwe admin gebruiker 
Om een nieuwe beheerder aan te maken kan er gebruik gemaakt worden van het volgende command:  
`php artisan app:create-admin-user <username> <email>`

### Hoe maak je een nieuwe template voor dummies
#### Laat de template genereren
Om een nieuwe template aan te maken kan het volgende commando uitvoeren:
- `<template_naam>` MOET hetzelfde zijn + PascalCase bijv: TekstLinksTekstRechts
- `<eigen_input_naam1>` Deze namen mag je zelf kiezen

`php artisan make:template <template_naam> <eigen_input_naam1> <eigen_input_naam2>`

Om later extra input velden toe te voegen kan je de volgende array aanpassen
- `public $input_names = ['<eigen_input_naam>','<eigen_input_naam>'];`

Deze code staat in het volgende bestand `App/View/Components/Templates/<template_naam>/Admin`.

#### Wil je alles zelf doen?
Om een nieuwe template aan te maken heb je 2 commando's:
- `<template_naam>` MOET hetzelfde zijn + PascalCase bijv: TekstLinksTekstRechts
1. `php artisan make:component Templates/<template_naam>/Admin`
2. `php artisan make:component Templates/<template_naam>/Page`

Voeg de `<template_naam>` toe in de template tabel onder de kolom `name` en in de `Database/Seeders/TemplateSeeder`.

Navigeer nu naar `App/View/Components/Templates/<template_naam>/Admin`.

Vervolgens vul je dit in bovenin de class:
- `public $input_names = ['<eigen_input_naam>','<eigen_input_naam>'];`

Navigeer nu naar `Resources/views/components/templates/<template_naam>/admin`.
Hier kun je de input velden aanmaken om in te vullen in de admin pagina.

Navigeer nu naar `Resources/views/components/templates/<template_naam>/page`.
Dit is wat je op de echte website gaat zien.

`{{ $template->pivot->data->eigen_input_naam }}`
Zo haal je de gewenste data op.


