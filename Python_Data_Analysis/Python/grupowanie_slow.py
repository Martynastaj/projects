TEKST=normalizacja(DANE)

def grupowanie_slow(TEKST):

    words = TEKST.split()
    LITERY = {}

    for word in words:
        letter_set = frozenset(word)
        LITERY.setdefault(letter_set, []).append(word)
    return LITERY

grupowanie_slow(TEKST)
