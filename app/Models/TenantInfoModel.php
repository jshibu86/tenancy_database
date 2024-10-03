<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantInfoModel extends Model
{
    use HasFactory;
    protected $table = "tenant_info";
}
