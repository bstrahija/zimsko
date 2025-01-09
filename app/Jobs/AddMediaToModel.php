<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Uri;

class AddMediaToModel implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Model $model,
        public string $file,
        public string $collection
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $uri  = Uri::of($this->file);
        $path = str_replace('/zimsko', '/zimsko.wp', base_path()) . '/public/' . $uri->path();

        if (file_exists($path)) {
            Log::debug('Adding media [' . $this->file . '] to model collection: ' . $this->collection);
            try {
                $this->model->addMediaFromUrl($this->file)->toMediaCollection($this->collection);
            } catch (\Exception $e) {
                Log::error('Error when adding: ' . $this->file);
            }
        } else {
            Log::error('File does not exist: ' . $this->file);
        }
    }
}
