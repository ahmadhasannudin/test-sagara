<?php

namespace App\Jobs;

use App\Models\Import;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $totalRows = count(file(storage_path('app/' . $this->filePath))) - 1;
        $failedRowsData = [];
        $isHeader = true;

        if (($fileHandle = fopen(storage_path('app/' . $this->filePath), 'r')) === false) {
            return;
        }
        $import = Import::find($this->id);
        $import->total_rows = $totalRows;

        while (($chunk = $this->getChunk($fileHandle)) !== FALSE) {
            if ($isHeader) {
                $isHeader = false;
                $failedRowsData[] = array_shift($chunk);

                $import->link_to_failed_rows_file = $this->arrayToCsv($failedRowsData);
                $import->time_elapsed = $startTime->diffInMilliseconds(Carbon::now());
                $import->save();
            }
            InsertChunk::dispatch($chunk, $this->id);
        }
        fclose($fileHandle);

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
        $filename = 'imports/' . $this->id . date('His') . '.csv';
        $output = fopen(storage_path('app/' . $filename), 'a+');
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        return $filename;
    }
}
