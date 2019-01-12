<?php

function show_404()
{
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    include get_query_template('404');
    exit();
}