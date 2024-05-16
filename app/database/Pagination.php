<?php

namespace app\database;

class Pagination
{
  private int $currentPage = 1;
  private int $totalPages;
  private int $linksPerPage = 5;
  private int $itemsPerPage = 10;
  private int $totalItems = 10;
  private string $pageIdentifier = 'page';

  public function setTotalItems(int $totalItems)
  {
    $this->totalItems = $totalItems;
  }

  public function setPageIdentifier(string $itentifier)
  {
    $this->pageIdentifier = $itentifier;
  }

  public function setItemsPerPage(int $itemsPerPage)
  {
    $this->itemsPerPage = $itemsPerPage;
  }

  public function getTotal()
  {
    return $this->totalItems;
  }

  public function getPerPage()
  {
    return $this->itemsPerPage;
  }

  public function calculations()
  {
    $this->currentPage = $_GET[$this->pageIdentifier] ?? 1;

    $offset = ($this->currentPage - 1) * $this->itemsPerPage;
    $this->totalPages = ceil($this->totalItems / $this->itemsPerPage);

    return "LIMIT {$this->itemsPerPage} OFFSET {$offset}";
  }

  public function dump()
  {
    return $this->calculations();
  }

  public function links()
  {
    $links = "<ul class='pagination'>";

    if ($this->currentPage > 1) {
      $previous = $this->currentPage - 1;
      $linkPage = http_build_query(array_merge($_GET, [$this->pageIdentifier => $previous]));
      $first = http_build_query(array_merge($_GET, [$this->pageIdentifier => 1]));
      $links .= "<li class='page-item'><a href='?{$linkPage}' class='page-link'>Anterior</a></li>";
      $links .= "<li class='page-item'><a href='?{$first}' class='page-link'>1</a></li>";
    }

    for ($i = $this->currentPage - $this->linksPerPage; $i <= $this->currentPage + $this->linksPerPage; $i++) {
      if ($i > 0 && $i <= $this->totalPages) {
        $class = $this->currentPage === $i ? 'active' : '';
        $linkPage = http_build_query(array_merge($_GET, [$this->pageIdentifier => $i]));
        $links .= "<li class='page-item {$class}'><a href=?{$linkPage} class='page-link'>{$i}</a></li>";
      }
    }

    if ($this->currentPage < $this->totalPages) {
      $next = $this->currentPage + 1;
      $linkPage = http_build_query(array_merge($_GET, [$this->pageIdentifier => $next]));
      $last = http_build_query(array_merge($_GET, [$this->pageIdentifier => $this->totalPages]));
      $links .= "<li class='page-item'><a href='?{$linkPage}' class='page-link'>Próxima</a></li>";
      $links .= "<li class='page-item'><a href='?{$last}' class='page-link'>{$this->totalPages}</a></li>";
    }

    $links .= "</ul>";

    return $links;
  }
}
