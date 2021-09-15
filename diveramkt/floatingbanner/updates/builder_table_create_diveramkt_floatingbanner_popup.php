<?php namespace Diveramkt\Floatingbanner\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use DB;

class BuilderTableCreateDiveramktFloatingbannerPopup extends Migration
{
    public function up()
    {
        Schema::create('diveramkt_floatingbanner_popup', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('link', 255)->nullable();
            $table->integer('enabled')->default(1);
            $table->text('description')->nullable();
        });
        
        // Insert some stuff
        DB::table('diveramkt_floatingbanner_popup')->insert(
            [
                'id' => '1',
                'title' => 'FloatingBanner',
                'enabled' => 0
            ]
        );
    }
    
    public function down()
    {
        Schema::dropIfExists('diveramkt_floatingbanner_popup');
    }
}