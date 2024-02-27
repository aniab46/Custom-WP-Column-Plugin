<?php 

	add_action("init",function(){
		register_post_type('my_custom_post', [
			'label'=> 'Book',
			'public'=> true,
		]);
	});

?>