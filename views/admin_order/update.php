<?php include ROOT . '/views/layouts/header_admin.php'; ?>

    <section>
        <div class="container">
            <div class="row">

                <br/>

                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="/admin">Админпанель</a></li>
                        <li><a href="/admin/order">Управление заказам</a></li>
                        <li class="active">Редактировать заказ</li>
                    </ol>
                </div>


                <h4>Редактировать заказ #<?php echo $id; ?></h4>

                <br/>

                <div class="col-lg-4">
                    <div class="login-form">
                        <form action="#" method="post" enctype="multipart/form-data">

                            <p>Имя покупателя</p>
                            <input type="text" name="user_name" placeholder="" value="<?php echo $order['user_name']; ?>">

                            <p>Телефон покупателя</p>
                            <input type="text" name="user_phone" placeholder="" value="<?php echo $order['user_phone']; ?>">

                            <p>Комментарий покупателя</p>
                            <input type="text" name="user_comment" placeholder="" value="<?php echo $order['user_comment']; ?>">

                            <p>Дата оформления заказа</p>
                            <input type="text" name="date" placeholder="" value="<?php echo $order['date']; ?>">

                            <p>Статус</p>
                            <select name="status">
                                <option value="1" <?php if ($order['status'] == 1) echo ' selected="selected"'; ?>>Новый заказ</option>
                                <option value="2" <?php if ($order['status'] == 2) echo ' selected="selected"'; ?>>В обработке</option>
                                <option value="3" <?php if ($order['status'] == 3) echo ' selected="selected"'; ?>>Доставляется</option>
                                <option value="4" <?php if ($order['status'] == 4) echo ' selected="selected"'; ?>>Закрыт</option>
                            </select>

                            <br/><br/>

                            <input type="submit" name="submit" class="btn btn-default" value="Сохранить">

                            <br/><br/>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>