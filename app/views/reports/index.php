<?php require_once '../app/views/layouts/header.php'; ?>

<div class="no-print">
    <h1>Attendance Reports</h1>
    <p style="color: var(--text-muted);">Generate and view attendance reports</p>

    <div class="card mb-3">
        <form action="<?php echo BASE_URL; ?>reports" method="POST"
            style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
            <div class="form-group" style="flex: 1; min-width: 200px;">
                <label for="report_type">Report Type</label>
                <select name="report_type" id="report_type">
                    <option value="daily" <?php echo $data['report_type'] == 'daily' ? 'selected' : ''; ?>>Daily Report
                    </option>
                </select>
            </div>
            <div class="form-group" style="flex: 1; min-width: 200px;">
                <label for="subject_id">Filter by Subject (Optional)</label>
                <select name="subject_id" id="subject_id">
                    <option value="">All Subjects</option>
                    <?php foreach ($data['subjects'] as $subject): ?>
                        <option value="<?php echo $subject->id; ?>" <?php echo $data['subject_id'] == $subject->id ? 'selected' : ''; ?>>
                            <?php echo $subject->subject_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group" style="flex: 1; min-width: 200px;">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" value="<?php echo $data['date']; ?>">
            </div>
            <button type="submit" class="btn btn-dark" style="height: 42px;">Generate Report</button>
        </form>
    </div>
</div>

<?php if (!empty($data['results'])): ?>
    <div class="report-container card">
        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
            <div>
                <h2 style="margin-bottom: 0.25rem;">Attendance Report</h2>
                <p style="color: var(--text-muted);">Date: <?php echo date('F d, Y', strtotime($data['date'])); ?></p>
            </div>
            <button onclick="window.print()" class="btn btn-secondary no-print">Print / Export PDF</button>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['results'] as $row): ?>
                        <tr>
                            <td style="font-weight: 600; color: var(--secondary-color);">
                                <?php echo $row->student_id; ?>
                            </td>
                            <td>
                                <?php echo $row->full_name; ?>
                            </td>
                            <td>
                                <?php echo $row->subject_name; ?>
                            </td>
                            <td>
                                <span class="badge" style="background: <?php
                                echo ($row->status == 'Present') ? '#dcfce7' : (($row->status == 'Absent') ? '#fee2e2' : '#fef3c7');
                                ?>; color: <?php
                                echo ($row->status == 'Present') ? '#166534' : (($row->status == 'Absent') ? '#991b1b' : '#92400e');
                                ?>; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                    <?php echo $row->status; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <div class="alert alert-info">No records found for the selected criteria.</div>
<?php endif; ?>

<style>
    @media print {
        .no-print {
            display: none !important;
        }

        body {
            background-color: white;
        }

        .main-content {
            margin: 0;
            padding: 0;
        }

        .sidebar {
            display: none;
        }

        .top-nav {
            display: none;
        }

        .content-body {
            padding: 0;
        }

        table {
            border: 1px solid #ccc;
        }
    }
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>