<?php

	class Album{

		private $con;
		private $id;
		private $title;
		private $artistId;
		private $genre;
		private $artworkPath;


		public function __construct($con , $id){
			$this->con = $con;
			$this->id = $id;

			$albumQuery =  mysqli_query($this->con , "SELECT * FROM album WHERE id = '$this->id'");
			$album = mysqli_fetch_array($albumQuery);

			$this->title = $album['title'];
			$this->artistId = $album['artist'];
			$this->genre = $album['genre'];
			$this->artworkPath = $album['artworkPath'];
		}

		public function getTitle(){		
			return $this->title;
		}

		public function getArtworkPath(){		
			return $this->artworkPath;
		}

		public function getGenre(){		
			return $this->genre;
		}

		public function getArtist(){		
			return new Artist($this->con , $this->artistId);
		}

		public function getNumberOfSongs(){
			$query = mysqli_query($this->con , "SELECT COUNT(*) FROM songs WHERE album = '$this->id'");
			$result = mysqli_fetch_array($query);
			return $result[0];
		}

		public function getSongIds(){
			$query = mysqli_query($this->con , "SELECT id FROM songs WHERE album='$this->id' 
				ORDER BY albumOrder ASC");
			$songIdsArray = array();
			while($row = mysqli_fetch_array($query)){
				array_push($songIdsArray , $row['id']);
			}

			return $songIdsArray;
		}

	}



?>