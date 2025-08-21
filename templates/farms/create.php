<?php $title = 'Add New Farm'; ?>

<?php ob_start(); ?>
<h1>Add New Farm</h1>

<form action="?url=farm/store" method="POST">
    <div style="margin-bottom: 15px;">
        <label for="name">Farm Name</label><br>
        <input type="text" id="name" name="name" required style="width: 300px; padding: 8px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="location">Location</label><br>
        <input type="text" id="location" name="location" required style="width: 300px; padding: 8px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="owner_name">Owner Name</label><br>
        <input type="text" id="owner_name" name="owner_name" required style="width: 300px; padding: 8px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="contact_number">Contact Number</label><br>
        <input type="text" id="contact_number" name="contact_number" required style="width: 300px; padding: 8px;">
    </div>
    <div>
        <button type="submit">Save Farm</button>
        <a href="?url=farm/index">Cancel</a>
    </div>
</form>

<?php $content = ob_get_clean(); ?>

<?php require dirname(__DIR__) . '/layouts/main.php'; ?>
