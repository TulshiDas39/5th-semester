split-temporary-variable:csharp

###

1.ru. Найдите место в коде, где переменная первый раз заполняется каким-то значением. В этом месте переименуйте переменную и дайте ей название, соответствующее присваиваемому значению.
1.en. Find the place in your code where the variable is first filled with a value. In this place, rename the variable and give it a name that corresponds to the value assigned.
1.uk. Знайдіть місце в коді, де змінна перший раз заповнюється якимось значенням. У цьому місці перейменуйте змінну і дайте їй назву, відповідну до значення,що призначується.

2.ru. Подставьте её новое название вместо старого в тех местах, где использовалось это значение переменной.
2.en. Use the new name instead of the old one in places where this value of the variable is used.
2.uk. Підставте її нову назву замість старого в місцях, де використовувалося це значення змінної.

3.ru. Повторите операцию для случаев, где переменной присваивается новое значение.
3.en. Repeat as needed for places where the variable is assigned a different value.
3.uk. Повторіть операцію для інших випадків, де змінній привласнюється нове значення.



###

```
double GetDistanceTravelled(int time)
{
  double result;
  double acc = primaryForce / mass;
  int primaryTime = Math.min(time, delay);
  result = 0.5 * acc * primaryTime * primaryTime;

  int secondaryTime = time - delay;
  if (secondaryTime > 0)
  {
    double primaryVel = acc * delay;
    acc = (primaryForce + secondaryForce) / mass;
    result +=  primaryVel * secondaryTime + 0.5 * acc * secondaryTime * secondaryTime;
  }

  return result;
}
```

###

```
double GetDistanceTravelled(int time)
{
  double result;
  const double primaryAcceleration = primaryForce / mass;
  int primaryTime = Math.min(time, delay);
  result = 0.5 * primaryAcceleration * primaryTime * primaryTime;

  int secondaryTime = time - delay;
  if (secondaryTime > 0)
  {
    double primaryVel = primaryAcceleration * delay;
    const double secondaryAcceleration = (primaryForce + secondaryForce) / mass;
    result +=  primaryVel * secondaryTime + 0.5 * secondaryAcceleration * secondaryTime * secondaryTime;
  }

  return result;
}
```

###

Set step 1

#|ru| Давайте рассмотрим <i>Расщепление переменной</i> на примере небольшого метода расчёта расстояния перемещения мяча в пространстве в зависимости от времени и сил, действующих на него.
#|en| Let's look at <i>Split Temporary Variable</i> using a small method, which calculates the movement of a ball in space as a function of time and the forces acting on it.
#|uk| Давайте розглянемо <i>Розщеплення змінної<i> на прикладі невеличкого методу розрахунку відстані переміщення м'яча в просторі залежно від часу і сил, що діють на нього.

Select "|||acc||| ="

#|ru|^ Для нашего примера представляет интерес то, что переменная <code>acc</code> устанавливается в нём дважды.
#|en|^ Notably for our example, the <code>acc</code> variable is set in it twice.
#|uk|^ Для нашого прикладу становить цікавість те, що змінна <code>acc</code> встановлюється в ньому двічі.

#|ru|+ Она выполняет две задачи: содержит первоначальное ускорение, вызванное первой силой…
#|en|+ It performs two tasks: it contains the initial acceleration caused by the first force…
#|uk|+ Вона виконує два завдання: містить початкове прискорення, викликане першою силою…

#|ru|^= …и позднее ускорение, вызванное обеими силами.
#|en|^= …and later acceleration caused by both forces.
#|uk|^= …і пізніше прискорення, викликане обома силами.

#|ru|^ Следовательно, эту переменную лучше расщепить, чтобы каждая её часть отвечала только за одну задачу.
#|en|^ So it is better to split up this variable, with each part responsible for only one task.
#|uk|^ Отже, цю змінну краще розщепити, щоб кожна її частина відповідала тільки за одну задачу.

Select "double |||acc|||"

#|ru| Начнём с изменения имени переменной. Для этого очень удобно выбрать имя, которое будет отражать её первое применение.
#|en| Start by changing the name of the variable. For this purpose, it is convenient to select a name that reflects the first use of the variable.
#|uk| Почнемо з замніни ім'я для змінної. Для цього дуже зручно вибрати ім'я, яке буде відтворювати її перше застосування.

Print "primaryAcceleration"

Go to "|||double primaryAcceleration"

#|ru| Кроме того, мы объявим её константой, чтобы гарантировать однократное присваивание ей значения.
#|en| We will also declare it a constant to make sure that a value Is assigned only once.
#|uk| Крім того, ми оголосимо її константою, щоб гарантувати однократне присвоювання їй значення.

Print "const "

Wait 500ms

Set step 2

Select "result = 0.5 * |||acc|||"
+ Select "|||acc||| * delay"

#|ru| После этого нужно переименовать переменную во всех местах, где она использовалась, вплоть до того места, где ей присваивается новое значение.
#|en| Then we should rename the variable in all places where it is used, including the place where the new value is assigned.
#|uk| Після цього потрібно перейменувати змінну у всіх місцях, де вона використовувалася, аж до того місця, де їй присвоюється нове значення.

Print "primaryAcceleration"

Go to "|||acc ="

#|ru| После всех замен можно объявить первоначальную переменную в месте второго присваивания ей некоторого значения.
#|en| After all replacements, you can declare the initial variable in the place of the second assignment of a value to it.
#|uk| Після всіх замін можна оголосити первісну змінну в місці другого присвоювання їй деякого значення.

Print "double "

#C|ru| После того как мы добрались до второго случая использования переменной, можно выполнить компиляцию и тестирование.
#S Всё отлично, можем продолжать!

#C|en| After getting to the second case of variable use, compile and test.
#S Everything is OK! We can keep going.

#C|uk| Після того як ми дісталися до другого випадку використання змінної, можна виконати компіляцію і тестування.
#S Все добре, можна продовжувати.

Set step 3

Select 1st "|||acc||| "

#|ru| Теперь можно повторить все действия со вторым присваиванием временной переменной. Окончательно удаляем первоначальное имя переменной, и заменяем его новым, соответствующим второй задаче.
#|en| Now we can repeat all these actions with the second assignment of a temporary variable. We remove the initial name of the variable once and for all, and then replace it with a new name that fits the second task.
#|uk| Тепер можна повторити всі дії з другим присвоюванням тимчасової змінної. Остаточно видаляємо первинне ім'я змінної, і замінюємо його новим, відповідним другому завданню.

Print "secondaryAcceleration"

Wait 500ms

Go to "|||double secondaryAcceleration"

Print "const "

Wait 500ms

Select " |||acc||| "

Replace "secondaryAcceleration"

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