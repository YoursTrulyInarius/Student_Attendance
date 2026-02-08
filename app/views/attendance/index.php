<?php require_once '../app/views/layouts/header.php'; ?>

<h1>Mark Attendance</h1>
<p style="color: var(--text-muted);">Select a subject and date to record attendance</p>

<?php flash('attendance_message'); ?>

<div class="card mb-3">
    <form action="<?php echo BASE_URL; ?>attendances" method="POST"
        style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
        <div class="form-group" style="flex: 2; min-width: 200px; margin-bottom: 0;">
            <label for="subject_id">Select Subject</label>
            <select name="subject_id" id="subject_id" required>
                <option value="">-- Select Subject --</option>
                <?php foreach ($data['subjects'] as $subject): ?>
                    <option value="<?php echo $subject->id; ?>" <?php echo $data['selected_subject'] == $subject->id ? 'selected' : ''; ?>>
                        <?php echo $subject->subject_name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group" style="flex: 1; min-width: 150px; margin-bottom: 0;">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" value="<?php echo $data['date']; ?>" required>
        </div>
        <button type="submit" name="select_subject" class="btn btn-dark" style="height: 42px;">Load Students</button>
    </form>
</div>

<?php if (!empty($data['students'])): ?>
    <form action="<?php echo BASE_URL; ?>attendances/save" method="POST">
        <input type="hidden" name="subject_id" value="<?php echo $data['selected_subject']; ?>">
        <input type="hidden" name="date" value="<?php echo $data['date']; ?>">

        <div class="card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['students'] as $student): ?>
                            <tr>
                                <td style="font-weight: 600; color: var(--secondary-color);">
                                    <?php echo $student->student_id; ?>
                                </td>
                                <td>
                                    <?php echo $student->full_name; ?>
                                </td>
                                <td>
                                    <?php
                                    $status = isset($data['existing_attendance'][$student->id]) ? $data['existing_attendance'][$student->id] : 'Present';
                                    ?>
                                    <div style="display: flex; gap: 1rem;">
                                        <label class="radio-label">
                                            <input type="radio" name="status[<?php echo $student->id; ?>]" value="Present" <?php echo $status == 'Present' ? 'checked' : ''; ?>> Present
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" name="status[<?php echo $student->id; ?>]" value="Absent" <?php echo $status == 'Absent' ? 'checked' : ''; ?>> Absent
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" name="status[<?php echo $student->id; ?>]" value="Late" <?php echo $status == 'Late' ? 'checked' : ''; ?>> Late
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 2rem; text-align: right; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                <button type="submit" name="save_attendance" class="btn btn-primary" style="padding: 0.75rem 2rem;">Save
                    Attendance</button>
            </div>
        </div>
    </form>
<?php elseif (isset($_POST['select_subject'])): ?>
    <div class="alert alert-info">No students enrolled in this subject.</div>
<?php endif; ?>

<?php require_once '../app/views/layouts/footer.php'; ?>