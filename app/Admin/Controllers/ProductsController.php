<?php

namespace App\Admin\Controllers;

use App\Models\Shop;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品';


//    public function index()
//    {
//        return 1;
//    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
     protected function grid()
     {
         $grid = new Grid(new Product());
         $shop_id = Shop::select('id')->where('admin_user_id',Auth::guard('admin')->user()->id)->get()->toArray();
         $grid->model()->whereIn('shop_id',$shop_id);
         $grid->id('ID')->sortable();
         $grid->product_core('商品编码');
         $grid->title('商品名称');
         $grid->bar_code('国条码');
         $grid->category_id('商品分类')->display(function ($category_id){
           return Category::where('id',$category_id)->first()->name;
         });
         $grid->status('已上架')->display(function ($status){
           return $status ? '是' : '否';
         });
         $grid->audit_status('审核状态')->display(function ($audit_status){
           return $audit_status ? '审核通过' : '审核未通过';
         });
         $grid->shop_id('所属店铺')->display(function ($shop_id){
           return Shop::where('id',$shop_id)->first()->name;
         });
         $grid->price('价格');
         $grid->rating('评分');
         $grid->sold_count('销量');
         $grid->review_count('评论数');
         $grid->actions(function ($actions) {
             $actions->disableView();
             $actions->disableDelete();
         });
         $grid->tools(function ($tools) {
             // 禁用批量删除按钮
             $tools->batch(function ($batch) {
                 $batch->disableDelete();
             });
         });

         return $grid;
     }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('product_core', __('Product core'));
        $show->field('title', __('Title'));
        $show->field('bar_code', __('Bar code'));
        $show->field('category_id', __('Category id'));
        $show->field('status', __('Status'));
        $show->field('audit_status', __('Audit status'));
        $show->field('shop_id', __('Shop id'));
        $show->field('description_id', __('Description id'));
        $show->field('rating', __('Rating'));
        $show->field('sold_count', __('Sold count'));
        $show->field('review_count', __('Review count'));
        $show->field('price', __('Price'));
        $show->field('image', __('Image'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
      $form = new Form(new Product);

      // 创建一个输入框，第一个参数 title 是模型的字段名，第二个参数是该字段描述
      $form->text('title', '商品名称')->rules('required');

      $form->text('bar_code','国条码')->rules('required');
      // 创建一个选择图片的框
      $form->image('image', '封面图片')->rules('required|image');

      $form->select('category_id','商品分类')->options(function ($id){
        $category = Category::find($id);
        if ($category) {
          return [$category->id => $category->full_name];
        }
      })->ajax('/admin/api/categories?is_directory=0');


      // 创建一组单选框
      $form->radio('status', '上架')->options(['1' => '是', '0'=> '否'])->default('0');

      $form->select('shop_id','所属店铺')->options(function (){
        $shop = Shop::select('id','name')->where('admin_user_id',Auth::guard('admin')->user()->id)->get();
        $array= [];
        if ($shop) {
          foreach ($shop as $key => $values) {
            $array[$values->id] = $values->name;
          }
        }
        return $array;
      })->rules('required');

      //创建一个富文本编辑器
      $form->editor('productdescriptions.description','商品描述')->rules('required');

      // 直接添加一对多的关联模型
      $form->hasMany('skus', 'SKU 列表', function (Form\NestedForm $form) {
          $form->text('title', 'SKU 名称')->rules('required');
          $form->text('description', 'SKU 描述')->rules('required');
          $form->text('price', '单价')->rules('required|numeric|min:0.01');
          $form->text('stock', '剩余库存')->rules('required|integer|min:0');
      });
      // 定义事件回调，当模型即将保存时会触发这个回调
      $form->saving(function (Form $form) {
          $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price') ?: 0;

          $form->model()->product_core = strtotime(date('Y-m-d H:i:s',time()));
      });
      return $form;
    }
}
