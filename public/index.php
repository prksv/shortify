<?php

require __DIR__ . '/../vendor/autoload.php';

$auth = new \Core\Auth();

?>

<?php include '../components/top.php'; ?>

<div class="container my-5">
    <div class="card">
        <div class="card-header">
            <h4 class="mt-2">Let's shortify your link!</h4>
        </div>
        <div class="card-body">
            <form method="post" id="shortify-form">
                <div class="mb-3">
                    <label class="form-label">URL</label>
                    <input type="text" name="link" class="form-control" placeholder="https://example.com">
                </div>
                <div id="messages" class="text-danger"></div>
                <button type="submit" class="btn btn-primary">Shorty</button>
            </form>
        </div>
        <div class="card-footer text-body-secondary">
            <?php echo $auth->check() ? "Hello, {$auth->user->login}!" : "Links statistics available only for registered users" ?>

            <ul class="list-group" id="links-list"></ul>
        </div>
    </div>
</div>
    <script type="module" src="assets/app.js"></script>
<?php include '../components/bottom.php'; ?>