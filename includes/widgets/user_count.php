<div class="widget">
	<h2>Users</h2>
	<div class="inner">
	We currently have <?php foreach (user_count() as $COUNT['user_id'] => $value) {
		echo $value;
	}
	$suffix=($value!=1)?'s':'' ;
	?> 
	user<?php echo $suffix ;?>.
	</div>
</div>
 