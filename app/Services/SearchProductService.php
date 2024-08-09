<?php

namespace App\Services;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class SearchProductService

{
    public $filters = [];
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }
    public  function getFilterDepartments()
    {
        $newFilters = $this->filters;

        $newFilters['departments'] = [];
        $departments = Department::select('id', 'name', 'slug')
            ->active()
            ->withCount(['products' => function ($query) use ($newFilters) {
                $query->withFilters($newFilters);
            }])
            ->whereHas('products', function ($query) use ($newFilters) {
                $query->withFilters($newFilters);
            })
            ->get();

        $departments = $this->assignSelected($departments, $this->filters['departments']);

        return $departments;
    }

    public function getFilterCategories()
    {
        $newFilters = $this->filters;

        $newFilters['categories'] = [];

        $categories = Category::select('id', 'name', 'slug')->where('type', 'product')
            ->active()
            ->withCount(['products' => function ($query) use ($newFilters) {
                $query->withFilters($newFilters);
            }])
            ->whereHas('products', function ($query) use ($newFilters) {
                $query->withFilters($newFilters);
            })
            ->get();

        $categories = $this->assignSelected($categories, $this->filters['categories']);
        return $categories;
    }

    public function getFilterAttributes()
    {
        $newFilters = $this->filters;

        //$newFilters['attributes'] = [];

        $attributes = Attribute::select('name', 'slug')->groupBy('name', 'slug')
            ->whereHas('product', function ($query) use ($newFilters) {
                $query->withFilters($newFilters);
            })->get();

        foreach ($attributes as $attribute) {
            $attribute_values = AttributeValue::select('name', 'slug', DB::raw('count(*) as products_count'))
                ->whereHas('attribute', function ($query) use ($attribute) {
                    $query->where('slug', $attribute->slug);
                })
                ->whereHas('product', function ($query) use ($newFilters) {
                    $query->withFilters($newFilters);
                })
                ->groupBy('name', 'slug')->orderBy('products_count', 'desc')->limit(10)->get();


            if (empty($this->filters['attributes'][$attribute->slug])) {
                $attributesSelected = [];
            } else {
                $attributesSelected = $this->filters['attributes'][$attribute->slug];
            }

            $attribute_values = $this->assignSelected($attribute_values, $attributesSelected);

            $attribute->setRelation('attribute_values', $attribute_values);
        }

        return $attributes;
    }
    public function getFilterBrands()
    {
        $newFilters = $this->filters;
        $newFilters['brands'] = [];

        $brands = Brand::where('active', 1)
            ->select('id', 'name', 'slug')
            ->withCount(['products' => function ($query) use ($newFilters) {
                $query->withFilters($newFilters);
            }])
            ->whereHas('products', function ($query) use ($newFilters) {
                $query->withFilters($newFilters);
            })
            ->orderBy('name')
            ->get();

        $brands = $this->assignSelected($brands, $this->filters['brands']);
        return $brands;
    }

    public function assignSelected($collection, $itemsSelected = [])
    {
        $collection = $collection->map(function ($item) use ($itemsSelected) {
            $item->selected = in_array($item->slug, $itemsSelected);
            return $item;
        });

        return $collection;
    }

    public static function generateBreadcrumb($filters)
    {

        $breadcrumb = [];

        $categories_slug = [...$filters['department'], ...$filters['category']];

        $categories = Category::select('id', 'name', 'slug')->active()->whereIn('slug', $categories_slug)->get();

        $data = [
            'department' => $categories->whereIn('slug', $filters['department']),
            'category' => $categories->whereIn('slug', $filters['category']),
            'brands' => Brand::select('id', 'name', 'slug')->active()->whereIn('slug', $filters['brands'])->get(),
        ];

        foreach ($data as $key => $items) {
            foreach ($items as $key => $item) {
                $breadcrumb[] = [
                    'title' => $item->name,
                    'path' => route('search', [$key => $item->slug]),
                ];
            }
        }

        return $breadcrumb;
    }
}
