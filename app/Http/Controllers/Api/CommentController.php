<?php

namespace App\Http\Controllers\Api;

use App\Common\ApiResponser;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Service\Comment\CommentServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;




class CommentController extends Controller
{
    use ApiResponser;
    private $commentServiceInterface;

    public function __construct(CommentServiceInterface $commentServiceInterface)
    {
        $this->commentServiceInterface = $commentServiceInterface;
    }

    /**
     * comment create
     */
    public function create(Request $request)
    {
        $validate = $request->all();
        $validator = Validator::make($validate, [
            'email' => 'required',
            'movie_id' => 'required|exists:movies,id',
            'comment' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'ststus' => false,
                'message' => 'validation error',
                'error' => $validator->errors()
            ], 422);
        }

        $commentData = [
            'user_id' => auth()->id(),
            'movie_id' => $request->movie_id,
            'comment' => $request->comment,
            'email' => $request->email,
        ];

        $comment = $this->commentServiceInterface->create($commentData);

        return $this->created($comment, 'Comment created successfully');
    }

    /**
     * comment update
     */

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'ststus' => false,
                'message' => 'validation error',
                'error' => $validator->errors()
            ], 422);
        }

        $comment = Comment::where('id', $id)->first();
        // Check if the comment exists
        if (!$comment) {
            return response()->json([
                'ststus' => false,
                'message' => 'comment not found'
            ],404);
        }

        // Update the comment's content
        $comment->comment = $request->comment;
        $comment->save();
        return $this->updated(200, $comment, 'Comment update successfully');
    }

    /**
     * comment delete
     */

    public function delete($id)
    {
        $data = $this->commentServiceInterface->show($id);
        if (is_null($data)) {
            return $this->notFound(404, null, 'Comment not found , cant delete');
        }
        $this->commentServiceInterface->delete($id);
        return $this->deleted('Comment deleted successfully');
    }
}
