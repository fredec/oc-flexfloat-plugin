<?php namespace Diveramkt\Floatingbanner\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use DB;

class BuilderTableCreateDiveramktFloatingbannerCapturaEmails extends Migration
{
    public function up()
    {
        Schema::create('diveramkt_floatingbanner_captura_emails', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('enabled')->default(0);
            $table->string('tipo', 255)->nullable();
            $table->integer('time_aparecer')->default(0);
            $table->integer('time_cache')->default(1);
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->integer('enabled_name')->default(0);
            $table->string('select_campo', 255)->nullable();
            $table->string('color_fundo', 255)->default('#ffffff');
            $table->string('image_fundo', 255)->nullable();
            $table->integer('sort_order')->default(0);
            $table->text('colors')->nullable();
            $table->text('margin')->nullable();
            $table->integer('load_font_awesome')->default(0);
        });
        
        DB::table('diveramkt_floatingbanner_captura_emails')->insert(
            array(
                'id' => '1',
                'sort_order' => '1',
                'enabled_name' => '1',
                'time_cache' => '1',
            )
        );
        
    }
    
    public function down()
    {
        Schema::dropIfExists('diveramkt_floatingbanner_captura_emails');
    }
}