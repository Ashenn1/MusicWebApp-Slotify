<?php

	class Song{

		private $con;
		private $id;
		private $mysqliData;
		private $title;
		private $artistId;
		private $albumId;
		private $genreId;
		private $duration;
		private $songPath;

		public function __construct($con , $id){
			$this->con = $con;
			$this->id = $id;

			$songQuery =  mysqli_query($this->con , "SELECT * FROM songs WHERE id = '$this->id'");
			$this->mysqliData = mysqli_fetch_array($songQuery);

			$this->title = $this->mysqliData['title'];
			$this->artistId = $this->mysqliData['artist'];
			$this->albumId = $this->mysqliData['album'];
			$this->genreId = $this->mysqliData['genre'];
			$this->duration = $this->mysqliData['duration'];
			$this->songPth = $this->mysqliData['path'];

		}

		public function getTitle(){
			return $this->title;
		}

		public function getartist(){
			return new Artist($this->con , $this->artistId);
		}

		public function getAlbum(){
			return new Album($this->con , $this->albumId);
		}

		public function getgenre(){
			return $this->genreId;
		}

		public function getDuration(){
			return $this->duration;
		}

		public function getPath(){
			return $this->path;
		}

		public function getMysqliData(){
			return $this->mysqliData;
		}

	}



?>