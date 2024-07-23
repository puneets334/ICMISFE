<!-- Side Panel Starts -->
<div class="sidePanel hide">
				<div class="leftPanel">
					<div class="dashLeftNavSection">
						<div class="menu-close-sec">
							<a href="javascript:void(0)" class="main-menu-close"> <span
									class="mdi mdi-close-circle-outline"></span></a>
						</div>
						<div class="menu-profile-sec">
							<div class="profile-img">
								<img src="<?php  echo base_url('newBackend/images/profile-img.png'); ?>" alt="">
							</div>
							<div class="profile-info">
								<h6><?=!empty(session()->get('login')['type_name']) ? ucfirst(strtolower((session()->get('login')['name']))) . ' [' . session()->get('login')['type_name'] . ']' : ucfirst(strtolower((session()->get('login')['name']))) ?></h3>
								<a href="<?php echo base_url('Signout'); ?>"  class="profile-link link-txt"><span
											class="mdi mdi-circle-edit-outline"></span></a></h6>
								<a href="" class="profile-lnk link-txt">User Profile</a>
							</div>
						</div>
						<nav class=" mean-nav">
							<ul class="dashboardLeftNav accordion" id="accordionExample">
								<li class="health "><a href="dashboard.html">Dashboard</a></li>
								<li class="health">
									<a href="javascript:void(0)" class="accordion-button collapsed btn-link"
										type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
										aria-expanded="false" aria-controls="collapseOne">Cases
									</a>
									<ul id="collapseOne" class="submenu accordion-collapse collapse"
										aria-labelledby="headingOne" data-bs-parent="#accordionExample">
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
									</ul>
								</li>
								<li class="health ">
									<a href="javascript:void(0)" class="accordion-button collapsed btn-link"
										type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
										aria-expanded="false" aria-controls="collapseTwo">Add Advocate
									</a>
									<ul id="collapseTwo" class="submenu accordion-collapse collapse"
										aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
									</ul>
								</li>
								<li class="health ">
									<a href="javascript:void(0)" class="accordion-button collapsed btn-link"
										type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
										aria-expanded="false" aria-controls="collapseThree">Support
									</a>
									<ul id="collapseThree" class="submenu accordion-collapse collapse"
										aria-labelledby="headingThree" data-bs-parent="#accordionExample">
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
									</ul>
								</li>
								<li class="health ">
									<a href="javascript:void(0)" class="accordion-button collapsed btn-link"
										type="button" data-bs-toggle="collapse" data-bs-target="#collapse4"
										aria-expanded="false" aria-controls="collapse4">Resources
									</a>
									<ul id="collapse4" class="submenu accordion-collapse collapse"
										aria-labelledby="heading4" data-bs-parent="#accordionExample">
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
									</ul>
								</li>
								<li class="health ">
									<a href="javascript:void(0)" class="accordion-button collapsed btn-link"
										type="button" data-bs-toggle="collapse" data-bs-target="#collapse5"
										aria-expanded="false" aria-controls="collapse5">Transferred Cases
									</a>
									<ul id="collapse5" class="submenu accordion-collapse collapse"
										aria-labelledby="heading5" data-bs-parent="#accordionExample">
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
									</ul>
								</li>
								<li class="health ">
									<a href="javascript:void(0)" class="accordion-button collapsed btn-link"
										type="button" data-bs-toggle="collapse" data-bs-target="#collapse6"
										aria-expanded="false" aria-controls="collapse6">Advance Vacation List
									</a>
									<ul id="collapse6" class="submenu accordion-collapse collapse"
										aria-labelledby="heading6" data-bs-parent="#accordionExample">
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
										<li><a href="javascript:void(0)">Demo Sub Menu</a></li>
									</ul>
								</li>
								<li class="premium"><a href="javascript:void(0)" class="btn-link">Settings</a> </li>
								<li class="report"><a href="<?php echo base_url('signout'); ?>" class="btn-link">Logout</a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
			<!-- Side Panel Ends -->