# Slim Service Template (Updated)

Detta repository är en template för alla mikrotjänster byggda på Slim 4.

## Funktioner
- Slim 4 + PHP‑DI
- Action‑baserad arkitektur
- Doctrine DBAL
- Phinx migrations
- PHPUnit, PHPStan, PHPCS, Infection, Rector
- Dockerfile
- VERSION‑fil (semver)
- OpenAPI‑kontrakt (`openapi.yaml`)
- CI för OpenAPI (linter + validation + diff)

## OpenAPI
Alla mikrotjänster måste upprätthålla ett komplett API‑kontrakt i `openapi.yaml`.

Kontraktet används av:
- frontend (type‑safe klienter)
- CI (kontraktsvalidering + breaking change‑detektion)
- dokumentation

## Kom igång
```bash
composer install
php -S localhost:8080 -t public
```

## Uppdatera API‑kontrakt
När du ändrar något i API:et:
1. Uppdatera openapi.yaml
2. Bumpa VERSION‑filen
3. CI säkerställer att inga breaking changes glider igenom
