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
        if i%10000 == 0:
            print(i)

print(R)

finish = time.time()
print(finish)