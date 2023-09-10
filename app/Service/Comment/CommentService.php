<?php

namespace App\Service\Comment;

use App\Models\Comment;
use App\Models\Movie;

class CommentService implements CommentServiceInterface
{
    protected $commentModel;


    public function __construct(Comment $commentModel)
    {
        $this->commentModel = $commentModel;
    }


    public function create($data)
    {
        return $this->commentModel->create($data);
    }


    public function show($id){
        $data = Comment::where('id' , $id)->firstorFail();
        return $data;
    }


    public function update($id,$data)
    {
        $result = Comment::where('id' , $id)->firstOrfail();
        return $result->update($data);
    }

    
    public function delete($id)
    {
        $data = Comment::where('id' , $id)->firstOrFail();
        return $data->delete();
    }
}
