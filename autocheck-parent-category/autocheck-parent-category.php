<?php
/*
Plugin Name: Autocheck Parent Category
Description: Automatically select the parent categories when a sub category is selected.
Version: 1.0
Author: Gowranga
*/
function parent_category_checker(){
    $taxonomies = apply_filters( 'parent_category_checker', array() );

    for( $x=0; $x<count( $taxonomies ); $x++ )
	{
		$taxonomies[$x] = '#'.$taxonomies[$x].'div .selectit input';
	}

    $selector = implode( ',', $taxonomies );

    if( $selector == '' ) $selector = '.selectit input';

    echo '
		<script>
		jQuery("'.$selector.'").change(function(){
			var $chk = jQuery(this);
			var ischecked = $chk.is(":checked");
			$chk.parent().parent().siblings().children("label").children("input").each(function(){
			var b = this.checked;
			ischecked = ischecked || b;
		})
		checkParentNodes( ischecked, $chk );
		});

		function checkParentNodes( b, $obj )
		{
			$prt = findParentObj( $obj );
			if ( $prt.length != 0 )
			{
			 $prt[0].checked = b;
			 checkParentNodes( b, $prt );
			}
		}
		function findParentObj( $obj )
		{
			return $obj.parent().parent().parent().prev().children("input");
		}
		</script>
		';
}

add_action( 'admin_footer-post.php', 'parent_category_checker' );
add_action( 'admin_footer-post-new.php', 'parent_category_checker' );
?>