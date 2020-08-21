<?php

namespace App\Http\Resources\Api\v1;

use App\Comic;
use App\Story as StoryModel;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StoryFullView extends ResourceCollection
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
                        'startYear' => $data->start_year,
                        'endYear' => $data->end_year,
                        'rating' => $data->rating,
                        'type' => $data->type,
                        'modified' => $data->modified,
                        'thumbnail' => array(
                            "path" => $data->thumbnail,
                            "extension" => "jpg"
                        ),
                        'creators' => new CreatorSummaryView($data->creators),
                        'characters' => new CharacterSummaryView($data->characters),
                        'series' => SeriesSummaryView::collection([]),
                        'comics' => new ComicSummaryView(Comic::where('id', $data->comic_id)->get()),
                        'events' => EventSummaryView::collection([]),
                        'originalIssue' => array(
                            "resourceURI" => url("/comics/" . Comic::find($data->originalissue)->id),
                            "name" => Comic::find($data->originalissue)->title
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
