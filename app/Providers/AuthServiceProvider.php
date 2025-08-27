
<?php



use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Film;
use App\Policies\FilmPolicy;

class AuthServiceProvider extends ServiceProvider
{
    // Map models to policies
    protected $policies = [
        Film::class => FilmPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}