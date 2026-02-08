<?php require_once '../app/views/layouts/header.php'; ?>

<div class="dashboard-header mb-4">
    <h1 class="text-primary">Dashboard</h1>
    <p class="text-muted">Overview of attendance statistics and daily activity.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Students</h3>
        <div class="value">
            <span>👨‍🎓</span>
            <?php echo $data['stats']['total_students']; ?>
        </div>
        <div class="icon-bg">👨‍🎓</div>
    </div>
    <div class="stat-card">
        <h3>Total Subjects</h3>
        <div class="value">
            <span>📚</span>
            <?php echo $data['stats']['total_subjects']; ?>
        </div>
        <div class="icon-bg">📚</div>
    </div>
    <div class="stat-card">
        <h3>Teachers</h3>
        <div class="value">
            <span>👨‍🏫</span>
            <?php echo $data['stats']['total_teachers']; ?>
        </div>
        <div class="icon-bg">👨‍🏫</div>
    </div>
    <div class="stat-card border-accent">
        <h3>Present Today</h3>
        <div class="value text-accent">
            <span>✅</span>
            <?php echo $data['stats']['today_present']; ?>
        </div>
        <div class="icon-bg">✅</div>
    </div>
</div>

<div class="card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Today's Attendance Overview</h2>
        <a href="<?php echo BASE_URL; ?>attendances" class="btn btn-primary btn-sm">Mark Attendance</a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Students</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['today_overview'])): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="display-4 mb-2">📝</div>
                            No attendance recorded today yet.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($data['today_overview'] as $overview): ?>
                        <tr>
                            <td class="fw-bold"><?php echo $overview->subject_name; ?></td>
                            <td>
                                <a href="<?php echo BASE_URL; ?>dashboard/subject_attendance/<?php echo $overview->id; ?>"
                                    class="text-accent fw-bold text-decoration-none">
                                    <?php echo $overview->total_attendance; ?>
                                </a>
                            </td>
                            <td class="text-success fw-bold"><?php echo $overview->present_count; ?></td>
                            <td class="text-danger fw-bold"><?php echo $overview->absent_count; ?></td>
                            <td>
                                <?php
                                $percentage = ($overview->total_attendance > 0) ? round(($overview->present_count / $overview->total_attendance) * 100) : 0;
                                echo $percentage . '%';
                                ?>
                                <div class="progress-container">
                                    <div class="progress-bar" style="width: <?php echo $percentage; ?>%;"></div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>