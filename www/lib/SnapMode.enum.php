<?php

class SnapMode extends Enum {
	public static $Down;
	public static $Round;
	public static $Up;
	public static $__constructors = array(1 => 'Down', 2 => 'Round', 0 => 'Up');
	}
SnapMode::$Down = new SnapMode("Down", 1);
SnapMode::$Round = new SnapMode("Round", 2);
SnapMode::$Up = new SnapMode("Up", 0);
