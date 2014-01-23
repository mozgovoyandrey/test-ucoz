<?php
header("Content-Type: text/html; charset=utf-8");
?><!DOCTYPE html><html>
<head>
    <meta charset="utf-8" />
	<style type="text/css">
		.view_code {
			background-color: #eeeeee;
			display: block;
			padding: 5px;
		}
		.view_code  div {
			display: none;
			padding: 20px;
			background-color: #eeffee;
		}
		.view_code:hover div {
			display: block;
		}
	</style>
</head>
<body>
<h3>Тестовое задание 1</h3>
<p>
    На сервере лежит файл file.doc -  написать скрипт, отдающий на скачивание данный файл под произвольным именем, которое передается скрипту в запросе (параметр filename). При этом в cookies клиента скрипт должен установить параметр referrer, в котором должен быть сохранён реферальный домен (откуда именно пришел человек, скачавший файл)
</p>
<a href="/test1.php">Работающее приложение</a><br/>
<a href="/test1.php?filename=afile.txt">Пример работы</a><br/>
<hr>

<h3>Тестовое задание 2</h3>
<p>
    Заполнить массив 1000000 случайных натуральных (неотрицательных целых) чисел из интервала (0,2^32), 999999 из которых уникальные и не повторяющиеся, а 1 совпадает с каким-то из них. Найти в созданном массиве единственное повторяющееся число, предложив несколько вариантов решения. Оценить сложность, быстродействие и оптимальность каждого предложенного решения. Один из способов решения обязательно выполнить без использования стандартных функций сортировки.
</p>

<a href="/test2.py">Код программы на Python (*.py)</a><br/>
<span class="view_code">
Для того чтобы просмотреть код программы в этом окне - наведите курсор на эту надпись.
<div>
<pre>
__author__ = 'Mozgovoy'
import random
import time

## Sozdaem massiv
start = time.time()

t = 0 # dublikat
c = 1000000 # Dlina
k = 2 ** 32 # Diapazon
L = []

L = random.sample(range(k), 1000000)
print ("Len arr: ")
print (len(L))

R = ("yes", "no")[len(L)==len(set(L))]
print ("Dublikat: ")
print (R)

# Sozdaem dublikat
while t < 1:
    a = random.randint(0, c)
    b = random.randint(0, c)
    if a != b:
        L[a] = L[b]
        t = 1


R = ("yes", "no")[len(L)==len(set(L))]
print ("Dublikat: ")
print (R)


finish = time.time()
print (finish - start)

method = 4 # Vybiraem metod poiska
start = time.time()
R = [] # Resultat vypolneniya
i = 0

## Poisk znacheniya v sreze massiva
if method == 1:
    while i < c :
        if L[i] in L[i+1:c]:
            R.append(i)
            print(L[i])
        i += 1

## Podschet kolichestva povtoreniy
if method == 2:
    while i < c:
        lc = L.count(L[i])
        if lc > 1:
            R.append(i)
        i += 1

## Prostoy perebor s sravneniem
if method == 3:
    while i < len(L):
        j = i + 1
        while j < len(L):
            if L[i] == L[j]:
                R.append(L[i])
            j += 1
        i += 1

## Sortirovka i sravnenie elementov
if method == 4:
    Z = L
    Z.sort()
    while i < len(Z)-1:
        if Z[i] == Z[i+1]:
            R.append(Z[i])
        i += 1

print(R)

finish = time.time()
print(finish)
</pre>
</div>
</span>
<hr>

<h3>Тестовое задание 3</h3>
<p>
    Написать скрипт, который реализует:
    <ul>
        <li>а) форму добавления в базу данных клиентов (телефон + емейл)</li>
        <li>б) форму восстановления номера телефона по указанному емейлу, причём номер телефона должен высылаться на этот емейл</li>
        <li>в) организовать защиту данных таким образом, чтобы при получении злоумышленником доступа к САЙТУ (к базе данны клиентов и вашему скрипту), он не смог изъять из нее емейлы и телефоны клиентов</li>
        <li>г) оформить интерефейс скрипта стилями (css)</li>
    </ul>
</p>
<a href="/test3.php">Работающее приложение</a><br/>

<hr>

<a href="https://github.com/mozgovoyandrey/test-ucoz">Исходники на GitHub</a><br/>
</body>
</html>