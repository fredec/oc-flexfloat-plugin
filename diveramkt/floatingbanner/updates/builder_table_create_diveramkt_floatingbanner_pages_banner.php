<?php namespace Diveramkt\Floatingbanner\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDiveramktFloatingbannerPagesBanner extends Migration
{
    public function up()
    {
        Schema::create('diveramkt_floatingbanner_pages_banner', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('page_id', 100)->nullable();
            $table->integer('banner_id')->nullable();
            $table->text('url')->nullable();
            $table->string('type_url', 100)->nullable();
            $table->string('type_banner', 100)->nullable();
            $table->integer('enabled')->nullable()->default(1);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('diveramkt_floatingbanner_pages_banner');
    }
}