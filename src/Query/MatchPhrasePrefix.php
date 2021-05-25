<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', MatchPhrasePrefix::class, MatchPhrasePrefixQuery::class);

/**
 * Match Phrase Prefix query.
 *
 * @author Jacques Moati <jacques@moati.net>
 * @author Tobias Schultze <http://tobion.de>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query-phrase-prefix.html
 * @deprecated since version 7.2.0, use the MatchPhraseQueryPrefixQuery class instead.
 */
class MatchPhrasePrefix extends MatchPhrase
{
    public const DEFAULT_MAX_EXPANSIONS = 50;

    /**
     * Set field max expansions.
     *
     * Controls to how many prefixes the last term will be expanded (default 50).
     *
     * @return $this
     */
    public function setFieldMaxExpansions(string $field, int $maxExpansions = self::DEFAULT_MAX_EXPANSIONS): self
    {
        return $this->setFieldParam($field, 'max_expansions', $maxExpansions);
    }
}
