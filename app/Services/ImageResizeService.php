<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use Exception;

class ImageResizeService
{
    public function imageResize($img, $request)
    {
        try {
            $img = $request->imgpath->store('image', 'public');
            // 画像リサイズ処理
            // 画像を読み込む
            $image = Image::make('storage/' . $img);
            // リサイズする
            $image->resize(
                600,
                null,
                function ($constraint) {
                        // 縦横比を保持したままにする
                        $constraint->aspectRatio();
                        // 小さい画像は大きくしない
                        $constraint->upsize();
                    }
            );
            $image->save(storage_path('app/public/' . $img));
            return $img;
        } catch (Exception $e) {
            report($e);
            echo "エラーが発生しました。";
            return;
        }
    }
}
