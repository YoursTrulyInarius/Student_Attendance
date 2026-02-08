<?php require_once '../app/views/layouts/header.php'; ?>

<div class="card mx-auto" style="max-width: 600px;">
    <h2 class="mb-4">Add New User</h2>
    <form action="<?php echo BASE_URL; ?>users/add" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php echo $data['username']; ?>"
                placeholder="Enter username">
            <?php if (!empty($data['username_err'])): ?>
                <span class="text-danger small fw-bold mt-1 d-block">
                    <?php echo $data['username_err']; ?>
                </span>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" name="full_name" id="full_name" value="<?php echo $data['full_name']; ?>"
                placeholder="Enter full name">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="••••••••">
            <?php if (!empty($data['password_err'])): ?>
                <span class="text-danger small fw-bold mt-1 d-block">
                    <?php echo $data['password_err']; ?>
                </span>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="role_id">Role</label>
            <select name="role_id" id="role_id">
                <?php foreach ($data['roles'] as $role): ?>
                    <option value="<?php echo $role->id; ?>">
                        <?php echo $role->role_name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="d-flex gap-3 mt-4">
            <button type="submit" class="btn btn-primary">Save User</button>
            <a href="<?php echo BASE_URL; ?>users/manage" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>