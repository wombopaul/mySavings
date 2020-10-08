<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('subscriber_id');
            $table->string('display_name');
            $table->text('footer');
            $table->string('website_url');
            $table->string('logo')->nullable();
            $table->string('contact_number');
            $table->string('contact_email');
            $table->text('map');
            $table->boolean('sms_active')->default(1);
            $table->decimal('sms_charges', 3, 2)->default();


            $table->foreign('subscriber_id')->references('id')->on('subscribers')->onDelete('restrict');
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
        Schema::dropIfExists('system_settings');
    }
}