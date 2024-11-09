<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Chart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    @font-face {
    font-family: IRANSansX;
    font-style: normal;
    font-weight: 300;
    src: url(/IRANSansX.woff) format("woff")
}
@font-face {
    font-family: Estedad;
    font-style: normal;
    font-weight: 300;
    src: url(/Estedad.ttf) format("ttf")
}
    body, p , div{
        font-family: Estedad, sans-serif;
    }
    </style>

</head>
<body class="bg-secondary container">
<br>
@foreach($categories as $category)
    <div class="card shadow mb-5">
        <h4 class="text-center pt-3">{{ $category->label }}</h4>
        <canvas id="stockChart{{$category->rowid}}"></canvas>
    </div>
@endforeach

<script>
    function getRandomColor() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return 'rgba(' + r + ',' + g + ',' + b + ',0.6)';
    }

    document.addEventListener('DOMContentLoaded', function () {
        @foreach($categories as $category)
        var ctx = document.getElementById('stockChart{{$category->rowid}}').getContext('2d');
        var randomColor = getRandomColor();

        var products = {!! json_encode($productsByCategory[$category->rowid]) !!};
        var labels = products.map(function(product) { return product.product_name; });
        var data = products.map(function(product) {
            return product.per_device ? product.stock / product.per_device : product.stock;
        });

        var minStockData = products.map(function(product) {
            return product.per_device ? product.minStock / product.per_device : product.minStock;
        });

        Chart.defaults.font.family = 'Helvetica';
        Chart.defaults.font.weight = 'Bold';

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'دستگاه',
                        data: data,
                        backgroundColor: randomColor,
                        borderColor: randomColor.replace('0.6', '1'),
                        borderWidth: 1,
                    },
                    {
                        label: 'نقطه سفارش',
                        data: minStockData,
                        type: 'line',
                        borderColor: 'red',
                        fill: false,
                        borderWidth: 2,
                        tension: 0
                    }
                ]
            },
            options: {
                indexAxis: 'x',
                aspectRatio: 1.5,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        rtl : true,
                        textDirection:'rtl',
                        labels: {
                    font: {
                        size: 15
                    }
                }
                    }
                }
            }
        });
        @endforeach
    });
</script>
</body>
</html>
