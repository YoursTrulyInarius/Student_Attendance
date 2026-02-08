<?php require_once '../app/views/layouts/header.php'; ?>

<div class="dashboard-header mb-4">
    <h1 class="text-primary">Subject: <?php echo $data['subject']->subject_name; ?></h1>
    <p class="text-muted">Manage students enrolled in this subject</p>
</div>

<?php flash('subject_message'); ?>

<div class="row d-flex gap-4 align-items-start">
    <div class="card p-0 flex-1 overflow-hidden" style="flex: 2;">
        <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
            <h3 class="h5 mb-0">Enrolled Students</h3>
            <span class="badge badge-outline"><?php echo count($data['students']); ?> Students</span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>LRN</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['students'])): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                No students enrolled in this subject.
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($data['students'] as $student): ?>
                        <tr>
                            <td class="fw-bold text-accent"><?php echo $student->student_id; ?></td>
                            <td class="text-muted font-monospace small"><?php echo $student->lrn; ?></td>
                            <td><?php echo $student->full_name; ?></td>
                            <td>
                                <form
                                    action="<?php echo BASE_URL; ?>subjects/removeStudent/<?php echo $data['subject']->id; ?>/<?php echo $student->id; ?>"
                                    method="POST" onsubmit="return confirm('Remove student from this subject?')">
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div style="flex: 1; min-width: 300px;">
        <div class="card">
            <h3 class="h5 mb-4">Enroll Student</h3>
            <form action="<?php echo BASE_URL; ?>subjects/addStudent/<?php echo $data['subject']->id; ?>" method="POST">
                <div class="form-group">
                    <label for="student_id">Select Student</label>
                    <select name="student_id" id="student_id">
                        <?php foreach ($data['all_students'] as $student): ?>
                            <option value="<?php echo $student->id; ?>">
                                <?php echo $student->full_name; ?> (ID: <?php echo $student->student_id; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-2">Assign Student</button>
            </form>
        </div>

        <div class="mt-4 d-flex flex-column gap-2">
            <a href="<?php echo BASE_URL; ?>attendances" class="btn btn-secondary w-100">Mark Attendance</a>
            <a href="<?php echo BASE_URL; ?>subjects" class="btn btn-primary w-100" style="background: var(--primary-light);">Back to Subjects</a>
        </div>
    </div>
</div>

<style>
    .px-4 { padding-left: 1.5rem; padding-right: 1.5rem; }
    .py-3 { padding-top: 1rem; padding-bottom: 1rem; }
    .border-bottom { border-bottom: 1px solid var(--border); }
    .mb-0 { margin-bottom: 0; }
    .w-100 { width: 100%; }
    .flex-1 { flex: 1; }
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
