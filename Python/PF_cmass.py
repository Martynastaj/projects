
# PUNKTY, sekwencja krotek - przyjąć, że są zadane

# miejsce na rozwiązanie …

from functools import reduce

# dane punkty:
dane = [(-3.3, 8.0, -5.34), (7.0, -1.8, -6.4, -8.40)]
# 'dlugosc' danych:
n=len( dane )

# KROK 1: szukamy najwiekszego wymiaru przestrzeni
dim = map( len, dane )
max_dim =reduce( max, dim )
#print(max_dim)

# KROK 2: brakujace pozycje we wspolrzednych uzupelniamy zerami
new_points=map( lambda x: x + ( 0,)* ( max_dim - len(x) ), dane )

# KROK 3: sumujemy wpolrzedne dla poszczegolnych wymiarow
sum = [0] * max_dim
#print(sum)

for i in new_points:
    for k, value in enumerate(i):
        sum[k] += value
      

# wyniki:
# KROK 4: obliczamy sredia arytmetyczna i zamieniamy ja na listem bo inaczej dostaniemy generator
CMASS = list( map( lambda x: x / n, sum ) )

# KROK 5: drukujemy wyniki
print(CMASS)  
