<?php

namespace application\lib;

class Pagination {

    private $max = 5;
    private $route;
    private $index = '';
    private $current_page;
    private $total;
    private $limit;

    public function __construct($route, $total, $limit = 10) {
        $this->route = $route;
        $this->total = $total;
        $this->limit = $limit;
        $this->amount = $this->amount();
        $this->setCurrentPage();
    }

    public function get($tag = null) {
        $links = null;
        $limits = $this->limits();
        $prev = $this->current_page > $limits[0] ? '/'.($this->current_page - 1) : '';
        $next = $this->current_page < $limits[1] ? '/'.($this->current_page + 1) : '';
        $html = '<a href="/blogg/'.($this->route['controller']=='admin'?$this->route['controller'].'/':'').$this->route['action'].$prev.
        (is_null($tag)?'':'?tag='.$tag).'" class="prev"><i class="fas fa-angle-left"></i></a>';
        for ($page = $limits[0]; $page <= $limits[1]; $page++) {
            if ($page == $this->current_page) {
                $html .= '<a href="#" class="num active">'.$page.'</a>';
            } else {
                $html .= '<a href="/blogg/'.($this->route['controller']=='admin'?$this->route['controller'].'/':'').$this->route['action'].'/'.$page.(is_null($tag)?'':'?tag='.$tag).'" class="num">'.$page.'</a>';
            }
        }
        $html .= '<a href="/blogg/'.($this->route['controller']=='admin'?$this->route['controller'].'/':'').$this->route['action'].$next.
        (is_null($tag)?'':'?tag='.$tag).'" class="next"><i class="fas fa-angle-right"></i></a>';
        return $html;
    }

    private function limits() {
        $left = $this->current_page - round($this->max / 2);
        $start = $left > 0 ? $left : 1;
        if ($start + $this->max <= $this->amount) {
            $end = $start > 1 ? $start + $this->max : $this->max;
        }
        else {
            $end = $this->amount;
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
        }
        return array($start, $end);
    }

    private function setCurrentPage() {
        if (isset($this->route['page'])) {
            $currentPage = $this->route['page'];
        } else {
            $currentPage = 1;
        }
        $this->current_page = $currentPage;
        if ($this->current_page > 0) {
            if ($this->current_page > $this->amount) {
                $this->current_page = $this->amount;
            }
        } else {
            $this->current_page = 1;
        }
    }

    private function amount() {
        return ceil($this->total / $this->limit);
    }
}
