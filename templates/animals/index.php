<?php $title = 'Animal Management'; ?>

<?php ob_start(); ?>
<h1>Animals</h1>
<a href="?url=animal/create">Add New Animal</a>

<table border="1" style="width:100%; margin-top: 20px; border-collapse: collapse;">
    <thead>
        <tr>
            <th style="padding: 8px; text-align: left;">Tag Number</th>
            <th style="padding: 8px; text-align: left;">Species</th>
            <th style="padding: 8px; text-align: left;">Gender</th>
            <th style="padding: 8px; text-align: left;">Date of Birth</th>
            <th style="padding: 8px; text-align: left;">Farm</th>
            <th style="padding: 8px; text-align: left;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($animals as $animal): ?>
        <tr>
            <td style="padding: 8px;"><?= htmlspecialchars($animal['tag_number']) ?></td>
            <td style="padding: 8px;"><?= htmlspecialchars($animal['species']) ?></td>
            <td style="padding: 8px;"><?= htmlspecialchars($animal['gender']) ?></td>
            <td style="padding: 8px;"><?= htmlspecialchars($animal['date_of_birth']) ?></td>
            <td style="padding: 8px;"><?= htmlspecialchars($animal['farm_name'] ?? 'N/A') ?></td>
            <td style="padding: 8px;">
                <a href="?url=animal/edit/<?= $animal['id'] ?>">Edit</a>
                <form action="?url=animal/destroy/<?= $animal['id'] ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $content = ob_get_clean(); ?>

<?php require dirname(__DIR__) . '/layouts/main.php'; ?>
