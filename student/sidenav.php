<?php
//active menu tabs
if(empty(isset($_GET["page"]))){
$_GET["page"]="";
$window=$_GET["page"];	
}else{
$window=$_GET["page"];	
}
?>

<div class="main-container" id="main-container">
	<script type="text/javascript">
		try{ace.settings.check('main-container' , 'fixed')}catch(e){}
	</script>

	<div id="sidebar" class="sidebar                  responsive">
		<script type="text/javascript">
			try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
		</script>

		<div class="sidebar-shortcuts" id="sidebar-shortcuts">
			<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
				<button class="btn btn-success">
					<i class="ace-icon fa fa-signal"></i>
				</button>

				<button class="btn btn-info">
					<i class="ace-icon fa fa-pencil"></i>
				</button>

				<button class="btn btn-warning">
					<i class="ace-icon fa fa-users"></i>
				</button>

				<button class="btn btn-danger">
					<i class="ace-icon fa fa-cogs"></i>
				</button>
			</div>

			<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
				<span class="btn btn-success"></span>

				<span class="btn btn-info"></span>

				<span class="btn btn-warning"></span>

				<span class="btn btn-danger"></span>
			</div>
		</div><!-- /.sidebar-shortcuts -->
<?php
echo"
		<ul class='nav nav-list'>
			<li class='active'>
				<a href='index.php'>
					<i class='menu-icon fa fa-tachometer'></i>
					<span class='menu-text'> Dashboard </span>
				</a>

				<b class='arrow'></b>
			</li>
			<li class='";
				if($window=='view_courses' || $window=='enrolled_courses'){
					echo 'active open';
				}else{
				}
				echo"'>
				<a href='#' class='dropdown-toggle'>
					<i class='menu-icon fa fa-book'></i>
					<span class='menu-text'>Courses </span>

					<b class='arrow fa fa-angle-down'></b>
				</a>
				<b class='arrow'></b>
				<ul class='submenu'>
					
					<li class=''>
						<a href='index.php?page=view_courses'>
							<i class='menu-icon fa fa-caret-right'></i>
							View Courses
						</a>
						<b class='arrow'></b>
					</li>
					<li class=''>
						<a href='index.php?page=enrolled_courses'>
							<i class='menu-icon fa fa-caret-right'></i>
							Enrolled Courses
						</a>
						<b class='arrow'></b>
					</li>
				</ul>
			</li>
			<li class='";
				if($window=='assignments'){
					echo 'active open';
				}else{
				}
				echo"'>
				<a href='#' class='dropdown-toggle'>
					<i class='menu-icon fa fa-random'></i>
					<span class='menu-text'>Assignments</span>

					<b class='arrow fa fa-angle-down'></b>
				</a>
				<b class='arrow'></b>
				<ul class='submenu'>
					
					<li class=''>
						<a href='index.php?page=assignments'>
							<i class='menu-icon fa fa-caret-right'></i>
							Manage Assignments
						</a>
						<b class='arrow'></b>
					</li>
				</ul>
			</li>
			<li class='";
				if($window=='quizes' || $window=='marked_quizes'){
					echo 'active open';
				}else{
				}
				echo"'>
				<a href='#' class='dropdown-toggle'>
					<i class='menu-icon fa fa-bar-chart-o'></i>
					<span class='menu-text'>Quizes</span>

					<b class='arrow fa fa-angle-down'></b>
				</a>
				<b class='arrow'></b>
				<ul class='submenu'>
					
					<li class=''>
						<a href='index.php?page=quizes'>
							<i class='menu-icon fa fa-caret-right'></i>
							Manage Quizes
						</a>
						<b class='arrow'></b>
					</li>
					
				</ul>
			</li>
		</ul><!-- /.nav-list -->";
?>		

		<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
			<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
		</div>

		<script type="text/javascript">
			try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
		</script>
	</div>
