<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Milk Testing System') ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        nav { background-color: #333; padding: 10px; }
        nav a { color: white; text-decoration: none; padding: 10px 15px; }
        nav a:hover { background-color: #555; }
        .content { margin-top: 20px; }
    </style>
</head>
<body>
    <nav>
        <div class="container">
            <a href="?url=">Home</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="?url=dashboard">Dashboard</a>
                <?php if ($_SESSION['user_role'] === 'Admin'): ?>
                    <a href="?url=farm/index">Manage Farms</a>
                <?php endif; ?>
                <?php if (in_array($_SESSION['user_role'], ['Admin', 'Inspector'])): ?>
                    <a href="?url=animal/index">Manage Animals</a>
                <?php endif; ?>
                <?php if (in_array($_SESSION['user_role'], ['Admin', 'Inspector', 'Lab Technician'])): ?>
                    <a href="?url=milkSample/index">Milk Samples</a>
                <?php endif; ?>
                <a href="?url=report/index">Reports</a>
                <a href="?url=auth/logout" style="float: right;">Logout</a>
            <?php else: ?>
                <a href="?url=auth/login">Login</a>
                <a href="?url=auth/register">Register</a>
            <?php endif; ?>
        </div>
    </nav>
    <main class="container content">
        <?php if (isset($content)) echo $content; ?>
    </main>
</body>
</html>
