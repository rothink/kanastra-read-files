<?php

namespace App\Http\Resources;

use App\Models\Book;
use App\Models\Remessa;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookSubjectResource extends JsonResource
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
            'subject_id' => $this->subject_id,
            'book' => Book::find($this->book_id),
            'subject' => new SubjectResource(Remessa::find($this->subject_id))
        ];
    }
}
