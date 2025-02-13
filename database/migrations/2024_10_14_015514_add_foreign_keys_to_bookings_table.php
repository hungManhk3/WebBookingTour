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
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign(['tour_id'], 'bookings_fk_1')->references(['id'])->on('tours')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['customer_id'], 'bookings_fk_2')->references(['id'])->on('customers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign('bookings_fk_1');
            $table->dropForeign('bookings_fk_2');
        });
    }
};
