@extends('layout.panel')

@section('after_style')
<style>

</style>
@endsection

@section('content')
<div class="section">
    <h2 class="title text-center">Voting Result</h2>

    <div class="row">
        <div class="col-md-12">
            <canvas id="result"></canvas>
        </div>
    </div>

</div>
@endsection

@section('after_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script>
    $(document).on('ready', function(){
        var ctx = document.getElementById("result");
        var result = {!! json_encode($data) !!};
        var labels = [];
        var data = [];
        var color = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)'
        ];
        var i = 0;

        result.forEach(function(res) {
            data.push({
                label: res.voted_at,
                data: [parseFloat(res.qty)],
                backgroundColor: color[i]
            });
            i++;
        });

        console.log(result, labels, data);
        
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: labels,
                datasets: data
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                },
                responsive: true,
                legend: {
                    display: true,
                    labels: {
                        fontColor: 'rgb(255, 99, 132)'
                    }
                }
            }
        });
    });
</script>
@endsection