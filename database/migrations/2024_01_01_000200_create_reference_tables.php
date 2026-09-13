<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Decoys. Every one of these columns matches a personal-data name pattern and
 * none of them describes a person. A scanner that flags these is unusable on a
 * real schema, so they are here to be ignored.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city')->nullable();
        });

        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
        });

        Schema::create('refund_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('reason');
            $table->text('message')->nullable();
        });

        Schema::create('webhook_deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('email_template_id');
            $table->boolean('email_sent')->default(false);
            $table->timestamp('email_sent_at')->nullable();
            $table->json('payload');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_deliveries');
        Schema::dropIfExists('refund_reasons');
        Schema::dropIfExists('order_statuses');
        Schema::dropIfExists('countries');
    }
};
