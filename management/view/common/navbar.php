<!-- Navbar -->

<style>

        /* Untuk tampilan PC (lebih besar dari 1024px) */
        @media (min-width: 1025px) {
            .main-header{
                height: 50px;
            }
        }

        /* Untuk tampilan tablet dan HP (kurang dari atau sama dengan 1024px) */
        @media (max-width: 1024px) {
            .main-header{
                height: 75px;
            }
        }

        .nav .nav-treeview {
            width: 230px;
        }
</style>

<nav class="main-header navbar navbar-expand navbar-dark row">
    <!-- Left navbar links -->
    <ul class="navbar-nav col-6" style="float: left;">
        <li class="nav-item" style="display: flex;">
            <a style="margin: auto;" class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item">
            <p style="margin: auto;"><img src="img/organization/<?php echo $organization_logo; ?>" style="height: 50px; padding: 5px;">
        </li>
    </ul>
 
    <!-- Right navbar links -->
    <!--<ul class="navbar-nav ml-auto col-6" style="display: ruby; text-align: right;">
        <div class="row">
            <div class="col-sm-12 col-md-6" style="display: flex;">
                <ul class="navbar-nav" style="float: right;">
                    <li id="connection-status" class="nav-item dropdown" style="color: #48f9; display: flex; align-items: center; text-align: left; width: max-content;">
                        <i class="fas fa-circle mr-2"></i>  <b>Checking connection...</b>
                    </li>
                </ul>
            </div>
            <div class="col-sm-12 col-md-6"  style="display: flex; justify-content: space-around;">
                  <ul class="navbar-nav" style="float: right;">
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-comments"></i>
                            <span class="badge badge-danger navbar-badge">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <a href="#" class="dropdown-item">
                                Message Start 
                                <div class="media">
                                    <img src="dist/img/user1-128x128.jpg" alt="User Avatar"
                                        class="img-size-50 mr-3 img-circle">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            Brad Diesel
                                            <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">Call me whenever you can...</p>
                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                    </div>
                                </div>
                                Message End 
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                Message Start 
                                <div class="media">
                                    <img src="dist/img/user8-128x128.jpg" alt="User Avatar"
                                        class="img-size-50 img-circle mr-3">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            John Pierce
                                            <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">I got your message bro</p>
                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                    </div>
                                </div>
                                Message End 
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                Message Start 
                                <div class="media">
                                    <img src="dist/img/user3-128x128.jpg" alt="User Avatar"
                                        class="img-size-50 img-circle mr-3">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            Nora Silvester
                                            <span class="float-right text-sm text-warning"><i
                                                    class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">The subject goes here</p>
                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                    </div>
                                </div>
                                Message End 
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                        </div>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-bell"></i>
                            <span class="badge badge-warning navbar-badge">15</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-item dropdown-header">15 Notifications</span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-envelope mr-2"></i> 4 new messages
                                <span class="float-right text-muted text-sm">3 mins</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-users mr-2"></i> 8 friend requests
                                <span class="float-right text-muted text-sm">12 hours</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-file mr-2"></i> 3 new reports
                                <span class="float-right text-muted text-sm">2 days</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                            <i class="fas fa-th-large"></i>
                        </a>
                    </li> 
                </ul>
            </div>
        </div>
    </ul>-->
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto col-6 d-flex justify-content-end align-items-center">
        <li id="connection-status" class="nav-item d-flex align-items-center mr-3" style="color: #48f9;">
            <i class="fas fa-circle mr-2"></i> 
            <b class="d-none d-md-inline">Checking connection...</b>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>


</nav>
<!-- /.navbar -->
<script>
        function checkConnection() {
            $.ajax({
                url: 'view/common/check_connection.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var connectionStatus = $('#connection-status');
                    if (response.connected) {
                        connectionStatus.css('color', '#0f09');
                        connectionStatus.html('<i class="fas fa-circle mr-2"></i>  <b class="d-none d-md-inline">Connected to server</b>');
                    } else {
                        connectionStatus.css('color', '#f009');
                        connectionStatus.html('<i class="fas fa-circle mr-2"></i>  <b class="d-none d-md-inline">Disconnected from server</b>');
                    }
                },
                error: function() {
                    var connectionStatus = $('#connection-status');
                    connectionStatus.css('color', '#f009');
                    connectionStatus.html('<i class="fas fa-circle mr-2"></i>  <b class="d-none d-md-inline">Disconnected from server</b>');
                }
            });
        };
  </script>