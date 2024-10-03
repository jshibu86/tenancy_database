<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Database\Models\Tenant;
use Illuminate\Support\Facades\Config;
use App\Models\DomainModel;

class SetTenantConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        $domain = DomainModel::where("domain", $host)->first();

        if ($domain) {
            $tenantConnection = [
                "driver" => "mysql",
                "host" => "127.0.0.1",
                "port" => "3306",
                "database" => "tenant" . $domain->tenant_id,
                "username" => "root",
                "password" => "",
                "charset" => "utf8mb4",
                "collation" => "utf8mb4_unicode_ci",
                "prefix" => "",
                "strict" => true,
                "engine" => null,
            ];

            // Set the tenant connection configuration
            Config::set("database.connections.tenant", $tenantConnection);

            // Purge and set the default connection to tenant
            DB::purge('tenant');
            DB::setDefaultConnection('tenant');

            // Store tenant connection in session
            $request->session()->put('tenant_connection', $tenantConnection);
        }

        return $next($request);
    }
}
