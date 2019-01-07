form-template-method:java

###

1.ru. Разбейте алгоритмы в подклассах на составные части, описанные в отдельных методах. В этом может помочь <a href="/ru/extract-method">извлечение метода</a>.
1.en. Split algorithms in the subclasses into their constituent parts described in separate methods. <a href="/extract-method">Extract Method</a> can help with this.
1.uk. Розбийте алгоритми в підкласах на складові частини, описані в окремих методах. У цьому може допомогти <a href="/uk/extract-method">витягання методу</a>.

2.ru. Получившиеся методы, одинаковые для всех подклассов, можете смело перемещать в суперкласс, используя <a href="/ru/pull-up-method">подъём метода</a>.
2.en. The resulting methods that are identical for all subclasses can be moved to a superclass via <a href="/pull-up-method">Pull Up Method</a>.
2.uk. Методи, що вийшли однаковимі для усіх підкласів, можете сміливо переміщати в суперклас, використовуючи <a href="/uk/pull-up-method">підйом методу</a>.

3.ru. Отличающиеся методы приведите к единым названиям с помощью <a href="/ru/rename-method">переименования метода</a>.
3.en. The non-similar methods can be given consistent names via <a href="/rename-method">Rename Method</a>.
3.uk. Методи, що відрізняються, приведіть до єдиних назв за допомогою <a href="/uk/rename-method">перейменування методу</a>.

4.ru. Поместите сигнатуры отличающихся методов в суперкласс как абстрактные с помощью <a href="/ru/pull-up-method">подъёма метода</a>. Их реализации оставьте в подклассах.
4.en. Move the signatures of non-similar methods to a superclass as abstract ones by using <a href="/pull-up-method">Pull Up Method</a>. Leave their implementations in the subclasses.
4.uk. Помістіть сигнатури методів, що відрізняються, в суперклас як абстрактні за допомогою <a href="/uk/pull-up-method">підйому методу</a>. Їх реалізації залиште в підкласах.

5.ru. И наконец, поднимите основной метод алгоритма в суперкласс. Он теперь должен работать с методами-шагами, описанными в суперклассе — реальными или абстрактными.
5.en. And finally, pull up the main method of the algorithm to the superclass. Now it should work with the method steps described in the superclass, both real and abstract.
5.uk. І, нарешті, підніміть основний метод алгоритму в суперклас. Він тепер повинен працювати з методами-кроками, описаними в суперкласі — реальними або абстрактними.



###

```
class Article {
  // ...
  public String getTitle() { /* … */ }
  public String getIntro() { /* … */ }
  public String getBody() { /* … */ }
  public String getAuthor() { /* … */ }
  public String getDate() { /* … */ }

  public String markdownView() {
    String output = "# " + getTitle() + "\n\n";
    output += "> " + getIntro() + "\n\n";
    output += getBody() + "\n\n";
    output += "_Written by " + getAuthor() + " on " + getDate() + "_";
    return output;
  }
  public String htmlView() {
    String output = "<h2>" + getTitle() + "</h2>" + "\n";
    output += "<blockquote>" + getIntro() + "</blockquote>" + "\n";
    output += "<p>" + getBody() + "</p>" + "\n";
    output += "<em>Written by " + getAuthor() + " on " + getDate() + "</em>";
    return output;
  }
}
```

###

```
class Article {
  // ...
  public String getTitle() { /* … */ }
  public String getIntro() { /* … */ }
  public String getBody() { /* … */ }
  public String getAuthor() { /* … */ }
  public String getDate() { /* … */ }

  public String markdownView() {
    return new ArticleMarkdown(this).view();
  }
  public String htmlView() {
    return new ArticleHtml(this).view();
  }
}

abstract class ArticleView {
  protected Article article;
  protected ArticleView(Article article) {
    this.article = article;
  }
  protected abstract String title();
  protected abstract String intro();
  protected abstract String body();
  protected abstract String footer();
  public String view() {
    return title() + intro() + body() + footer();
  }
}

class ArticleMarkdown extends ArticleView {
  public ArticleMarkdown(Article article) {
    super(article);
  }
  @Override protected String title() {
    return "# " + article.getTitle() + "\n\n";
  }
  @Override protected String intro() {
    return "> " + article.getIntro() + "\n\n";
  }
  @Override protected String body() {
    return article.getBody() + "\n\n";
  }
  @Override protected String footer() {
    return "_Written by " + article.getAuthor() + " on " + article.getDate() + "_";
  }
}

class ArticleHtml extends ArticleView {
  public ArticleHtml(Article article) {
    super(article);
  }
  @Override protected String title() {
    return "<h2>" + article.getTitle() + "</h2>" + "\n";
  }
  @Override protected String intro() {
    return "<blockquote>" + article.getIntro() + "</blockquote>" + "\n";
  }
  @Override protected String body() {
    return "<p>" + article.getBody() + "</p>" + "\n";
  }
  @Override protected String footer() {
    return "<em>Written by " + article.getAuthor() + " on " + article.getDate() + "</em>";
  }
}
```

