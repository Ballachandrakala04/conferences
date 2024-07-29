<?php
// getTexts.php

header('Content-Type: application/json');

// Data to be returned (you can fetch this from a database or any other source)
$texts = [
    "chandrakala.",
    "nandu",
    "surendra"
];

// Return the data as JSON
echo json_encode($texts);
