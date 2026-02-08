<?php require_once '../app/views/layouts/header.php'; ?>

<div class="row mb-4 d-flex justify-content-between align-items-center">
    <h1>Students</h1>
    <a href="<?php echo BASE_URL; ?>students/add" class="btn btn-primary">Add Student</a>
</div>

<?php flash('student_message'); ?>

<div class="card p-0 overflow-hidden">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>LRN</th>
                    <th>Full Name</th>
                    <th>Course / Strand</th>
                    <th>Year Level</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['students'] as $student): ?>
                    <tr>
                        <td class="fw-bold text-accent"><?php echo $student->student_id; ?></td>
                        <td class="text-muted font-monospace small">
                            <?php echo $student->lrn; ?>
                        </td>
                        <td><?php echo $student->full_name; ?></td>
                        <td><?php echo $student->course_strand; ?></td>
                        <td>
                            <span class="badge badge-outline">
                                <?php echo $student->year_level; ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="<?php echo BASE_URL; ?>students/edit/<?php echo $student->id; ?>"
                                    class="btn btn-secondary btn-sm">Edit</a>
                                <form action="<?php echo BASE_URL; ?>students/delete/<?php echo $student->id; ?>"
                                    method="POST" onsubmit="return confirm('Are you sure?')">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>