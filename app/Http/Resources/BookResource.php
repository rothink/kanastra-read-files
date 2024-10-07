<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'editora' => $this->editora,
            'anoPublicacao' => $this->anoPublicacao,
            'edicao' => $this->edicao,
            'valor' => $this->valor,
            'valor_formatted' => Number::currency($this->valor, 'BRL'),
            'created_at' => Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans(),
            'authors' => BookAuthorResource::collection($this->authors),
            'subjects' => BookSubjectResource::collection($this->subjects)
        ];
    }
}
