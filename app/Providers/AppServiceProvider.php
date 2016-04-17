<?php

namespace App\Providers;

use App\Project as Project;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Ei tarvita.
        // Enable SQLite foreign keys.
        // if (\DB::connection() instanceof \Illuminate\Database\SQLiteConnection) {
        //     \DB::statement(\DB::raw('PRAGMA foreign_keys=1'));
        // }
        
        // Poistetaan kaikki aikatapahtumat projektin mukana.
        Project::deleting(function($project) {
            foreach ($project->timesheets as $timesheet) {
                $timesheet->delete();
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
