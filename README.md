# Eloquent Settings Repository

A package to store settings of your application on database.

# Installation

    composer require vluzrmos/eloquent-settings
    
# Configuration

First, you have to publish the configs and migrations:

    php artisan vendor:publish --provider=Vluzrmos\EloquentSettings\Providers\EloquentSettingsServiceProvider

Second, run the migrations:

    php artisan migrate
    
# Usage

You can use the dependency injection or the `setting` helper:

```php
use \Vluzrmos\EloquentSettings\Setting;

class YourInjectableClass {
   
   protected $settings;
   
   public function __construct (Setting $settings) {
       $this->settings = $settings;   
   }
   
   public function theMethod() {
       $option = $this->settings->get('my.awesome.option', 'default-value');
   }
} 
    
```

It's more easy to use the `setting` helper:

```php
// Getter
$option = setting('my.awesome.option', 'default-value');
//or
$option = setting()->get('my.awesome.option', 'default-value');

// Setter
setting()->set('my.awesome.option', 'That is Awesome!');

setting()->save(); //remember, without this the settings will not be stored on database
```

# Setting API

**get(string key, mixed default=null) : mixed** - Get a setting on database, if doens't exists it will use the default value.

**set(string|array key, mixed value=null) : void** - Set a value or array of key=>values to the settings.

**forget(string key) : void** - Clear an value of the settings.

**has(string key) : bool** - Check if settings has a given key.

**all() : array** - Get an array of all settings.

**except(string|array keys ...) : array** - Get settings which doesn't match with that given keys.

**only(string|array keys ...) : array** - Get settings which match with that given keys.

**save() : void** - **IMPORTANT!** Store settings on the database.

**update(string|array keys, mixed value=null) : void** - Sets and saves one or more settings.
