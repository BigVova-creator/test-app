<?php
require_once __DIR__ . '/../includes/functions.php';

if (currentUser()) {
    redirect('index.php');
}

$errors = [];
$old    = ['name' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['name']  = post('name');
    $old['email'] = mb_strtolower(post('email'));
    $password     = $_POST['password'] ?? '';
    $confirm      = $_POST['password_confirm'] ?? '';

    if (!verifyCsrf()) {
        $errors['form'] = 'Сессия устарела. Обновите страницу и попробуйте снова.';
    }
    if ($old['name'] === '' || mb_strlen($old['name']) > 100) {
        $errors['name'] = 'Укажите имя (до 100 символов).';
    }
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите корректный email.';
    }
    if (!is_string($password) || mb_strlen($password) < 8) {
        $errors['password'] = 'Пароль должен быть не короче 8 символов.';
    } elseif ($password !== $confirm) {
        $errors['password_confirm'] = 'Пароли не совпадают.';
    }

    if (!$errors) {
        $stmt = db()->prepare('SELECT 1 FROM users WHERE email = ?');
        $stmt->execute([$old['email']]);
        if ($stmt->fetchColumn()) {
            $errors['email'] = 'Пользователь с таким email уже зарегистрирован.';
        }
    }

    if (!$errors) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = db()->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
        $stmt->execute([$old['name'], $old['email'], $hash]);

        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id'    => (int) db()->lastInsertId(),
            'name'  => $old['name'],
            'email' => $old['email'],
        ];

        flash('success', 'Аккаунт создан! Добро пожаловать, ' . $old['name'] . '.');
        redirect('index.php');
    }
}

$pageTitle  = 'Регистрация';
$activePage = 'register';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="container section">
    <form class="auth-card" method="post" action="register.php" novalidate>
        <h1>Регистрация</h1>
        <p class="auth-subtitle">Создайте аккаунт, чтобы отслеживать заказы и получать скидки</p>
        <?= csrfField() ?>

        <?php if (isset($errors['form'])): ?>
            <div class="alert alert-error"><?= e($errors['form']) ?></div>
        <?php endif; ?>

        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" id="name" name="name" value="<?= e($old['name']) ?>" maxlength="100" required autocomplete="name"
                   class="<?= isset($errors['name']) ? 'invalid' : '' ?>">
            <?php if (isset($errors['name'])): ?><small class="error"><?= e($errors['name']) ?></small><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= e($old['email']) ?>" required autocomplete="email"
                   class="<?= isset($errors['email']) ? 'invalid' : '' ?>">
            <?php if (isset($errors['email'])): ?><small class="error"><?= e($errors['email']) ?></small><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <div class="password-field">
                <input type="password" id="password" name="password" minlength="8" required autocomplete="new-password"
                       class="<?= isset($errors['password']) ? 'invalid' : '' ?>">
                <button type="button" class="toggle-password" aria-label="Показать пароль">👁</button>
            </div>
            <?php if (isset($errors['password'])): ?><small class="error"><?= e($errors['password']) ?></small><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password_confirm">Повторите пароль</label>
            <input type="password" id="password_confirm" name="password_confirm" minlength="8" required autocomplete="new-password"
                   class="<?= isset($errors['password_confirm']) ? 'invalid' : '' ?>">
            <?php if (isset($errors['password_confirm'])): ?><small class="error"><?= e($errors['password_confirm']) ?></small><?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Создать аккаунт</button>
        <p class="auth-switch">Уже есть аккаунт? <a href="login.php">Войти</a></p>
    </form>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
