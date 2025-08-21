<?php $title = 'Edit Animal'; ?>

<?php ob_start(); ?>
<h1>Edit Animal: <?= htmlspecialchars($animal['tag_number']) ?></h1>

<form action="/animal/update/<?= $animal['id'] ?>" method="POST">
    <div style="margin-bottom: 15px;">
        <label for="farm_id">Farm</label><br>
        <select id="farm_id" name="farm_id" required style="width: 300px; padding: 8px;">
            <option value="">Select a Farm</option>
            <?php foreach ($farms as $farm): ?>
                <option value="<?= $farm['id'] ?>" <?= ($farm['id'] == $animal['farm_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($farm['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div style="margin-bottom: 15px;">
        <label for="tag_number">Tag Number</label><br>
        <input type="text" id="tag_number" name="tag_number" value="<?= htmlspecialchars($animal['tag_number']) ?>" required style="width: 300px; padding: 8px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="species">Species</label><br>
        <input type="text" id="species" name="species" value="<?= htmlspecialchars($animal['species']) ?>" required style="width: 300px; padding: 8px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="date_of_birth">Date of Birth</label><br>
        <input type="date" id="date_of_birth" name="date_of_birth" value="<?= htmlspecialchars($animal['date_of_birth']) ?>" required style="width: 300px; padding: 8px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="gender">Gender</label><br>
        <select id="gender" name="gender" required style="width: 300px; padding: 8px;">
            <option value="Male" <?= ($animal['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= ($animal['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
        </select>
    </div>
    <div style="margin-bottom: 15px;">
        <label for="health_status">Health Status</label><br>
        <textarea id="health_status" name="health_status" rows="4" style="width: 300px; padding: 8px;"><?= htmlspecialchars($animal['health_status']) ?></textarea>
    </div>
    <div>
        <button type="submit">Update Animal</button>
        <a href="/animal/index">Cancel</a>
    </div>
</form>

<?php $content = ob_get_clean(); ?>

<?php require dirname(__DIR__) . '/layouts/main.php'; ?>
