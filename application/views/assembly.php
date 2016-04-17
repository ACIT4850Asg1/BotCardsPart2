<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/styles.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<div align="Center">
	<div class="container-fluid" >
		<div class="row equal" >
			<div class="panel panel-primary">
    		<div class="panel-heading">Head cards</div>
    		<div class="panel-body"> {Head}</div>
			</div>


			<div class="panel panel-primary">
    		<div class="panel-heading">Body Cards</div>
    		<div class="panel-body"> {Body}</div>
			</div>

			<div class="panel panel-primary">
    		<div class="panel-heading">Leg Cards</div>
    		<div class="panel-body"> {Leg}</div>
			</div>
		</div>
		<button onclick="window.location.assign('/index.php/Welcome/Buy')"><img src="/assets/img/button.png" alt="Submit"></button>
	</div>
	<div class="panel panel-primary">
    		<div class="panel-heading">Assembled Bot</div>
    		<div class="panel-body"> {assemble}</div>
    </div>
	
	<button onclick="window.location.assign('/index.php/Assembly/assemble/'+document.getElementById('Head').value + '/' + 
					document.getElementById('Body').value + '/' + document.getElementById('Leg').value)"> Assemble </button>
	<button onclick="sellFunction()"> Sell </button>
	</div>
