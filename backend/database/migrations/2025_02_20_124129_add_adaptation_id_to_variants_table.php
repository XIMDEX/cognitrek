<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_variants', function (Blueprint $table) {
            $table->dropForeign('user_variants_variant_id_foreign');
        });

        Schema::table('variants', function (Blueprint $table) {
            $table->string('adaptation_id', 36)->nullable()->index()->after('id');
        });

        Schema::table('user_variants', function(Blueprint $table) {
            $table->string('variant_id', 36)->change();
        });

        DB::transaction(function () {
            $groups = DB::table('variants')->select('label')->distinct()->get();

            foreach ($groups as $group) {
                $uuid = Str::uuid()->toString();
                DB::table('variants')
                    ->where('label', $group->label)
                    ->update(['adaptation_id' => $uuid]);
            }
        });
    }

    public function down(): void
    {
        // Antes de eliminar la columna, deshacer los otros cambios
        Schema::table('user_variants', function (Blueprint $table) {
            $table->unsignedBigInteger('variant_id')->change();
            $table->foreign('variant_id')
                ->references('id')
                ->on('variants')
                ->onDelete('cascade');
        });

        Schema::table('variants', function (Blueprint $table) {
            $table->dropColumn('adaptation_id');
        });
    }
};
