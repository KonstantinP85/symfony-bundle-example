<?php

namespace St\AbstractService\Repository;

use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;

enum RepositoryEnum: string
{
    case EXPRESSION_OR = 'OR';

    case EXPRESSION_AND = 'AND';

    case COMPARISON_EQ = '=';

    case COMPARISON_CONTAINS = 'CONTAINS';
}
