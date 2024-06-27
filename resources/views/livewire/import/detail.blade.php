<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import</h5>
                <button type="button" class="btn-close" onclick="closeDetail()"></button>
            </div>
            <div class="modal-body table-bordered">
                <table class="table">
                    <tr>
                        <td>Status</td>
                        <td>{{ $detailImport['status'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Total Rows</td>
                        <td>{{ $detailImport['total_rows'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Success Rows</td>
                        <td>{{ $detailImport['success_rows'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Failed Rows</td>
                        <td>{{ $detailImport['failed_rows'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Time Elapsed</td>
                        <td>
                            {{ !empty($detailImport['time_elapsed']) ? gmdate("i \m\n s \s", $detailImport['time_elapsed'] / 1000) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>
                            @if (!empty($detailImport['status']) && $detailImport['status'] == 'Completed')
                                <button class="btn btn-success btn-sm">Completed</button>
                            @else
                                <button class="btn btn-secondary btn-sm">Pending</button>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>File Error</td>
                        <td>
                            @if (!empty($detailImport['link_to_failed_rows_file']))
                                <button class="btn btn-primary btn-sm"
                                    wire:click="download(`{{ 'app/' . $detailImport['link_to_failed_rows_file'] }}`)">
                                    <i class="fa fa-download"></i>Download
                                    File
                                </button>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Detail
                        </td>
                        <td>
                            @if (!empty($detailImport['errors']))
                                <table class="table">
                                    @foreach (json_decode($detailImport['errors'], true) as $e)
                                        <tr>
                                            <td>Trx ID</td>
                                            <td>{{ $e['trx_id'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Detail</td>
                                            <td>{{ $e['detail'] }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeDetail()" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function closeDetail() {
        $('#modalDetail').modal('hide')
    }
    window.addEventListener('closeDetail', event => {
        $('#modalDetail').modal('hide')
    });
    window.addEventListener('openDetail', event => {
        $('#modalDetail').modal('show')
    });
</script>
