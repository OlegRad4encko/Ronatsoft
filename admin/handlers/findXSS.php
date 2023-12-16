<?php

function findXSS($param) {
  return htmlspecialchars($param,ENT_QUOTES);
}

 ?>
