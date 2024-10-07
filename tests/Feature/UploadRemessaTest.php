<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadRemessaTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     */
    public function testUploadRemessa(): void
    {
        Storage::fake('remessa');
        $response = $this->json('POST', '/api/upload', [
            'input' => UploadedFile::fake()
                ->createWithContent('input.csv', json_encode($this->makeParams()))
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testUploadRemessaIfFileNotExists(): void
    {
        Storage::fake('remessa');
        $this->json('POST', '/api/upload', [
            'input' => UploadedFile::fake()
                ->createWithContent('input59.csv', json_encode($this->makeParams()))
        ]);
        Storage::disk('local')->assertMissing('remessa/input5.csv');
    }

    public function testUploadRemessaIfFileExists(): void
    {
        Storage::fake('remessa');
        $this->json('POST', '/api/upload', [
            'input' => UploadedFile::fake()
                ->createWithContent('input.csv', json_encode($this->makeParams()))
        ]);
        Storage::disk('local')->assertExists('remessa/input.csv');
    }

    public function testUploadRemessaIfContentAreSame(): void
    {
        Storage::fake('remessa');
        $this->json('POST', '/api/upload', [
            'input' => UploadedFile::fake()
                ->createWithContent('input.csv', json_encode($this->makeParams()))
        ]);
        $file = Storage::disk('local')->get('remessa/input.csv');
        $this->assertIsString($file);
        $this->assertEquals($file, json_encode(json_decode($file)));
    }

    public function testUploadRemessaIfHeaderAreSame(): void
    {
        Storage::fake('remessa');
        $this->json('POST', '/api/upload', [
            'input' => UploadedFile::fake()
                ->createWithContent('input.csv', json_encode($this->makeParams()))
        ]);
        $file = Storage::disk('local')->get('remessa/input.csv');
        $arrayFile = (array)json_decode($file);
        $this->assertArrayHasKey('name', $arrayFile);
        $this->assertArrayHasKey('governmentId', $arrayFile);
        $this->assertArrayHasKey('email', $arrayFile);
        $this->assertArrayHasKey('debtAmount', $arrayFile);
        $this->assertArrayHasKey('debtDueDate', $arrayFile);
        $this->assertArrayHasKey('debtID', $arrayFile);
    }

    public function makeParams()
    {
        return [
            'name' => fake()->name,
            'governmentId' => fake()->numerify,
            'email' => fake()->email,
            'debtAmount' => fake()->numerify,
            'debtDueDate' => fake()->numerify,
            'debtID' => fake()->uuid,
        ];
    }
}
