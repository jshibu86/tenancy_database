<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Tenant;
use App\Models\User;

class SeedTenantInforamtionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $multiTenant;
    protected $users;
    public function __construct(Tenant $multiTenant,$users)
    {
        $this->multiTenant = $multiTenant;
        $this->users = $users;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->multiTenant->run(function () {
            $user = User::create([
                "name" => $this->users->name,
                "email" => $this->users->email,
                "password" => $this->users->password,
            ]);
        });
    }
}
