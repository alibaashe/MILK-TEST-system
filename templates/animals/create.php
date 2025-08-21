<?php $title = 'Add New Animal'; ?>

<?php ob_start(); ?>
<h1>Add New Animal</h1>

<form action="?url=animal/store" method="POST">
    <div style="margin-bottom: 15px;">
        <label for="farm_id">Farm</label><br>
        <select id="farm_id" name="farm_id" required style="width: 300px; padding: 8px;">
            <option value="">Select a Farm</option>
            <?php foreach ($farms as $farm): ?>
                <option value="<?= $farm['id'] ?>"><?= htmlspecialchars($farm['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div style="margin-bottom: 15px;">
        <label for="tag_number">Tag Number</label><br>
        <input type="text" id="tag_number" name="tag_number" required style="width: 300px; padding: 8px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="species">Species</label><br>
        <input type="text" id="species" name="species" required style="width: 300px; padding: 8px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="date_of_birth">Date of Birth</label><br>
        <input type="date" id="date_of_birth" name="date_of_birth" required style="width: 300px; padding: 8px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="gender">Gender</label><br>
        <select id="gender" name="gender" required style="width: 300px; padding: 8px;">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </div>
    <div style="margin-bottom: 15px;">
        <label for="health_status">Health Status</label><br>
        <textarea id="health_status" name="health_status" rows="4" style="width: 300px; padding: 8px;"></textarea>
    </div>
    <div>
        <button type="submit">Save Animal</button>
        <a href="?url=animal/index">Cancel</a>
    </div>
</form>

<?php $content = ob_get_clean(); ?>

<?php require dirname(__DIR__) . '/layouts/main.php'; ?>
