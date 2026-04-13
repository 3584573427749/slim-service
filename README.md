# Slim Service Template

Detta repository är en komplett template för mikrotjänster byggda på Slim 4.

Den innehåller en fullständig grund för:

*   Settings (.env + typcasting)
*   ErrorHandler (standardiserat JSON‑format)
*   DBAL‑bootstrap (Doctrine DBAL)
*   Repositories (AbstractRepository)
*   Actions (invokable, en per endpoint)
*   Routing (grupper per domän)
*   Middleware (JSON body parsing + CORS)
*   Auth (gateway‑baserad)
*   Role‑middleware
*   AuthService‑integration (service‑to‑service säkerhet)
*   OpenAPI‑kontrakt
*   Docker + Makefile + Composer scripts

***

## Funktioner

*   Slim 4 + PHP-DI
*   Action‑baserad arkitektur
*   Doctrine DBAL
*   Phinx migrations
*   PHPUnit, PHPStan, PHPCS, Infection, Rector
*   Dockerfile + docker-compose
*   VERSION‑fil (semver)
*   OpenAPI-kontrakt (openapi.yaml)
*   CI för OpenAPI (linter + validation + diff)
*   Central ErrorHandler
*   Monolog-loggning
*   Settings-system (.env, castade variabler)
*   Auth-middleware (gateway User‑auth)
*   Role‑middleware (behörighet per route)
*   AuthService-middleware (service‑to‑service autentisering)

***

## ErrorHandler

Systemet använder en central ErrorHandler som:

*   returnerar JSON i fast struktur
*   inkluderar “status”, “error”, “message” och valfri “details”
*   loggar ALLA exceptions (logs/app.log)
*   visar aldrig stacktraces i API‑svar
*   använder egna exception-klasser:
    *   ValidationException
    *   UnauthorizedException
    *   ForbiddenException
    *   NotFoundException
    *   InternalException

Exempel på felrespons:

{
"status": 400,
"error": {
"type": "ValidationException",
"message": "Felaktig input",
"details": { ... }
}
}

***

## Settings

Settings-systemet:

*   läser `.env` via vlucas/phpdotenv
*   finns i `src/Application/Settings.php`
*   erbjuder `get(key, default)`
*   castar automatiskt values beroende på key (int, bool, float, string)

Exempel:

$dbHost = $settings->get('DB\_HOST');
$debug = $settings->get('APP\_DEBUG', false);

***

## DBAL (Database)

Doctrine DBAL‑bootstrap via singleton:

*   Connection ligger i `src/Infrastructure/Database/Connection.php`
*   Lazy-connection (ansluter först när query körs)
*   Konfiguration läses från Settings
*   Repositories får DB‑connection via DI

***

## Repositories

AbstractRepository:

*   finns i `src/Infrastructure/Persistence/AbstractRepository.php`
*   tillhandahåller:
    *   `$this->db` (DBAL connection)
    *   `qb()` (QueryBuilder helper)
*   konkreta repositories anger tabellnamn själva

Exempel:

protected string $table = 'users';

***

## Routing & Actions

Routing organiseras i domän-grupper via `config/routes.php`.

Varje endpoint har en egen Action‑klass:

src/Application/Actions/<Domain>/<Action>.php

Alla Actions är **invokable**:

public function \_\_invoke(Request $request, Response $response)

Alla Actions returnerar konsekventa success‑responses:

{
"status": 200,
"data": {
"user": {
...
}
}
}

***

## Middleware

### JSON Body Parsing

Slims inbyggda body parser:
$app->addBodyParsingMiddleware();

### CORS middleware

Regex-baserad, konfigureras via `.env`:

ENABLE\_CORS=true  
CORS\_ALLOW\_ORIGIN\_PATTERN=^https\://(\[a-z0-9-]+.)\*example.com$  
CORS\_ALLOW\_METHODS=GET,POST,PUT,PATCH,DELETE,OPTIONS  
CORS\_ALLOW\_HEADERS=Authorization,Content-Type,Accept

Stödjer credentials.

***

## AuthMiddleware (gateway‑auth)

Validerar trusted headers från gateway:

X-Auth-Verified: true  
X-User-Id: <id>  
X-User-Roles: role1,role2

Om saknas → UnauthorizedException (401)

Lägger userId och roles i request‑attributes.

Appliceras per route‑group.

***

## RoleMiddleware

Kräver minst en roll:

new RequireRoleMiddleware(\['admin'])

Case‑insensitiv jämförelse.

Vid roll‑brist → ForbiddenException (403)

Läggs på route‑grupper efter AuthMiddleware.

***

## AuthServiceMiddleware (service‑to‑service security)

Varje mikrotjänst (utom auth‑service själv) måste kunna verifiera interna anrop från andra tjänster.

Middleware kräver:

X-Service-Token: <token>

Och anropar auth‑servicen:

POST /validate-service-token  
{
"token": "...",
"service": "\<SERVICE\_NAME>"
}

Om ogiltig → UnauthorizedException (401)

Konfigureras via `.env`:

AUTH\_SERVICE\_URL=<http://auth-service:8080>  
SERVICE\_NAME=time-service

***

## OpenAPI-kontrakt

Varje mikrotjänst måste ha ett openapi.yaml:

*   ligger i projektroten
*   används av frontend (gen. typer)
*   används av CI (breaking change-detektion)
*   används av dokumentation

Vid API‑ändringar:

1.  Uppdatera openapi.yaml
2.  Bumpa VERSION
3.  Skicka PR — CI blockerar breaking changes

***

## Composer-scripts

Kommandon för utveckling:

composer up  
composer down  
composer start  
composer shell  
composer logs  
composer test  
composer stan  
composer migrate  
composer fix

***

## Lokal utveckling

### Steg 1 – Installera beroenden via Docker

docker compose up --build -d  
docker compose exec slim-service composer install

### Steg 2 – Kopiera miljöfil

cp .env.example .env

### Steg 3 – Starta tjänsten

composer up

### Tjänsten finns på:

<http://localhost:8080/health>

### Shell i containern:

composer shell

***

## Databas

Kör migrations:

composer migrate

