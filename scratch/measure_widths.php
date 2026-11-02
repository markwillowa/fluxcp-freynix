<?php
$html = file_get_contents(__DIR__ . '/pages_output.html');
$measureScript = <<< 'HTML'
<div id="measure-result" style="position: fixed; top: 10px; right: 10px; background: red; color: white; padding: 20px; z-index: 99999; font-size: 16px;"></div>
<script>
window.onload = function() {
    var sidebar = document.querySelector('.freynix-sidebar');
    var mainPanel = document.querySelector('.main-content-panel');
    var card = document.querySelector('.freynix-card');
    var table = document.querySelector('.horizontal-table');
    var container = document.querySelector('.freynix-container');
    var grid = document.querySelector('.inner-layout-grid');
    
    var res = "Container: " + (container ? container.offsetWidth : 0) + "px\n" +
              "Grid: " + (grid ? grid.offsetWidth : 0) + "px\n" +
              "Sidebar: " + (sidebar ? sidebar.offsetWidth : 0) + "px\n" +
              "MainPanel: " + (mainPanel ? mainPanel.offsetWidth : 0) + "px\n" +
              "Card: " + (card ? card.offsetWidth : 0) + "px\n" +
              "Table: " + (table ? table.offsetWidth : 0) + "px\n";
    document.getElementById('measure-result').innerText = res;
    console.log(res);
};
</script>
HTML;

$html = str_replace('</body>', $measureScript . '</body>', $html);
file_put_contents(__DIR__ . '/test_measure.html', $html);
?>

