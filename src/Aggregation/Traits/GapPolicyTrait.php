<?php

namespace Elastica\Aggregation\Traits;

trait GapPolicyTrait
{
    /**
     * @return $this
     */
    public function setGapPolicy(string $policy): self
    {
        return $this->setParam('gap_policy', $policy);
    }
}
