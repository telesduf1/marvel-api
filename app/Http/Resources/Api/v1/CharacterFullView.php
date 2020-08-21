<?php

namespace App\Http\Resources\Api\v1;

use App\Character as CharacterModel;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CharacterFullView extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'code' => "",
            'status' => "",
            'copyright' => env("COPYRIGHT", ""),
            'attributionText' => env("ATTRIBUTION_TEXT", ""),
            'attributionHTML' => env("ATTRIBUTION_HTML", ""),
            'etag' => "",
            'data' => [
                'offset' => $request->offset ?: 0,
                'limit' => $request->limit ?: 20,
                'total' => $this->collection->count(),
                'count' => $this->collection->count(),
                'results' => $this->collection->transform(function ($data) {
                    return [
                        'id' => $data->id,
                        'name' => $data->name,
                        'description' => $data->description,
                        'modified' => $data->modified,
                        'thumbnail' => array(
                            "path" => $data->thumbnail,
                            "extension" => "jpg"
                        ),
                        'resourceURI' => url("/api/v1/public/characters/{$data->id}"),
                        'comics' => new ComicSummaryView(CharacterModel::relatedComics($data->stories)->get()),
                        'series' => new SeriesSummaryView(CharacterModel::relatedSeries($data->stories)->get()),
                        'stories' => new StorySummaryView($data->stories),
                        'events' => new EventSummaryView(CharacterModel::relatedEvents($data->stories)->get())
                    ];
                }),
            ]
        ];
    }

    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);
        $jsonResponse['code'] = $response->status();

        unset($jsonResponse['links'],$jsonResponse['meta']);

        $response->setContent(json_encode($jsonResponse));
    }

}
