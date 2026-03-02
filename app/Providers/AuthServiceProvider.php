<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Admin;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        
        try {
            $scopes   = [];
            $minutes  = 60; 
            if(auth()->guard('web')->check()){
                $sections = Cache::remember('sections', $minutes, function () {
                    try {
                        return (new Section())->setConnection('tenant')->select('id' , 'name')->get();
                    } catch (\Exception $e) {
                        \Log::warning('Failed to load sections from tenant connection: ' . $e->getMessage());
                        return collect([]);
                    }
                });
            }elseif(auth()->guard('admins')->check()){
                $sections = Cache::remember('sections', $minutes, function () {
                    try {
                        return  (new Section())->setConnection('mysql')->select('id' , 'name')->get();
                    } catch (\Exception $e) {
                        \Log::warning('Failed to load sections from mysql connection: ' . $e->getMessage());
                        return collect([]);
                    }
                });
            }else{
                $sections = Cache::remember('sections', $minutes, function () {
                    try {
                        return  (new Section())->setConnection('mysql')->select('id' , 'name')->get();
                    } catch (\Exception $e) {
                        \Log::warning('Failed to load sections from mysql connection: ' . $e->getMessage());
                        return collect([]);
                    }
                });
            }
            
            foreach ($sections as $section) {
                Gate::define($section->name, function ($user) use ($section) {
                    $guard = Auth::getDefaultDriver();
                    if ($guard === 'web' && $user instanceof User) {
                        return $user->hasPermission($section->name);
                    } elseif ($guard === 'admins' && $user instanceof Admin) {
                        return $user->hasPermission($section->name);
                    } 
                    return false;
                });
            }
        } catch (\Exception $e) {
            // If database connection fails during boot, log and continue
            // This allows migrations to run even if database is not available
            \Log::warning('AuthServiceProvider boot failed: ' . $e->getMessage());
        }
    }
}
