<?php

namespace App\Services;

use App\Author;

class AuthorsService extends BaseService
{
    private $showRouteName = 'api.authors.show';

    const VALIDATION_RULES = [
        'name' => 'required',
        'description' => 'required',
    ];

    /**
     * @param Author $author
     * @return array
     */
    public function createdResponseData(Author $author)
    {
        return $this->createdResponseDataBase($author, $this->showRouteName);
    }

    /**
     * @param Author $author
     * @return array
     */
    public function updatedResponseData(Author $author)
    {
        $routeName = 'api.authors.show';
        return $this->updatedResponseDataBase($author, $this->showRouteName);
    }
}
