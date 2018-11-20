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
    private $request;

    public function __construct(Database $db, Builder $queryBuilder, Request $request)
    {
        $this->request      = $request;
        $this->currentPage  = $this->request->query->get('page', 1);
        $this->config       = Config::getInstance();
        $this->db           = $db;
        $this->queryBuilder = $queryBuilder;

        $query = $this->queryBuilder->count()->getSQL();
        $this->db->makeQuery($query);
        $this->entitiesCount = $this->db->result('count');
    }

    public function getQuery(): Builder
    {
        $start = ($this->currentPage-1)*$this->config->get('itemsPerPage');
        $this->queryBuilder->limit($start, $this->config->get('itemsPerPage'));
        return $this->queryBuilder;
    }

    public function getLinks(): array
    {
        $totalPagesNum = ceil($this->entitiesCount/$this->config->get('itemsPerPage'));
        $paginationActiveLinks = $this->config->get('paginationActiveLinks');
        $pageFrom = 1;
        if ($this->currentPage > floor($paginationActiveLinks/2)) {
            $pageFrom = max(1, $this->currentPage-floor($paginationActiveLinks/2)-1);
        }
        if ($this->currentPage > $totalPagesNum-ceil($paginationActiveLinks/2)) {
            $pageFrom = max(1, $totalPagesNum-$paginationActiveLinks-1);
        }
        $pageTo = min($pageFrom+$paginationActiveLinks, $totalPagesNum-1);

        // Prev page
        if ($this->currentPage > 1) {
            // На первую страницу ссылка будет без параметра page
            if ($this->currentPage > 2) {
                $this->request->query->set('page', $this->currentPage - 1);
            } else {
                $this->request->query->remove('page');
            }
            $link['url'] = $this->request->getUri();
            $link['isLink'] = true;
            $link['isActive'] = false;
            $link['anchor'] = '&laquo;';
            $result[] = $link;
        }

        //first page
        if ($this->currentPage == 1) {
            $this->request->query->remove('page');
            $link['url'] = $this->request->getUri();
            $link['isLink'] = false;
            $link['isActive'] = true;
            $link['anchor'] = '1';
            $result[] = $link;
        } else {
            $this->request->query->remove('page');
            $link['url'] = $this->request->getUri();
            $link['isLink'] = true;
            $link['isActive'] = false;
            $link['anchor'] = '1';
            $result[] = $link;
        }

        for ($i=$pageFrom; $i < $pageTo; ++$i) {
            $p = $i+1;
            if (($p == $pageFrom+1 && $p!=2) || ($p == $pageTo && $p != $totalPagesNum-1)) {
                $this->request->query->set('page', $p);
                $link['url'] = $this->request->getUri();
                $link['isLink'] = true;
                $link['isActive'] = false;
                $link['anchor'] = '...';
            } elseif ($p == $this->currentPage) {
                $this->request->query->set('page', $p);
                $link['url'] = $this->request->getUri();
                $link['isLink'] = true;
                $link['isActive'] = true;
                $link['anchor'] = $p;
            } else {
                $this->request->query->set('page', $p);
                $link['url'] = $this->request->getUri();
                $link['isLink'] = true;
                $link['isActive'] = false;
                $link['anchor'] = $p;
            }
            $result[] = $link;
        }

        //last page
        $this->request->query->set('page', $totalPagesNum);
        $link['url'] = $this->request->getUri();
        $link['isLink'] = ($this->currentPage == $totalPagesNum) ? true : false;
        $link['isActive'] = false;
        $link['anchor'] = $totalPagesNum;
        $result[] = $link;

        //next page
        if ($this->currentPage<$totalPagesNum) {
            $this->request->query->set('page', $this->currentPage+1);
            $link['url'] = $this->request->getUri();
            $link['isLink'] = true;
            $link['isActive'] = false;
            $link['anchor'] = '&raquo';
            $result[] = $link;
        }

        return $result;
    }
}
