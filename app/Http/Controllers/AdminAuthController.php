<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\User;
use App\Models\Tenant as TenantMod;
use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Database\Models\Tenant;
use Illuminate\Support\Facades\Config;
use Stancl\Tenancy\Facades\Tenancy;
use App\Models\DomainModel;
use App\Models\TenantInfoModel;
use App\Jobs\SeedTenantInforamtionJob;
use App\Jobs\SeedCustomersJob;
use App\Models\CustomersModel;
use Hash;
use Illuminate\Support\Str;
class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        // dd("login");
        // dd(getCoreModuleMigrationPath());
        // dd($request->getHost());
        // session()->forget("tenant_connection");
        return view("login");
    }
    public function backendlogin(Request $request)
    {
        // $this->validate($request, [
        //     "email" => "required|exists:users,email|max:191",
        //     "password" => "required",
        // ]);
            // dd($request->all());
        // Check the user in the default connection
       
    
        $user = UserModel::where([
            "email" => "$request->email",
        ])->first();
        // dd(UserModel::get());
       
        if ($user) {
            if($user->name != "Admin"){
                // $domain = DomainModel::where("id",$user->domain_id)->first();
           
                // $tenantConnection = [
                //     "driver" => "mysql",
                //     "host" => "127.0.0.1",
                //     "port" => "3306",
                //     "database" => "tenant" . $domain->tenant_id, // Ensure the correct database name is used
                //     "username" => "root",
                //     "password" => "",
                //     "charset" => "utf8mb4",
                //     "collation" => "utf8mb4_unicode_ci",
                //     "prefix" => "",
                //     "strict" => true,
                //     "engine" => null,
                // ];
                
                // Set the tenant connection configuration
                // Config::set("database.connections.tenant", $tenantConnection);
                
                // Purge and set the default connection to tenant
                // DB::purge('tenant');
                // DB::setDefaultConnection('tenant');
                
                // Store tenant connection in session
                // $request->session()->forget('tenant_connection');
                // $request->session()->put('tenant_connection', $tenantConnection);
                
                // // Log the tenant database name for debugging
                // Log::info(DB::connection('tenant')->getDatabaseName());
                
                // Perform query on the tenant database
                $Tenantuser = UserModel::where("email", $request->email)->first();
            }
            else{
                $Tenantuser = UserModel::where("email", $request->email)->first();
            }
         
          
            // dd($Tenantuser);

                    if (
                        $Tenantuser &&
                        Hash::check($request->password, $Tenantuser->password)
                    ) {
                        $request->session()->put([
                            "ACTIVE_USER" => strval($Tenantuser->id),
                            "ACTIVE_USERNAME" => $Tenantuser->name,
                            "ACTIVE_GROUP" => "Super Admin",
                            "ACTIVE_EMAIL" => $Tenantuser->email,
                            // "ACTIVE_MOBILE" => $Tenantuser->mobile,
                            // "ACTIVE_USERIMAGE" => $Tenantuser->images,
                        ]);

                        //Auth::login($Tenantuser); // Login the user in the new connection

                        // Mark user as online
                        // $Tenantuser->online = 1;
                        // $Tenantuser->ip = $request->ip();
                        // $Tenantuser->lastactive = now();
                        // $Tenantuser->save();
                        // dd($request->pathinfo);
                      
                            return redirect()->route("backenddashboard");
                        
                    } else {
                       dd("bad credientials");
                    }
            
        } else {
           
            return redirect()
            ->back()
            ->withInput($request->input())->withErrors([
                "This Credentials Doesn't Match our Records | Please Enter Valid Credentials",
            ]);;
        }
    }

    public function Dashboard(Request $request)
    {
        
        $email = $request->session()->get('ACTIVE_EMAIL');
        $username = $request->session()->get('ACTIVE_USERNAME');
        $user = UserModel::where("email", $email)->first();
        $tenant = [];
        if($username == "Admin"){
            $tenant = TenantInfoModel::where("tenant_info.name","!=","Admin")
            ->leftJoin("domains","domains.id","=","tenant_info.domain_id")
            ->select("tenant_info.name","tenant_info.email","domains.domain","domains.tenant_id")
            ->get();
        }
        else{
            $tenant = CustomersModel::get();  
        }
       
        return view("dasboard", ["user" => $user,"username"=>$username,"tenant_info"=>$tenant]);
    }

    public function TenantCreate(Request $request){
        // dd($request->all());
        $validatedData = $request->validate([
            "name"=>"required|string",
            'email'=>'required|email',
            'domain_name' => 'required|string|unique:domains,domain',
            'password' => 'required',
        ]);
        try{
            $tenant = TenantMod::create($validatedData);
        
            $tenant->domains()->create([
                'domain'=>$validatedData['domain_name'] .'.'.config('app.domain')
            ]);
            $domain_name = $validatedData['domain_name'] .'.'.config('app.domain');
            $domain = DomainModel::where("domain",$domain_name)->first();
            $user = new TenantInfoModel();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->domain_id = $domain->id;
            $user->save();
            $tenant = TenantMod::where('id', $domain->tenant_id)->first(); 
            dispatch(new SeedTenantInforamtionJob($tenant,$user));
            // if ($tenant) {
            //     // Run the operation for this specific tenant
            //     $tenant->run(function () use ($request) {
            //         $user = new UserModel();
            //         $user->name = $request->name;
            //         $user->email = $request->email;
            //         $user->password = Hash::make($request->password);
            //         $user->save();
            //     });
            // }

            return redirect()->route('backenddashboard');
        }
        catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()
                ->back()
                ->withInput()
                ->with("exception", $e);
        }
      
    }

    public function logout(Request $request)
    {
        
        $request->session()->flush();

        $request->session()->flash("success", "Logout Successfull");
        return redirect()->route("login");
    }

    public function CustomersCreate(Request $request) {
        $customerData = [
            'name' => $request->name,
            'gmail' => $request->gmail,
            'mobile' => $request->mobile,
            'gender' => $request->gender,
        ];
    
        // Generate a UUID for the job
        $uuid = (string) Str::uuid();
    
        // Get the current tenant ID
        $id = DB::connection()->getDatabaseName();
        $cleanedId = str_replace('tenant', '', $id);
        $tenant = TenantMod::find($cleanedId); 
    
        if (!$tenant) {
            return redirect()->route('backenddashboard')->with('error', 'Tenant not found');
        }
    
        // Constructing the payload
        $payload = json_encode([
            'uuid' => $uuid,
            'displayName' => 'App\\Jobs\\SeedCustomersJob',
            'job' => 'Illuminate\\Queue\\CallQueuedHandler@call',
            'maxTries' => null,
            'maxExceptions' => null,
            'failOnTimeout' => false,
            'backoff' => null,
            'timeout' => null,
            'retryUntil' => null,
            'data' => [
                'commandName' => 'App\\Jobs\\SeedCustomersJob',
                'command' => serialize(new SeedCustomersJob($tenant, $customerData)), 
            ],
        ]);
    
        
        DB::connection('mysql')->table('jobs')->insert([
            'queue' => 'default',
            'payload' => $payload,
            'attempts' => 0,
            'reserved_at' => null,
            'available_at' => now()->timestamp,
            'created_at' => now()->timestamp,
        ]);
    
        
        dispatch(new SeedCustomersJob($tenant, $customerData)); 
    
        return redirect()->route('backenddashboard');
    }

}
