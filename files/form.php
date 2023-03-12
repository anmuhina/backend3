/*<form action="" method="POST">
  <input name="fio" />
  <select name="year">
    <?php 
    for ($i = 1922; $i <= 2022; $i++) {
      printf('<option value="%d">%d год</option>', $i, $i);
    }
    ?>
  </select>
  
  <input type="submit" value="ok" />
</form>*/




<form class="forma" method="POST">
    <label><br>
        Имя:<br>
        <input id="data" name="fio" placeholder="Введите Ваше имя">
    </label><br>
    <label>
        Email:<br>
        <input id="data" name="email" type="email" placeholder="Введите вашу почту">
    </label><br>
    <label>
        Дата рождения:<br>
        <select name="year">
         <?php 
          for ($i = 1922; $i <= 2022; $i++) {
          printf('<option value="%d">%d год</option>', $i, $i);
          }
         ?>
        </select>
    </label><br>
    Пол:<br>
      <label><input id="data" type="radio" checked="checked" name="sex">ж</label>
      <label><input id="data" type="radio" name="sex">м</label><br />
    Количество конечностей:<br />
      <label><input id="data" type="radio" checked="checked" name="limb"> 2 </label>
      <label><input id="data" type="radio" name="limb"> 3 </label>
      <label><input id="data" type="radio" name="limb"> 4 </label><br>
    <label>
        Сверхспособности:<br>
        <select id="data" name="superpowers" multiple="multiple">
          <option disabled>Выберите сверхспособность:</option>
          <option value="Значение1">Бессмертие</option>
          <option value="Значение2">Прохождение сквозь стены</option>
          <option value="Значение3">Левитация</option>
        </select>
    </label><br>
    <label>
        Биография:<br />
        <textarea id="data" name="biography" placeholder="Введите текст"></textarea>
    </label><br>
    <label><input id="data" type="checkbox" checked="checked" name="check">С контрактом ознакомлен(а)</label><br>
    <input id="data" type="submit" value="Отправить">
  </form>