###

Set step 1

Select name of "Article"

#|ru|+ Рассмотрим этот рефакторинг на примере класса статьи, которая может выводиться в двух форматах…
#|en|+ Let's look at this refactoring using the example of an article that can be displayed in two formats…
#|uk|+ Розглянемо цей рефакторинг на прикладі класу статті, яка може виводитися в двох форматах…

Select name of "markdownView"

#|ru|<+ …простом текстовом формате Markdown…
#|en|<+ …in Markdown plain text…
#|uk|<+ …простому текстовому форматі Markdown…

Select name of "htmlView"

#|ru|<= …и в разметке HTML.
#|en|<= …and in HTML.
#|uk|<= …і в розмітці HTML.

#|ru| Прежде чем приступить непосредственно к рефакторингу, мы должны сделать так, чтобы эти два метода появились в подклассах некоторого общего родительского класса.
#|en| Before starting the refactoring per se, we should arrange things so that these two methods appear in the subclasses of some shared parent class.
#|uk| Перш ніж приступити безпосередньо до рефакторингу, ми повинні зробити так, щоб ці два методи з'явилися в підкласах деякого загального батьківського класу.

Select whole "markdownView"
+Select whole "htmlView"

#|ru| Для этого можно создать <a href="/ru/replace-method-with-method-object">простой объект методов</a>, переместив оба метода в него.
#|en| To do this, we create a <a href="/replace-method-with-method-object">simple method object</a> by moving both methods to it.
#|uk| Для цього можна створити <a href="/uk/replace-method-with-method-object">простий об'єкт методів</a>, перемістивши обидва методи в нього.

Go to after "Article"

Print:
```


class ArticleView {
  protected Article article;
  public ArticleView(Article article) {
    this.article = article;
  }
  public String markdownView() {
    String output = "# " + article.getTitle() + "\n\n";
    output += "> " + article.getIntro() + "\n\n";
    output += article.getBody() + "\n\n";
    output += "_Written by " + article.getAuthor() + " on " + article.getDate() + "_";
    return output;
  }
  public String htmlView() {
    String output = "<h2>" + article.getTitle() + "</h2>" + "\n";
    output += "<blockquote>" + article.getIntro() + "</blockquote>" + "\n";
    output += "<p>" + article.getBody() + "</p>" + "\n";
    output += "<em>Written by " + article.getAuthor() + " on " + article.getDate() + "</em>";
    return output;
  }
}
```

Wait 500ms

Select body of "markdownView"
+ Select body of "htmlView"

#|ru| Теперь тела оригинальных методов можно заменить вызовами методов <code>ArticleView</code>
#|en| Now the bodies of the original methods can be replaced with calls to the <code>ArticleView</code> methods.
#|uk| Тепер тіла оригінальних методів можна замінити викликами методів <code>ArticleView</code>

Select body of "markdownView"

Replace:
```
    return new ArticleView(this).markdownView();
```

Wait 500ms

Select body of "htmlView"

Replace:
```
    return new ArticleView(this).htmlView();
```

Wait 500ms

Select name of "ArticleView"

#|ru| Далее из <code>ArticleView</code> мы можем выделить два подкласса — <code>ArticleMarkdown</code> и <code>ArticleHtml</code>, переместив в них соответствующие методы.
#|en| Then from <code>ArticleView</code> we can extract two subclasses, <code>ArticleMarkdown</code> and <code>ArticleHtml</code>, by moving the corresponding methods to them.
#|uk| Далі з <code>ArticleView</code> ми можемо виділити два підкласи – <code>ArticleMarkdown</code> і <code>ArticleHtml</code>, перемістивши в них відповідні методи.

