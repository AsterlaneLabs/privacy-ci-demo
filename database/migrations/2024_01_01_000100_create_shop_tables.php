<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Linked by a real foreign key. The easy case.
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Nullable so the order survives the buyer being erased.
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('shipping_address');
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            // Nullable so the comment can survive its author being anonymised.
            $table->foreignId('user_id')->nullable()->constrained();
            $table->text('body');
            $table->ipAddress('author_ip')->nullable();
            $table->timestamps();
        });

        // Personal data with nothing pointing at a user. The hard case.
        Schema::create('newsletter_signups', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('source')->nullable();
            $table->timestamps();
        });

        // No migration declares a link here. Only the Eloquent model does.
        Schema::create('audit_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id')->nullable();   // nullable so it can be anonymised
            $table->string('action');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_entries');
        Schema::dropIfExists('newsletter_signups');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('orders');
    }
};
