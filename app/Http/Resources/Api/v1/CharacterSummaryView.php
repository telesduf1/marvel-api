<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CharacterSummaryView extends ResourceCollection
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
                function ( $character ) {
                    return [
                        'resourceURI' => url("/api/v1/public/characters/{$character->id}"),
                        'name' => $character->name
                    ];
                }
            ),
            'returned' => $this->collection->take(20)->count()

        ];

    }
}
