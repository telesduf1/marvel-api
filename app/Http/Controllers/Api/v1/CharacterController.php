<?php

namespace App\Http\Controllers\Api\v1;

use App\Character;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\CharacterFullView;
use App\Http\Resources\Api\v1\ComicFullView;
use App\Http\Resources\Api\v1\EventFullView;
use App\Http\Resources\Api\v1\SeriesFullView;
use App\Http\Resources\Api\v1\StoryFullView;
use App\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $validation = $this->validateRequest($request);

        if(!$validation["passed"]){

            return response()->json(['code' => $validation['code'], 'status' => $validation['message']], $validation['code']);

        }

        $limit = $request->limit ?: 20;
        $offset = $request->offset ?: 0;

        $characters = new CharacterFullView(Character::offset($offset)->limit($limit)->get());

        return $characters->response();

    }

    /**
     * Display a listing of the specified resource.
     *
     * @param $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        $validation = $this->validateRequest($request);

        if(!$validation["passed"]){

            return response()->json(['code' => $validation['code'], 'status' => $validation['message']], $validation['code']);

        }

        $limit = $request->limit ?: 20;
        $offset = $request->offset ?: 0;

        $characters = new CharacterFullView(Character::where('id', $id)->offset($offset)->limit($limit)->get());

        return $characters->response();

    }

    /**
     * Display a listing of the specified resource comics.
     *
     * @param  Character  $character
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showComics(Character $character, Request $request)
    {

        $validation = $this->validateRequest($request);

        if(!$validation["passed"]){

            return response()->json(['code' => $validation['code'], 'status' => $validation['message']], $validation['code']);

        }

        $limit = $request->limit ?: 20;
        $offset = $request->offset ?: 0;

        $comics = new ComicFullView(Character::relatedComics($character->stories)->offset($offset)->limit($limit)->get());

        return $comics->response();

    }

    /**
     * Display a listing of the specified resource events.
     *
     * @param  Character  $character
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showEvents(Character $character, Request $request)
    {

        $validation = $this->validateRequest($request);

        if(!$validation["passed"]){

            return response()->json(['code' => $validation['code'], 'status' => $validation['message']], $validation['code']);

        }

        $limit = $request->limit ?: 20;
        $offset = $request->offset ?: 0;

        $events = new EventFullView(Character::relatedEvents($character->stories)->offset($offset)->limit($limit)->get());

        return $events->response();
     
    }

    /**
     * Display a listing of the specified resource series.
     *
     * @param  Character  $character
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showSeries(Character $character, Request $request)
    {

        $validation = $this->validateRequest($request);

        if(!$validation["passed"]){

            return response()->json(['code' => $validation['code'], 'status' => $validation['message']], $validation['code']);

        }

        $limit = $request->limit ?: 20;
        $offset = $request->offset ?: 0;

        $series = new SeriesFullView(Character::relatedSeries($character->stories)->offset($offset)->limit($limit)->get());

        return $series->response();

    }

    /**
     * Display a listing of the resource stories.
     *
     * @param  Character  $character
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showStories(Character $character, Request $request)
    {

        $validation = $this->validateRequest($request);

        if(!$validation["passed"]){

            return response()->json(['code' => $validation['code'], 'status' => $validation['message']], $validation['code']);

        }

        $limit = $request->limit ?: 20;
        $offset = $request->offset ?: 0;

        $stories = new StoryFullView(Story::whereIn('id', $character->stories->pluck('id'))->offset($offset)->limit($limit)->get());

        return $stories->response();

    }

    /**
     * Validate Request before response.
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    private function validateRequest(Request $request)
    {

        $validation = array(
            "passed" => true,
            "code" => '',
            "message" => '',
        );

        if($request->has('limit')){

            $limit = (int)$request->limit;

            if($limit > 100){

                $validation["passed"] = false;
                $validation["code"] = 409;
                $validation["message"] = "You may not request more than 100 items.";

            }

            if($limit < 1 ){

                $validation["passed"] = false;
                $validation["code"] = 409;
                $validation["message"] = "You must pass an integer limit greater than 0.";

            }
        }

        return $validation;

    }

}
