<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Illuminate\Support\Facades\DB;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;
    protected $connection = "mysql";
    public static function getCustomColumns(): array
    {
        return ["id", "tenant_username"];
    }

    protected $casts = [
        "data" => "array",
    ];
    
    public function setPasswordAttribute($value){
        return $this->attributes['password'] = bcrypt($value);
    }
    // public function candidate()
    // {
    //     return $this->hasOne(CandidateModel::class, "tenant_id", "id");
    // }

    // public function makeCurrent()
    // {
    //     // Set the database for the current tenant
    //     config(['database.connections.tenant.database' => $this->database]); 
    //     DB::purge('tenant'); // Clear the previous connection

    //     // Optionally, switch to the new tenant connection
    //     DB::connection('tenant'); 
    // }
}
