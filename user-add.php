<?php 
include 'authentication.php';
include 'includes/header.php';
?>

<div class="container-fluid px-4">
    <h3 class="mt-3"></h3>


    <div class="row at-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add User</h4>
                </div>
                <div class="card-body">
                <form action="functions.php" method="POST">
                        <div class="row">
                            <div id="msg" class="form-group"></div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Lastname</label>
                                        <input type="text" class="form-control form-control-sm" name="lastname"  required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" >Firstname</label>
                                        <input type="text" class="form-control form-control-sm" name="firstname" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" >Username</label>
                                    <input type="text" class="form-control form-control-sm" name="username" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" >Password</label>
                                    <input type="password" class="form-control form-control-sm" name="password" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Role as</label>
                                    <select name="role" id="role" required class="form-control form-control-sm">
                                        <option value="">--Select Role--</option>
                                        <option value="1" >Admin</option>
                                        <option value="0" >User</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4 mb-0">
                                <button type="submit" name="user-add" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div>
                </form> 

                
                </div>
            </div>
        </div>    
    </div>
</div>


<?php 
include 'includes/footer.php';
include 'includes/script.php';
?>
