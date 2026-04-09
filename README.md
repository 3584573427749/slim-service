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

## Lokal utveckling

Detta projekt kan köras helt med Docker för snabb och isolerad utveckling.

### Starta tjänsten

```bash
make up
````

Tjänsten nås sedan på:  
**<http://localhost:8080/health>**

***

### Stoppa tjänsten

```bash
make stop
```

***

### Starta utan rebuild (snabbare)

```bash
make start
```

***

### Öppna shell i containern

```bash
make shell
```

***

### Visa loggar

```bash
make logs
```

***

### Kör tester

```bash
make test
```

***

### Kör PHPStan

```bash
make stan
```

***

### Kör migreringar (Phinx)

```bash
make migrate
```

***

### Formatera kod med PHP‑CS‑Fixer

```bash
make fix
```


## OpenAPI
Alla mikrotjänster måste upprätthålla ett komplett API-kontrakt i `openapi.yaml`.

Kontraktet används av:
- frontend (type-safe klienter)
- CI (kontraktsvalidering + breaking change-detektion)
- dokumentation

## Kom igång
```bash
composer install
php -S localhost:8080 -t public
```

## Uppdatera API-kontrakt
När du ändrar något i API:et:
1. Uppdatera openapi.yaml
2. Bumpa VERSION-filen
3. CI säkerställer att inga breaking changes glider igenom
