
<?php foreach ( $mainMenus as $mainMenu ): ?>
<a href="<?=$mainMenu->url?>" target="<?=$mainMenu->target?>"><?=$mainMenu->name?> </a>
<?php endforeach; ?>
<br>
<br>
<?php foreach ( $subMenus as $subMenu ): ?>
<a href="<?=$subMenu->url?>" target="<?=$subMenu->target?>"><?=$subMenu->name?></a>
<?php endforeach; ?> 

<br>
<br>

<?=$this->load->views($content_view)?>
<br>
<br>
footer