<div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">Update Profile</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col mb-3">
                <form action="{{ route('updateProfile') }}" method="post">
                            @csrf
                      <label for="nameWithTitle" class="form-label">Email</label>
                      <input type="text" id="nameWithTitle" name="email" class="form-control" value="{{$admin->email}}">
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Password</label>
                      <input type="password" name="password" id="nameWithTitle" class="form-control">
                    </div>
                  </div>
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
