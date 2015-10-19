<?php

// Display errors
ini_set('display_errors', true);

// Initialise database connection
$mysqli = new mysqli('localhost', 'root', '901jumper', 'nouvel');

// Database class
class Database {
	protected $tableName = NULL;
	protected $tableColumns = NULL;

	// Insert values into database
	public function insert($mysqli, $values) {
		$query = "INSERT INTO " . $this->tableName;

		// Insert column names into query
		$query .= " (";
		for($i = 0; $i < count($this->tableColumns); $i++) {
			$query .= $this->tableColumns[$i];

			// Add commas (but not for last column name)
			if($i < count($this->tableColumns) - 1)
				$query .= ", ";
		}

		// Insert values into query
		$query .= ") VALUES (";
		for($i = 0; $i < count($values); $i++) {
			$query .= "'" . $values[$i] . "'";

			// Add commas (but not for last value)
			if($i < count($values) - 1)
				$query .= ", ";
		}

		$query .= ")";

		//$query = $mysqli->real_escape_string($query);

		$mysqli->query($query);
	}

	// Read values from the database
	// $whereClauses is an array of clauses
	public function read($mysqli, $values, $whereClauses) {
		// Set all table columns to be read if 'all' is supplied for $values
		if($values = 'all')
			$values = $this->tableColumns;

		$query = "SELECT ";

		for($i = 0; $i < count($values); $i++) {
			$query .= $values[$i];

			// Append comma for all except the last value
			if($i < count($values) - 1)
				$query .= ', ';
		}

		// Table name selection
		$query .= " FROM " . $this->tableName;

		// Append where clause
		if(!empty($whereClauses)) {
			for($i = 0; $i < count($whereClauses); $i++) {
				if($i >= 1)
					$query .= " AND " . $whereClauses[$i];
				else
					$query .= " WHERE " . $whereClauses[$i];
			}
		}

		$result = $mysqli->query($query);

		while($row = $result->fetch_assoc()) {
			print_r($row);
		}
	}
}



// Initialise book class
class Book extends Database {
	protected $tableName = 'books';
	protected $tableColumns = array(
		'id',
		'topic',
		'author',
		'title',
		'number_of_chapters',
		'number_of_pages'
	);

	protected $id;
	protected $topic;
	// Group of authors who contributed to the book
	// Given as an id identifier
	protected $publisher;
	protected $title;
	protected $numChapters;
	protected $numPages;

	// Constructor function
	public function __construct(
		$topic,
		$publisher,
		$title,
		$numChapters = NULL,
		$numPages = NULL
	) {
		$this->topic = $topic;
		$this->publisher = $publisher;
		$this->title = $title;
		$this->numChapters = $numChapters;
		$this->numPages = $numPages;
	}

	// Getter and setter methods
	public function setTitle($title) {
		$this->title = $title;
	}

	public function getTitle($title) {
		return $this->title;
	}
}


class Chapter extends Database {
	protected $tableName = 'chapters';
	protected $tableColumns = '';
	protected $type;
	protected $bookID;
	protected $title;
	protected $author;
	protected $numPages;
	protected $content;

	public function __construct(
		$type,
		$bookID,
		$title,
		$author,
		$numPages = NULL,
		$content = NULL
	) {
		$this->type = $type;
		$this->bookID = $bookID;
		$this->title = $title;
		$this->author = $author;
		$this->numPages = $numPages;
		$this->content = $content;
	}

	// Getter and setter methods
	public function setContent($content) {
		$this->content = $content;
	}

	public function getContent() {
		return $this->content;
	}
}

$matilda = new Book('Childrens Fiction', 'Roald Dahl', 'Matilda');

$valArray = array('Childrens Fiction', 'Roald Dahl', 'Matilda', 15, 256);

echo $matilda->read($mysqli, 'all', array('title = "Matilda"'));

