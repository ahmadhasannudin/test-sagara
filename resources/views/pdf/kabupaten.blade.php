<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Report Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 2px solid #007BFF;
        }

        .header h1 {
            margin: 0;
            color: #007BFF;
        }

        .header p {
            margin: 5px 0 0;
            color: #333;
        }

        .report-date {
            text-align: right;
            font-size: 0.9em;
            color: #666;
        }

        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #007BFF;
            color: #fff;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            text-align: center;
            padding: 10px 0;
            border-top: 2px solid #007BFF;
            color: #666;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Report Populasi per Kabupaten</h1>
            <p>Provinsi {{ $provinsi->nama }}</p>
        </div>
        <div class="report-date">
            <p>Tanggal: {{ date('d-m-Y') }}</p>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="text-center">Kabupaten</th>
                        <th width="200px" class="text-center">Provinsi</th>
                        <th width="200px" class="text-center">Penduduk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kabupaten as $k)
                        <tr>
                            <td>{{ $k->nama }}</td>
                            <td>{{ $k->provinsi->nama }}</td>
                            <td class="text-end">{{ number_format($k->populasi, 0, ',') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
