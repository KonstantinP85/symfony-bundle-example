<?php

namespace St\AbstractService\Repository;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;

class SimpleFilter
{
    /**
     * @var RepositoryEnum
     */
    private RepositoryEnum $expression;

    /**
     * @var RepositoryEnum
     */
    private RepositoryEnum $comparison;

    /**
     * @var int|null
     */
    private ?int $page;

    /**
     * @var int|null
     */
    private ?int $countPerPage;

    /**
     * @var array|null
     */
    private ?array $filter;

    /**
     * @var string|null
     */
    private ?string $sort;

    /**
     * @var string|null
     */
    private ?string $order;

    public function __construct(
        $expression = RepositoryEnum::EXPRESSION_AND,
        $comparison = RepositoryEnum::COMPARISON_EQ,
        ?int $page = null,
        ?int $countPerPage = null,
        ?array $filter = null,
        ?string $sort = null,
        ?string $order = null
    ) {
        $this->expression = $expression;
        $this->comparison = $comparison;
        $this->page = $page;
        $this->countPerPage = $countPerPage;
        $this->filter = $filter;
        $this->sort = $sort;
        $this->order = $order;
    }

    /**
     * @return Criteria
     */
    public function getCriteria(): Criteria
    {
        $firstResult = (!is_null($this->page) && !is_null($this->countPerPage)) ? ($this->page - 1) * $this->countPerPage : null;

        return new Criteria(
            $this->buildExpression(),
            $this->buildOrdering(),
            $firstResult,
            !is_null($this->countPerPage)? $this->countPerPage : null
        );
    }

    /**
     * @return CompositeExpression|null
     */
    private function buildExpression(): ?CompositeExpression
    {
        if (!is_null($this->filter) && count($this->filter) > 0) {
            return new CompositeExpression(
                $this->expression->value,
                array_map(function($key, $value) {
                    return new Comparison(
                        $key,
                        $this->comparison->value,
                        $value,
                    );
                }, array_keys($this->filter), $this->filter)
            );
        }

        return null;
    }

    /**
     * @return array|null
     */
    private function buildOrdering(): ?array
    {
        if(!is_null($this->sort)) {
            return [$this->sort => !is_null($this->order) ? $this->order : 'asc'];
        }

        return null;
    }
}