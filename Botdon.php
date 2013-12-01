<?php
/**
 * Bot that plays random
 */
class Botdon implements Player {
	public function move($data, $cursor) {
		$nulls = array();
		for ($i=0; $i < 3; $i++)
			for ($j=0; $j < 3; $j++)
				if (is_null($data[$i][$j]))
					$nulls[] = array($i, $j);
		return $nulls[rand(0, count($nulls) - 1)];
	}
}

?>