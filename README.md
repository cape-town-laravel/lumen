## Cape Town Laravel - Lumen Explorer

[![Build Status](https://travis-ci.org/ct-laravel/lumen.svg)](https://travis-ci.org/ct-laravel/lumen)

Explore lumen feature

### Explore Installation

* Download the Lumen installer

	`composer global require "laravel/lumen-installer=~1.0"`

* Add the path `~/.composer/vendor/bin`

* Checking 

	`lumen`
	> Lumen Installer version 1.0.1

* Create lumen app

    `lumen new explore-installer`
    > Crafting application...
    > Application ready! Build something amazing.
    
* Alternative method using Composer install (slower)

    `composer create-project laravel/lumen --prefer-dist explore-installer`

### Explore Configuration

* Enable Dotenv configuration
    - Enable [Dotenv](https://github.com/vlucas/phpdotenv) great at keeping sensitive data hidden.
    - `Dotenv::load(__DIR__.'/../');`

    - Created `.env`
    
            OPT_CUSTOM=true

* Lumen configs are found in `vendor/laravel/lumen-framework/config`

* Custom configs are found in `config`
    - Created `config/options.php`

            return [
                'custom' => env('OPT_CUSTOM', true),
            ];

* Loading Custom configs
    
        app()->configure('options');
        $custom = config('options.custom');