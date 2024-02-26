<?php 
/*
 * Plugin Name:       Custom Column Dashboard
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       This is Custom Column Dashboard plugin. With the phone ..
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Muhammad Aniab
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */


 class CCD_custom_column{
	function __construct(){
		add_action("init", array( $this,"init") );
	}
	function init(  ) {
		add_filter("manage_posts_columns", array( $this,"add_columns") );
		add_action("manage_posts_custom_column", array( $this,"customize_column"),10, 2);

		add_filter("manage_pages_columns", array( $this,"add_page_column") );
		add_action("manage_pages_custom_column", array( $this,"customize_page_column") ,10,2);
		add_filter("manage_edit-page_sortable_columns", array( $this,"page_column_sorting") );
		// View Count Column
		add_filter("manage_posts_columns", array( $this,"add_view_count") );
		add_action("manage_posts_custom_column", array( $this,"manage_view_count"),10,2 );
		add_filter("the_content", array( $this,"add_content_meta") );
		// if single post visited 
		add_action("wp_head", array( $this,"single_post_view_count") );

		
	}

	




	

	// Pages codes..
	function add_page_column( $columns ) {
		$columns["ID"] = ("ID");
		return $columns;
	}

	function customize_page_column( $column, $post_id ) {
		if ( $column=='ID' ) {
			echo $post_id;
		}

	}

	function page_column_sorting( $columns ) {
		$columns['ID'] = 'ID';
		return	$columns;
	}

	// View counts function


	function add_content_meta( $content ) {

		$view="<p>Post View: ";
		$view_count= get_post_meta(get_the_ID(),"View Count", true );
		$view_count++;
		$count="</p>";
		$content.= $view. $view_count. $count;
		return $content;
	}
	function single_post_view_count() {
		if(is_single()) {

			$view_count= get_post_meta( get_the_ID(),"View Count", true );
			//$view_count=$view_count ? $view_count:0;
			$view_count++;
			update_post_meta( get_the_ID(),"View Count", $view_count) ;
	}
		else{
			$view_count= 0;
			update_post_meta( get_the_ID(),"View Count", $view_count);
		}
	}

	function add_view_count( $columns ) {
		$columns['View Count'] = ('View Count');
		return $columns;
	}

	function manage_view_count( $column, $post_id ) {
		if ( $column== 'View Count') {
			echo get_post_meta( $post_id,'View Count', true );
		}
	}

//post codes .....


	function add_columns( $columns ) {

		//$columns['Thumbnail'] = 'Thumbnail'; //How to add any key with value in an array
		$new_columns=[];
		foreach( $columns as $column_name => $column_data ) {
			if($column_name=='title'){
				$new_columns[$column_name]=$column_data; // Columns autometically added.
				$new_columns["Thumbnail"]="Thumbnail";
			}
			else {
				$new_columns[$column_name]=$column_data;
			}
			
		}
		return $new_columns ;
	}

	function customize_column( $column, $post_id ) {
		if($column=="Thumbnail"){
			if(has_post_thumbnail($post_id)){
				echo get_the_post_thumbnail( $post_id , [50,50]);
			}
			else
			echo "No Thumbnail";
			//echo "Data";
		}

	}

}

new CCD_custom_column();

















?>