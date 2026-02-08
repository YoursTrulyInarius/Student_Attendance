<?php require_once '../app/views/layouts/header.php'; ?>

<div class="row mb-3" style="display: flex; justify-content: space-between; align-items: center;">
    <h1>User Management</h1>
    <a href="<?php echo BASE_URL; ?>users/add" class="btn btn-primary">Add New User</a>
</div>

<?php flash('user_message'); ?>

<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Full Name</th>
            <th>Role</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['users'] as $user): ?>
            <tr>
                <td>
                    <?php echo $user->username; ?>
                </td>
                <td>
                    <?php echo $user->full_name; ?>
                </td>
                <td>
                    <?php echo $user->role_name; ?>
                </td>
                <td>
                    <?php echo date('M d, Y', strtotime($user->created_at)); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../app/views/layouts/footer.php'; ?>