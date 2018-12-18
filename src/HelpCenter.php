<?php

namespace SmallRuralDog\HelpCenter;

use App\User;
use Encore\Admin\Extension;
use SmallRuralDog\HelpCenter\Models\HelpDoc;
use SmallRuralDog\HelpCenter\Models\HelpWorkOrder;

class HelpCenter extends Extension
{
    public $name = 'help-center';

    public $views = __DIR__ . '/../resources/views';

    public $assets = __DIR__ . '/../resources/assets';
    public $migrations = __DIR__ . '/../database/migrations';

    public $menu = [
        'title' => '帮助中心',
        'path' => 'help-center',
        'icon' => 'fa-gears',
    ];


    /**
     * 获取帮助文档
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getDocs()
    {
        return HelpDoc::query()->orderByDesc('order')->get();
    }

    public static function getWorkOrders($user)
    {
        return HelpWorkOrder::query()->where('user_id', $user->id)
            ->with(['replays'])
            ->where('p_id', 0)
            ->orderBy('is_close')->orderBy('updated_at', 'desc')
            ->get();
    }

    public static function getWorkOrderInfo($user, $id)
    {
        return HelpWorkOrder::query()->where('user_id', $user->id)
            ->with(['replays'])
            ->where('p_id', 0)
            ->where('id', $id)
            ->firstOrFail();
    }

    /**
     * 添加工单
     * @param string $content
     * @param array $images
     * @param User $user
     * @param int $p_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public static function addWorkOrder($content, $images, $user, $p_id = 0)
    {

        return HelpWorkOrder::query()->create([
            'p_id' => $p_id,
            'user_id' => $user->id,
            'content' => $content,
            'images' => $images,
            'is_close' => 0
        ]);
    }
}