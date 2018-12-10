<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('api_campaign_id')->unsigned();
            $table->integer('cabinet_id')->unsigned();
            $table->string('name');
            $table->string('type');
            $table->integer('day_limit')->unsigned();
            $table->integer('all_limit')->unsigned();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('stop_time')->nullable();
            $table->timestamps();
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->foreign('cabinet_id')
                ->references('id')->on('cabinets')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropForeign(['cabinet_id']);
        });
        Schema::dropIfExists('campaigns');
    }
}
