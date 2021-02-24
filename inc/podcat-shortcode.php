<?php
// Exit you access directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

global $wpdb;
$postType 		= 'podcast';
//$getpostLimit 	= get_option('podcastpostperpage', $podcastpostperpage);
//$getthumbnail 	= get_option('showhidethumbnail', $showhidethumbnail); 
$getpostLimit	= 6;
$getthumbnail	= "show";
$podcast_args 	= array('posts_per_page' => $getpostLimit,'post_type' => $postType,'post_status' => 'publish');
$podcast_Query 	= new WP_Query( $podcast_args );

echo "<div class='all-podcast-girds'>";
if( $podcast_Query->have_posts() ){
	echo "<div class='row'>";
		while( $podcast_Query->have_posts() ){ $podcast_Query->the_post();
		echo "<div class='col-sm-6'>
				<div class='podcast-grid'>
					<div class='row'>";
						if( $getthumbnail =="show" ){
						echo"<div class='col-sm-4'>
							<img src=".get_the_post_thumbnail_url()." class='podcast-img'>
						</div>";
						}
						if( $getthumbnail=='hide' ){
							echo"<div class='col-sm-12'>";
						}else{
							echo"<div class='col-sm-8'>";
						}
							echo "<span class='pdate'>".get_the_date('F j, Y')."</span>
							<h2 class='ptitle'>".get_the_title()."</h2>
							<p class='pcontent'>".wp_trim_words( get_the_content(), 10,'...' )."</p>
							<a href='".get_permalink()."' class='pread'>Read More</a>
						</div>
					</div>
				</div>";
		echo "</div>";
		}  wp_reset_postdata();
	echo "</div>";

}

//Pagination
$podcast_args_all 	= array('posts_per_page' => -1,'post_type' => $postType,'post_status' => 'publish');
$podcast_Query_all 	= new WP_Query( $podcast_args_all );
$podcast_Count  	= count($podcast_Query_all->posts);
$podcast_Lastpg     = ceil($podcast_Count/$getpostLimit);

$setPagination  = "";
	
	if( $podcast_Lastpg > 0 ){
		$setPagination .="<div class='row justify-content-center'>";
		$setPagination .="<div class='col-sm-6'>";
		$setPagination .="<ul class='list-podcast list-group list-group-horizontal'>";
		$setPagination .="<li class='pagitext list-group-item'><a href='javascript:void(0);' onclick='podcastajaxPagination(1,$getpostLimit)'>Prev</a></li>";
		
		for( $pod=1; $pod<=$podcast_Lastpg; $pod++){

			if( $pod ==  0 || $pod ==  1 ){ $active="active"; }else{ $active=""; }
			$setPagination .="<li class='pagitext list-group-item'><a href='javascript:void(0);' id='post' class='$active' data-posttype='$postType' data-thumb='$getthumbnail' onclick='podcastajaxPagination($pod,$getpostLimit);'>$pod</a></li>";

		}
		
		$setPagination .="<li class='pagitext list-group-item'><a href='javascript:void(0);' onclick='podcastajaxPagination(2,$getpostLimit)'>Next</a></li>";
		$setPagination .="</ul>";
		$setPagination .="</div>";
		$setPagination .="</div>";
	}

echo $setPagination;
echo "</div>";
