<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CreatorSummaryView extends ResourceCollection
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
                function ( $creator ) {
                    return [
                        'resourceURI' => url("/api/v1/public/creators/{$creator->id}"),
                        'name' => $creator->first_name . $creator->middle_name . $creator->last_name,
                        'role' => ""
                    ];
                }
            ),
            'returned' => $this->collection->take(20)->count()

        ];

    }
}
