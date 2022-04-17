# Witrac Vault Smart Storage

## Requirements 📋

1. docker `latest`
2. docker-compose `latest`
3. make `latest`

## Setting up ⚙️

1. Copy the base _.env_ file as _.env.local_ and set the next values:
    - `DATABASE_URL` - Connection string (DSN) for MySQL RDBMS with the 
next format `(mysql://witrac:witrac@mysql:3306/witrac?serverVersion=5.7)`.
    - `S3_ENDPOINT` - HTTP URL for file storage system
    - `S3_BUCKET` - The bucket of AWS S3 for storage system
2. Build the docker containers using the command `make start`
3. On docker build finish exec the command `make bash` and then inside of container install the project
dependencies using **composer** running `composer install`
4. Migrate the database for both environments `dev` and `test` 
running `php bin/console doctrine:migrations:migrate` and `php bin/console doctrine:migrations:migrate --env=test`
5. Enjoy development

## Considerations 🕵

1. The implementation of consumer for published domain events is not completed i just have been defined as an interface.
2. The [FileStatus](./src/Vault/Domain/File/FileStatus.php) could be better at least the behavior should
be migrated as enumerated and keep the business domain context.
3. Refactor [Custom Doctrine Types](./src/Shared/Infrastructure/Persistence/Doctrine) classes to avoid repeated logic.
4. Refactor input data validation controllers could be a great idea to establish a standard way to validate all
incoming data.
5. Refactor storage systems implementations and abstractions.
6. The kernel is shared between bounded contexts but could be separated if every bounded context has specifics requirements about configuration.
7. Some entities have Doctrine [Collection](./vendor/doctrine/collections/lib/Doctrine/Common/Collections/Collection.php) typehint and
for me this is a possible shortcut taken. They say that is not problem because all behind scenes' implementation comes from
[PHP itself & SPL,](https://www.doctrine-project.org/projects/doctrine-orm/en/2.11/reference/association-mapping.html#collections) but it is possible
think another approach to manage this scenario.
```
The Collection interface and ArrayCollection class, like everything else in the Doctrine namespace, are neither part of the ORM, 
nor the DBAL, it is a plain PHP class that has no outside dependencies apart from dependencies on PHP itself (and the SPL). 
Therefore using this class in your model and elsewhere does not introduce a coupling to the ORM.
```
8. Authentication system isn't implemented.
9. Generic exception catching on controllers is a shortcut taken and could be replaced by an exception mapping
responses by controller and environment (error trace in dev environments is really usefully).
10. Feature tests for File entity isn't implemented yet.