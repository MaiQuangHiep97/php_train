<div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="<?php echo _WEB_ROOT;?>/dashboard">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <!-- product -->
                            <a class="nav-link" href="<?php echo _WEB_ROOT;?>/admin-product-list">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Product
                            </a>
                            <!-- category -->
                            <a class="nav-link" href="<?php echo _WEB_ROOT;?>/admin-cat-list">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Category
                            </a>
                            <!-- user -->
                            <a class="nav-link collapsed" href="<?php echo _WEB_ROOT;?>/admin-list-admin" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                User
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo _WEB_ROOT;?>/admin-list-admin.html">List Admin</a>
                                    <a class="nav-link" href="<?php echo _WEB_ROOT;?>/admin-list-user.html">List User</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="<?php echo _WEB_ROOT;?>/admin-order-list">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Order
                            </a>
                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>