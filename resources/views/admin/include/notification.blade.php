                      @if($message = Session::get('success'))
                      <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                          <div class="col-md-7">
                        <div class="alert alert-primary alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button> <?php echo $message ?>
                        </div>
                        </div>
                        </div>
                      </div>
                      @endif

                      @if($message = Session::get('error'))
                      <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                          <div class="col-md-7">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button> <?php echo $message ?>
                        </div>
                        </div>
                        </div>
                      </div>
                      @endif