Go to after "ArticleView"

#|ru| Создаём класс <code>ArticleMarkdown</code>.
#|en| Let's create a <code>ArticleMarkdown</code> class.
#|uk| Створюємо клас <code>ArticleMarkdown</code>.

Print:
```


class ArticleMarkdown extends ArticleView {
  public ArticleMarkdown(Article article) {
    super(article);
  }
}
```

Wait 500ms

Select whole of "markdownView" in "ArticleView"

#|ru| Переносим в него соответствующий метод.
#|en| Move corresponding method to it.
#|uk| Переносимо в нього відповідний метод.

Remove selected

Wait 500ms

Go to end of "ArticleMarkdown"

Print:
```

  public String markdownView() {
    String output = "# " + article.getTitle() + "\n\n";
    output += "> " + article.getIntro() + "\n\n";
    output += article.getBody() + "\n\n";
    output += "_Written by " + article.getAuthor() + " on " + article.getDate() + "_";
    return output;
  }
```

Wait 500ms

Select "ArticleView" in "markdownView" of "Article"

Replace "ArticleMarkdown"

Wait 500ms

Go to after "ArticleMarkdown"

#|ru| Далее создаём класс <code>ArticleHtml</code>.
#|en| Now let's create a <code>ArticleHtml</code> class.
#|uk| Далі створюємо клас <code>ArticleHtml</code>.

Print:
```


class ArticleHtml extends ArticleView {
  public ArticleHtml(Article article) {
    super(article);
  }
}
```

Wait 500ms

Select whole of "htmlView" in "ArticleView"

#|ru| И аналогичным образом переносим в него оставшийся метод.
#|en| And similarly move the remaining method to it.
#|uk| І аналогічним чином переносимо в нього залишився метод.

Remove selected

Wait 500ms

Go to end of "ArticleHtml"

Print:
```

  public String htmlView() {
    String output = "<h2>" + article.getTitle() + "</h2>" + "\n";
    output += "<blockquote>" + article.getIntro() + "</blockquote>" + "\n";
    output += "<p>" + article.getBody() + "</p>" + "\n";
    output += "<em>Written by " + article.getAuthor() + " on " + article.getDate() + "</em>";
    return output;
  }
```

Wait 500ms

Select "ArticleView" in "htmlView" of "Article"

Replace "ArticleHtml"

Wait 500ms

Select name of "markdownView" in "ArticleMarkdown"
+ Select name of "htmlView" in "ArticleHtml"

#|ru| Так как методы теперь находятся в разных классах, мы можем дать им одинаковые имена.
#|en| Since the methods are now located in different classes, we can give them identical names.
#|uk| Так як методи тепер знаходяться в різних класах, ми можемо дати їм однакові імена.

Replace "view"

Wait 500ms

Select "markdownView" in body of "markdownView" of "Article"
+ Select "htmlView" in body of "htmlView" of "Article"

Replace "view"

Select name of "ArticleHtml"
+ Select name of "ArticleMarkdown"

#C|ru| Запустим тестирование, чтобы убедиться в отсутствии ошибок.
#S Всё работает, можем продолжать.

#C|en| Let's launch autotests to check for errors in the code.
#S Everything is OK! We can keep going.

#C|uk| Запустимо тестування, щоб переконатися у відсутності помилок.
#S Все працює, можемо продовжувати.

#|ru| Итак, все готово чтобы, наконец, приступить к самому рефакторингу.
#|en| Finally, everything is ready to start the refactoring itself.
#|uk| Отже, все готово щоб, нарешті, приступити до самого рефакторингу.

#|ru| Первым делом разобьём методы <code>view</code> в обоих классах на составные части. Определить которые в нашем случае довольно просто — это будут части напечатанной статьи.
#|en| First split the <code>view</code> methods in both steps to their constituent steps. Defining the steps is rather easy in our case – these are parts of the printed article.
#|uk| Першим ділом розіб'ємо методи <code>view</code> в обох класах на складові частини. Визначити які в нашому випадку досить просто – це будуть частини надрукованої статті.

