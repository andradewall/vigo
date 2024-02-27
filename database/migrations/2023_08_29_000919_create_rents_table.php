<?php

use App\Enums\RentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->id();

            $table->enum('status', array_column(RentStatus::cases(), 'value'))
                ->default(RentStatus::PENDING_PAYMENT->value);

            $table->datetime('starting_date');
            $table->datetime('ending_date')->nullable();

            $table->decimal('value', 10, 2);
            $table->decimal('shipping_fee', 10, 2)->default(0.00);
            $table->text('notes')->nullable();
            $table->string('payment_method', 125);
            $table->unsignedSmallInteger('discount_percentage')->default(0);
            $table->string('usage_address', 255);

            $table->foreignId('contact_id')->nullable();
            $table->string('contact_name', 125);
            $table->string('contact_main_phone', 15);
            $table->string('contact_secondary_phone', 15)->nullable();
            $table->string('contact_email', 125)->nullable();
            $table->string('contact_address', 255);
            $table->string('contact_document_number', 14);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};
