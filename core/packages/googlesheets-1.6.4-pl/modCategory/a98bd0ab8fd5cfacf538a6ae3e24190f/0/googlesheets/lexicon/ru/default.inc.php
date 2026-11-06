<?php
include_once 'setting.inc.php';
include_once 'auth.inc.php';
include_once 'import.inc.php';
include_once 'export.inc.php';
// include_once 'seo.inc.php';
include_once 'migx.inc.php';

$_lang['googlesheets'] = 'GoogleSheets';
$_lang['googlesheets_menu_desc'] = 'Компонент для работы с Google Sheets: Импорт/Экспорт';

// GRID
$_lang['googlesheets_id'] = 'ID';
$_lang['googlesheets_name'] = 'URL таблицы';
$_lang['googlesheets_range'] = 'Лист таблицы';
$_lang['googlesheets_create'] = 'Создать';
$_lang['googlesheets_update'] = 'Изменить';
$_lang['googlesheets_remove'] = 'Удалить';
$_lang['googlesheets_remove_data'] = 'Удалить данные';
$_lang['googlesheets_grid_search'] = 'Поиск';
$_lang['googlesheets_grid_actions'] = 'Действия';
$_lang['googlesheets_active'] = 'Активно';
$_lang['googlesheets_resource'] = 'Ресурс';
$_lang['googlesheets_resource_desc'] = 'id ресурса';
$_lang['googlesheets_copy'] = 'Копировать';
$_lang['googlesheets_item_copy_confirm'] = 'Вы действительно хотите сделать копию?';
$_lang['googlesheets_copy_empty'] = 'Нечего копировать';

// WINDOW
$_lang['googlesheets_sync'] = 'Синхронизация';
$_lang['googlesheets_sync_create'] = 'Создание';
$_lang['googlesheets_sync_update'] = 'Обновление';
$_lang['googlesheets_sync_remove'] = 'Удаление';
$_lang['googlesheets_required'] = 'Обязательные поля';
$_lang['googlesheets_header_table'] = 'Использовать поля как заголовки в таблице';
$_lang['googlesheets_field_unique'] = 'Уникальное поле';
$_lang['googlesheets_skip_first'] = 'Пропускать первую строку';

// ERROR
$_lang['googlesheets_err_token'] = 'Не верно указан токен.';
$_lang['googlesheets_err_table'] = 'Не указана таблица.';
$_lang['googlesheets_err_range'] = 'Не указано навазвание листа.';
$_lang['googlesheets_err_remove'] = 'Ошибка при удалении.';
$_lang['googlesheets_err_save'] = 'Ошибка при сохранении.';
$_lang['googlesheets_err_sycn_id'] = 'Вы не указали поле "id" для синхронизации!';
$_lang['googlesheets_err_sync_field'] = 'Не найдено поле "[[+name]]" для синхронизации листа: [[+range]]!';
$_lang['googlesheets_err_get_value'] = 'Ошибка получение данных с таблицы.';
$_lang['googlesheets_err_option'] = 'Не заполнена опция [[+name]]';
$_lang['googlesheets_err_option_notexist'] = 'Опции [[+key]] не существует!';
$_lang['googlesheets_err_empty_setting'] = 'Не заполнена системная настройка [[+name]]';
$_lang['googlesheets_err_empty_unique'] = 'Уникальное поле не может быть пустым!';
$_lang['googlesheets_err_null_unique'] = 'Уникальное не найдено!';
$_lang['googlesheets_err_parent'] = 'Не найден родитель с id: [[+id]]';
$_lang['googlesheets_err_create_parent'] = 'Не получилось создать родителя: [[+parent]]';
$_lang['googlesheets_err_create_category'] = 'Не получилось создать категорию: [[+category]]';
$_lang['googlesheets_err_category'] = 'Не найдена категория с id: [[+id]]';
$_lang['googlesheets_err_copy'] = 'Не удалось скопировать объект';

$_lang['googlesheets_err_create_order'] = 'Не получилось создать заказ: [[+id]]';
$_lang['googlesheets_err_update_order'] = 'Не получилось обновить заказ: [[+id]]';
$_lang['googlesheets_err_remove_order'] = 'Не получилось удалить заказ: [[+id]]';
$_lang['googlesheets_err_empty_order'] = 'Заказ: [[+id]] не найден';

$_lang['googlesheets_err_create_user'] = 'Не получилось создать пользователя: [[+id]]';
$_lang['googlesheets_err_update_user'] = 'Не получилось обновить пользователя: [[+id]]';
$_lang['googlesheets_err_remove_user'] = 'Не получилось удалить пользователя: [[+id]]';
$_lang['googlesheets_err_empty_user'] = 'Пользователь: [[+id]] не найден';

$_lang['googlesheets_error'] = 'Что-то пошло не так!';
// LOG ERROR
$_lang['googlesheets_log_error_id'] = 'Не найден ресурс с id:';
$_lang['googlesheets_log_error_status'] = 'Не найдено поле status в системной настройки googlesheets_order_fields';

// MODAL
$_lang['googlesheets_title_success'] = 'Успех';
$_lang['googlesheets_content_success'] = 'Все получилось!';
$_lang['googlesheets_msg_loading'] = 'Идет загрузка';
$_lang['googlesheets_msg_total'] = 'Всего';
$_lang['googlesheets_msg_processed'] = 'Обработано';
$_lang['googlesheets_msg_export'] = 'Экспортировано';
$_lang['googlesheets_msg_empty'] = 'Не найдено';
$_lang['googlesheets_msg_success'] = 'Успешно';
$_lang['googlesheets_msg_error'] = 'Ошибок';
$_lang['googlesheets_msg_create'] = 'Создано';
$_lang['googlesheets_msg_update'] = 'Обновленно';
$_lang['googlesheets_msg_remove'] = 'Удалено';
$_lang['googlesheets_msg_time'] = 'Время выполнения';

$_lang['googlesheets_type_resources'] = 'ресурсов';
$_lang['googlesheets_type_products'] = 'товаров';
$_lang['googlesheets_type_categories'] = 'категорий';
$_lang['googlesheets_remove_confirm_title'] = 'Удаление';
$_lang['googlesheets_remove_confirm_content'] = 'Вы действительно хотите удалить данные?';