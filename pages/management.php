<?php
session_start();
require_once('../php/header.php'); /* Верхня частина сайту */
checkAccess(2); /* Доступ лише у адміністраторів */
require_once('../php/managment.php');  /* Необхідні функції */
?>

<div class="main-block">
    <h1>Список користувачів</h1>
    <table>
        <tr>
            <th>Логін</th>
            <th>Роль</th>
            <th>Змінити роль</th>
        </tr>
        <?php foreach ($userList->getUsers() as $user): ?> <!-- Використовуємо метод getUsers() для отримання списку користувачів -->
            <?php if ($user->getRole() !== 'administrator'): ?>
                <tr>
                    <td><?php echo $user->getLogin(); ?></td>
                    <td><?php echo $user->getRole(); ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="login" value="<?php echo $user->getLogin(); ?>">
                            <select name="new_role">
                                <?php if ($user->getRole() !== 'seller'): ?>
                                    <option value="seller">Продавець</option>
                                <?php endif; ?>
                                <?php if ($user->getRole() !== 'user'): ?>
                                    <option value="user">Користувач</option>
                                <?php endif; ?>
                            </select>
                            <button type="submit" name="change_role">Змінити</button>
                        </form>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
</div>

<?php require_once('../php/footer.php'); ?>
