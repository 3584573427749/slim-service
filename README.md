# Slim Service Template

Detta repository är en template för alla mikrotjänster byggda på Slim 4.

## Funktioner
- Slim 4 + PHP-DI
- Action-baserad arkitektur
- Doctrine DBAL
- Phinx migrations
- PHPUnit, PHPStan, PHPCS, Infection, Rector
- Dockerfile
- VERSION-fil (semver)
- OpenAPI-kontrakt (`openapi.yaml`)
- CI för OpenAPI (linter + validation + diff)

## ErrorHandler
Systemet använder en central ErrorHandler som:
- returnerar JSON i fast struktur
- loggar ALLA exceptions
- aldrig visar stacktraces i API‑svar
- använder egna exception‑klasser
- använder Monolog och skriver loggar i logs/app.log


## Composer‑scripts
Detta repo erbjuder enhetliga scripts för alla mikrotjänster.
```json
"scripts": {
"up": "docker compose up --build",
"down": "docker compose down",
"start": "docker compose up",
"shell": "docker compose exec slim-service sh",
"logs": "docker compose logs -f",
"test": "docker compose exec slim-service vendor/bin/phpunit",
"stan": "docker compose exec slim-service vendor/bin/phpstan analyse src --level=max",
"migrate": "docker compose exec slim-service vendor/bin/phinx migrate -e development",
"fix": "docker compose exec slim-service vendor/bin/php-cs-fixer fix"
}
```

Kommandon körs så här:
```bash
composer up
composer test
composer stan
composer migrate
composer fix
```

På Windows fungerar detta utan Makefile, eftersom Composer är plattformsoberoende.

## OpenAPI
Alla mikrotjänster måste upprätthålla ett komplett API-kontrakt i `openapi.yaml`.

Kontraktet används av:
- frontend (type-safe klienter)
- CI (kontraktsvalidering + breaking change-detektion)
- dokumentation


## Lokal utveckling
### Steg 1 – Installera beroenden i Docker
```bash
docker compose up --build -d
docker compose exec slim-service composer install
```


### Steg 2 – Skapa din .env‑fil
```bash
cp .env.example .env
```


### Steg 3 – Starta tjänsten
```bash
composer up
```

Tjänsten körs nu på:
http://localhost:8080/health


### Steg 4 – Shell in i containern
```bash
composer shell
```

##️ Databas & migrations
```bash
composer migrate
```

## Uppdatera API-kontrakt
När du ändrar något i API:et:
1. Uppdatera openapi.yaml
2. Bumpa VERSION-filen
3. CI säkerställer att inga breaking changes glider igenom
