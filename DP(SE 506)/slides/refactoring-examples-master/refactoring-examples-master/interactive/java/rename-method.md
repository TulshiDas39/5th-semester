rename-method:java

###

1.ru. Проверьте, не определён ли метод в суперклассе или подклассе. Если определён, то нужно будет повторить все шаги и в этих классах.
1.en. See whether the method is defined in a superclass or subclass. If so, you must repeat all steps in these classes too.
1.uk. Перевірте, чи не визначений метод в суперкласі або підкласі. Якщо так, треба буде повторити усі кроки і в цих класах.

2.ru. Следующий шаг важен, чтобы сохранить работоспособность программы во время рефакторинга. Итак, создайте новый метод с новыми именем. Скопируйте туда код старого метода. Удалите весь код в старом методе и вставьте вместо него вызов нового метода.
2.en. The next method is important for maintaining the functionality of the program during the refactoring process. Create a new method with a new name. Copy the code of the old method to it. Delete all the code in the old method and, instead of it, insert a call for the new method.
2.uk. Наступний крок важливий, щоб зберегти працездатність програми під час рефакторингу. Отже, створіть новий метод з новими ім'ям. Скопіюйте туди код старого методу. Видаліть увесь код в старому методі, а замість нього додайте виклик нового методу.

3.ru. Найдите все обращения к старому методу и замените их обращениями к новому.
3.en. Find all references to the old method and replace them with references to the new one.
3.uk. Знайдіть усі звернення до старого методу і замініть їх зверненнями до нового.

4.ru. Удалите старый метод. Этот шаг неосуществим, если старый метод является частью публичного интерфейса. В этом случае старый метод нужно пометить как устаревший (<code>deprecated</code>).
4.en. Delete the old method. This step is not possible if the old method is part of the public interface. In that case, mark the old method as <code>deprecated</code>.
4.uk. Видаліть старий метод. Цей крок неможливий, якщо старий метод є частиною публічного інтерфейсу. В цьому випадку старий метод потрібно помітити як застарілий (<code>deprecated</code>).



###

```
class Person {
  //…
  public String getTelephoneNumber() {
    return ("(" + officeAreaCode + ") " + officeNumber);
  }
}

// Client code
phone = employee.getTelephoneNumber();
```

###

```
class Person {
  //…
  public String getOfficeTelephoneNumber() {
    return ("(" + officeAreaCode + ") " + officeNumber);
  }
}

// Client code
phone = employee.getOfficeTelephoneNumber();
```

###

Set step 1

Select name of "getTelephoneNumber"

#|ru| Имеется метод для получения номера телефона определенного лица. Метод нигде не переопределяется, так что нам не нужно отслеживать изменение в подклассах.
#|en| There is a method for getting the phone number of a certain person. The method is not overridden anywhere so we do not need to track changes in subclasses.
#|uk| Маємо метод для отримання номера телефону певної особи. Метод ніде не перевизначається, так що нам не потрібно відстежувати зміну в підкласах.

Set step 2

#|ru| Мы решили переименовать метод в <code>getOfficeTelephoneNumber</code>, чтобы он лучше отражал то, что делает.
#|en| Let's change it's name to <code>getOfficeTelephoneNumber</code>, a more descriptive name.
#|uk| Ми вирішили перейменувати метод в <code>getOfficeTelephoneNumber</code>, щоб він краще відображав те, що робить.

Go to the end of "Person"

#|ru| Начинаем с создания нового метода и копирования тела в новый метод.
#|en| Start by creating a new method and copying the body to the new method.
#|uk| Починаємо зі створення нового методу і копіювання тіла в новий метод.

Print:
```

  public String getOfficeTelephoneNumber() {
    return ("(" + officeAreaCode + ") " + officeNumber);
  }
```

#|ru| Старый метод изменяется так, чтобы вызывать новый. Это действие может выглядеть лишним, однако это поможет держать код рабочим, пока вы выполняете все последующие шаги рефакторинга.
#|en| Then we change the old method so that it call the new one. That might look to you as a useless step, but it will help to keep the code working while you search for all calls of the old method and replace them with the new method calls.
#|uk| Старий метод змінюється так, щоб викликати новий. Ця дія може виглядати зайвою, однак вона допоможе зберігти код працюючим, поки ви виконуєте всі наступні кроки рефакторингу.

Select body of "getTelephoneNumber"

Replace "    getOfficeTelephoneNumber();"

Set step 3

#|ru| Теперь находим места вызова прежнего метода и изменяем их так, чтобы в них вызывался новый метод.
#|en| So, we find the places where the old method is called, modifying them to call the new method instead.
#|uk| Тепер знаходимо місця виклику колишнього методу і змінюємо їх так, щоб в них викликався новий метод.

Select "employee.|||getTelephoneNumber|||()"

Replace "getOfficeTelephoneNumber"

Set step 4

Select whole "getTelephoneNumber"

#|ru| После проведения всех изменений старый метод можно удалить.
#|en| After all changes have been made, we can go ahead and delete the old method.
#|uk| Після проведення всіх змін старий метод можна видалити.

Remove selected

#C|ru| Запускаем финальную компиляцию.
#S Отлично, все работает!

#C|en| Let's perform the final compilation and testing.
#S Wonderful, it's all working!

#C|uk| Запускаємо фінальну компіляцію.
#S Супер, все працює.

Set final step

#|ru|Q На этом рефакторинг можно считать оконченным. В завершение, можете посмотреть разницу между старым и новым кодом.
#|en|Q The refactoring is complete! You can compare the old and new code if you like.
#|uk|Q На цьому рефакторинг можна вважати закінченим. На завершення, можете подивитися різницю між старим та новим кодом.