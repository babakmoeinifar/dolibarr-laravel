<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>آمار آنلاین مونتاژ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
          integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="{{ asset('css/persian-datepicker.min.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
            integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        @font-face {
            font-family: yekan;
            src: url('{{ asset('fonts/yekan.ttf') }}');
        }

        body, .btn, label, .card-body {
            font-family: yekan, sans-serif !important;
        }
    </style>

</head>
<body>
<div class="container-fluid">
    <br>
    @include('messages')
    <div class="page-title mb-4">
        <h1 class="mb-2 text-center">آمار آنلاین برای مونتاژ</h1>
    </div>
    <div class="row">
        <div class="card col-md-4">
            <div class="card-body d-flex justify-content-between table-responsive text-end">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>مدل</th>
                        <th>تعداد نیاز</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($devices as $device)
                        <tr>
                            <td><b style="font-family: 'Helvetica'">{{$device->en_name}}</b> ({{$device->name}})</td>
                            <td>{{ $device->sales_sum_qty ?? 0 }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card col-md-8" style="background-color: #f5f5f5">
            <div class="card-body">
                <div class="row">

                    @foreach($newSales as $groupedSale)
                        @php
                            $exitDate = \Hekmatinasser\Verta\Verta::parse($groupedSale[0]->exit_date);
                            $today = \Hekmatinasser\Verta\Verta::today();
                            $daysUntilExit = $exitDate->diffDays($today);
                        @endphp
                        <div class="col-md-4 mb-3">

                            <div class="card bg-light position-relative shadow">

                                <div class="card-body">
                                    <h5 class="card-title border-bottom text-center bg-secondary text-white p-2">{{ $groupedSale[0]->exit_date }}</h5>
                                    <div class="list-unstyled text-end">
                                        @foreach($groupedSale as $sale)
                                            <div class="d-flex justify-content-between">
                                                <b style="font-family: 'Helvetica'">{{ $sale->device->en_name }}</b><small>{{ $sale->comment ?? '' }}</small><b>{{ $sale->total_qty }}</b>
                                            </div>
                                        @endforeach
                                    </div>
                                    <br>
                                    <span class="badge bg-warning text-dark mt-2 d-flex justify-content-around" style="font-size: 16px;"> @if($daysUntilExit == 0) <span class="text-danger">امروز</span> @else {{ $daysUntilExit }} روز {{ ($exitDate)->format('Y-m-d') <  $today->format('Y-m-d') ? 'گذشته' : 'مانده' }} @endif</span>
                                    <a href="#"
                                       class="btn btn-dark btn-sm mt-2"
                                       onclick="printSalesCard(this)"
                                       data-exit-date="{{ $groupedSale[0]->exit_date }}"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="top">چاپ</a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printSalesCard(element) {
        const exitDate = element.getAttribute('data-exit-date');
        const cardContent = element.closest('.card');

        const printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>چاپ کارت فروش - ' + exitDate + '</title>');

        printWindow.document.write(`
        <style>
            @page {
                size: A4;
                margin: 10mm;
            }
            body {
                font-family: Helvetica, sans-serif;
                direction: rtl;
                text-align: right;
                width: 148mm;
                margin: 0 auto;
            }
            .print-container {
                border: 1px solid #ddd;
                padding: 20px;
            }
            .print-header {
                text-align: center;
                margin-bottom: 20px;
            }
            .print-details div {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
            }
        </style>
    `);

        printWindow.document.write('</head><body>');
        printWindow.document.write('<div class="print-container">');
        printWindow.document.write('<div class="print-header"><h2>آمار برای واحد مونتاژ </h2><h3>' + exitDate + '</h3></div>');

        // Reconstruct sales details with total_qty
        let salesDetailsHtml = '<div class="print-details">';
        const salesItems = cardContent.querySelectorAll('.list-unstyled .d-flex');
        salesItems.forEach(item => {
            const deviceName = item.querySelector('b:first-child').textContent;
            const comment = item.querySelector('small').textContent;
            const totalQty = item.querySelector('b:last-child').textContent;

            salesDetailsHtml += `
            <div>
                <span>${deviceName}</span>
                <span>${comment}</span>
                <span>تعداد: ${totalQty}</span>
            </div>
        `;
        });
        salesDetailsHtml += '</div>';

        printWindow.document.write(salesDetailsHtml);

        printWindow.document.write('</div>');
        printWindow.document.write('<script>window.print(); window.close();<\/script>');
        printWindow.document.write('</body></html>');

        printWindow.document.close();
    }
</script>
</body>
</html>
