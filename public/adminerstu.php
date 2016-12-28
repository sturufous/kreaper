<?php
function adminer_object() {

	class AdminerSoftware extends Adminer {

		function name() {
			// custom name in title and heading
			return 'Software';
		}

		function permanentLogin() {
			// key used for permanent login
			return "2ad43683b0affcc27e1ad6ff777bc135";
		}

		function credentials() {
			// server, username and password for connecting to database
			return array('homestead', '', '');
		}

		function database() {
			// database name, will be escaped by Adminer
			return 'software';
		}

		function login($login, $password) {
			// validate user submitted credentials
			return ($login == 'admin' && $password == '');
		}

	}

	return new AdminerSoftware;
}

include "./adminer.php";
