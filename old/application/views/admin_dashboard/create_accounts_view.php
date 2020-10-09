<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>


    <div class="row">

        <div class="col-sm-4">

            <h3>Add new account</h3>

            <form action="<?= site_url( 'admin-dashboard/create-accounts-process' ) ?>" method="post">

                <div class="form-group">

                    <label>Account Type</label>

                    <select name="acc_type" class="form-control" required="">

                        <?php if ( $user_type_names !== FALSE ): ?>
                            <?php foreach ( $user_type_names as $utn ): ?>

                                <option value="<?= $utn ?>" <?= set_select( 'acc_type', $utn, ( $utn == 'parent' ? true : false ) ) ?>><?= $utn ?></option>

                            <?php endforeach; ?>
                        <?php endif; ?>

                    </select>

                </div>

                <div class="form-group">

                    <label>Username</label>

                    <p class="help-block">This will be used for sign in</p>

                    <input type="text" class="form-control" name="username" value="<?= set_value( 'username' ) ?>" placeholder="Choose username for the account holder" required="">

                </div>

                <div class="form-group">

                    <label>Password</label>

                    <input type="password" class="form-control" name="password" value="<?= set_value( 'password' ) ?>" placeholder="Password for the account" required="">

                </div>

                <div class="form-group">

                    <label>Account holder's full name</label>

                    <p class="help-block">This is just a display name</p>

                    <input type="text" class="form-control" name="full_name" value="<?= set_value( 'name' ) ?>" placeholder="Full name of the account holder">

                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Create Account</button>
                </div>

            </form>

        </div>

        <div class="col-sm-8">
            <h3>Accounts</h3>
            <?php if ( $accounts === false ): ?>
                <p class="text-danger text-center">No account found!</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $accounts as $account ): ?>
                                <tr>
                                    <td><?= $account['admin_name'] ?></td>
                                    <td><?= $account['admin_username'] ?></td>
                                    <td><?= $account['admin_user_type'] ?></td>
                                    <td>
                                        <?php if ( $this->session->userdata( 'user_id' ) != $account['admin_users_id'] ): ?>
                                            <a href="<?= site_url( 'admin-dashboard/delete-account/' . $account['admin_users_id'] ) ?>" onclick="return confirm('Do you really want to delete this?')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                                            <?php else: ?>
                                            <small>Current</small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </div>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>