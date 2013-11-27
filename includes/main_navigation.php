<!-- MAIN NAVIGATION WITH ICON CLASSES -->
<div id="main-navigation">
	<div class="nav-wrap clearfix">
		<div class="grid_3">
		
			<!-- Regular Navigation
				 Each nav item has a different class, you'll notice. This is what creates the different icons you see.
				 To add a new one, simply create a new PNG and create the class for it in "master.php" -->
				 
			<!-- The class "hide-on-mobile" will hide this navigation on a small mobile device. -->
			<ul class="hide-on-mobile">
				<li><a href="dashboard.php" class="dashboard active">Dashboard</a></li>
				<li><a href="grid.php" class="grid">Grid Styles</a></li>
				<li><a href="page.php" class="page">Page Layout</a></li>
				<li><a href="stats.php" class="stats">Statistics</a></li>
				<li><a href="gallery.php" class="gallery">Gallery</a></li>
				<li><a href="forms.php" class="forms">Form Styling</a></li>
				<li><a href="#" class="calendar">Calendar</a></li>
				<li><a href="#" class="users">Users</a></li>
				<li><a href="#" class="messages">Messages<span class="counter">4</span></a></li>
			</ul>
			
			<!-- The class "show-on-mobile" will show only this navigation on a small mobile device. It's a
			 	 dropdown select box that loads the page upon select. Dependant on JS within "custom.js" -->
			<div class="show-on-mobile">
				<div class="mobile-nav-wrap">
					<select name="navigation" class="mobile-navigation">
						<option value="">Choose a Page...</option>
						<option value="dashboard.php">Dashboard</option>
						<option value="grid.php">Grid Styles</option>
						<option value="page.php">Page Layout</option>
						<option value="stats.php">Statistics</option>
						<option value="gallery.php">Gallery</option>
						<option value="forms.php">Form Styling</option>
						<option value="#">Calendar</option>
						<option value="#">Users</option>
						<option value="#">Messages</option>
					</select>
				</div>
			</div>
		</div>
		<!-- END GRID_3 -->
		
		<!-- SEARCH BLOCK -->
		<div id="search" class="grid_1">
			<form action="dashboard.php">
				<input type="text" class="search" value="Search..." />
				<input type="submit" class="go" />
			</form>
		</div>
		<!-- END GRID_1 -->
		
	</div>
	<!-- END NAV WRAP -->
	
</div>
<!-- END MAIN NAVIGATION -->