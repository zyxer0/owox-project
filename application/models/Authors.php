<?php

namespace App\Models;

use App\Core\Model;
use App\DB\ActiveRecord\Author as AuthorActiveRecord;

class Authors extends Model
{
    public function getAuthorById(int $id)
    {
        $query = $this->queryBuilder->select([
            'a.id',
            'a.first_name',
            'a.last_name',
        ])
            ->from('authors', 'a')
            ->orderBy('a.last_name ASC')
            ->where('a.id='.$id)
            ->getSQL();

        $this->db->makeQuery($query);
        return $this->db->resultActiveRecord(AuthorActiveRecord::class);
    }

    public function getAllAuthors()
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