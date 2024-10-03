<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\DomainModel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Tenant as TenantMod;
use Stancl\Tenancy\Database\Models\Tenant;
use Stancl\Tenancy\Facades\Tenancy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        DB::listen(function ($query) {
            \Log::info($query->sql, $query->bindings);
        });
      
    }
}
