<?php
/**
 * Tictactoe Player interface
 */
interface Player {
	/**
	 * Make a play/move
	 * @param array $data Board
	 * @param string $cursor Self cursor
	 * @return array The movement (x, y)
	 */
	public function move($data, $cursor);
}

?>