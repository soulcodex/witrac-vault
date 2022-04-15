# Witrac Smart Storage

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
    - `S3_STORAGE_KEY` - The access storage key for AWS S3 storage system
    - `S3_STORAGE_SECRET` - The secret key for AWS S3 storage system unique access.
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