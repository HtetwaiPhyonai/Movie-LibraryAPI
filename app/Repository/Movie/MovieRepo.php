<?php

namespace App\Repository\Movie;

use App\Models\Movie;

class MovieRepo implements MovieRepoInterface
{
    /**
     * Movie Lists
     *
     */
    public function list()
    {
        $data = Movie::with('comments')->orderBy('id', 'asc')->paginate(7);
        return $data;
    }

    /**
     * Show Movie details
     * 
     * @param $id
     */
    public function show($id)
    {
        $data = Movie::with('comments')->where('id',$id)->firstOrFail();
        return $data;
    }
}