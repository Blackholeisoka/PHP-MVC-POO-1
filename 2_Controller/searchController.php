<?php
require_once '../1_Model/search.php';

if(isset($_POST['search']) && isset($_POST['content_type'])){
    $search_input = implode('', preg_split('/\s+/', trim($_POST['search'])));
    $content_type = $_POST['content_type'];

    $counter_start = isset($_POST['counter_start']) ? (int) $_POST['counter_start'] : 0;
    $counter_end = $counter_start + 15;

    $content_init = new Content($search_input, $content_type, $counter_start, $counter_end);
    $content_init->fetchContent();
    $contentResult = $content_init->content;
    $dataSize = $content_init->dataSize;
    $counterStart = $content_init->counter_start ?? 0;
}
?>