<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 定义下拉框搜索接口
  public function apiIndex(Request $request)
  {
    $search = $request->input('q');
    $result = Category::query()
        // 通过 is_directory 参数来控制
        ->where('is_directory', boolval($request->input('is_directory', true)))
        ->where('name', 'like', '%'.$search.'%')
        ->paginate();
      // 把查询出来的结果重新组装成 Laravel-Admin 需要的格式
      $result->setCollection($result->getCollection()->map(function (Category $category) {
          return ['id' => $category->id, 'text' => $category->full_name];
      }));

      return $result;
  }
}