Select name of "ArticleMarkdown"

#|ru| Начнём с класса <code>ArticleMarkdown</code>.
#|en| Start with the <code>ArticleMarkdown</code> class.
#|uk| Почнемо з класу <code>ArticleMarkdown</code>.

Go to end of "ArticleMarkdown"

Print:
```

  private String title() {
    return "# " + article.getTitle() + "\n\n";
  }
  private String intro() {
    return "> " + article.getIntro() + "\n\n";
  }
  private String body() {
    return article.getBody() + "\n\n";
  }
  private String footer() {
    return "_Written by " + article.getAuthor() + " on " + article.getDate() + "_";
  }
```

Select body of "view" in "ArticleMarkdown"

#|ru| Теперь мы можем заменить части метода <code>view</code> вызовами новых методов.
#|en| Now we can replace parts of the <code>view</code> method with calls to the new methods.
#|uk| Тепер ми можемо замінити частини методу <code>view</code> викликами нових методів.

Print:
```
    return title() + intro() + body() + footer();
```

Select name of "ArticleHtml"

#|ru| Проделаем все то же самое для класса <code>ArticleHtml</code>.
#|en| Do all of this for the <code>ArticleHtml</code> class.
#|uk| Виконаємо все те ж саме для класу <code>ArticleHtml</code>.

Go to end of "ArticleHtml"

Print:
```

  private String title() {
    return "<h2>" + article.getTitle() + "</h2>" + "\n";
  }
  private String intro() {
    return "<blockquote>" + article.getIntro() + "</blockquote>" + "\n";
  }
  private String body() {
    return "<p>" + article.getBody() + "</p>" + "\n";
  }
  private String footer() {
    return "<em>Written by " + article.getAuthor() + " on " + article.getDate() + "</em>";
  }
```

Select body of "view" in "ArticleHtml"

#|ru| Теперь мы можем заменить части метода <code>view</code> вызовами новых методов.
#|en| Now we can replace parts of the <code>view</code> method with calls to the new methods.
#|uk| Тепер ми можемо замінити частини методу <code>view</code> викликами нових методів.

Print:
```
    return title() + intro() + body() + footer();
```

Set step 4

Go to type "ArticleView"

#|ru| Как видите, у нас получилось много одинаковых частей в обоих классах. Следует вынести их в суперкласс в виде абстрактных методов.
#|en| As you can see, the two classes have many identical steps. We should move the identical steps as abstract methods to the superclass.
#|uk| Як бачите, у нас вийшло багато однакових частин в обох класах. Слід винести їх в суперклас у вигляді абстрактних методів.

Print "abstract "

Wait 500ms

Select visibility of "public ArticleView"

Replace "protected"

Wait 500ms

Go to end of "ArticleView"

Wait 500ms

Print:
```

  protected abstract String title();
  protected abstract String intro();
  protected abstract String body();
  protected abstract String footer();
```

Wait 500ms

Select "|||private||| String"

Replace "@Override protected"

Wait 500ms

Select whole of "view" in "ArticleMarkdown"
+ Select whole of "view" in "ArticleHtml"

Set step 5

#|ru| Теперь мы можем свободно вынести в суперкласс ничем не отличающиеся методы <code>view</code>.
#|en| Now we can freely extract the identical <code>view</code> methods to the superclass.
#|uk| Тепер ми можемо вільно винести в суперклас методи <code>view</code>, які нічим не відрізняються.

Remove selected

Go to end of "ArticleView"

Print:
```

  public String view() {
    return title() + intro() + body() + footer();
  }
```

#C|ru| Запускаем финальное тестирование.
#S Отлично, все работает!

#C|en| Let's start the final testing.
#S Wonderful, it's all working!

#C|uk| Запускаємо фінальне тестування.
#S Супер, все працює.

Set final step

#|ru|Q На этом рефакторинг можно считать оконченным. В завершение, можете посмотреть разницу между старым и новым кодом.
#|en|Q The refactoring is complete! You can compare the old and new code if you like.
#|uk|Q На цьому рефакторинг можна вважати закінченим. На завершення, можете подивитися різницю між старим та новим кодом.