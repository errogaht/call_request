call_request
============
Универсальный скрипт для разных форм обратной связи.

СМС через infosmska.ru
email через PHP mailer

SMS
-------

```php
    $login = '';
    $password = '';
    $phone = '';
    $sender = 'SMS';
```

Email
-------

Для яндекса работает так:

```php
    $mail->isSMTP();
    $mail->SMTPKeepAlive = true;
    $mail->Host = 'smtp.yandex.ru';
    $mail->SMTPAuth = true;
    $mail->Username = 'lol@yandex.ru';
    $mail->Password = '';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->CharSet = 'UTF-8';
    $mail->From = 'lol@yandex.ru';
    $mail->FromName = $sender_name;
    $mail->addAddress('lol@yandex.ru', 'Joe User');
    $mail->isHTML(true);
```

Типы сообщений
-------

Всё передавать через POST

Если указаны `product` (названите товара) и `phone` (телефон клиента) - будет отправлен быстрый заказ. Также в быстрый заказ можно ещё передать `model` (модель/артикул товара), `price` (стоимость), `name` (имя покупателя), `phone`(телефон покупателя), `message`(сообщение от покупателя)

| поле                 | product        | model | price | name | email | phone | message
| *Описание*           |*Название товара*|*артикул товара*|*стоимость товара*|*имя отправителя*|*email отправителя*|*телефон отправителя*|*сообщение отправителя*|
| Быстрый заказ        | **обяз.** |   *необяз.*| *необяз.*    | *необяз.*   | *необяз.*     |  **обяз.**    |*необяз.*          |
| Форма обратной связи |—|—|—|   *необяз.* |   **обяз.** |*необяз.*        |  **обяз.**      |
| Обратный звонок      |—|—|—|*необяз.*    |*необяз.*      |**обяз.**      |*необяз.*          |
