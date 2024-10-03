<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\CustomersModel;
use App\Models\Tenant;
use DB;
use App\Traits\TenantJobTrait;

class SeedCustomersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,TenantJobTrait;

    protected $multiTenant;
    protected $customers;

    public function __construct(Tenant $multiTenant, $customers)
    {
        $this->multiTenant = $multiTenant;
        $this->customers = $customers;
    }

    public function handle(): void
    {
        \Log::info('SeedCustomersJob started processing.', $this->customers);

        try {
            // Set tenant connection dynamically
            $this->setTenantConnection($this->multiTenant);

            CustomersModel::create([
                "name" => $this->customers['name'],
                "gmail" => $this->customers['gmail'],
                "mobile" => $this->customers['mobile'],
                "gender" => $this->customers['gender']
            ]);

            // Log success
            \Log::info('Customer creation successful for ' . $this->customers['name']);

            // Delete the job from both central and tenant job tables
            $this->deleteJobs($this->customers);
        } catch (\Exception $e) {
            \Log::error('Failed to create customer: ' . $e->getMessage());
        }
    }

   
}

