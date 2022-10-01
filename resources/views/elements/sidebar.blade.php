<div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
                    <li>
                        <a href="{{ route('index') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-networking"></i>
							<span class="nav-text">Dashboard</span>
						</a>
					</li>
                    <li>
                        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-list-1"></i>
							<span class="nav-text">Absensi</span>
						</a>
                        <ul aria-expanded="false">
							<li><a href="{{ route('attendances.create') }}" class="ai-icon"><i class="flaticon-381-add"></i><span class="nav-text">Tambah Absensi</span></a></li>
						</ul>
                        <ul aria-expanded="false">
							<li><a href="{{ route('attendances.index') }}" class="ai-icon"><i class="flaticon-381-notepad"></i><span class="nav-text">Daftar Absensi</span></a></li>
						</ul>
                    </li>
                    <li>
                        <a href="{{ route('periods.index') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-folder-8"></i>
							<span class="nav-text">Rekap Absensi</span>
						</a>
					</li>
                    <li>
                        <a href="{{ route('permissions.index') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-send-2"></i>
							<span class="nav-text">Perizinan</span>
						</a>
					</li>
                    <li>
                        <a href="{{ route('students.index') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-user-9"></i>
							<span class="nav-text">Siswa</span>
						</a>
					</li>
                    <li>
                        <a href="{{ route('classrooms.index') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-home-2"></i>
							<span class="nav-text">Kelas</span>
						</a>
					</li>
                    @can('admin')
                    <li>
                        <a href="{{ route('teachers.index') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-user-8"></i>
							<span class="nav-text">Wali Kelas</span>
						</a>
					</li>
                    @endcan
                    <li>
                        <a href="{{ route('change.edit') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-user-7"></i>
							<span class="nav-text">User Management</span>
						</a>
					</li>
                    <!-- <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-television"></i>
							<span class="nav-text">Apps</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{!! url('/app-profile'); !!}">Profile</a></li>
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Email</a>
                                <ul aria-expanded="false">
                                    <li><a href="{!! url('/email-compose'); !!}">Compose</a></li>
                                    <li><a href="{!! url('/email-inbox'); !!}">Inbox</a></li>
                                    <li><a href="{!! url('/email-read'); !!}">Read</a></li>
                                </ul>
                            </li>
                            <li><a href="{!! url('/app-calender'); !!}">Calendar</a></li>
							<li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Shop</a>
                                <ul aria-expanded="false">
                                    <li><a href="{!! url('/ecom-product-grid'); !!}">Product Grid</a></li>
									<li><a href="{!! url('/ecom-product-list'); !!}">Product List</a></li>
									<li><a href="{!! url('/ecom-product-detail'); !!}">Product Details</a></li>
									<li><a href="{!! url('/ecom-product-order'); !!}">Order</a></li>
									<li><a href="{!! url('/ecom-checkout'); !!}">Checkout</a></li>
									<li><a href="{!! url('/ecom-invoice'); !!}">Invoice</a></li>
									<li><a href="{!! url('/ecom-customers'); !!}">Customers</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-controls-3"></i>
							<span class="nav-text">Charts</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{!! url('/chart-flot'); !!}">Flot</a></li>
                            <li><a href="{!! url('/chart-morris'); !!}">Morris</a></li>
                            <li><a href="{!! url('/chart-chartjs'); !!}">Chartjs</a></li>
                            <li><a href="{!! url('/chart-chartist'); !!}">Chartist</a></li>
                            <li><a href="{!! url('/chart-sparkline'); !!}">Sparkline</a></li>
                            <li><a href="{!! url('/chart-peity'); !!}">Peity</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-internet"></i>
							<span class="nav-text">Bootstrap</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{!! url('/ui-accordion'); !!}">Accordion</a></li>
                            <li><a href="{!! url('/ui-alert'); !!}">Alert</a></li>
                            <li><a href="{!! url('/ui-badge'); !!}">Badge</a></li>
                            <li><a href="{!! url('/ui-button'); !!}">Button</a></li>
                            <li><a href="{!! url('/ui-modal'); !!}">Modal</a></li>
                            <li><a href="{!! url('/ui-button-group'); !!}">Button Group</a></li>
                            <li><a href="{!! url('/ui-list-group'); !!}">List Group</a></li>
                            <li><a href="{!! url('/ui-media-object'); !!}">Media Object</a></li>
                            <li><a href="{!! url('/ui-card'); !!}">Cards</a></li>
                            <li><a href="{!! url('/ui-carousel'); !!}">Carousel</a></li>
                            <li><a href="{!! url('/ui-dropdown'); !!}">Dropdown</a></li>
                            <li><a href="{!! url('/ui-popover'); !!}">Popover</a></li>
                            <li><a href="{!! url('/ui-progressbar'); !!}">Progressbar</a></li>
                            <li><a href="{!! url('/ui-tab'); !!}">Tab</a></li>
                            <li><a href="{!! url('/ui-typography'); !!}">Typography</a></li>
                            <li><a href="{!! url('/ui-pagination'); !!}">Pagination</a></li>
                            <li><a href="{!! url('/ui-grid'); !!}">Grid</a></li>

                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-heart"></i>
							<span class="nav-text">Plugins</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{!! url('/uc-select2'); !!}">Select 2</a></li>
                            <li><a href="{!! url('/uc-nestable'); !!}">Nestedable</a></li>
                            <li><a href="{!! url('/uc-noui-slider'); !!}">Noui Slider</a></li>
                            <li><a href="{!! url('/uc-sweetalert'); !!}">Sweet Alert</a></li>
                            <li><a href="{!! url('/uc-toastr'); !!}">Toastr</a></li>
                            <li><a href="{!! url('/map-jqvmap'); !!}">Jqv Map</a></li>
                        </ul>
                    </li>
                    <li><a href="{!! url('/widget-basic'); !!}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-settings-2"></i>
							<span class="nav-text">Widget</span>
						</a>
					</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-notepad"></i>
							<span class="nav-text">Forms</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{!! url('/form-element'); !!}">Form Elements</a></li>
                            <li><a href="{!! url('/form-wizard'); !!}">Wizard</a></li>
                            <li><a href="{!! url('/form-editor-summernote'); !!}">Summernote</a></li>
                            <li><a href="{!! url('/form-pickers'); !!}">Pickers</a></li>
                            <li><a href="{!! url('/form-validation-jquery'); !!}">Jquery Validate</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-network"></i>
							<span class="nav-text">Table</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{!! url('/table-bootstrap-basic'); !!}">Bootstrap</a></li>
                            <li><a href="{!! url('/table-datatable-basic'); !!}">Datatable</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-layer-1"></i>
							<span class="nav-text">Pages</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{!! url('/page-register'); !!}">Register</a></li>
                            <li><a href="{!! url('/page-login'); !!}">Login</a></li>
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Error</a>
                                <ul aria-expanded="false">
                                    <li><a href="{!! url('/page-error-400'); !!}">Error 400</a></li>
                                    <li><a href="{!! url('/page-error-403'); !!}">Error 403</a></li>
                                    <li><a href="{!! url('/page-error-404'); !!}">Error 404</a></li>
                                    <li><a href="{!! url('/page-error-500'); !!}">Error 500</a></li>
                                    <li><a href="{!! url('/page-error-503'); !!}">Error 503</a></li>
                                </ul>
                            </li>
                            <li><a href="{!! url('/page-lock-screen'); !!}">Lock Screen</a></li>
                        </ul>
                    </li> -->
                </ul>
            
				<!-- <div class="add-menu-sidebar">
					<p>Generate Monthly Credit Report</p>
					<a href="javascript:void(0);">
					<svg width="24" height="12" viewBox="0 0 24 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M23.725 5.14889C23.7248 5.14861 23.7245 5.14828 23.7242 5.148L18.8256 0.272997C18.4586 -0.0922062 17.865 -0.0908471 17.4997 0.276184C17.1345 0.643169 17.1359 1.23675 17.5028 1.602L20.7918 4.875H0.9375C0.419719 4.875 0 5.29472 0 5.8125C0 6.33028 0.419719 6.75 0.9375 6.75H20.7917L17.5029 10.023C17.1359 10.3882 17.1345 10.9818 17.4998 11.3488C17.865 11.7159 18.4587 11.7172 18.8256 11.352L23.7242 6.477C23.7245 6.47672 23.7248 6.47639 23.7251 6.47611C24.0923 6.10964 24.0911 5.51414 23.725 5.14889Z" fill="white"/>
					</svg>
					</a>
				</div> -->
				<div class="copyright">
					<p><strong>Chrev - Crypto Admin Dashboard</strong> © 2020 All Rights Reserved</p>
					<p>Made with <i class="fa fa-heart"></i> by DexignZone</p>
				</div>
			</div>
        </div>