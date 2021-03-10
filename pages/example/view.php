<?php

declare(strict_types=1);

use \Lib\Layout;

?>

<?php
Layout::head(); ?>

    <div>
        페이지 내용!
        <?= "my name is {$name}, {$age}." ?>
    </div>

    <!-- include your javascript here -->
    <!--<script></script>-->

<?php
Layout::foot(); ?>