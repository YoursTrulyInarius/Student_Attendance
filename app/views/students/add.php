<?php require_once '../app/views/layouts/header.php'; ?>

<div class="card" style="max-width: 600px; margin: auto;">
    <div class="card">
        <form action="<?php echo BASE_URL; ?>students/add" method="POST">
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="text" name="student_id" id="student_id" value="<?php echo $data['student_id']; ?>"
                    class="<?php echo (!empty($data['student_id_err'])) ? 'is-invalid' : ''; ?>">
                <span class="error-text"
                    style="color: var(--complementary-color); font-size: 0.8rem;"><?php echo $data['student_id_err']; ?></span>
            </div>

            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" name="full_name" id="full_name" value="<?php echo $data['full_name']; ?>"
                    class="<?php echo (!empty($data['full_name_err'])) ? 'is-invalid' : ''; ?>">
                <span class="error-text"
                    style="color: var(--complementary-color); font-size: 0.8rem;"><?php echo $data['full_name_err']; ?></span>
            </div>

            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="course_strand">Course / Strand</label>
                    <input type="text" name="course_strand" id="course_strand"
                        value="<?php echo $data['course_strand']; ?>">
                </div>

                <div class="form-group">
                    <label for="year_level">Year Level</label>
                    <select name="year_level" id="year_level">
                        <option value="">Select Year Level</option>
                        <option value="Grade 11" <?php echo $data['year_level'] == 'Grade 11' ? 'selected' : ''; ?>>Grade
                            11</option>
                        <option value="Grade 12" <?php echo $data['year_level'] == 'Grade 12' ? 'selected' : ''; ?>>Grade
                            12</option>
                        <option value="1st Year" <?php echo $data['year_level'] == '1st Year' ? 'selected' : ''; ?>>1st
                            Year</option>
                        <option value="2nd Year" <?php echo $data['year_level'] == '2nd Year' ? 'selected' : ''; ?>>2nd
                            Year</option>
                        <option value="3rd Year" <?php echo $data['year_level'] == '3rd Year' ? 'selected' : ''; ?>>3rd
                            Year</option>
                        <option value="4th Year" <?php echo $data['year_level'] == '4th Year' ? 'selected' : ''; ?>>4th
                            Year</option>
                    </select>
                </div>
            </div>

            <div class="form-actions" style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Add Student</button>
                <a href="<?php echo BASE_URL; ?>students" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>