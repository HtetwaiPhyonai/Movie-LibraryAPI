<?php

namespace App\Service\Movie;

use App\Models\Movie;

class MovieService implements MovieServiceInterface
{
    
    public function create($data)
    {
        return Movie::create($data);
    }

    public function update($id, $data)
    {
        $result = Movie::where('id', $id)->firstOrFali();
        return $result->update($data);
    }

    public function delete($id)
    {
        $data = Movie::where('id', $id)->firstOrFail();
        return $data->delete();
    }
}
