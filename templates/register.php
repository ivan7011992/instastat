

<html>
<head>
    <title>Анкета</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Анкета</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>



</head>
<body>

<form method="POST" enctype="multipart/form-data" action="/controllers/register.php">
    <div class="form-group">
        <label for="Name">Имя</label>
        <input name="reg-name"
               type="text"
               class="form-control"
               id="Name"
               aria-describedby="emailHelp"
               placeholder="Ввеите имя"
               value="<?= $name['name'] ?? '' ?>">
<!--        --><?php //if (array_key_exists('reg-name', $errors)): ?>
<!--            <p> --><?//= $errors['reg-name'] ?><!--</p>-->
<!--        --><?php //endif ?><!-- -->
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="Area">Район</label>
        <input  name= 'reg-area'
                type="text"
                class="form-control"
                id="Area"
                placeholder="Укажите район проживания"
                value="<?= $Area['reg-area'] ?? '' ?>">
<!--        --><?php //if (array_key_exists('reg-area', $errors)): ?>
<!--            <p class="form__message">Введите район</p>--><?//= $errors['area'] ?><!--</p>-->
<!--        --><?php //endif ?>
    </div>
    <div class="form-group">
        <label for="password">Пароль</label>
        <input  name= 'reg-password'
                type="password"
                class="form-control"
                id="password"
                placeholder="Введите пароль"
                value="<?= $password['reg-password'] ?? '' ?>">
<!--        --><?php //if (array_key_exists('reg-password', $errors)): ?>
<!--            <p class="form__message">Пароль</p>--><?//= $errors['password'] ?><!--</p>-->
<!--        --><?php //endif ?>
    </div>

    <div class="form-group">
        <label for="emsil">Email</label>
        <input  name= 'reg-email'
                type="email"
                class="form-control"
                id="email"
                placeholder="Введите email"
                value="<?= $password['reg-email'] ?? '' ?>">
<!--        --><?php //if (array_key_exists('reg-email', $errors)): ?>
<!--            <p class="form__message">Пароль</p>--><?//= $errors['reg-email'] ?><!--</p>-->
<!--        --><?php //endif ?>
    </div>

    <?php if (!empty($errors)): ?>
        <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
    <?php endif ?>

    <button type="submit" class="btn btn-primary">Submit</button>

</form>
</body>
</html>






