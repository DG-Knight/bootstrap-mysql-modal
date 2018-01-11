<div class="modal fade" id="addModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Insert User</h4>
      </div>
      <div class="modal-body" >
        <form method="post" id="insert-form">
          <label>Firstname</label>
          <input type="hidden" id="id" name="id" />
          <input type="text" name="first_name" id="fname" class="form-control" required />
          <label>Lastname</label>
          <input type="text" name="last_name" id="lname" class="form-control" required />
          <label>Email</label>
          <input type="email" name="email" id="email" class="form-control" required />
          <br>
          <input type="submit" id="insert" value="Save" class="btn btn-success" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default "id="close"  data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
