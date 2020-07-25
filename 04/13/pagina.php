<?php header('Content-type: text/xml', true);  ?>
<ajax-response>
<response type="element" id="div1"> <h1> Es la hora <?php print date("H:i:s"); ?> del <?php print date("d/m/Y"); ?> </h1> </response>
</ajax-response>
