<?php $title = 'Milk Samples'; ?>

<?php ob_start(); ?>
<h1>Milk Samples</h1>
<a href="?url=milkSample/create">Add New Sample</a>

<table border="1" style="width:100%; margin-top: 20px; border-collapse: collapse;">
    <thead>
        <tr>
            <th style="padding: 8px; text-align: left;">Sample Code</th>
            <th style="padding: 8px; text-align: left;">Collection Date</th>
            <th style="padding: 8px; text-align: left;">Animal Tag</th>
            <th style="padding: 8px; text-align: left;">Farm</th>
            <th style="padding: 8px; text-align: left;">Status</th>
            <th style="padding: 8px; text-align: left;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($samples as $sample): ?>
        <tr>
            <td style="padding: 8px;"><?= htmlspecialchars($sample['sample_code']) ?></td>
            <td style="padding: 8px;"><?= htmlspecialchars($sample['collection_date']) ?></td>
            <td style="padding: 8px;"><?= htmlspecialchars($sample['animal_tag']) ?></td>
            <td style="padding: 8px;"><?= htmlspecialchars($sample['farm_name']) ?></td>
            <td style="padding: 8px;"><?= htmlspecialchars($sample['status']) ?></td>
            <td style="padding: 8px;">
                <a href="?url=milkSample/show/<?= $sample['id'] ?>">View Details</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $content = ob_get_clean(); ?>

<?php require dirname(__DIR__) . '/layouts/main.php'; ?>
