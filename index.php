<?php
require_once('vehicles.php');
$block = new Vehicles();
$block->createFile();
$indexLinks = $block->indexLinks();
?>

<h2>Vehicles with a VIN starting with "2": </h2>
<ul>
  <?php foreach($indexLinks as $link) :?>
    <li>
      <a href="<?php echo $link; ?>"><?php echo $link; ?></a>
    </li>
  <?php endforeach ;?>
</ul>