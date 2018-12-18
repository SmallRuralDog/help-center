<?php


namespace SmallRuralDog\HelpCenter\Http\Controllers;


use Carbon\Carbon;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Illuminate\Routing\Controller;
use SmallRuralDog\HelpCenter\Models\HelpWorkOrder;

class HelpReplyController extends Controller
{
    use HasResourceActions;

    public function index(){
        return redirect(route('help-center.index'));
    }

    public function create(Content $content)
    {
        return $content
            ->header('添加')
            ->description('帮助文档')
            ->body($this->form());
    }

    public function edit($id, Content $content){
        return $content
            ->header('回复')
            ->description('工单')
            ->body($this->form()->edit($id));
    }

    protected function form()
    {
        $form = new Form(new HelpWorkOrder());

        $form->textarea('content')->readOnly();
        //$form->multipleImage('images');
        $form->switch('is_close','关闭工单');
        $form->text('user_id')->readOnly();
        $form->hasMany('replays','工单记录',function (Form\NestedForm $form){
            $form->textarea('content','回复内容')->setElementClass('text-2')->rows(2);
            //$form->multipleImage('images');
            $form->datetime('created_at','创建时间')->default(Carbon::now());
            $form->hidden('user_id')->default(Admin::user()->id);
            $form->hidden('role')->default('admin');
        });

        $form->footer(function (Form\Footer $footer){
            $footer->disableViewCheck();
            $footer->disableCreatingCheck();
            $footer->disableEditingCheck();
        });
        $form->tools(function (Form\Tools $tools){
            $tools->disableDelete();
            $tools->disableView();
        });


        return $form;
    }

}