<?php

if (!defined('file_access')) {
    header('Location: ' . url . ' home');
}

function pagination($sql, $limit = 5) {
    $query = query($sql);
    if (num_rows($query) > 0) {
        $array = array();
        $page  = array('page' => '', 'link' => '');

        foreach (core_page() as $id => $p) {
            if ($p === 'cPage') {
                $page['page'] = $id + 1;
            }
            $page['link'] .= $p;

            if (count(core_page()) - 1 != $id) {
                $page['link'] .= '/';
            }
        }

        $npage = explode('/', $page['link']);
        $cpage = $npage[$page['page']];


        if ($cpage == 0) {
            $npage[$page['page']] = 1;
            core_header(printPage($npage));
        }

        $result = ceil(num_rows($query) / $limit);

        if ($cpage > $result) {
            $npage[$page['page']] = 1;
            core_header(printPage($npage));
        }

        $startResult = $cpage * $limit - $limit;

        $query = query($sql . " LIMIT $startResult,$limit");

        while ($row = fetch_assoc($query)) {
            $array[] = $row;
        }

        $pagination = array('prev' => $cpage - 1, 'next' => $cpage + 1, 'max' => $result);

        return array($pagination, $array);
    } else {
        return '';
    }
}

function printPage($array) {
    $string = '';

    foreach ($array as $id => $page) {
        $string .= $page;

        if (count($array) - 1 != $id) {
            $string .= '/';
        }
    }

    return $string;
}
