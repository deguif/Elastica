<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', MatchPhrase::class, MatchPhraseQuery::class);

/**
 * Match Phrase query.
 *
 * @author Jacques Moati <jacques@moati.net>
 * @author Tobias Schultze <http://tobion.de>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query-phrase.html
 * @deprecated since version 7.2.0, use the MatchPhraseQuery class instead.
 */
class MatchPhrase extends MatchPhraseQuery
{
}
