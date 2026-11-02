<?php
// Script to check bounding client rects of key elements
$jsCode = <<< 'JS'
const sidebar = document.querySelector('.freynix-sidebar');
const mainPanel = document.querySelector('.main-content-panel');
const card = document.querySelector('.freynix-card');
const table = document.querySelector('.horizontal-table');
const header = document.querySelector('.freynix-header');
const innerHeader = document.querySelector('.inner-page-header');

console.log("=== LAYOUT RECT CHECK ===");
if (header) console.log("Header:", JSON.stringify(header.getBoundingClientRect()));
if (innerHeader) console.log("InnerHeader:", JSON.stringify(innerHeader.getBoundingClientRect()));
if (sidebar) console.log("Sidebar:", JSON.stringify(sidebar.getBoundingClientRect()));
if (mainPanel) console.log("MainPanel:", JSON.stringify(mainPanel.getBoundingClientRect()));
if (card) console.log("Card:", JSON.stringify(card.getBoundingClientRect()));
if (table) console.log("Table:", JSON.stringify(table.getBoundingClientRect()));

if (sidebar && mainPanel) {
    const sRect = sidebar.getBoundingClientRect();
    const mRect = mainPanel.getBoundingClientRect();
    console.log("Sidebar right:", sRect.right, "MainPanel left:", mRect.left);
    if (sRect.right > mRect.left && sRect.left < mRect.right) {
        console.log("OVERLAP DETECTED BETWEEN SIDEBAR AND MAINPANEL!");
    } else {
        console.log("No horizontal overlap between sidebar and mainPanel.");
    }
}
JS;

// Inject this into pages_output.html and run with Edge
$html = file_get_contents(__DIR__ . '/pages_output.html');
$html = str_replace('</body>', '<script>' . $jsCode . '</script></body>', $html);
file_put_contents(__DIR__ . '/test_pages_rect.html', $html);

echo "Created test_pages_rect.html\n";
?>

