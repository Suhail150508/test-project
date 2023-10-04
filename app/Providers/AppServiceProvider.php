<?php

namespace App\Providers;

use App\Validators\CustomValidator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        //Schema::disableForeignKeyConstraints();

        // custom validation for offensive word start
        Validator::extend('offensive_words', [CustomValidator::class, 'offensiveWords']);
        // custom validation for offensive word end

        View::composer('*', function ($view) {
            $view->with([
                'notifications' => @Auth::user()->notifications,
            ]);
        });

        \View::composer('*',function($email_header_logo){
            $logo = \URL::asset('assets/common/images/logo/ccc_logo.png');
            $email_header_logo->with('email_header_logo',$logo);
        });

        \View::composer('*',function($no_image){
            $image = \URL::asset('assets/common/images/no-image.png');
            $no_image->with('no_image',$image);
        });

        \View::composer('*',function($number_pattern){
            $pattern = '[.0-9]+';  //this pattern only for english
            $number_pattern->with('number_pattern',$pattern);
        });

        \View::composer('*',function($bn_number_pattern){
            $pattern = '[.০-৯]+';  //this pattern only for bengali
            $bn_number_pattern->with('bn_number_pattern',$pattern);
        });

        \View::composer('*',function($en_bn_number_pattern){
            $pattern = '[.০-৯0-9]+';  //this pattern for bengali and english both
            $en_bn_number_pattern->with('en_bn_number_pattern',$pattern);
        });

        \View::composer('*',function($ajax){
            $ajax_request = request()->ajax();
            $ajax->with('ajax',$ajax_request);
        });

        Paginator::useBootstrap();

    }
}
