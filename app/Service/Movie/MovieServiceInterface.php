<?php 

namespace App\Service\Movie;

interface MovieServiceInterface
{
    public function create($data);
    public function update($data,$id);
    public function delete($id);
}