<?php

namespace App\Jobs;

use App\Models\Import;
use App\Models\ImportData;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InsertChunk implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $chunk;
    public $id;

    /**
     * Create a new job instance.
     */
    public function __construct($chunk, $id)
    {
        $this->chunk = $chunk;
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $startTime = Carbon::now();
        $failedRows = 0;
        $successfulRows = 0;
        $failedRows = 0;
        $errorMessages = [];
        $failedRowsData = [];


        foreach ($this->chunk as $row) {
            try {
                ImportData::create([
                    'pc' => empty($row[0]) ? null : $row[0],
                    'trx_id' => empty($row[1]) ? null : $row[1],
                    'trx_date' => date('Y-m-d H:i:s', strtotime($row[2])),
                    'produk_name' => empty($row[3]) ? null : $row[3],
                    'product_code' => empty($row[28]) ? null : $row[28],
                    'qty' => empty($row[4]) ? null : $row[4],
                    'no_tujuan' => empty($row[5]) ? null : $row[5],
                    'reseller_code' => empty($row[6]) ? null : $row[6],
                    'reseller_name' => empty($row[7]) ? null : $row[7],
                    'modul' => empty($row[8]) ? null : $row[8],
                    'status' => empty($row[9]) ? null : $row[9],
                    'status_date' => date('Y-m-d H:i:s', strtotime($row[10])),
                    'supplier_name' => empty($row[11]) ? null : $row[11],
                    'supplier_stock' => empty($row[12]) ? null : $row[12],
                    'buy_price' => empty($row[13]) ? null : $row[13],
                    'sell_price' => empty($row[14]) ? null : $row[14],
                    'commission' => empty($row[15]) ? null : $row[15],
                    'profit' => empty($row[16]) ? null : $row[16],
                    'poin' => empty($row[17]) ? null : $row[17],
                    'reply_provide' => empty($row[18]) ? null : $row[18],
                    'serial_number' => empty($row[19]) ? null : $row[19],
                    'ref_id' => empty($row[20]) ? null : $row[20],
                    'rate_tp' => empty($row[21]) ? null : $row[21],
                    'rate' => empty($row[22]) ? null : $row[22],
                    'shell' => empty($row[23]) ? null : $row[23],
                    'hbfix' => empty($row[24]) ? null : $row[24],
                    'notes' => empty($row[25]) ? null : $row[25],
                    'provider_code' => empty($row[26]) ? null : $row[26],
                    'provider_name' => empty($row[27]) ? null : $row[27],
                ]);
                $successfulRows++;
            } catch (\Exception $e) {
                $errorMessages[] = [
                    'trx_id' => $row[1],
                    'detail' => $e->getMessage()
                ];
                $failedRows++;
                $failedRowsData[] = $row;
                Log::error('Error importing row : ' . $e->getMessage());
            }
            //update progress
            // if (($successfulRows + $failedRows) % 50 == 0) {
            //     $import->success_rows = $successfulRows;
            //     $import->failed_rows = $failedRows;
            //     $import->save();

            //     $successfulRows = 0;
            //     $failedRows = 0;
            // }
        }
        $import = Import::find($this->id);
        $this->arrayToCsv($import->link_to_failed_rows_file, $failedRowsData);
        $import->success_rows += $successfulRows;
        $import->failed_rows += $failedRows;
        $import->errors = json_encode(array_merge(json_decode($import->errors) ?? [], $errorMessages));

        if ($import->success_rows + $import->failed_rows == $import->total_rows) {
            $import->status = 'Completed';
            Storage::delete($import->file);
            if (empty(json_decode($import->errors))) {
                Storage::delete($import->link_to_failed_rows_file);
                $import->link_to_failed_rows_file = '';
                $import->errors = null;
            }
        }
        $import->time_elapsed += $startTime->diffInMilliseconds(Carbon::now());
        $import->save();

        // Trigger notification or broadcast event
        // Example: event(new ImportCompleted($import));
    }
    protected function arrayToCsv($path, $data)
    {
        $output = fopen(storage_path('app/' . $path), 'a+');
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        return $output;
    }
}
