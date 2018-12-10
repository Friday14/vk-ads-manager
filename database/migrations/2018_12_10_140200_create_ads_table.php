<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('api_ad_id')->unique()->unsigned();
            $table->integer('api_campaign_id')->unsigned();
            $table->string('name');
            $table->integer('age_restriction')->unsigned();
            $table->integer('ad_format')->unsigned();
            $table->integer('cost_type')->unsigned();
            $table->integer('cpm')->unsigned();
            $table->integer('impressions_limit')->unsigned();
            $table->string('ad_platform')->nullable();
            $table->smallInteger('approved')->unsigned();
            $table->string('weekly_schedule_use_holidays')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('stop_time')->nullable();
            $table->integer('all_limit')->unsigned()->default(0);
            $table->integer('day_limit')->unsigned()->default(0);
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
