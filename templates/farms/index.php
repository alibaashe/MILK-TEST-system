<?php $title = 'Farm Management'; ?>

<?php ob_start(); ?>
<h1>Farms</h1>
<a href="?url=farm/create">Add New Farm</a>

<table border="1" style="width:100%; margin-top: 20px; border-collapse: collapse;">
    <thead>
        <tr>
            <th style="padding: 8px; text-align: left;">Name</th>
            <th style="padding: 8px; text-align: left;">Location</th>
            <th style="padding: 8px; text-align: left;">Owner</th>
            <th style="padding: 8px; text-align: left;">Contact</th>
            <th style="padding: 8px; text-align: left;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($farms as $farm): ?>
        <tr>
            <td style="padding: 8px;"><?= htmlspecialchars($farm['name']) ?></td>
            <td style="padding: 8px;"><?= htmlspecialchars($farm['location']) ?></td>
            <td style="padding: 8px;"><?= htmlspecialchars($farm['owner_name']) ?></td>
            <td style="padding: 8px;"><?= htmlspecialchars($farm['contact_number']) ?></td>
            <td style="padding: 8px;">
                <a href="?url=farm/edit/<?= $farm['id'] ?>">Edit</a>
                <form action="?url=farm/destroy/<?= $farm['id'] ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $content = ob_get_clean(); ?>

<?php require dirname(__DIR__) . '/layouts/main.php'; ?>
