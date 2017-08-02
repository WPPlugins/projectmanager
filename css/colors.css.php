<?php if ( !empty($options['colors']['headers']) ) : ?>
table.projectmanager th {
	background-color: <?php echo $options['colors']['headers'] ?>
}
<?php endif; ?>
<?php if ( !empty($options['colors']['rows'][1]) ) : ?>
table.projectmanager tr {
	background-color: <?php echo $options['colors']['rows'][1] ?>
}
<?php endif; ?>
<?php if ( !empty($options['colors']['rows'][0]) ) : ?>
table.projectmanager tr.alternate {
	background-color: <?php echo $options['colors']['rows'][0] ?>
}
<?php endif; ?>
<?php if ( !empty($options['colors']['headers']) ) : ?>
fieldset.dataset {
	border-color: <?php echo $options['colors']['headers'] ?>
}
<?php endif; ?>
<?php if ( !empty($options['colors']['boxheader']) ) : ?>
<?php if ( !empty($options['colors']['boxheader'][1]) ) : ?>
div.projectmanager-list.accordion .list-header,
div.projectmanager-list.expandable .list-header,
div.dataset-container h3 {
	background: <?php echo $options['colors']['boxheader'][0] ?>;
	background: -moz-linear-gradient(top, <?php echo $options['colors']['boxheader'][0] ?> 0%, <?php echo $options['colors']['boxheader'][1] ?> 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, <?php echo $options['colors']['boxheader'][0] ?>), color-stop(100%, <?php echo $options['colors']['boxheader'][1] ?>));
	background: -webkit-linear-gradient(top, <?php echo $options['colors']['boxheader'][0] ?> 0%, <?php echo $options['colors']['boxheader'][1] ?> 100%);
	background: -o-linear-gradient(top, <?php echo $options['colors']['boxheader'][0] ?> 0%, <?php echo $options['colors']['boxheader'][1] ?> 100%);
	background: -ms-linear-gradient(top, <?php echo $options['colors']['boxheader'][0] ?> 0%, <?php echo $options['colors']['boxheader'][1] ?> 100%);
	background: linear-gradient(top, <?php echo $options['colors']['boxheader'][0] ?> 0%, <?php echo $options['colors']['boxheader'][1] ?> 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $options['colors']['boxheader'][0] ?>', endColorstr='<?php echo $options['colors']['boxheader'][1] ?>', GradientType=0 );
}
div.projectmanager-list.accordion .list-header:hover,
div.projectmanager-list.expandable .list-header:hover  {
	background: <?php echo $options['colors']['boxheader'][0] ?>;
	background: -moz-linear-gradient(top, <?php echo $options['colors']['boxheader'][1] ?> 0%, <?php echo $options['colors']['boxheader'][0] ?> 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, <?php echo $options['colors']['boxheader'][1] ?>), color-stop(100%, <?php echo $options['colors']['boxheader'][0] ?>));
	background: -webkit-linear-gradient(top, <?php echo $options['colors']['boxheader'][1] ?> 0%, <?php echo $options['colors']['boxheader'][0] ?> 100%);
	background: -o-linear-gradient(top, <?php echo $options['colors']['boxheader'][1] ?> 0%, <?php echo $options['colors']['boxheader'][0] ?> 100%);
	background: -ms-linear-gradient(top, <?php echo $options['colors']['boxheader'][1] ?> 0%, <?php echo $options['colors']['boxheader'][0] ?> 100%);
	background: linear-gradient(top, <?php echo $options['colors']['boxheader'][1] ?> 0%, <?php echo $options['colors']['boxheader'][0] ?> 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $options['colors']['boxheader'][1] ?>', endColorstr='<?php echo $options['colors']['boxheader'][0] ?>', GradientType=0 );
}
<?php else : ?>
div.projectmanager-list.accordion .list-header,
div.projectmanager-list.expandable .list-header,
div.dataset-container h3 {
	background-color: <?php echo $options['colors']['boxheader'][0] ?>;
}
<?php endif; ?>
<?php endif; ?>