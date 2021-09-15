<?php namespace Diveramkt\Floatingbanner\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use DB;

class BuilderTableCreateDiveramktFloatingbannerExitpopup extends Migration
{
    public function up()
    {
        Schema::create('diveramkt_floatingbanner_exitpopup', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', 255);
            $table->string('image', 255);
            $table->string('link', 255);
            $table->boolean('enabled')->default(1);
            $table->text('description');
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
        Schema::dropIfExists('diveramkt_floatingbanner_exitpopup');
    }
}