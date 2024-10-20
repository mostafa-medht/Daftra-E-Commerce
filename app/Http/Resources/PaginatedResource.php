<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginatedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total'                 => $this->total(),
            'count'                 => $this->count(),
            'per_page'              => $this->perPage(),
            'current_page'          => $this->currentPage(),
            'total_pages'           => $this->lastPage(),
            "from"                  => $this->firstItem(),
            "to"                    => $this->lastItem(),
            "last_page"             => $this->lastPage(),
            "path"                  => $this->path(),
        ];
    }
}
