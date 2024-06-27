    <div class="row">
        <div class="col-6">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Penduduk per Provinsi</h5>
                    <p class="card-text">Cetak jumlah populasi penduduk dari tiap provinsi</p>
                    <button wire:click="printProvinsi" class="btn btn-primary float-end">Cetak</button>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Penduduk per Kabupaten</h5>
                    <p class="card-text">Cetak jumlah populasi penduduk dari tiap kabupaten</p>
                    <select wire:model="provinsi_id" class="form-select mb-2">
                        <option value="">Semua Provinsi</option>
                        @foreach ($provinsi as $prov)
                            <option value="{{ $prov->id }}">{{ $prov->nama }}</option>
                        @endforeach
                    </select>
                    @error('provinsi_id')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                    <button wire:click="printKabupaten" class="btn btn-primary float-end">Cetak</button>
                </div>
            </div>
        </div>
    </div>
