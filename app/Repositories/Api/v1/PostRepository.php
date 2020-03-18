<?php
namespace App\Repositories\Api\v1;

use App\Repositories\Api\v1\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostRepository implements PostRepositoryInterface
{
	public function start()
	{
    }

    public function attemptCreate(Request $request) : array
    {
        $UserID = Auth::id();

        echo $UserID;


        return [
            'state' => true
        ];
    }

    public function attemptUpdate(Request $request)
    {

    }

}
