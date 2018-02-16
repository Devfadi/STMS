<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>Teacher Portal</title>

	<meta name="description" content="overview &amp; stats" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.2.0/css/font-awesome.min.css" />

	<!-- text fonts -->
	<link rel="stylesheet" href="assets/fonts/fonts.googleapis.com.css" />

	<!-- ace styles -->
	<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
	<script src="assets/js/ace-extra.min.js"></script>
	<script>
		function calculate_marks(el)
		{
			$el = $(el);
			$row = $el.closest("tr");
			$marks = $row.find(".marks");
			marks = 0;
			$marks.each(function(ind, e){
				marks += parseFloat(e.value);
			})
			
			gpa = marks/20-1;
			console.log(gpa);

			$obtain = $row.find(".obtained");
			$obtain.val(marks);
			
			$gpa = $row.find(".gpa");
			$gpa.val(gpa);
		}
	</script>