<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
        });

        if (Schema::hasColumn('programs', 'title')) {
            DB::table('programs')->orderBy('id')->get()->each(function ($row) {
                $name = trim($row->title ?? '');
                $name = $name === '' ? null : $name;
                DB::table('programs')->where('id', $row->id)->update([
                    'name' => $name,
                ]);
            });

            Schema::table('programs', function (Blueprint $table) {
                $table->dropColumn('title');
            });
        }
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
        });

        if (Schema::hasColumn('programs', 'name')) {
            DB::table('programs')->orderBy('id')->get()->each(function ($row) {
                $title = trim($row->name ?? '');
                $title = $title === '' ? null : $title;
                DB::table('programs')->where('id', $row->id)->update([
                    'title' => $title,
                ]);
            });

            Schema::table('programs', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }
    }
};
