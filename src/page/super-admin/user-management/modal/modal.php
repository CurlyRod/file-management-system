<div class="modal fade" id="add-user-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg">
        <div class=" modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add User Account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-user-form">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Firstname</label>
                                <input type="text" class="form-control" id="fname" name="fname">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Middlename</label>
                                <input type="text" class="form-control" id="mname" name="mname">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Lastname</label>
                                <input type="text" class="form-control" id="lname" name="lname">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Password</label>

                                <div class="input-group">
                                    <input type="password" class="form-control" name="user-password" id="user-password">

                                    <button type="button" class="btn btn-secondary" onclick="togglePassword()">
                                        <i id="toggleIcon" data-feather="eye-off"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3"> 
                            <label class="form-label">User role</label>
                                <select class="form-select" aria-label="Default select example" name="user-role">
                                    <option value="1">Super Admin</option>
                                    <option value="2">Admin</option>
                                    <option value="3">Client</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="save-user-btn" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 


<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog modal-lg">
    <form id="edit-user-form">
      <input type="hidden" id="edit-id" name="edit-id" />
      <div class="modal-content">
        <div class="modal-header">
          <h5>Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
        <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Firstname</label>
                                <input type="text" class="form-control" id="editfnameModal" name="editfnameModal">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Middlename</label>
                                <input type="text" class="form-control" id="editmnameModal" name="editmnameModal">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Lastname</label>
                                <input type="text" class="form-control" id="editlnameModal" name="editlnameModal">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" class="form-control" id="editemailModal" name="editemailModal"
                                    aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3"> 
                            <label class="form-label">User role</label>
                                <select class="form-select" aria-label="Default select example" name="edit-user-role-modal">
                                    <option value="1">Super Admin</option>
                                    <option value="2">Admin</option>
                                    <option value="3">Client</option>
                                </select>
                            </div>
                        </div>
                    </div>
                   
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>
