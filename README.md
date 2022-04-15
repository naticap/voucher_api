## Prequesite

Im using [Lando with Laravel Recipe for this project](https://docs.lando.dev/laravel/). 
So to running out this project instantly please make sure this following software installed on your local machine:
- [Docker](https://www.docker.com/).
- [Lando](https://lando.dev/).
- [Rest Client](https://marketplace.visualstudio.com/items?itemName=humao.rest-client) Extension for VSCode this one nice to have. Because if you have you can try this app easily. I already put each sample request on `voucher_api.rest` file.

## Running the app 

Once all of those software above installed you can easily running this following command:
- `lando start` to pulling images and running the container
- `lando composer install` to installing laravel and its dependencies
- `lando artisan migrate` migrating all of initial migrations 
- `lando artisan db:seed` to add some seeder record 
- `lando artisan queue:work` this one needed, because I use queued job to manage rollback voucher code when the user didn't upload photo after 10 minutes reserved.

## 