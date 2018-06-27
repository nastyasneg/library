<?php
 session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Форма регистрации в библиотеке</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600&amp;subset=cyrillic" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <?php

    function database_store($name,$surname,$gender,$number,$month,$year,$lit1,$lit2,$lit3,$login,$pass) {
      $aa=fopen("data.txt", "a+");
      $str=$name.";".$surname.";".$gender.";".$number.";".$month.";".$year.";".$lit1.";".$lit2.";".$lit3.";".$login.";".$pass.";"."\n";
      fwrite($aa,$str);
      fclose($aa);
    }

    function database_log_search($login) {
      $bb=file("data.txt");
      foreach ($bb as $kk=>$vv) {
        $cc=explode(";", $vv);
        if ($cc[9]==$login) {
           return true;
          }
      }
      return false;
    }

    function database_pass_search($login) {
      $bb=file("data.txt");
      foreach ($bb as $kk=>$vv) {
        $cc=explode(";",$vv);
        if ($cc[9]==$login) {
          $dd=$cc[10];
        }
      }
      return $dd;
    }

    function database_data_search($login) {
      $bb=file("data.txt");
      foreach ($bb as $kk=>$vv) {
        $cc=explode(";",$vv);
        if ($cc[9]==$login) {
          $dd['name']=$cc[0];
          $dd['surname']=$cc[1];
          $dd['day_of_birth']=$cc[3];
          $dd['month_of_birth']=$cc[4];
          $dd['year_of_birth']=$cc[5];
          $dd['literature_1']=$cc[6];
          $dd['literature_2']=$cc[7];
          $dd['literature_3']=$cc[8];
          $dd['login']=$cc[9];
          $dd['password']=$cc[10];
          $ff[]=$dd;
        }
      }
      return $dd;
    }

    function database_age_search($login) {
      $total_year="2018";
      $bb=file("data.txt");
      foreach ($bb as $kk=>$vv) {
        $cc=explode(";",$vv);
        if ($cc[9]==$login) {
          $dd['year_of_birth']=$cc[5];
          $age=$total_year-$cc[5];
        }
      }
      return $age;
    }

    ?>
  </head>
  <body>
    <div class="description">
      <h1>Stuttgart Library</h1>
      <p>Городская библиотека Штутгарта.<br>
        Появилось здание сравнительно недавно и фото его интерьеров мгновенно заполонили сеть.<br>
        Главное — совершенная незаурядность каждой детали этого одиннадцатиэтажного вместилища носителей информации — книг,
        альбомов и дисков.</p>
      <div class="description-data">
        <?php

        if ($_POST['form']=="reg")  {
          $ee=database_log_search($_POST['login-new']);
          if ($ee==false) {
            $_SESSION['logname']=$_POST['login-new'];
            database_store($_POST['name'],$_POST['surname'],$_POST['gender'],$_POST['number'],$_POST['month'],$_POST['year'],$_POST['lit1'],$_POST['lit2'],$_POST['lit3'],$_POST['login-new'],$_POST['pass-new']);
            echo 'Спасибо за регистрацию '.$_POST['name'].'!'.$ee;
          } else {
            unset($_SESSION['logname']);
            echo "<div class='login-error-text'>".'Такой логин уже cуществует!'."</div>";
          }
        }

        if ($_POST['form']=="enter") {
          $minage="18";
          $maxage="55";
          $ee=database_pass_search($_POST['login2']);
          if ($ee==$_POST['pass2']) {
            $gg=database_data_search($_POST['login2']);
            $ss=database_age_search($_POST['login2']);
            $_SESSION['logname']=$_POST['login2'];
              echo 'Рады видеть вас снова, '.$gg['name'].'!'."<br>";
              echo "<br>";
              foreach ($gg as $kk => $vv) {
                echo $kk.": ".$vv."<br>";
              }
              echo "<br>";
            if($ss<=$minage) {
              echo 'Новинки для тех, кто оканчивает школу и активно готовится к поступлению в ВУЗы!';
              } else if ($ss>=$maxage) {
              echo 'Новые поступления литературы для дачников!';
              }
          } else {
            unset($_SESSION['logname']);
            echo "<div class='enter-error-text'>".'Неверный логин или пароль!'."</div>";
          }
        } else if ($_POST['log']=="out") {
          unset($_SESSION['logname']);
        }

        if (isset($_SESSION['logname'])) {
         echo "<form action='' method='post'><button class='button button-login button-logout' type='submit' name='log' value='out'>Выйти</button></form>";
         } else {
           echo "<a class='button button-open-form'>Регистрация</a>";
           echo "<a class='button button-login button-open-login'>Войти</a>";
           }

        ?>
      </div>
    </div>
    <div id="overl1" class="new-user-overlay"></div>
    <section class="new-user">
      <form class="main-form" action="" method="post">
        <h1>Регистрация нового читателя</h1>
        <input type="hidden" name="form" value="reg">
        <p class="form-name">
          <label for="name">Имя</label>
          <input class="name" id="name" type="text" name="name" required>
          <label for="surname">Фамилия</label>
          <input id="surname" type="text" name="surname"required>
        </p>
        <p class="form-gender">
          <span>Пол:</span>
          <label>
          <input type="radio" name="gender" value="m">
            мужской
          </label>
          <label>
          <input type="radio" name="gender" value="w">
            женский
          </label>
        </p>
        <p class="form-date">
          <span>Дата рождения</span>
          <select name="number">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
          </select>
          <select name="month">
            <option value="января">января</option>
            <option value="февраля">февраля</option>
            <option value="марта">марта</option>
            <option value="апреля">апреля</option>
            <option value="мая">мая</option>
            <option value="июня">июня</option>
            <option value="июля">июля</option>
            <option value="августа">августа</option>
            <option value="сентября">сентября</option>
            <option value="октября">октября</option>
            <option value="ноября">ноября</option>
            <option value="декабря">декабря</option>
          </select>
          <select name="year">
            <option value="1958">1958</option>
            <option value="1968">1968</option>
            <option value="1978">1978</option>
            <option value="1988">1988</option>
            <option value="1998">1998</option>
            <option value="2008">2008</option>
            <option value="2018">2018</option>
          </select>
        </p>
        <p class="form-lit">
          <span>Меня интересует:</span>
          <label>
          <input type="checkbox" name="lit1" value="Научная литература">
            научная литература
          </label><br>
          <label>
          <input type="checkbox" name="lit2" value="Художественая литература">
            художественная литература
          </label><br>
          <label>
          <input type="checkbox" name="lit3" value="Документальная проза">
            документальная проза
          </label><br>
        </p>
        <p class="form-login">
          <label for="login">Логин</label>
          <input id="login" type="text" name="login-new" required>
          <label for="pass">Пароль</label>
          <input id="pass" type="password" name="pass-new" required>
        </p>
        <p>
          <textarea name="about" placeholder="Расскажите немного о себе"></textarea>
        </p>
        <div id="reg-msg" class="error-message">Такой логин уже существует</div>
        <button class="button" type="submit" name="log" value="enter">Зарегистрироваться</button>
        <button class="form-close" type="button">Закрыть</button>
      </form>
    </section>
    <section class="login">
      <form class="login-form" action="" method="post">
        <h1>Вход в личный кабинет</h1>
        <input type="hidden" name="form" value="enter">
        <p class="form-login">
          <label for="login2">Логин</label>
          <input id="login2" type="text" name="login2">
          <label for="pass2">Пароль</label>
          <input id="pass2" type="password" name="pass2">
        </p>
        <div id="msg" class="error-message">Неверный логин или пароль!</div>
        <button class="button button-login" type="submit" name="log" value="in">Войти</button>
        <button class="form-close" type="button">Закрыть</button>
      </form>
    </section>

    <script>
      var openForm = document.querySelector(".button-open-form");
      var popup = document.querySelector(".new-user");
      var closePopup = popup.querySelector(".form-close");
      var nameInput = popup.querySelector("[name=name]");
      var overlay = document.querySelector(".new-user-overlay");

      openForm.addEventListener("click", function (event) {
        event.preventDefault();
        popup.classList.add("new-user-show");
        overlay.classList.add("new-user-overlay-show");
        nameInput.focus();
      });

      closePopup.addEventListener("click", function (event) {
        event.preventDefault();
        popup.classList.remove("new-user-show");
        overlay.classList.remove("new-user-overlay-show");
      });

      window.addEventListener("keydown", function (event) {
        if (event.keyCode === 27) {
          event.preventDefault();
          if (popup.classList.contains("new-user-show")) {
            popup.classList.remove("new-user-show");
            overlay.classList.remove("new-user-overlay-show");
          }
        }
      });

      var openLogin = document.querySelector(".button-open-login");
      var popupLogin = document.querySelector(".login");
      var formLogin = document.querySelector(".login-form");
      var closePopupLogin = popupLogin.querySelector(".form-close");
      var loginInput = popupLogin.querySelector("[name=login2]");
      var passInput = popupLogin.querySelector("[namw=pass2]");

      openLogin.addEventListener("click", function (event) {
        event.preventDefault();
        popupLogin.classList.add("login-show");
        overlay.classList.add("new-user-overlay-show");
        loginInput.focus();
      });

      closePopupLogin.addEventListener("click", function (event) {
        event.preventDefault();
        popupLogin.classList.remove("login-show");
        overlay.classList.remove("new-user-overlay-show");
        popupLogin.classList.remove("login-error");
      });

      window.addEventListener("keydown", function (event) {
        if (event.keyCode === 27) {
          event.preventDefault();
          if (popupLogin.classList.contains("login-show")) {
            popupLogin.classList.remove("login-show");
            popupLogin.classList.remove("login-error");
            overlay.classList.add("new-user-overlay-show");
          }
        }
      });
      
    </script>

  </body>
</html>
