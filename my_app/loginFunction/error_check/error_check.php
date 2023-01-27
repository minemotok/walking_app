<?php
class Errorcheck {
  public $error_message = array();
  public $escape = array();
  public function input_error_check($input_name, $error_name, $word_count) {
    if(empty($_POST[$input_name])) {
        $this->error_message[] = $error_name . 'が入力されていません';
      } else if(strlen($_POST[$input_name]) > $word_count) {
        $this->error_message[] = $error_name . 'は' . $word_count . '文字以内にしてください';
      } else {
        $this->escape[$input_name] = htmlspecialchars($_POST[$input_name], ENT_QUOTES, 'UTF-8');
        return $this->escape;
    }
    return $this->error_message;
  }
}
?>