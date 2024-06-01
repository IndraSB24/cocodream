<?= $this->include('partials/main') ?>

    <head>
        
    <?= $title_meta ?>
        <!-- twitter-bootstrap-wizard css -->
        <link rel="stylesheet" href="assets/libs/twitter-bootstrap-wizard/prettify.css">

        <?= $this->include('partials/head-css') ?>
    </head>

    <?= $this->include('partials/body') ?>
        <!-- Begin page -->
        <div id="layout-wrapper">

        <?= $this->include('partials/menu') ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                            <?= $page_title ?>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Basic pills Wizard</h4>

                                        <div id="basic-pills-wizard" class="twitter-bs-wizard">
                                            <ul class="twitter-bs-wizard-nav">
                                                <li class="nav-item">
                                                    <a href="#seller-details" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">01</span>
                                                        <span class="step-title">Seller Details</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#company-document" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">02</span>
                                                        <span class="step-title">Company Document</span>
                                                    </a>
                                                </li>
                                                
                                                <li class="nav-item">
                                                    <a href="#bank-detail" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">03</span>
                                                        <span class="step-title">Bank Details</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#confirm-detail" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">04</span>
                                                        <span class="step-title">Confirm Detail</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content twitter-bs-wizard-tab-content">
                                                <div class="tab-pane" id="seller-details">
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basicpill-firstname-input">First name</label>
                                                                    <input type="text" class="form-control" id="basicpill-firstname-input">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basicpill-lastname-input">Last name</label>
                                                                    <input type="text" class="form-control" id="basicpill-lastname-input">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basicpill-phoneno-input">Phone</label>
                                                                    <input type="text" class="form-control" id="basicpill-phoneno-input">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basicpill-email-input">Email</label>
                                                                    <input type="email" class="form-control" id="basicpill-email-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basicpill-address-input">Address</label>
                                                                    <textarea id="basicpill-address-input" class="form-control" rows="2"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="company-document">
                                                  <div>
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basicpill-pancard-input">PAN Card</label>
                                                                    <input type="text" class="form-control" id="basicpill-pancard-input">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basicpill-vatno-input">VAT/TIN No.</label>
                                                                    <input type="text" class="form-control" id="basicpill-vatno-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basicpill-cstno-input">CST No.</label>
                                                                    <input type="text" class="form-control" id="basicpill-cstno-input">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basicpill-servicetax-input">Service Tax No.</label>
                                                                    <input type="text" class="form-control" id="basicpill-servicetax-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basicpill-companyuin-input">Company UIN</label>
                                                                    <input type="text" class="form-control" id="basicpill-companyuin-input">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="basicpill-declaration-input">Declaration</label>
                                                                    <input type="text" class="form-control" id="basicpill-declaration-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                  </div>
                                                </div>
                                                <div class="tab-pane" id="bank-detail">
                                                    <div>
                                                      <form>
                                                          <div class="row">
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label class="form-label" for="basicpill-namecard-input">Name on Card</label>
                                                                      <input type="text" class="form-control" id="basicpill-namecard-input">
                                                                  </div>
                                                              </div>
  
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label>Credit Card Type</label>
                                                                      <select class="form-select">
                                                                            <option selected>Select Card Type</option>
                                                                            <option value="AE">American Express</option>
                                                                            <option value="VI">Visa</option>
                                                                            <option value="MC">MasterCard</option>
                                                                            <option value="DI">Discover</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label class="form-label" for="basicpill-cardno-input">Credit Card Number</label>
                                                                      <input type="text" class="form-control" id="basicpill-cardno-input">
                                                                  </div>
                                                              </div>
  
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label class="form-label" for="basicpill-card-verification-input">Card Verification Number</label>
                                                                      <input type="text" class="form-control" id="basicpill-card-verification-input">
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label class="form-label" for="basicpill-expiration-input">Expiration Date</label>
                                                                      <input type="text" class="form-control" id="basicpill-expiration-input">
                                                                  </div>
                                                              </div>
  
                                                          </div>
                                                      </form>
                                                    </div>
                                                  </div>
                                                <div class="tab-pane" id="confirm-detail">
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-6">
                                                            <div class="text-center">
                                                                <div class="mb-4">
                                                                    <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                                                </div>
                                                                <div>
                                                                    <h5>Confirm Detail</h5>
                                                                    <p class="text-muted">If several languages coalesce, the grammar of the resulting</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <ul class="pager wizard twitter-bs-wizard-pager-link">
                                                <li class="previous"><a href="javascript: void(0);">Previous</a></li>
                                                <li class="next"><a href="javascript: void(0);">Next</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Wizard with progressbar</h4>

                                        <div id="progrss-wizard" class="twitter-bs-wizard">
                                            <ul class="twitter-bs-wizard-nav nav-justified">
                                                <li class="nav-item">
                                                    <a href="#progress-seller-details" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">01</span>
                                                        <span class="step-title">Seller Details</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#progress-company-document" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">02</span>
                                                        <span class="step-title">Company Document</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="#progress-bank-detail" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">03</span>
                                                        <span class="step-title">Bank Details</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#progress-confirm-detail" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">04</span>
                                                        <span class="step-title">Confirm Detail</span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <div id="bar" class="progress mt-4">
                                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div>
                                            </div>
                                            <div class="tab-content twitter-bs-wizard-tab-content">
                                                <div class="tab-pane" id="progress-seller-details">
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">First name</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-firstname-input">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-lastname-input">Last name</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-lastname-input">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-phoneno-input">Phone</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-phoneno-input">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-email-input">Email</label>
                                                                    <input type="email" class="form-control" id="progress-basicpill-email-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-address-input">Address</label>
                                                                    <textarea id="progress-basicpill-address-input" class="form-control" rows="2"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="progress-company-document">
                                                  <div>
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-pancard-input">PAN Card</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-pancard-input">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">VAT/TIN No.</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-vatno-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">CST No.</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-servicetax-input">Service Tax No.</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-servicetax-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-companyuin-input">Company UIN</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-companyuin-input">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-declaration-input">Declaration</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-declaration-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                  </div>
                                                </div>
                                                <div class="tab-pane" id="progress-bank-detail">
                                                    <div>
                                                      <form>
                                                          <div class="row">
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label class="form-label" for="progress-basicpill-namecard-input">Name on Card</label>
                                                                      <input type="text" class="form-control" id="progress-basicpill-namecard-input">
                                                                  </div>
                                                              </div>
  
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label>Credit Card Type</label>
                                                                      <select class="form-select">
                                                                            <option selected>Select Card Type</option>
                                                                            <option value="AE">American Express</option>
                                                                            <option value="VI">Visa</option>
                                                                            <option value="MC">MasterCard</option>
                                                                            <option value="DI">Discover</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label class="form-label" for="progress-basicpill-cardno-input">Credit Card Number</label>
                                                                      <input type="text" class="form-control" id="progress-basicpill-cardno-input">
                                                                  </div>
                                                              </div>
  
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label class="form-label" for="progress-basicpill-card-verification-input">Card Verification Number</label>
                                                                      <input type="text" class="form-control" id="progress-basicpill-card-verification-input">
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label class="form-label" for="progress-basicpill-expiration-input">Expiration Date</label>
                                                                      <input type="text" class="form-control" id="progress-basicpill-expiration-input">
                                                                  </div>
                                                              </div>
  
                                                          </div>
                                                      </form>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="progress-confirm-detail">
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-6">
                                                            <div class="text-center">
                                                                <div class="mb-4">
                                                                    <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                                                </div>
                                                                <div>
                                                                    <h5>Confirm Detail</h5>
                                                                    <p class="text-muted">If several languages coalesce, the grammar of the resulting</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="pager wizard twitter-bs-wizard-pager-link">
                                                <li class="previous"><a href="javascript: void(0);">Previous</a></li>
                                                <li class="next"><a href="javascript: void(0);">Next</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                
                <?= $this->include('partials/footer') ?>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        <?= $this->include('partials/right-sidebar') ?>
        <!-- /Right-bar -->

        <?= $this->include('partials/vendor-scripts') ?>
        
        <!-- twitter-bootstrap-wizard js -->
        <script src="assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

        <script src="assets/libs/twitter-bootstrap-wizard/prettify.js"></script>

        <!-- form wizard init -->
        <script src="assets/js/pages/form-wizard.init.js"></script>

        <script src="assets/js/app.js"></script>

    </body>
</html>
