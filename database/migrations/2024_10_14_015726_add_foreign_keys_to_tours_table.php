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
        Schema::table('tours', function (Blueprint $table) {
            $table->foreign(['type_id'], 'tours_fk_1')->references(['id'])->on('tour_types')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['destination_id'], 'tours_fk_2')->references(['id'])->on('destinations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropForeign('tours_fk_1');
            $table->dropForeign('tours_fk_2');
        });
    }
};
