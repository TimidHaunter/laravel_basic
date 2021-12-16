<?php


namespace App\Transformers;


use App\Models\Slide;
use League\Fractal\TransformerAbstract;

class SlideTransformer extends TransformerAbstract
{
    public function transform(Slide $slide)
    {
        // 自定义响应格式
        return [
            'id'         => $slide->id,
            'title'      => $slide->title,
            'url'        => $slide->url,
            'img'        => $slide->img,
            'img_url'    => oss_url($slide->img),
            'status'     => $slide->status,
            'seq'        => $slide->seq,
            'created_at' => $slide->created_at ? $slide->created_at : '时间遥远'
        ];
    }
}
