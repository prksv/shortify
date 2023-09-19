<?php

require __DIR__ . '/../vendor/autoload.php';

use Core\Auth;
use Core\User;
use Rakit\Validation\Validator;

$errors = [];

$auth = new Auth();
$user = new User();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validator = new Validator();

    $validation = $validator->validate($_POST, [
        'login' => 'required|min:5|max:20',
        'password' => 'required|min:5|max:100'
    ]);

    if ($validation->fails()) {
        foreach ($validation->errors()->toArray() as $error) {
            $errors[] = reset($error);
        }
    } else {
        $data = $validation->getValidatedData();

        $user = $user->login($data['login'], $data['password']);

        if ($user) {
            $auth->setUser($user);
            header("Location: index.php");
        } else {
            $errors[] = "Invalid login or password.";
        }
    }
}

?>
<?php include '../components/top.php'; ?>

<div class="container d-flex justify-content-center flex-column align-items-center my-5">
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Login</label>
            <input type="text" class="form-control" value="<?php echo $_POST['login'] ?? '' ?>" name="login">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" value="<?php echo $_POST['password'] ?? '' ?>">
        </div>
        <div class="mb-3 text-danger">
            <?php
            foreach ($errors as $error) {
                echo $error . "<br/>";
            }
            ?>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<?php include '../components/bottom.php'; ?>
