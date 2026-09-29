<?php
require_once __DIR__ . '/../includes/functions.php';

if (currentUser()) {
    redirect('index.php');
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = mb_strtolower(post('email'));
    $password = $_POST['password'] ?? '';

    if (!verifyCsrf()) {
        $error = 'Сессия устарела. Обновите страницу и попробуйте снова.';
    } elseif ($email === '' || !is_string($password) || $password === '') {
        $error = 'Введите email и пароль.';
    } else {
        $stmt = db()->prepare('SELECT id, name, email, password_hash FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Обновляем хэш, если изменился алгоритм по умолчанию
            if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
                db()->prepare('UPDATE users SET password_hash = ? WHERE id = ?')
                    ->execute([password_hash($password, PASSWORD_DEFAULT), $user['id']]);
            }

            // Защита от фиксации сессии
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id'    => (int) $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
            ];

            flash('success', 'С возвращением, ' . $user['name'] . '!');
            redirect('index.php');
        }

        // Одинаковое сообщение, чтобы не раскрывать, существует ли email
        $error = 'Неверный email или пароль.';
    }
}

$pageTitle  = 'Вход';
$activePage = 'login';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="container section">
    <form class="auth-card" method="post" action="login.php" novalidate>
        <h1>Вход</h1>
        <p class="auth-subtitle">Рады видеть вас снова!</p>
        <?= csrfField() ?>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
        <?php endif; ?>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= e($email) ?>" required autocomplete="email">
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <div class="password-field">
                <input type="password" id="password" name="password" required autocomplete="current-password">
                <button type="button" class="toggle-password" aria-label="Показать пароль">👁</button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Войти</button>
        <p class="auth-switch">Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
    </form>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
