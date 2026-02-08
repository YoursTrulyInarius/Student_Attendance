<?php require_once '../app/views/layouts/header.php'; ?>

<div class="row mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1 class="text-primary">
            <?php echo $data['subject_name']; ?>
        </h1>
        <p class="text-muted">Attendance details for today (
            <?php echo date('F j, Y'); ?>)
        </p>
    </div>
    <a href="<?php echo BASE_URL; ?>dashboard" class="btn btn-secondary">Back to Dashboard</a>
</div>

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
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['attendance_list'] as $student): ?>
                    <tr>
                        <td class="fw-bold text-accent">
                            <?php echo $student->student_id; ?>
                        </td>
                        <td class="text-muted font-monospace small">
                            <?php echo $student->lrn; ?>
                        </td>
                        <td>
                            <?php echo $student->full_name; ?>
                        </td>
                        <td>
                            <?php echo $student->course_strand; ?>
                        </td>
                        <td>
                            <span class="badge badge-outline">
                                <?php echo $student->year_level; ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($student->status == 'Present'): ?>
                                <span class="badge bg-success text-white">Present</span>
                            <?php else: ?>
                                <span class="badge bg-danger text-white">Absent</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .bg-success {
        background-color: var(--success);
    }

    .bg-danger {
        background-color: var(--danger);
    }

    .text-white {
        color: #fff;
    }
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>