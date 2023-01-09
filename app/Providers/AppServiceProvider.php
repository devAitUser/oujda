<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;  
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Organigramme;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('permission_user', function ()
        {
            $value = false;
             if (Auth::user()->hasPermissionTo('Gestion des utilisateurs'))
            {
              $value = true;
            }
            return $value;
        });
        Gate::define('permission_plan_classements', function ()
        {
            $value = false;
             if (Auth::user()->hasPermissionTo('Modifier le plan de classement'))
            {
              $value = true;
            }
            return $value;
        });
        ;
        Gate::define('Voir_plan_classement', function ()
        {
            $value = false;
             if (Auth::user()->hasPermissionTo('Visualiser le plan de classement'))
            {
              $value = true;
            }
            return $value;
        });
        Gate::define('permission_creer_dossier', function ()
        {
            $value = false;
             if (Auth::user()->hasPermissionTo('Créer un dossier'))
            {
              $value = true;
            }
            return $value;
        });

        Gate::define('permission_Modifier_dossiers', function ()
        {
            $value = false;
             if (Auth::user()->hasPermissionTo('Modifier le plan de classement'))
            {
              $value = true;
            }
            return $value;
        });
        Gate::define('permission_Modifier_roles', function ()
        {
            $value = false;
             if (Auth::user()->hasPermissionTo('Modifier les roles'))
            {
              $value = true;
            }
            return $value;
        });

      

        View::composer('layouts.app', function ($view) {
          $user = Auth::user();
          $projet_select_id = $user->projet_select_id;
          $nom_projet = "";

            if($projet_select_id != NULL) {
          
            $organigramme = Organigramme::find($projet_select_id);
            
            $dossiers = $organigramme->dossiers;
            $nom_projet = $organigramme->nom;
            
            }
            $view->with('role_name', $nom_projet );
            $view->with('name_user', $user->identifiant );
         });
       
        
    }

    
}
