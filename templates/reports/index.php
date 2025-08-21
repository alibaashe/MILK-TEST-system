<?php $title = 'Reports'; ?>

<?php ob_start(); ?>

<style>
    .chart-container {
        width: 100%;
        max-width: 800px;
        margin: 40px auto;
    }
</style>

<h1>Reports</h1>

<div class="chart-container">
    <h2>Animals per Farm</h2>
    <canvas id="animalsPerFarmChart"></canvas>
</div>

<div class="chart-container">
    <h2>Final Judgement Breakdown</h2>
    <canvas id="judgementBreakdownChart"></canvas>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Animals per Farm Chart (Bar)
    const animalsCtx = document.getElementById('animalsPerFarmChart').getContext('2d');
    new Chart(animalsCtx, {
        type: 'bar',
        data: {
            labels: <?= $farmLabels ?>,
            datasets: [{
                label: '# of Animals',
                data: <?= $animalCounts ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            maintainAspectRatio: true
        }
    });

    // Judgement Breakdown Chart (Pie)
    const judgementCtx = document.getElementById('judgementBreakdownChart').getContext('2d');
    new Chart(judgementCtx, {
        type: 'pie',
        data: {
            labels: <?= $judgementLabels ?>,
            datasets: [{
                label: 'Judgement Breakdown',
                data: <?= $judgementCounts ?>,
                backgroundColor: [
                    'rgba(40, 167, 69, 0.6)',
                    'rgba(255, 193, 7, 0.6)',
                    'rgba(220, 53, 69, 0.6)',
                    'rgba(108, 117, 125, 0.6)'
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(220, 53, 69, 1)',
                    'rgba(108, 117, 125, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });
</script>

<?php $content = ob_get_clean(); ?>

<?php require dirname(__DIR__) . '/layouts/main.php'; ?>
