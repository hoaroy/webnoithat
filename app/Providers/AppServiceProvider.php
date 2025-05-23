<?php

namespace App\Providers;

use App\Category;
use App\Products;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

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
        view()->composer('*',function($view){
            $url_canonical = Request()->url();
            $startOfWeek = Carbon::now('Asia/Ho_Chi_Minh')->startOfWeek()->format('Y/m/d');
            $endOfWeek = Carbon::now('Asia/Ho_Chi_Minh')->endOfWeek()->format('Y/m/d');

            $all_category = Category::whereNull('category_sub')
            ->where('category_status',1)
            ->take(8)
            ->orderBy('category_sorting','asc')
            ->get();
            $product_modal = Products::where('product_status',1)->get();

            $view->with(compact('url_canonical','all_category','startOfWeek','endOfWeek','product_modal'));
        });
    }
}
