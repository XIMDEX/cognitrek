<?php

use App\Models\Variant;
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
        Schema::table('user_variants', function (Blueprint $table) {
            
            $table->dropForeign('user_variants_variant_id_foreign');
            
            $table->foreign('variant_id')
                ->references('adaptation_id')
                ->on('variants')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_variants', function (Blueprint $table) {
            $table->dropForeign('user_variants_variant_id_foreign');
            
            $table->foreign('variant_id')
                ->references('id')
                ->on('variants')
                ->onDelete('cascade');
        });
    }
};
