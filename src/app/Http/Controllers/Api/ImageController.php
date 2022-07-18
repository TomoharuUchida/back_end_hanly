<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\Friend;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ImageStoreRequest;

class ImageController extends Controller
{
    /**
     * @param \App\Http\Requests\Api\ImageStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ImageStoreRequest $request)
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
