<?php

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = Category::where('type', 0)->select(['rowid', 'label'])->get();

    $productsQuery = DB::table('llx_product')
        ->join('llx_categorie_product', 'llx_product.rowid', '=', 'llx_categorie_product.fk_product')
        ->join('llx_categorie', 'llx_categorie_product.fk_categorie', '=', 'llx_categorie.rowid')
        ->where('llx_categorie.type', 0)
        ->whereNotNull('llx_categorie_product.fk_categorie')
        ->select(
            'llx_categorie.rowid as category_id',
            'llx_categorie.label as category_label',
            'llx_product.label as product_name',
            'llx_product.stock',
            'llx_product.seuil_stock_alerte as minStock',
            'llx_product.per_device'
        )
        ->orderBy('llx_product.label')
        ->get();

    $productsByCategory = $productsQuery->groupBy('category_id');

    // Remove categories without products
    $categories = $categories->filter(function ($category) use ($productsByCategory) {
        return isset($productsByCategory[$category->rowid]) && $productsByCategory[$category->rowid]->isNotEmpty();
    });

    return view('welcome', compact('categories', 'productsByCategory'));
});

Route::get('sales', [\App\Http\Controllers\MontajController::class, 'index'])->name('sales.index');

Route::post('sales', [\App\Http\Controllers\MontajController::class, 'store'])->name('sales.store');
Route::get('sales/toggleStatus', [\App\Http\Controllers\MontajController::class, 'toggleStatus'])->name('sales.toggleStatus');
