<?php

use App\Models\District;
use App\Models\User;
use App\Models\VillageCouncil;
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
        Schema::create('farmers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('house_no')->nullable();
            $table->string('locality')->nullable();
            $table->string('latlong')->nullable();
            $table->string('ip')->nullable();
            $table->foreignIdFor(District::class)->nullable();
            $table->foreignIdFor(User::class, 'vc_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmers');
    }
};
