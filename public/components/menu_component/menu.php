<ul class="menu">
<?php
$i = 0;
$len = count($menuList);
foreach($menuList as $menu) {
	if($i<$len - 1)
		echo "<li><a id='".$menu["menu"]["id"]."' href='".BASE_PATH.$menu["menu"]["url"]."'>".$menu["menu"]["name"]."</a></li>";
	else
		echo "<li class='last-item'><a id='".$menu["menu"]["id"]."' href='".BASE_PATH.$menu["menu"]["url"]."'>".$menu["menu"]["name"]."</a></li>";
	$i++;
}
?>
</ul>