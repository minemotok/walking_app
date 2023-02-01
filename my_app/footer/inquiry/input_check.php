<?PHP
class Errorcheckform
{
  public $error_message = array();
  public $escape = array();
  // 入力文字のチェック
  public function word_error_check($input_word, $word_item)
  {
    if (empty($_POST[$input_word])) {
      return $this->error_message[] = $word_item . 'を入力してください';
    } else {
      return $this->escape[$input_word] = htmlspecialchars($_POST[$input_word], ENT_QUOTES, 'UTF-8');
    }
  }
  // 数値のみのチェック
  public function number_error_check($input_number, $number_item)
  {
    if (is_numeric($_POST[$input_number]) === false) {
      return $this->error_message[] = $number_item . 'は数字のみで入力してください';
    } else {
      return $this->escape[$input_number] = htmlspecialchars($_POST[$input_number], ENT_QUOTES, 'UTF-8');
    }
  }
  // 部分入力されていないかチェック(３つチェックできる)
  public function all_input_check($first_value, $second_value, $third_value)
  {
    if (!empty($_POST[$first_value]) && !empty($_POST[$second_value]) && !empty($_POST[$third_value])) {
    } else {
      return $this->error_message[] = '郵便番号・都道府県・住所はセットで入力してください';
    }
  }
}
// 郵便番号とメールアドレスの正規表現チェッククラス
class Checkexpansion extends Errorcheckform
{
  // 数値チェック(郵便番号の正規表現)拡張
  public function number_error_check($input_number, $number_item)
  {
    if (is_numeric($_POST[$input_number]) === false) {
      return $this->error_message[] = $number_item . 'は数値のみ入力可能です';
    } elseif (!preg_match("/^\d{3}\d{4}$/", $_POST[$input_number])) {
      return $this->error_message[] = $number_item . 'は例のような形で入力してください';
    } else {
      return $this->escape[$input_number] = htmlspecialchars($_POST[$input_number], ENT_QUOTES, 'UTF-8');
    }
  }
  // 文字チェック(メールアドレスの正規表現)拡張
  public function word_error_check($input_word, $word_item)
  {
    if (empty($_POST[$input_word])) {
      return $this->error_message[] = $word_item . 'を入力してください';
    } elseif (!preg_match("/^\w+([.|-]*\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $_POST[$input_word])) {
      return $this->error_message[] = $word_item . 'は例のような形で入力してください';
    } else {
      return $this->escape[$input_word] = htmlspecialchars($_POST[$input_word], ENT_QUOTES, 'UTF-8');
    }
  }
}

// 生年月日の正規表現チェック
class Birthdatecheck extends Errorcheckform
{
  // 数値チェック(生年月日の正規表現)拡張
  public function number_error_check($input_number, $number_item)
  {
    if (empty($_POST[$input_number])) {
      return $this->error_message[] = $number_item . 'を入力してください';
    } elseif (!preg_match("/^([1-2]{1}[089]{1}[0-9]{2})*([1-9]{1}|1[0-2]{1})*([1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})*$/", $_POST[$input_number])) {
      return $this->error_message[] = $number_item . 'は例のような形で入力してください';
    } else {
      return $this->escape[$input_number] = htmlspecialchars($_POST[$input_number], ENT_QUOTES, 'UTF-8');
    }
  }
}