<?php
class SearchTextUtil {

	public static function getClosestMatch($keyword, $words) {

		// no shortest distance found, yet
		$closest = null;
		$shortest = - 1;

		// loop through words to find the closest
		foreach($words as $word) {

			// calculate the distance between the input word,
			// and the current word
			$lev = levenshtein($keyword, $word);

			// check for an exact match
			if ($lev == 0) {

				// closest word is this one (exact match)
				$closest = $word;
				$shortest = 0;

				// break out of the loop; we've found an exact match
				break;
			}

			// if this distance is less than the next found shortest
			// distance, OR if a next shortest word has not yet been found
			if ($lev <= $shortest || $shortest < 0) {
				// set the closest match, and shortest distance
				$closest = $word;
				$shortest = $lev;
			}
		}


		if ($shortest == 0) {
			return $closest;
		} else {
			$wordsArr = str_word_count($keyword, 1);
			if (count($wordsArr) > 1) {
				foreach($wordsArr as $val) {
					$closestTemp = self::getClosestMatch($val, $words);
					if (isset($closestTemp)) {
						return $closestTemp;
					}
				}
			}
		}

	}

	public static function getClosestMatch2($keyword, $words, $minMatchRate = 1) {

		$wordScores = array();

		foreach($words as $word) {
			$percent = 0;
			similar_text($word, $keyword, $percent);
			$wordScores[$word] = $percent;
		}

		arsort($wordScores, SORT_NUMERIC);

		$topWords = array();

		$topScore = 0;

		if (! isset($minMatchRate)) {
			$minMatchRate = 1;
		}

		foreach($wordScores as $key => $wordScore) {
			if ($wordScore < $minMatchRate) {
				continue;
			}
			if (empty($topWords)) {
				$topWords[] = $key;
				$topScore = $wordScore;
			} else {
				if ($wordScore == $topScore) {
					$topWords[] = $key;
				}
			}
		}

		if (count($topWords) > 1) {
			$wordScores = array();
			foreach($topWords as $word) {
				$word = strtolower($word);
				$percent = 0;
				similar_text($word, $keyword, $percent);
				$wordScores[$word] = $percent;
			}

			arsort($wordScores, SORT_NUMERIC);

			return array_shift(array_keys($wordScores));
		} else {
			return array_shift($topWords);
		}

	}

}