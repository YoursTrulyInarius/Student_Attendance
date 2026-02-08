<?php require_once '../app/views/layouts/header.php'; ?>

<div class="row mb-3" style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Subjects</h1>
    <a href="<?php echo BASE_URL; ?>subjects/add" class="btn btn-primary">Add Subject</a>
</div>

<?php flash('subject_message'); ?>

<table>
    <thead>
        <tr>
            <th>Subject Name</th>
            <th>Teacher</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['subjects'] as $subject): ?>
            <tr>
                <td>
                    <?php echo $subject->subject_name; ?>
                </td>
                <td>
                    <?php echo $subject->teacher_name ? $subject->teacher_name : 'N/A'; ?>
                </td>
                <td>
                    <?php echo date('M d, Y', strtotime($subject->created_at)); ?>
                </td>
                <td>
                    <a href="<?php echo BASE_URL; ?>subjects/viewDetails/<?php echo $subject->id; ?>"
                        class="btn btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">View Students</a>
                    <form action="<?php echo BASE_URL; ?>subjects/delete/<?php echo $subject->id; ?>" method="POST"
                        style="display:inline;">
                        <button type="submit" class="btn btn-dark"
                            style="padding: 0.25rem 0.5rem; font-size: 0.75rem; background: #ef4444;"
                            onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../app/views/layouts/footer.php'; ?>