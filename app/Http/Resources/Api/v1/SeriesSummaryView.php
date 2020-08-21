<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SeriesSummaryView extends ResourceCollection
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

            'available' => $this->collection->count(),
            'collectionURI' => '',
            'items' => $this->collection->take(20)->map(
                function ( $series ) {
                    return [
                        'resourceURI' => url("/api/v1/public/series/{$series->id}"),
                        'name' => $series->title
                    ];
                }
            ),
            'returned' => $this->collection->take(20)->count()

        ];

    }
}
