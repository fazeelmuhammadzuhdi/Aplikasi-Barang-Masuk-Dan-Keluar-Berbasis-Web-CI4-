<link rel="stylesheet" href="<?= base_url() . '/plugins/chart.js/Chart.min.css' ?>">
<script src="<?= base_url() . '/plugins/chart.js/Chart.bundle.min.js' ?>"></script>

<canvas id="myChart" style="height: 50vh; width: 80vh;"></canvas>

<?php
$tanggal = "";
$total = "";

foreach ($grafik as $row) :
    $tagal = $row->tgl;
    $tanggal .= "'$tagal'" . ",";

    $totalHarga = $row->totalharga1910021;
    $total .= "'$totalHarga'" . ",";
endforeach;
?>

<script>
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'bar',
    responsive: true,
    data: {
        labels: [<?= $tanggal ?>],
        datasets: [{
            label: 'Total Harga',
            backgroundColor: ['rgb(0,255,255)', 'rgb(14,99,132)'],
            borderColor: ['rgb(255,0,0)'],
            data: [<?= $total ?>]
        }]
    },

    duration: 1000
})
</script>