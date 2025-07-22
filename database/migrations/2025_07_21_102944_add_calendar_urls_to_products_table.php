<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            
            $table->json('calendar_urls')->nullable();
        });

        DB::table('products')->whereNotNull('airbnb_url')->orWhereNotNull('booking_url')->chunkById(100, function ($products) {
            foreach ($products as $product) {
                $calendarUrls = [];
                
                if ($product->airbnb_url) {
                    $calendarUrls['Airbnb'] = $product->airbnb_url;
                }
                
                if ($product->booking_url) {
                    $calendarUrls['Booking'] = $product->booking_url;
                }
                
                if (!empty($calendarUrls)) {
                    \DB::table('products')
                        ->where('id', $product->id)
                        ->update(['calendar_urls' => json_encode($calendarUrls)]);
                }
            }
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['airbnb_url', 'booking_url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('calendar_urls');
        });
    }
};
