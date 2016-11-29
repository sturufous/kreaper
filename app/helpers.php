<?php

function flash($label, $level='info') {
	Session::flash($label, 'Hello Stu!');
}