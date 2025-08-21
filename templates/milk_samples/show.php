<?php $title = 'Sample Details'; ?>

<?php ob_start(); ?>

<style>
    .section { border: 1px solid #ccc; padding: 15px; margin-top: 20px; border-radius: 5px; }
    .section h2 { margin-top: 0; }
    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { margin-bottom: 10px; }
    .form-group label { display: block; font-weight: bold; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 8px; box-sizing: border-box; }
</style>

<h1>Sample Details: <?= htmlspecialchars($sample['sample_code']) ?></h1>
<a href="?url=milkSample/index">Back to List</a>

<div class="section">
    <h2>Sample Information</h2>
    <div class="grid">
        <div><strong>Sample Code:</strong> <?= htmlspecialchars($sample['sample_code']) ?></div>
        <div><strong>Status:</strong> <?= htmlspecialchars($sample['status']) ?></div>
        <div><strong>Collection Date:</strong> <?= htmlspecialchars($sample['collection_date']) ?> at <?= htmlspecialchars($sample['collection_time']) ?></div>
        <div><strong>Collected By:</strong> <?= htmlspecialchars($sample['collected_by']) ?></div>
        <div><strong>Animal Tag:</strong> <?= htmlspecialchars($sample['animal_tag']) ?></div>
        <div><strong>Farm:</strong> <?= htmlspecialchars($sample['farm_name']) ?></div>
    </div>
</div>


<!-- Lab Test Section -->
<div class="section">
    <h2>Laboratory Test Results</h2>
    <?php if (in_array($_SESSION['user_role'], ['Admin', 'Lab Technician'])): ?>
        <form action="?url=milkSample/storeLabTest/<?= $sample['id'] ?>" method="POST">
            <div class="grid">
                <div class="form-group">
                    <label for="ph">pH</label>
                    <input type="number" step="0.01" id="ph" name="ph" value="<?= htmlspecialchars($labTest['ph'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="specific_gravity">Specific Gravity</label>
                    <input type="number" step="0.0001" id="specific_gravity" name="specific_gravity" value="<?= htmlspecialchars($labTest['specific_gravity'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="mastitis_test_result">Mastitis Test</label>
                    <input type="text" id="mastitis_test_result" name="mastitis_test_result" value="<?= htmlspecialchars($labTest['mastitis_test_result'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="antibiotic_test_result">Antibiotic Test</label>
                    <input type="text" id="antibiotic_test_result" name="antibiotic_test_result" value="<?= htmlspecialchars($labTest['antibiotic_test_result'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="bacterial_count">Bacterial Count</label>
                    <input type="number" id="bacterial_count" name="bacterial_count" value="<?= htmlspecialchars($labTest['bacterial_count'] ?? '') ?>">
                </div>
                 <div class="form-group">
                    <label for="fat_percentage">Fat (%)</label>
                    <input type="number" step="0.01" id="fat_percentage" name="fat_percentage" value="<?= htmlspecialchars($labTest['fat_percentage'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="protein_percentage">Protein (%)</label>
                    <input type="number" step="0.01" id="protein_percentage" name="protein_percentage" value="<?= htmlspecialchars($labTest['protein_percentage'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="lactose_percentage">Lactose (%)</label>
                    <input type="number" step="0.01" id="lactose_percentage" name="lactose_percentage" value="<?= htmlspecialchars($labTest['lactose_percentage'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="solids_non_fat_percentage">Solids-non-fat (%)</label>
                    <input type="number" step="0.01" id="solids_non_fat_percentage" name="solids_non_fat_percentage" value="<?= htmlspecialchars($labTest['solids_non_fat_percentage'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="freezing_point">Freezing Point</label>
                    <input type="number" step="0.001" id="freezing_point" name="freezing_point" value="<?= htmlspecialchars($labTest['freezing_point'] ?? '') ?>">
                </div>
            </div>
            <button type="submit">Save Lab Test</button>
        </form>
    <?php elseif ($labTest): ?>
        <div class="grid">
            <div><strong>pH:</strong> <?= htmlspecialchars($labTest['ph']) ?></div>
            <div><strong>Specific Gravity:</strong> <?= htmlspecialchars($labTest['specific_gravity']) ?></div>
            <div><strong>Mastitis Test:</strong> <?= htmlspecialchars($labTest['mastitis_test_result']) ?></div>
            <div><strong>Antibiotic Test:</strong> <?= htmlspecialchars($labTest['antibiotic_test_result']) ?></div>
            <div><strong>Bacterial Count:</strong> <?= htmlspecialchars($labTest['bacterial_count']) ?></div>
        </div>
    <?php else: ?>
        <p>No lab test results have been submitted yet.</p>
    <?php endif; ?>
</div>


<!-- Final Judgement Section -->
<div class="section">
    <h2>Final Judgement</h2>
    <?php if (in_array($_SESSION['user_role'], ['Admin', 'Inspector'])): ?>
        <form action="?url=milkSample/storeFinalJudgement/<?= $sample['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="judgement">Judgement</label>
                <select id="judgement" name="judgement" required>
                    <option value="">Select Judgement</option>
                    <option value="Safe for Consumption" <?= ($finalJudgement['judgement'] ?? '') == 'Safe for Consumption' ? 'selected' : '' ?>>Safe for Consumption</option>
                    <option value="Requires Pasteurization" <?= ($finalJudgement['judgement'] ?? '') == 'Requires Pasteurization' ? 'selected' : '' ?>>Requires Pasteurization</option>
                    <option value="Unfit for Consumption" <?= ($finalJudgement['judgement'] ?? '') == 'Unfit for Consumption' ? 'selected' : '' ?>>Unfit for Consumption</option>
                    <option value="Requires Follow-up" <?= ($finalJudgement['judgement'] ?? '') == 'Requires Follow-up' ? 'selected' : '' ?>>Requires Follow-up</option>
                </select>
            </div>
            <div class="form-group">
                <label for="comments">Comments</label>
                <textarea id="comments" name="comments" rows="4"><?= htmlspecialchars($finalJudgement['comments'] ?? '') ?></textarea>
            </div>
            <div class="form-group">
                <label for="signature">Inspector Signature</label>
                <input type="file" id="signature" name="signature" accept="image/png, image/jpeg">
            </div>
            <button type="submit">Save Final Judgement</button>
        </form>
    <?php elseif ($finalJudgement): ?>
        <div><strong>Judgement:</strong> <?= htmlspecialchars($finalJudgement['judgement']) ?></div>
        <div><strong>Comments:</strong> <?= nl2br(htmlspecialchars($finalJudgement['comments'])) ?></div>
        <div><strong>Judged By:</strong> <?= htmlspecialchars($finalJudgement['judge_name'] ?? 'N/A') ?></div>
        <?php if (!empty($finalJudgement['inspector_signature_path'])): ?>
            <div style="margin-top: 15px;">
                <strong>Signature:</strong><br>
                <img src="serve_image.php?file=<?= urlencode($finalJudgement['inspector_signature_path']) ?>" alt="Inspector Signature" style="max-width: 300px; border: 1px solid #ccc; margin-top: 5px;">
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p>No final judgement has been made yet.</p>
    <?php endif; ?>
</div>


<?php $content = ob_get_clean(); ?>

<?php require dirname(__DIR__) . '/layouts/main.php'; ?>
