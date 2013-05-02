<ul id="adminmenu">
	<LI id=menu-dashboard class="wp-first-item current menu-top menu-top-first menu-top-last">
		<DIV class=wp-menu-image><a href="index.php"><BR></a></DIV>
		<DIV style="DISPLAY: none" class=wp-menu-toggle ><BR></DIV>
		<A class="wp-first-item current menu-top menu-top-first menu-top-last" tabIndex=1 href="index.php">SuperAdmin</A>
	</LI>
	
		
	<li class="wp-first-item wp-menu-separator"><br /></li>
	
	<!-- products -->
	<li class="wp-has-submenu menu-top menu-top-first" id="menu-pages">
	    <div class="wp-menu-image"><br /></div>
	    <div class="wp-menu-toggle"><br /></div>
	    <a href='products_list.php' class="wp-has-submenu menu-top" tabindex="1"><strong>Products</strong></a>
	    <div class='wp-submenu'>
			<ul>
	        	<li><a href="products_list.php">View Products</a></li>
	        	<li><a href="products_edit.php">Create Products</a></li>
	            <li><a href="products_export.php">Export Products Data (.csv)</a></li>
	        </ul>
		</div>
	</li>
	<li class="wp-has-submenu menu-top menu-top-last">
		<a class="wp-has-submenu menu-top" tabindex="1"></a>
	</li>	
	
	<!-- store -->
	<li class="wp-has-submenu menu-top menu-top-first" id="menu-pages">
	    <div class="wp-menu-image"><br /></div>
	    <div class="wp-menu-toggle"><br /></div>
	    <a href='stores_list.php' class="wp-has-submenu menu-top" tabindex="1"><strong>Store</strong></a>
	    <div class='wp-submenu'>
			<ul>
	        	<li><a href="stores_list.php">View Store</a></li>
	        	<li><a href="stores_edit.php">Create Store</a></li>
	            <li><a href="stores_export.php">Export Store Data (.csv)</a></li>
	        </ul>
		</div>
	</li>
	<li class="wp-has-submenu menu-top menu-top-last">
		<a class="wp-has-submenu menu-top" tabindex="1"></a>
	</li>
	
	<!-- system setting -->
	<li class="wp-has-submenu menu-top menu-top-first" id="menu-settings">
	    <div class="wp-menu-image"><br /></div>
	    <div class="wp-menu-toggle"><br /></div>
	    <a href='configurations.php' class="wp-has-submenu menu-top" tabindex="1"><strong>System Settings</strong></a>
	    <div class='wp-submenu'>
			<ul>
				<li><a href="sendmessage.php">Send Message</a></li>
				<li><a href="about.php" >About for Mobile</a></li>
	        	<li><a href="configurations.php">Configuration</a></li>
				<li><a href="edit_profile.php" >Edit Profile</a></li>          
	        	<li><a href="change_password.php" >Change Password</a></li>
	        	<li><a href="logout.php">Logout</a></li>
	        </ul>
		</div>
	</li>
	<li class="wp-has-submenu menu-top menu-top-last">
		<a class="wp-has-submenu menu-top" tabindex="1"></a>
	</li>
</ul>