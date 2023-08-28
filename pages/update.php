<? $title = 'Страница для управления данными';
add_header();
?>

<h1>УПРАВЛЕНИЕ ДАННЫМИ</h1>

<div class="update-menu">
    <div class="button on-click" action="updateData">ЗАГРУЗИТЬ</div>
    <div class="button on-click" action="clearData">ОЧИСТИТЬ БД</div>
</div>
<div id="pc" class="pseudo-console">
</div>

<?
add_footer();
?>