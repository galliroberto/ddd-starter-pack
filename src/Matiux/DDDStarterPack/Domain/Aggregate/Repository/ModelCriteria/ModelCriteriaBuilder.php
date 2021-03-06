<?php

namespace DDDStarterPack\Domain\Aggregate\Repository\ModelCriteria;

class ModelCriteriaBuilder
{
    private $andCriteria = [];
    private $orCriteria = [];

    private $sorting;
    private $page = 1;
    private $limit = 0;

    private function __construct()
    {
    }

    public static function create(): self
    {
        return new static();
    }

    public function withPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function withLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function withOrCriterion(string $field, $value, $operator = '='): self
    {
        $criterion = new Criterion($field, $value, $operator);

        array_push($this->orCriteria, $criterion);

        return $this;
    }

    public function withBetweenCriterion(string $field, $from, $to): self
    {
        $criterion = new Criterion($field, $from, '>=');
        array_push($this->andCriteria, $criterion);

        $criterion = new Criterion($field, $to, '<=');
        array_push($this->andCriteria, $criterion);

        return $this;
    }

    public function withAndCriterion(string $field, $value, $operator = '='): self
    {
        $criterion = new Criterion($field, $value, $operator);

        array_push($this->andCriteria, $criterion);

        return $this;
    }

    public function withOrder($sortField, $sortDirection): self
    {
        $order = new Sorting($sortField, $sortDirection);

        $this->sorting = $order;

        return $this;
    }

    public function build(): ModelCriteria
    {
        $modelCriteria = new ModelCriteria();
        $modelCriteria->setLimit($this->limit);
        $modelCriteria->setPage($this->page);

        if ($this->andCriteria) {

            $andCriteria = new AndCriteria();

            foreach ($this->andCriteria as $criterion) {

                $andCriteria->add($criterion);
            }

            $modelCriteria->addCriteria($andCriteria);
        }

        if ($this->orCriteria) {

            $orCriteria = new OrCriteria();

            foreach ($this->orCriteria as $criterion) {

                $orCriteria->add($criterion);
            }

            $modelCriteria->addCriteria($orCriteria);
        }

        if ($this->sorting) {
            $modelCriteria->addSorting($this->sorting);
        }

        return $modelCriteria;
    }
}
