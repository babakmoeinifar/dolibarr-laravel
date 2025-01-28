<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>آمار فروش آنلاین</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
          integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="{{ asset('css/persian-datepicker.min.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
            integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/persian-datepicker.min.js') }}"></script>
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
        <h1 class="mb-2 text-center">آمار آنلاین فروش</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            + فروش جدید
        </button>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('sales.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="customer_name" class="fw-bold">نام مشتری <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name"
                                           required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exit_date" class="fw-bold">تاریخ خروج <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="exit_date" name="exit_date"
                                           required>
                                </div>
                            </div>
                            <br>
                            <label for="device_id">مدل دستگاه <span class="text-danger">*</span></label>
                            <div class="text-danger" id="deviceError">
                                حداقل یک دستگاه را انتخاب کنید
                            </div>
                            <div class="row">
                                @foreach($devices as $device)
                                    <div class="device-row mb-3 border p-3 col-md-3 shadow-sm rounded">
                                        <div class="form-check">
                                            <input type="checkbox"
                                                   class="form-check-input device-checkbox"
                                                   name="devices[{{$device->id}}][selected]"
                                                   id="device_{{$device->id}}"
                                                   value="1">
                                            <label class="form-check-label fw-bold" style="cursor: pointer"
                                                   for="device_{{$device->id}}">
                                                {{$device->name}} <br>
                                                <span class="badge bg-dark">{{$device->en_name}}</span>
                                            </label>
                                        </div>

                                        <div class="mt-2 d-flex justify-content-start">
                                            <label for="qty_{{$device->id}}">تعداد</label>&nbsp;
                                            <input type="number"
                                                   class="form-control w-25"
                                                   id="qty_{{$device->id}}"
                                                   name="devices[{{$device->id}}][qty]"
                                                   min="1"
                                                   disabled>
                                        </div>
                                        <div class="mt-2 d-flex justify-content-start">
                                            <label for="qty_{{$device->id}}" style="font-size: small">توضیحات</label>&nbsp;
                                            <input type="text"
                                                   class="form-control"
                                                   id="comment_{{$device->id}}"
                                                   name="devices[{{$device->id}}][comment]"
                                                   disabled>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-success">ثبت</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                    @php
                        $groupedSales = $newSales->groupBy(function($sale) {
                            return $sale->customer_name . '_' . $sale->exit_date;
                        });
                    @endphp

                    @foreach($groupedSales as $groupedSale)
                        @php
                            $exitDate = \Hekmatinasser\Verta\Verta::parse($groupedSale[0]->exit_date);
                            $today = \Hekmatinasser\Verta\Verta::today();
                            $daysUntilExit = $exitDate->diffDays($today);
                            $isUrgent = $daysUntilExit < 4;
                            $saleIds = $groupedSale->pluck('id')->join(',');
                        @endphp
                        <div class="col-md-4 mb-3">

                            <div class="card {{ $isUrgent ? 'bg-danger text-white' : 'bg-light' }} position-relative shadow">

                                <div class="card-body">
                                    <h5 class="card-title">{{ $groupedSale[0]->customer_name }}</h5>
                                    <div class="card-text border-bottom mb-3 bg-white text-dark rounded p-2">
                                        <div class="d-flex justify-content-between">
                                            تاریخ خروج: <b dir="ltr">{{ $groupedSale[0]->exit_date }}</b>
                                        </div>
                                        <div class="d-flex justify-content-between text-muted">
                                            تاریخ ثبت: <span dir="ltr">{{ ($groupedSale[0]->created_at)->toJalali()->format('Y-m-d H:i') }}</span>
                                        </div>
                                    </div>
                                    <div class="list-unstyled text-end">
                                        @foreach($groupedSale as $sale)
                                            @if(($sale->created_at)->format('Y-m-d') == today()->format('Y-m-d'))
                                                <span class="badge bg-warning text-black position-absolute" style="top: 10px; left: 10px; font-size: 1.05rem;">جدید</span>
                                            @endif
                                            <div class="d-flex justify-content-between">
                                                <b style="font-family: 'Helvetica'">{{ $sale->device->en_name }}</b><small>{{ $sale->comment ?? '' }}</small><b>{{ $sale->qty }}</b>
                                            </div>
                                        @endforeach
                                    </div>
                                    <br>
                                    <span class="badge bg-warning text-dark mt-2 d-flex justify-content-around" style="font-size: 16px;"> @if($daysUntilExit == 0) <span class="text-danger">امروز</span> @else {{ $daysUntilExit }} روز {{ ($exitDate)->format('Y-m-d') <  $today->format('Y-m-d') ? 'گذشته' : 'مانده' }} @endif</span>
                                    <div class="border-top pt-2 d-flex justify-content-between mt-2">
                                        <a href="{{ route('sales.toggleStatus', ['status' => 'done', 'ids' => $saleIds]) }}"
                                           class="btn btn-success btn-sm btn-status"
                                           data-bs-toggle="tooltip" data-bs-placement="top" title="مسٔول انبار"><i class="bi bi-check"></i>خارج شد</a>
                                        <a href="{{ route('sales.toggleStatus', ['status' => 'cancel', 'ids' => $saleIds]) }}"
                                           class="btn btn-secondary btn-sm btn-status"
                                           data-bs-toggle="tooltip" data-bs-placement="top" title="واحد فروش">کنسل</a>
                                    </div>
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
    $("#exit_date").pDatepicker({
        autoClose: true,
        format: 'YYYY-MM-DD',
        "calendar": {
            "persian": {
                "locale": "en",
            },
            "gregorian": {
                "locale": "en",
                "showHint": true
            }
        },
        toolbox: {
            calendarSwitch: {
                enabled: false
            }
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // refresh
        function checkAndRefresh() {
            const modal = document.getElementById('exampleModal');
            if (!modal.classList.contains('show')) {
                // If the modal is not open, refresh the page
                location.reload();
            }
        }
        setInterval(checkAndRefresh, 30000);
        // end of refresh

        // Select all labels with "for" attribute matching the qty inputs
        const qtyLabels = document.querySelectorAll('label[for^="qty_"]');
        qtyLabels.forEach(label => {
            label.addEventListener('click', function () {
                const inputId = this.getAttribute('for');
                const input = document.getElementById(inputId);
                const deviceId = inputId.split('_')[1]; // Extract the device ID
                const checkbox = document.getElementById('device_' + deviceId); // Get the corresponding checkbox
                const comment = document.getElementById('comment_' + deviceId);


                if (input.disabled) {
                    checkbox.checked = true; // Check the checkbox
                    comment.disabled = false; // Enable the comment input
                    input.disabled = false;  // Enable the input
                    input.value = 1;         // Set the value to 1
                    input.focus();           // Focus on the input
                }
            });
        });

        const form = document.getElementById('montajForm');
        const checkboxes = document.querySelectorAll('.device-checkbox');
        const deviceError = document.getElementById('deviceError');

        // Enable/disable quantity input based on checkbox
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const deviceId = this.id.split('_')[1];
                const qtyInput = document.getElementById('qty_' + deviceId);
                const commentInput = document.getElementById('comment_' + deviceId);
                if (this.checked) {
                    qtyInput.disabled = false; // Enable input
                    commentInput.disabled = false;
                    qtyInput.required = true; // Make it required
                    qtyInput.value = 1;       // Set default value
                    qtyInput.focus();
                } else {
                    qtyInput.disabled = true; // Disable input
                    commentInput.disabled = true;
                    qtyInput.required = false; // Remove required attribute
                    qtyInput.value = '';      // Clear value
                }
            });
        });
    });
</script>
<script>
    $('.btn-status').on('click', function () {
        return confirm('از انجام این کار اطمینان دارید؟');
    })
</script>
</body>
</html>
