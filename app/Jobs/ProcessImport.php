<?php

namespace App\Jobs;

use App\Models\Import;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessImport implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $filePath;
    protected $id;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath, $id)
    {
        $this->filePath = $filePath;
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $startTime = Carbon::now();

        $import = Import::find($this->id);

        $totalRows = 0;
        $successfulRows = 0;
        $failedRows = 0;
        $failedRowsData = [];

        if (($handle = fopen(storage_path('app/' . $this->filePath), 'r')) !== FALSE) {
            while (($chunk = $this->getChunk($handle)) !== FALSE) {
                foreach ($chunk as $row) {
                    $totalRows++;
                    try {
                        // Implement your import logic here
                        // Example:
                        // Model::create([...]);

                        $successfulRows++;
                    } catch (\Exception $e) {
                        $failedRows++;
                        $failedRowsData[] = $row;
                        Log::error('Error importing row ' . $totalRows . ': ' . $e->getMessage());
                    }
                }
            }
            fclose($handle);
        }

        $failedRowsFile = null;
        if (count($failedRowsData) > 0) {
            $failedRowsFile = 'failed_imports/' . $this->id . '_failed_rows.csv';
            Storage::put($failedRowsFile, $this->arrayToCsv($failedRowsData));
        }

        $duration = $startTime->diffInSeconds(Carbon::now());

        $import->update([
            'total_rows' => $totalRows,
            'successful_rows' => $successfulRows,
            'failed_rows' => $failedRows,
            'failed_rows_file' => $failedRowsFile,
            'duration' => $duration,
        ]);

        // Trigger notification or broadcast event
        // Example: event(new ImportCompleted($import));
    }

    protected function getChunk($handle)
    {
        $chunk = [];
        for ($i = 0; $i < (int) getenv('IMPORT_CHUNK_SIZE'); $i++) {
            if (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $chunk[] = $row;
            } else {
                break;
            }
        }

        return count($chunk) > 0 ? $chunk : FALSE;
    }

    protected function arrayToCsv($data)
    {
        $output = fopen('php://temp', 'r+');
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $csv;
    }
}
