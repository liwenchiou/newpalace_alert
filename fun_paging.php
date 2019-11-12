<?php
/*
 * 分页函数
 * @param type $p
 * @param type $page
 */
function paging($p, $page)
{
    $str = "<ul class = 'pagination'>";
    $str .= "<li><a href = '?p=1'>第一頁</a></li>";
    if ($p == 1) {
        $str .= "<li class='disabled'><a href='javascript:;'>上一頁</a></li>";
    } else {
        $str .= "<li><a href='?p=".($p - 1)."'>上一頁</a></li>";
    }
    $active = '';
    for ($i = 1; $i <= $page; ++$i) {
        if ($p == $i) {
            $active = 'active';
        } else {
            $active = '';
        }
        $str .= "<li class='{$active}'><a href='?p={$i}'>{$i}</a></li>";
    }
    if ($p == $page) {
        $str .= "<li class='disabled'><a href='javascript:;'>下一頁</a></li>";
    } else {
        $str .= "<li><a href='?p=".($p + 1)."'>下一頁</a></li>";
    }
    $str .= "<li><a href='?p={$page}'>最後一頁</a></li>";
    $str .= '</ul>';

    return $str;
}
