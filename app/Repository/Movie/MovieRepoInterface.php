<?php

namespace App\Repository\Movie;


interface MovieRepoInterface
{
    public function list();
    
    public function show($id);
}