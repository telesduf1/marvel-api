<?php

namespace App\Http\Resources\Api\v1;

use App\Series as SeriesModel;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SeriesFullView extends ResourceCollection
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
                        'title' => $data->title,
                        'description' => $data->description,
                        'resourceURI' => url("/api/v1/public/events/{$data->id}"),
                        "urls" => [],
                        'startYear' => $data->start_year,
                        'endYear' => $data->end_year,
                        'rating' => $data->rating,
                        'type' => $data->type,
                        'modified' => $data->modified,
                        'thumbnail' => array(
                            "path" => $data->thumbnail,
                            "extension" => "jpg"
                        ),
                        'creators' => new CreatorSummaryView(SeriesModel::relatedCreators($data->comics)->get()),
                        'characters' => new CharacterSummaryView(SeriesModel::relatedCharacters($data->comics)->get()),
                        'stories' => new StorySummaryView(SeriesModel::relatedStories($data->comics)->get()),
                        'comics' => new ComicSummaryView($data->comics),
                        'events' => new EventSummaryView(SeriesModel::relatedEvents($data->comics)->get()),
                        'next' => array(
                            "resourceURI" => url("series/{$data->next()->id}"),
                            "name" => $data->next()->title
                        ),
                        'previous' => array(
                            "resourceURI" => url("series/{$data->previous()->id}"),
                            "name" => $data->previous()->title
                        )
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
