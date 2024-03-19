<?php

use App\Models\District;
use App\Models\Farmer;
use App\Models\MeasurementUnit;
use App\Models\Vegetable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('thlai_thars', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vegetable::class);
            $table->foreignIdFor(Farmer::class);
            $table->foreignIdFor(District::class)->nullable();
            $table->year('thar_kum')->nullable();
            $table->decimal('thar_zat')->nullable();
            $table->decimal('zau_zawng')->nullable();
            $table->decimal('a_hring_rate')->nullable();
            $table->decimal('a_ro_rate')->nullable();
            $table->decimal('hralh_zat')->nullable();
            $table->decimal('hluihlawn_zat')->nullable();


            $table->decimal('thar_zat_beisei')->nullable();
            $table->decimal('zau_zawng_beisei')->nullable();

            // $table->foreignIdFor(MeasurementUnit::class, 'thar_zat_unit_id')->nullable();
            // $table->string('beisei_kum')->nullable();
            // $table->decimal('beisei_zat')->nullable();
            // $table->foreignIdFor(MeasurementUnit::class, 'beisei_zat_unit_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thlai_thars');
    }
};
