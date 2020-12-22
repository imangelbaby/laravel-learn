<?php

namespace App\Admin\Controllers;

use App\Models\Learn;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;


class LearnController extends AdminController
{

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Learn';


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Learn());

        $grid->column('id', __('Id'));

        $grid->column('name', __('Name'))->display(function($pic){
            return json_decode($pic,true);
        })->image('http:www.baidu.com',100,100);
        $grid->column('age', __('Age'))->sortable()->label('danger');
        $grid->column('test',__('test'))->display(function($s){
            return $s ? '<span color="red">是</span>':'<span color="red">否</span>';
        });
        $grid->column('t1','t2','t3');
        $grid->age('年龄1');

        //$grid->column('age')->using(['12'=>100]);
        //$grid->column('age')->replace([32=>'_']);
        $grid->column('age', '数量')->totalRow('合计');
        //$grid->column('name', a)->gravatar();
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
        $show = new Show(Learn::findOrFail($id));
        $show->field('id', __('Id'));
        $show->field('age', __('Age'));
        $show->field('name', __('Name'));


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        
        $form = new Form(new Learn());
        $form->textarea('name', __('Name'));
        $form->textarea('age', __('Age'));


        return $form;
    }
}
