<?php

namespace App\Http\Resources\Api\v1;

use App\Series;
use App\Comic as ComicModel;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ComicFullView extends ResourceCollection
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
                        'digitalId' => $data->digital_id,
                        'title' => $data->title,
                        'issueNumber' => $data->issue_number,
                        'variantDescription' => $data->variant_description,
                        'description' => $data->description,
                        'modified' => $data->modified,
                        'isbn' => $data->isbn,
                        'upc' => $data->isbn,
                        'diamondCode' => $data->diamond_code,
                        'ean' => $data->ean,
                        'issn' => $data->issn,
                        'format' => $data->format,
                        'pageCount' => $data->page_count,
                        'textObjects' => $data->textObjects,
                        'resourceURI' => url("/api/v1/public/comics/{$data->id}"),
                        'series' => new SeriesSummaryView(Series::where('id', $data->series_id)->get()),
                        'variants' => [],
                        'collections' => [],
                        'collectedIssues' => [],
                        'dates' => $data->dates,
                        'prices' => $data->prices,
                        'thumbnail' => array(
                            "path" => $data->thumbnail,
                            "extension" => "jpg"
                        ),
                        'images' => [],
                        'creators' => new CreatorSummaryView(ComicModel::relatedCreators($data->stories)->get()),
                        'characters' => new CharacterSummaryView(ComicModel::relatedCharacters($data->stories)->get()),
                        'stories' => new StorySummaryView($data->stories),
                        'events' => new EventSummaryView($data->events)
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
