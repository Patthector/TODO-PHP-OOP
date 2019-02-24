<?php

function compareArrays( $a, $b ){
	if( count( $a ) != count( $b ) ){
		return false;
	}
	#all the elements should be the same value
	foreach( $a as $key=>$value){

		if( $value != $b[$key] )return false;
	}
	return true;
}