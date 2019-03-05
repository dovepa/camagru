<?php

namespace App\HTML;

class Form{

	public $surround = 'p';
	public $type = "text";
	public $class = "form_fields";
	public $submit_class = "submit_fields";

	public function __construct($action = "#", $method = "POST"){
		print "<form action='".$action."' method='".$method."'>";
	}

	private function surround($html)
	{
		return "<{$this->surround}>$html</{$this->surround}>";
	}

	public function input($input_txt)
	{
		return ($this->surround($input_txt.' :').$this->surround('<input type="'.$this->type.'" name="'.$input_txt.'" class="'.$this->class.'">'));
	}

	public function area($input_txt, $rows, $cols, $defval)
	{
		return ($this->surround($input_txt.' :').$this->surround('<textarea rows="'.$rows.'" type="'.$this->type.'" class="'.$this->class.'" cols="'.$cols.'" name="'.$input_txt.'">
		'.$defval.'</textarea>'));
	}

	public function submit($submit_txt){
		return $this->surround('<button class="'.$this->submit_class.'"  type="submit" name="submit" value="'.$submit_txt.'">'.$submit_txt.'</button>');
	}

	public function __destruct(){
		print "</form>";
	}

}