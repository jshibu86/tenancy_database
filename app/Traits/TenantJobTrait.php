<?php

namespace App\Traits;

use App\Models\Tenant;
use DB;

trait TenantJobTrait
{
    protected function setTenantConnection(Tenant $multiTenant)
    {
        // Dynamically set the tenant connection database name
        config(['database.connections.tenant.database' => "tenant" . $multiTenant->id]);
        \DB::purge('tenant'); // Reset the tenant connection

        // Set the default connection to 'tenant'
        \DB::setDefaultConnection('tenant');
    }

    protected function deleteJobs($customers)
    {
        // Delete from central jobs table
        DB::connection('mysql')->table('jobs')
            ->where('payload', 'like', '%' . json_encode($customers) . '%')
            ->delete();

        // Delete from tenant jobs table
        DB::connection('tenant')->table('jobs')
            ->where('payload', 'like', '%' . json_encode($customers) . '%')
            ->delete();
    }
    
}
