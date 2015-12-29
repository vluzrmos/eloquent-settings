<?php

namespace Vluzrmos\EloquentSettings\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {

    public $timestamps = false;

    protected $fillable = ['key', 'value'];

    /**
     * @return mixed
     */
    public function getTable()
    {
        return config('settings.table', 'settings');
    }

    /**
     * @return \Illuminate\Database\Connection
     */
    public function getConnection()
    {
        return static::resolveConnection(config('settings.connection'));
    }
}
