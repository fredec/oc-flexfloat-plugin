<?php namespace Diveramkt\Floatingbanner\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDiveramktFloatingbannerExitpopup extends Migration
{
    public function up()
    {
        Schema::table('diveramkt_floatingbanner_exitpopup', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
            $table->string('title', 255)->nullable()->change();
            $table->string('image', 255)->nullable()->change();
            $table->string('link', 255)->nullable()->change();
            $table->boolean('enabled')->nullable()->change();
            $table->text('description')->nullable()->change();
        });

        // Insert some stuff
        DB::table('diveramkt_floatingbanner_exitpopup')->insert(
            [
                'id' => '1',
                'title' => 'ExitBanner',
                'enabled' => 0,
                'image' => '',
                'link' => '',
                'description' => '',
            ]
        );
    }
    
    public function down()
    {
        Schema::table('diveramkt_floatingbanner_exitpopup', function($table)
        {
            $table->increments('id')->unsigned()->change();
            $table->string('title', 255)->nullable(false)->change();
            $table->string('image', 255)->nullable(false)->change();
            $table->string('link', 255)->nullable(false)->change();
            $table->boolean('enabled')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
        });
    }
}