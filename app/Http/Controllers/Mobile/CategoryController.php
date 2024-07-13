<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

/**
 * @tags 😸 Mobile > 3 > Category
 */
class CategoryController extends Controller
{

    /**
     * List Categories
     *
     * Bu servis sistemdeki kategorileri listeler tüm kategorileri döner.
     *
     */
    public function categories()
    {
        return CategoryResource::collection(Category::orderBy('sort', 'asc')
            ->get());
    }
}
