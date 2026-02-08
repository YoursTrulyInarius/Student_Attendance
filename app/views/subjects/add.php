<?php require_once '../app/views/layouts/header.php'; ?>

<div class="card" style="max-width: 600px; margin: auto;">
    <h2>Add Subject</h2>
    <form action="<?php echo BASE_URL; ?>subjects/add" method="POST">
        <div class="form-group">
            <label for="subject_name">Subject Name</label>
            <input type="text" name="subject_name" id="subject_name" value="<?php echo $data['subject_name']; ?>">
            <span class="error-msg">
                <?php echo $data['subject_name_err']; ?>
            </span>
        </div>
        <div class="form-group">
            <label for="teacher_id">Assign Teacher</label>
            <select name="teacher_id" id="teacher_id">
                <option value="">Select Teacher</option>
                <?php foreach ($data['teachers'] as $teacher): ?>
                    <option value="<?php echo $teacher->id; ?>">
                        <?php echo $teacher->full_name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Save Subject</button>
            <a href="<?php echo BASE_URL; ?>subjects" class="btn btn-dark">Cancel</a>
        </div>
    </form>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>