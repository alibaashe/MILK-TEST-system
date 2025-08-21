<?php $title = 'Add Milk Sample'; ?>

<?php ob_start(); ?>
<h1>Add Milk Sample</h1>

<form action="/milkSample/store" method="POST">
    <div style="margin-bottom: 15px;">
        <label for="sample_code">Sample Code</label><br>
        <input type="text" id="sample_code" name="sample_code" required style="width: 300px; padding: 8px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="animal_id">Animal</label><br>
        <select id="animal_id" name="animal_id" required style="width: 300px; padding: 8px;">
            <option value="">Select an Animal</option>
            <?php foreach ($animals as $animal): ?>
                <option value="<?= $animal['id'] ?>"><?= htmlspecialchars($animal['tag_number']) ?> (<?= htmlspecialchars($animal['farm_name']) ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div style="margin-bottom: 15px;">
        <label for="collection_date">Collection Date</label><br>
        <input type="date" id="collection_date" name="collection_date" required style="width: 300px; padding: 8px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="collection_time">Collection Time</label><br>
        <input type="time" id="collection_time" name="collection_time" required style="width: 300px; padding: 8px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="status">Initial Status</label><br>
        <select id="status" name="status" required style="width: 300px; padding: 8px;">
            <option value="Pending">Pending</option>
            <option value="In Progress">In Progress</option>
        </select>
    </div>
    <div>
        <button type="submit">Save Sample</button>
        <a href="/milkSample/index">Cancel</a>
    </div>
</form>

<?php $content = ob_get_clean(); ?>

<?php require dirname(__DIR__) . '/layouts/main.php'; ?>
