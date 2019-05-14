<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->connection = config('settings.connection');
        $this->table = config('settings.table', 'settings');
    }

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->index();
            $table->longText('value');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop($this->table);
    }
}
