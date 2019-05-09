# DEMO API without any framework

## Setup
`docker-compose build`

`docker-compose up -d`

The API base is [http://localhost:8080/api/v1/](http://localhost:8080/api/v1/)

## Run tests
`docker-compose exec test ./vendor/bin/phpunit`

## Available endpoints
`GET http://localhost:8080/api/v1/products` - List all available products

`GET http://localhost:8080/api/v1/products/<SKU>` - Get information about specific product including prices
Error codes: 404 if specific SKU is not found or 400 if missing argument

`GET http://localhost:8080/api/v1/products/<SKU>/prices/<UNIT>` - Get information about specific unit price
Error codes: 404 if specific unit is not found or 400 if missing argument

### Notes
1. docker-compose set-up has to be adjusted to not be forced to always run 2 containers
2. The `\DemoApi\Infrastructure\ProductRepository` has very bad performance since it has to iterate over the whole data set on every request
3. Setup in `public/index.php` is heavily inspired/adopted from this awesome [blog post](https://kevinsmith.io/modern-php-without-a-framework)
4. Validation was done for SKU format assuming it should always be in `NN-DD` format e.g. BA-01
5. No extensive validation of requested parameters was done, only bare minimum
    1. Validate that inputs are string
    2. Filter input variables using filter_var
