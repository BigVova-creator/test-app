<?php
require_once __DIR__ . '/includes/functions.php';

$errors = [];
$old    = ['name' => '', 'company' => '', 'email' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (array_keys($old) as $field) {
        $old[$field] = post($field);
    }

    if (!verifyCsrf()) {
        $errors['form'] = 'Сессия устарела. Обновите страницу и попробуйте снова.';
    }
    if ($old['name'] === '' || mb_strlen($old['name']) > 100) {
        $errors['name'] = 'Укажите имя (до 100 символов).';
    }
    if ($old['company'] === '' || mb_strlen($old['company']) > 150) {
        $errors['company'] = 'Укажите название компании (до 150 символов).';
    }
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите корректный email.';
    }
    if (mb_strlen($old['message']) < 10 || mb_strlen($old['message']) > 2000) {
        $errors['message'] = 'Сообщение должно содержать от 10 до 2000 символов.';
    }

    if (!$errors) {
        $stmt = db()->prepare('INSERT INTO sponsors (name, company, email, message) VALUES (?, ?, ?, ?)');
        $stmt->execute([$old['name'], $old['company'], $old['email'], $old['message']]);

        flash('success', 'Спасибо, ' . $old['name'] . '! Заявка отправлена — мы свяжемся с вами в течение 2 рабочих дней.');
        redirect('sponsors.php');
    }
}

$pageTitle  = 'Поиск спонсоров';
$activePage = 'sponsors';
require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1>Станьте нашим партнёром</h1>
        <p>Ищем спонсоров и бренды для совместных акций, розыгрышей и мероприятий</p>
    </div>
</section>

<section class="container section sponsors-layout">
    <div class="sponsors-info">
        <h2>Что мы предлагаем</h2>
        <ul class="check-list">
            <li>Аудитория 50 000+ активных покупателей техники</li>
            <li>Размещение баннеров в слайдере на главной</li>
            <li>Совместные розыгрыши и промо-коды</li>
            <li>Интеграции в email-рассылки и соцсети</li>
            <li>Прозрачная отчётность по охватам и продажам</li>
        </ul>
    </div>

    <form class="form-card" method="post" action="sponsors.php" novalidate>
        <h2>Заявка на партнёрство</h2>
        <?= csrfField() ?>

        <?php if (isset($errors['form'])): ?>
            <div class="alert alert-error"><?= e($errors['form']) ?></div>
        <?php endif; ?>

        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" id="name" name="name" value="<?= e($old['name']) ?>" maxlength="100" required
                   class="<?= isset($errors['name']) ? 'invalid' : '' ?>" placeholder="Иван Иванов">
            <?php if (isset($errors['name'])): ?><small class="error"><?= e($errors['name']) ?></small><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="company">Компания</label>
            <input type="text" id="company" name="company" value="<?= e($old['company']) ?>" maxlength="150" required
                   class="<?= isset($errors['company']) ? 'invalid' : '' ?>" placeholder="ООО «Ромашка»">
            <?php if (isset($errors['company'])): ?><small class="error"><?= e($errors['company']) ?></small><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= e($old['email']) ?>" required
                   class="<?= isset($errors['email']) ? 'invalid' : '' ?>" placeholder="you@company.ru">
            <?php if (isset($errors['email'])): ?><small class="error"><?= e($errors['email']) ?></small><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="message">Текст предложения</label>
            <textarea id="message" name="message" rows="5" maxlength="2000" required
                      class="<?= isset($errors['message']) ? 'invalid' : '' ?>"
                      placeholder="Расскажите о вашей компании и формате сотрудничества"><?= e($old['message']) ?></textarea>
            <?php if (isset($errors['message'])): ?><small class="error"><?= e($errors['message']) ?></small><?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Отправить заявку</button>
    </form>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
