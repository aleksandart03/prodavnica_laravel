<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;


class FetchProductsFromApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Povlači proizvode sa dummyjson API-ja i upisuje ih u bazu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            Log::info("Povezujem se na dummyjson API...");

            $limit = 30;
            $skip = 0;
            $totalFetched = 0;
            $insertData = [];
            $existingExternalIds = Product::pluck('external_id')->toArray();

            while (true) {
                $response = Http::get("https://dummyjson.com/products", [
                    'limit' => $limit,
                    'skip' => $skip,
                ]);

                if (!$response->successful()) {
                    Log::error('API Error: ' . $response->status());
                    Log::error($response->body());
                    break;
                }

                $products = $response->json()['products'];

                if (empty($products)) {
                    break;
                }

                foreach ($products as $item) {
                    if (in_array($item['id'], $existingExternalIds)) {
                        continue;
                    }

                    $category = Category::firstOrCreate(['name' => $item['category']]);

                    $insertData[] = [
                        'name' => $item['title'],
                        'description' => $item['description'],
                        'price' => $item['price'],
                        'category_id' => $category->id,
                        'external_id' => $item['id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                $totalFetched += count($products);
                $skip += $limit;
            }

            if (!empty($insertData)) {
                Product::insert($insertData);
                Log::info("Uvezeno " . count($insertData) . " novih proizvoda.");
            } else {
                Log::info("Nema novih proizvoda za uvoz.");
            }
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
        }
    }
}
