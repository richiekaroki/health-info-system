<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // add new columns (nullable at first)
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');
        });

        // populate new columns from existing full_name (if exists)
        if (Schema::hasColumn('clients', 'full_name')) {
            DB::table('clients')->orderBy('id')->get()->each(function ($row) {
                $full = trim($row->full_name ?? '');
                if ($full === '') {
                    $first = null;
                    $last = null;
                } else {
                    $parts = preg_split('/\s+/', $full);
                    $first = array_shift($parts);
                    $last  = count($parts) ? implode(' ', $parts) : null;
                }
                DB::table('clients')->where('id', $row->id)->update([
                    'first_name' => $first,
                    'last_name'  => $last,
                ]);
            });

            // drop old full_name column (safe on most DBs)
            Schema::table('clients', function (Blueprint $table) {
                $table->dropColumn('full_name');
            });
        }
    }

    public function down(): void
    {
        // re-create full_name and populate from first_name/last_name
        Schema::table('clients', function (Blueprint $table) {
            $table->string('full_name')->nullable()->after('id');
        });

        if (Schema::hasColumn('clients', 'first_name')) {
            DB::table('clients')->orderBy('id')->get()->each(function ($row) {
                $full = trim(($row->first_name ?? '') . ' ' . ($row->last_name ?? ''));
                $full = $full === '' ? null : $full;
                DB::table('clients')->where('id', $row->id)->update([
                    'full_name' => $full,
                ]);
            });

            // drop the two columns
            Schema::table('clients', function (Blueprint $table) {
                $table->dropColumn(['first_name', 'last_name']);
            });
        }
    }
};