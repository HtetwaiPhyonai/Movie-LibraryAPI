<?php

namespace App\Http\Controllers\Api;

use App\Common\ApiResponser;
use App\Http\Controllers\Controller;

use App\Models\Movie;
use App\Repository\Movie\MovieRepoInterface;
use App\Service\Movie\MovieServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    use ApiResponser;
    private $movieServiceInterface, $movieRepoInterface, $commentServiceInterface;

    public function __construct(MovieServiceInterface $movieServiceInterface, MovieRepoInterface $movieRepoInterface,)
    {
        $this->movieServiceInterface = $movieServiceInterface;
        $this->movieRepoInterface = $movieRepoInterface;
    }

    /**
     * Movie Lists
     */
    public function list()
    {
        $data = $this->movieRepoInterface->list();
        if (is_null($data)) {
            return $this->notFound(404, null, 'Movie list not found');
        }
        return $this->created(200, $data, 'Movie retrieved successfully');
    }

    /**
     * movie store
     */

    public function store(Request $request)
    {
        try {

            $imgName = Str::random(30) . '.' . $request->cover_image->getClientOriginalExtension();

            //Save image in storage folder
            Storage::disk('public')->put($imgName, file_get_contents($request->cover_image));

            $validator = $request->all();
            $validate = Validator::make(
                $validator,
                [
                    'title' => 'required',
                    'summary' => 'required|string',
                    'cover_image' => 'nullable',
                    'genres' => 'required|string',
                    'author' => 'required|string',
                    'tags' => 'required|string',
                    'imdb_rating' => 'required|between:1,5',
                    'pdf_download_link' => 'nullable',
                ]
            );
            if ($validate->fails()) {
                return response()->json([
                    'ststus' => false,
                    'message' => 'validation error',
                    'error' => $validate->errors()
                ], 422);
            }
            $data = $this->movieServiceInterface->create($validator);

            return $this->created($data, 'Movie created successfully');
        } catch (\Throwable $th) {
            return response()->json([
                'ststus' => false,
                'error' => $th->getMessage()
            ]);
        }
    }

    /**
     * movie show detail
     */

    public function show($id)
    {
        $data = $this->movieRepoInterface->show($id);

        if (is_null($data)) {
            return response()->json([
                'ststus' => false,
                'message' => 'movie not found',
                'data' =>$data
            ], 404);
        }
        return $this->success(200, $data, 'Movie detail list successfully');
    }

    /**
     * movie update
     */

    public function update($id, Request $request)
    {
        $movie = Movie::where('id', $id)->first();

        if (is_null($movie)) {
            return $this->validationError(404, null, 'Movie List not found');
        }

        // Update the movie attributes from the request
        $movie->update($request->except('cover_image'));


        if ($request->hasFile('cover_image')) {
            // Delete the old image if it exists
            if ($movie->cover_image) {
                Storage::disk('public')->delete('movies/' . $movie->cover_image);
            }

            // Store the new image
            $imageName = Str::random(30) . '.' . $request->file('cover_image')->getClientOriginalExtension();
            Storage::disk('public')->put('public' . $imageName, file_get_contents($request->cover_image));
            $movie->cover_image = $imageName;
            $movie->save();
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'summary' => 'required|string',
            'cover_image' => 'nullable',
            'genres' => 'required|string',
            'author' => 'required|string',
            'tags' => 'required|string',
            'imdb_rating' => 'required|between:1,5',
            'pdf_download_link' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'ststus' => false,
                'message' => 'validation error',
                'error' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();
        $data = $this->movieServiceInterface->update($id, $validatedData);
        return $this->updated(200, $data, 'Movie update successfully');
    }

    /**
     * movie delete
     */

    public function delete($id)
    {
        $data = $this->movieRepoInterface->show($id);
        if (is_null($data)) {
            return $this->notFound(404, null, 'Movie not found , cant delete');
        }
        $this->movieServiceInterface->delete($id);

        return $this->deleted('Movie deleted successfully');
    }
}
