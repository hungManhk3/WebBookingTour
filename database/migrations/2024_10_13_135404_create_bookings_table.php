<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('tour_id')->index('tour_id');
            $table->integer('customer_id')->index('customer_id');
            $table->float('price', 10, 0);
            $table->float('total', 10, 0)->nullable();
            $table->float('deposit', 10, 0)->default(0);// cọc
            $table->float('discount', 10, 0)->default(0);
            $table->string('discount_code', 20)->nullable();
            $table->mediumInteger('people');
            $table->tinyInteger('payment_method')->default(1)->comment('1: Cash, 2: Momo');
            $table->boolean('is_payment')->default(false)->comment('0: Unpaid, 1: paid');;
            $table->date('departure_time');//ngày xuất phát
            $table->text('requirement')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: New, 2: Confirmed, 3: Completed, 4: Cancel');
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
        Schema::dropIfExists('bookings');
    }
};
