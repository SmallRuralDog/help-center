<?php

namespace SmallRuralDog\HelpCenter\Http\Controllers;

use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Illuminate\Routing\Controller;
use SmallRuralDog\HelpCenter\Models\HelpDoc;
use SmallRuralDog\HelpCenter\Models\HelpWorkOrder;

class HelpCenterController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('帮助')
            ->description('中心')
            ->row(function (Row $row) {
                $row->column(8, $this->work_orders());
                $row->column(4, $this->docs());
            });
    }

    public function work_orders()
    {
        $grid = new Grid(new HelpWorkOrder());
        $grid->with(['replays','user']);
        $grid->model()->where('p_id', 0)->orderBy('id','desc');
        $grid->user()->name('用户');
        $grid->column('content', '内容')->limit(50);
        $grid->column('updated_at', '更新时间');
        $grid->images('图片')->light_box(['width' => 50, 'height' => 50]);
        $grid->actions(function (Grid\Displayers\Actions $actions) use ($grid) {
            $actions->disableView();
            $actions->disableEdit();
            $actions->disableDelete();
            $row = $actions->row;
            if ($row->is_close == 1) {
                $grid->column('is_close')->using([0 => '正常', 1 => '关闭'])->badge();
            } else {

                $actions->append('<a href="' . route('help-reply.edit', ['id' => $row->id]) . '" class="btn btn-xs">回复</a>');
            }
        });

        $grid->replay_info('回复状态')->display(function () {
            $last_replay = collect($this->replays)->first();
            if (empty($last_replay) || $last_replay->role == 'user') {
                return '<span class="badge bg-red">待回复</span>';
            } else {
                return '<span class="badge bg-aqua">已回复</span>';
            }
        });

        $grid->disableRowSelector();
        $grid->disableExport();
        $grid->disableFilter();
        return $grid;
    }

    public function reply($id, Content $content)
    {
        return $content
            ->header('工单')
            ->description('回复')
            ->body($this->form()->edit($id));
    }

    public function work_order_edit()
    {
        $form = new Form(new HelpDoc());
        $form->text('title', '标题');
        $form->editor('content', '内容');
        $form->number('order', '排序')->default(0);

        return $form;
    }

    public function docs()
    {
        $grid = new Grid(new HelpDoc());

        $grid->model()->orderBy('order', 'desc');
        $grid->column('id');
        $grid->column('title', '标题');
        $grid->column('order', '排序')->editable();
        $grid->disableRowSelector();
        $grid->disablePagination();
        $grid->disableExport();
        $grid->disableFilter();
        return $grid;
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑')
            ->description('帮助文档')
            ->body($this->form()->edit($id));
    }

    public function create(Content $content)
    {
        return $content
            ->header('添加')
            ->description('帮助文档')
            ->body($this->form());
    }

    protected function form()
    {
        $form = new Form(new HelpDoc());

        $form->text('title', '标题');
        $form->editor('content', '内容');
        $form->number('order', '排序')->default(0);

        return $form;
    }
}