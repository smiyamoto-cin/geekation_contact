<?php
require_once('../Models/ContactModel.php');

class ContactController
{
    private $request; //リクエストパラメーター(GET,POST)WEBリクエストに関連する情報を格納
    private $Contact; //Contactモデルのインスタンスを格納

    //findAll用
    public function __construct()
    {
        //リクエストパラメーターの取得
        $this->request['GET'] = $_GET;
        $this->request['POST'] = $_POST; //それぞれ、$request配列の getおよびpostキーに格納される。

        // モデルオブジェクトの生成
        $this->Contact = new Contact();
        //別モデルと連携
        $dbh = $this->Contact->get_db_handler();
    }

    //index()メソッドは、このコントローラーのエントリーポイントとして機能
//一覧ページを表示するためのデータを準備
    public function index()
    {
        $instance = new Contact();
        $contacts = $instance->findAll();

        $params = [
            'contacts' => $contacts
        ];
        return $params;
    }

        //入力画面
    public function contact()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['fullname'] = htmlspecialchars($_POST['fullname'], ENT_QUOTES, 'UTF-8');
            $_SESSION['furigana'] = htmlspecialchars($_POST['furigana'], ENT_QUOTES, 'UTF-8');
            $_SESSION['tel'] = htmlspecialchars($_POST['tel'], ENT_QUOTES, 'UTF-8');
            $_SESSION['email'] = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
            $_SESSION['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

            $errors = $this->validate($_POST);

            if (!empty($errors)) {
                //エラーがある場合の対処
                foreach ($errors as $error) {
                    echo '<p>' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</p>';
                }
            } else {
                //エラーがなかった時→confirm.phpへ
                header('Location: /confirm.php');
                exit;
            }
        }
    }
    //編集画面
    public function edit()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $_SESSION['id'] = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
            $_SESSION['fullname'] = htmlspecialchars($_POST['fullname'], ENT_QUOTES, 'UTF-8');
            $_SESSION['furigana'] = htmlspecialchars($_POST['furigana'], ENT_QUOTES, 'UTF-8');
            $_SESSION['tel'] = htmlspecialchars($_POST['tel'], ENT_QUOTES, 'UTF-8');
            $_SESSION['email'] = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
            $_SESSION['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
        
            $errors =$this ->validate($_POST);
          
              if (!empty($errors)) {
                //エラーがある場合の対処
                foreach ($errors as $error) {
                echo '<p>' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</p>';
                }
                } else { 
                //エラーがなかった時→、入力画面contact.phpへ
                //DBを更新
                $dbh = (new DbModel())->dbConnect();
                $update = new ContactController();
                $result =$update ->update($_SESSION, $dbh);
                session_destroy();
                if ($result === true){
                    header('Location: /contact.php');
                    exit;
                }
                }
            }
        }
    //確認画面
    public function confirm()
    {
        // POSTデータが送信された場合
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $create = new ContactController();
            $result = $create->create($_SESSION);
            session_destroy();
            if ($result === true) {
                ob_end_clean();
                header('Location: /complete.php');
                exit;
            }
        }
    }
    //phpバリデーション
    public function validate($request)
    {
        $errors = [];
        //氏名のバリデーション
        if (empty($request['fullname'])) {
            $errors['fullname'] = '氏名は必須です。';
        } elseif (mb_strlen($request['fullname']) > 10) {
            $errors['fullname'] = '氏名は10文字以内で入力してください。';
        }

        //フリガナのバリデーション
        if (empty($request['furigana'])) {
            $errors['furigana'] = 'フリガナは必須です。';
        } elseif (mb_strlen($request['furigana']) > 10) {
            $errors['furigana'] = 'フリガナは10文字以内で入力してください。';
        } elseif (mb_strlen($request['furigana']) < 1) {
            $errors['furigana'] = 'フリガナは1文字以上で入力してください。';
        }

        //電話番号のバリデーション
        if (!empty($request['tel'])) {
            if (!preg_match('/^[0-9]*$/', $request['tel'])) {
                $errors['tel'] = '電話番号は数字のみで入力してください。';
            }
        }

        //メールアドレスのバリデーション
        if (empty($request['email'])) {
            $errors['email'] = 'メールアドレスは必須です。';
        } elseif (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'メールアドレスが正しくありません。';
        }

        //お問い合わせ内容のバリデーション
        if (empty($request['message'])) {
            $errors['message'] = 'お問い合わせ内容は必須です。';
        }
        return $errors;
    }
    public function create($request)
    {
        $contactmodel = new ContactModel();
        $result = $contactmodel->create($request);
        return $result;
    }
    public function update($request)
    {
        $contactmodel = new ContactModel();
        $result = $contactmodel->update($request);
        return $result;
    }
    public function delete($request)
    {
        $contactmodel = new ContactModel();
        $result = $contactmodel->delete($request);
        return $result;
    }
}
?>
<!-- javascriptバリデーション -->
<script>
    function validateForm() {
        // 入力値の取得
        var fullname = document.forms["myForm"]["fullname"].value;
        var furigana = document.forms["myForm"]["furigana"].value;
        var tel = document.forms["myForm"]["tel"].value;
        var email = document.forms["myForm"]["email"].value;
        var message = document.forms["myForm"]["message"].value;

        // 入力値の検証
        if (fullname == "") {
            alert("氏名を入力してください。");
            return false;
        }
        if (furigana == "") {
            alert("フリガナを入力してください。");
            return false;
        }
        if (email == "") {
            alert("メールアドレスを入力してください。");
            return false;
        }
        if (message == "") {
            alert("お問い合わせ内容を入力してください。");
            return false;
        }
        return true;
    }
</script>