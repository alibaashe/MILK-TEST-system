<?php $title = 'Dashboard'; ?>

<?php ob_start(); ?>

<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .stat-card {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
    }
    .stat-card .number {
        font-size: 2.5em;
        font-weight: bold;
        color: #007bff;
    }
    .stat-card .label {
        font-size: 1.1em;
        color: #555;
        margin-top: 10px;
    }
</style>

<h1>Dashboard</h1>
<p>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</p>

<div class="stats-grid">
    <div class="stat-card">
        <div class="number"><?= $stats['farm_count'] ?></div>
        <div class="label">Total Farms</div>
    </div>
    <div class="stat-card">
        <div class="number"><?= $stats['animal_count'] ?></div>
        <div class="label">Total Animals</div>
    </div>
    <div class="stat-card">
        <div class="number"><?= array_sum($stats['sample_status_counts']) ?></div>
        <div class="label">Total Milk Samples</div>
    </div>
</div>

<div style="margin-top: 40px;">
    <h2>Milk Sample Status</h2>
    <table border="1" style="width: 50%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="padding: 8px; text-align: left;">Status</th>
                <th style="padding: 8px; text-align: left;">Count</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stats['sample_status_counts'] as $status => $count): ?>
            <tr>
                <td style="padding: 8px;"><?= htmlspecialchars($status) ?></td>
                <td style="padding: 8px;"><?= $count ?></td>
            </tr>
            <?php endforeach; ?>
             <?php if (empty($stats['sample_status_counts'])): ?>
                <tr><td colspan="2" style="padding: 8px; text-align: center;">No samples found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<?php $content = ob_get_clean(); ?>

<?php require dirname(__DIR__) . '/layouts/main.php'; ?>
