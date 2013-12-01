<?php
/**
 * Tictactoe
 *
 * PHP AI game. Challenge your friends.
 * Run in command line
 *
 * @author Alejandro Moraga <moraga86@gmail.com>
 */
class Tictactoe {
	/**
	 * Board
	 * @var array
	 */
	private $board = array(
		0 => array(null, null, null),
		1 => array(null, null, null),
		2 => array(null, null, null),
	);
	
	/**
	 * Players
	 * @var array
	 */
	private $players = array();
	
	/**
	 * Delay between players movements
	 * @var int
	 */
	private $delay;
	
	/**
	 * Creates a new Tictactoe
	 * @param int $delay Delay between players movements in seconds
	 */
	function __construct($delay=1) {
		$this->delay = $delay;
	}
	
	/**
	 * Set the players
	 * @param Player $player1 First player
	 * @param Player $player2 Second player
	 * @return void
	 */
	public function setPlayers(Player $player1, Player $player2) {
		$this->players = array('x' => $player1, 'o' => $player2);
	}
	
	/**
	 * Register a player movement.
	 * If a player set a invalid position the other player wins
	 * @param array $position The position
	 * @param string $cursor The player cursor
	 * @return boolean
	 */
	private function register($position, $cursor) {
		if (!is_array($position) || count($position) < 2)
			throw new Exception('invalid data');
			
		$row = array_shift($position);
		$col = array_shift($position);
		
		if (!is_numeric($row) || !is_numeric($col))
			throw new Exception('only numbers are accepted');

		if ($row > 2 || $col > 2)
			throw new Exception(sprintf('invalid coords (%d,%d)', $row, $col));
		
		if (!is_null($this->board[$row][$col]))
			throw new Exception(sprintf('invalid position (%d,%d)', $row, $col));
		
		$this->board[$row][$col] = $cursor;
		
		return true;
	}
	
	/**
	 * Prints the board
	 * @return void
	 */
	private function printBoard() {
		for ($i=0; $i < 3; $i++)
			echo implode(' | ', $this->board[$i])."\n";
		echo "\n";
	}
	
	/**
	 * Checks if there is a winner
	 * @return Player|false Returns the Player winner, FALSE otherwise
	 */
	private function has_winner() {
		$d1 = array();
		$d2 = array();
		
		for ($i=0; $i < 3; $i++) {
			$h = array();
			$v = array();
			
			for ($j=0; $j < 3; $j++) {
				// horizontal
				if ($h !== false && !is_null($this->board[$i][$j]) && (count($h) == 0 || in_array($this->board[$i][$j], $h)))
					$h[] = $this->board[$i][$j];
				else
					$h = false;
				
				// vertical	
				if ($v !== false && !is_null($this->board[$j][$i]) && (count($v) == 0 || in_array($this->board[$j][$i], $v)))
					$v[] = $this->board[$j][$i];
				else
					$v = false;
				
				// diagonal 1
				if ($i - $j == 0 && (count($d1) == 0 || in_array($this->board[$i][$j], $d1)))
					$d1[] = $this->board[$i][$j];
				
				// diagonal 2
				if ($i + $j == 2 && (count($d2) == 0 || in_array($this->board[$i][$j], $d2)))
					$d2[] = $this->board[$i][$j];
			}
			
			if ($h)
				return $this->players[$h[0]];
			
			if ($v)
				return $this->players[$v[0]];
		}

		if (count($d1) == 3)
			return $this->players[$d1[0]];

		if (count($d2) == 3)
			return $this->players[$d2[0]];

		return false;
	}
	
	/**
	 * Runs the game
	 * @return void
	 */
	public function run() {
		$playing = 'x';
		$moves = 0;
		
		while (true) {
			// draw
			if ($moves == 9)
				break;
			try {
				$this->register($this->players[$playing]->move($this->board, $playing), $playing);
				$this->printBoard();
				$playing = ($playing == 'x' ? 'o' : 'x');
				$moves++;
				sleep($this->delay);
				if ($moves >= 5)
					if ($winner = $this->has_winner())
						break;
			}
			catch (Exception $e) {
				exit(sprintf('Player %s lost: %s', get_class($this->players[$playing]), $e->getMessage()));
			}
		}
		
		exit(($winner ? 'Winner: '. get_class($winner) : 'draw') ."\n");
	}
}

?>