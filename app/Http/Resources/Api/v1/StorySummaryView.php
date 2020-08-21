<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StorySummaryView extends ResourceCollection
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
                function ( $story ) {
                    return [
                        'resourceURI' => url("/api/v1/public/stories/{$story->id}"),
                        'name' => $story->title,
                        'type' => $story->type
                    ];
                }
            ),
            'returned' => $this->collection->take(20)->count()

        ];

    }
}
