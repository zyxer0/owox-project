<?php

namespace App\Paginator;

use App\DB\QueryBuilder\Builder;
use App\DB\Database;
use App\Core\Config;
use App\Http\Request;

class Paginator implements PaginatorInterface
{

    private $currentPage;
    private $db;
    private $queryBuilder;
    private $entitiesCount;
    private $config;

    public function __construct(Database $db, Builder $queryBuilder, Request $request)
    {
        // TODO Изменить GET на Request()
        $this->currentPage  = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->config       = Config::getInstance();
        $this->db           = $db;
        $this->queryBuilder = $queryBuilder;

        $query = $this->queryBuilder->count()->getSQL();
        $this->db->makeQuery($query);
        $this->entitiesCount = $this->db->result('count');
    }

    public function getQuery(): Builder
    {
        $start = ($this->currentPage-1)*$this->config->get('articlesPerPage');
        $this->queryBuilder->limit($start, $this->config->get('articlesPerPage'));
        return $this->queryBuilder;
    }

    public function getLinks(): array
    {
        $currentURL = explode('?', $_SERVER['REQUEST_URI'], 2)[0]; // TODO change this!!!
        $totalPagesNum = ceil($this->entitiesCount/$this->config->get('articlesPerPage'));
        $paginationActiveLinks = $this->config->get('paginationActiveLinks');
        $pageFrom = 1;
        if ($this->currentPage > floor($paginationActiveLinks/2)) {
            $pageFrom = max(1, $this->currentPage-floor($paginationActiveLinks/2)-1);
        }
        if ($this->currentPage > $totalPagesNum-ceil($paginationActiveLinks/2)) {
            $pageFrom = max(1, $totalPagesNum-$paginationActiveLinks-1);
        }
        $pageTo = min($pageFrom+$paginationActiveLinks, $totalPagesNum-1);

        if ($this->currentPage > 1) {
            $link['url'] = $currentURL.($this->currentPage > 2 ? '?page='.($this->currentPage - 1) : '');
            $link['isLink'] = true;
            $link['isActive'] = false;
            $link['anchor'] = '&laquo;';
            $result[] = $link;
        }

        if ($this->currentPage == 1) {
            $link['url'] = '';
            $link['isLink'] = false;
            $link['isActive'] = true;
            $link['anchor'] = '1';
            $result[] = $link;
        } else {
            $link['url'] = $currentURL;
            $link['isLink'] = true;
            $link['isActive'] = false;
            $link['anchor'] = '1';
            $result[] = $link;
        }

        for ($i=$pageFrom; $i < $pageTo; ++$i) {
            $p = $i+1;
            if (($p == $pageFrom+1 && $p!=2) || ($p == $pageTo && $p != $totalPagesNum-1)) {
                $link['url'] = $currentURL.'?page='.$p;
                $link['isLink'] = true;
                $link['isActive'] = false;
                $link['anchor'] = '...';
            } elseif ($p == $this->currentPage) {
                $link['url'] = $currentURL.'?page='.$p;
                $link['isLink'] = true;
                $link['isActive'] = true;
                $link['anchor'] = $p;
            } else {
                $link['url'] = $currentURL.'?page='.$p;
                $link['isLink'] = true;
                $link['isActive'] = false;
                $link['anchor'] = $p;
            }
            $result[] = $link;
        }

        if ($this->currentPage == $totalPagesNum) {
            $link['url'] = '';
            $link['isLink'] = false;
            $link['isActive'] = false;
            $link['anchor'] = $totalPagesNum;
        } else {
            $link['url'] = $currentURL.'?page='.$totalPagesNum;
            $link['isLink'] = true;
            $link['isActive'] = false;
            $link['anchor'] = $totalPagesNum;
        }
        $result[] = $link;

        if ($this->currentPage<$totalPagesNum) {
            $link['url'] = $currentURL.'?page='.($this->currentPage+1);
            $link['isLink'] = true;
            $link['isActive'] = false;
            $link['anchor'] = '&raquo';
            $result[] = $link;
        }

        return $result;
    }
}
