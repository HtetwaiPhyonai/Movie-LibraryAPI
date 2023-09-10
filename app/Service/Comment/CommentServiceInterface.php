<?php 

namespace App\Service\Comment;

interface CommentServiceInterface
{
    public function create($data);
    public function show($data);
    public function update($id,$data);
    public function delete($data);

}