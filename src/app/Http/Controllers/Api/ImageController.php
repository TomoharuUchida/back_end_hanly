<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\Friend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // transactionメソッドを使えば、ロールバックやコミットを自分でコードする必要なし
        $myId = \DB::transaction(function () use ($request) {
            $myId = $request->user()->id;
            $savedPath = $request->file->store('images', 'local');

            Friend::find($myId)
                ->fill([
                    'image_path' => $savedPath,
                ])
                ->save();

            return $myId;
        });

        return response()->json([
            'image_url' => route('web.image.get', ['userId' => $myId])
        ]);
    }
}
