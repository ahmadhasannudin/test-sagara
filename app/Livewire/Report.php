<?php

namespace App\Livewire;

use App;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class Report extends Component {
    public $provinsi_id;
    public function __construct()
    {
        $this->provinsi = Provinsi::orderBy('nama')->get();
    }
    public function render()
    {
        return view('livewire.report', ['provinsi' => $this->provinsi]);
    }

    public function printProvinsi()
    {
        $data = Provinsi::orderBy('nama')
            ->withCount('kabupaten')
            ->withSum('kabupaten', 'populasi')
            ->orderBy('nama')
            ->get();
        // dd($data);

        $pdf = Pdf::loadView('pdf.provinsi', ['data' => $data]);
        $pdf->setPaper('a4', 'protrait');
        $pdf->setOptions(['isPhpEnabled' => true]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Populasi-per-Provinsi-' . date('Y-m-d') . '.pdf');
    }
    public function printKabupaten()
    {
        $this->validate([
            'provinsi_id' => ['required', 'exists:provinsi,id']
        ]);
        $provinsi = Provinsi::find($this->provinsi_id);
        $data = Kabupaten::where('provinsi_id', $this->provinsi_id)
            ->with('provinsi')
            ->orderBy('nama')
            ->get();

        $pdf = Pdf::loadView(
            'pdf.kabupaten',
            ['kabupaten' => $data, 'provinsi' => $provinsi]
        );
        $pdf->setPaper('a4', 'protrait');
        $pdf->setOptions(['isPhpEnabled' => true]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Populasi-per-Provinsi-' . date('Y-m-d') . '.pdf');
    }
}
