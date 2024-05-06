<?php
session_start();
require_once ('../php/header.php'); /* Верхня частина сайту */
require_once ('../php/managment.php');  /* Необхідні функції */
require_once ('../php/highaccess.php'); /* Доступ лише у адміністраторів */
?>

<div class="main-block">
    <h1>Список користувачів</h1>
    <table>
        <tr>
            <th>Логін</th>
            <th>Роль</th>
            <th>Змінити роль</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <?php if ($user[1] !== 'administrator'): ?>
                <tr>
                    <td><?php echo $user[0]; ?></td>
                    <td><?php echo $user[1]; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="login" value="<?php echo $user[0]; ?>">
                            <select name="new_role">
                                <?php if ($user[1] !== 'seller'): ?>
                                    <option value="seller">Продавець</option>
                                <?php endif; ?>
                                <?php if ($user[1] !== 'user'): ?>
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

<?php require_once ('../php/footer.php'); ?>
