Multi Tenancy database:

    1)composer require stancl/tenancy

    2)php artisan tenancy:install

    3)php artisan migrate

    4)you can use seeding for seed the users.

    5)set providers : config/app.php - providers: App\Providers\TenancyServiceProvider::class,

    6)Then make a model in app/models : Tenant.php using,php artisan make:model Tenant

    7)create a multi tenancy database and domain using following the document , https://tenancyforlaravel.com/

    8)Make the dynamic tenant connection based on domain using middleware. (ex.setTenantConnection.php)

    9)Make login using the dynamic tenant connection middleware

    10)make your tenant routes and functions for tenant db.(ex.AdminRoute.php)

    11)Set the general tenant database cridetials to that database connections . (ex.database.php)

    12)Now make the TenantJobTrait for handling the tenant connections where during the queue working jobs for tenant database .(ex.TenantJobTrait.php)

    13)Now Make the job for tenant and dispatch it from the tenant web and work the queue.
