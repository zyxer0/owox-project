<?php

namespace App\Models;

use App\Core\Model;
use App\DB\ActiveRecord\Author as AuthorActiveRecord;

class Authors extends Model
{
    public function getAuthorsTagCloud()
    {
        $query = $this->queryBuilder->select([
            'a.id',
            'a.first_name',
            'a.last_name',
        ])
            ->from('authors', 'a')
            ->orderBy('a.last_name ASC')
            ->getSQL();

        $this->db->makeQuery($query);
        $authors = [];
        while ($author = $this->db->resultActiveRecord(AuthorActiveRecord::class)) {
            $authors[] = $author;
        }

        return $authors;
    }
}