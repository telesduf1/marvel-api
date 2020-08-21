<?php

namespace App\Http\Resources\Api\v1;

use App\Event as EventModel;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EventFullView extends ResourceCollection
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
                        'modified' => $data->modified,
                        'start' => $data->start,
                        'end' => $data->end,
                        'thumbnail' => array(
                            "path" => $data->thumbnail,
                            "extension" => "jpg"
                        ),
                        'creators' => new CreatorSummaryView(EventModel::relatedCreators($data->comics)->get()),
                        'characters' => new CharacterSummaryView(EventModel::relatedCharacters($data->comics)->get()),
                        'stories' => new StorySummaryView(EventModel::relatedStories($data->comics)->get()),
                        'comics' => new ComicSummaryView($data->comics),
                        'series' => new SeriesSummaryView(EventModel::relatedSeries($data->comics)->get()),
                        'next' => array(
                            "resourceURI" => url("series/{$data->next()->id}"),
                            "name" => $data->next()->title
                        ),
                        'previous' => array(
                            "resourceURI" => url("series/{$data->previous()->id}"),
                            "name" => $data->previous()->title
                        ),
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
