<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Company;

class AppReportProvider extends ServiceProvider
{
    public function boot()
    {
        // Misal ini data statis/sederhana
        View::share('companyName', 'PT Contoh');

        // Misal ini data dari model (hati-hati performa)
        View::composer('pt.report', function ($view) {
            $view->with([
                'totalresultcompany' => 100, // ganti dengan perhitungan atau query
                'totalresultIPP' => 200,
                // tambahkan semua data lain di sini...
            ]);
        });
    }

    public function register()
    {
        //
    }
}
