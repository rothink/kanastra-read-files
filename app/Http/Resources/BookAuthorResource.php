<?php

namespace App\Http\Resources;

use App\Models\Author;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class BookAuthorResource extends JsonResource
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
            'book_id' => $this->book_id,
            'author_id' => $this->author_id,
            'book' => Book::find($this->book_id),
            'author' => new AuthorResource(Author::find($this->author_id))
        ];
    }
}
