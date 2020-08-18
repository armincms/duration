<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Duration\Nova\Duration;

class CreateDurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('durations', function (Blueprint $table) {
            $table->bigIncrements('id');    
            $table->string('label')->nullable(); 
            $table->string('locale')->default(app()->getLocale()); 
            $table->integer('length')->default(1); 
            $table->enum('interval', array_keys(Duration::intervals()))->default('day'); 
            $table->string('sequence_key')->nullable();  
            $table->timestamps();    
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('durations');
    }
}
